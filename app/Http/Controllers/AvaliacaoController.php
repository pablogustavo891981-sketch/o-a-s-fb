<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvaliacaoController extends Controller
{
    /**
     * Listar avaliações.
     */
    public function index()
    {
        $usuario = auth()->user();

        $consulta = Avaliacao::with([
            'cliente',
            'prestador',
            'agendamento.servico',
        ]);

        if ($usuario->tipo_usuario === 'cliente') {
            $consulta->where('cliente_id', $usuario->id);
        } elseif ($usuario->tipo_usuario === 'prestador') {
            $consulta->where('prestador_id', $usuario->id);
        }

        $mediaAvaliacoes = (clone $consulta)->avg('nota');
        $avaliacoes = $consulta
            ->latest()
            ->paginate(15);

        return view('avaliacoes.index', compact('avaliacoes', 'mediaAvaliacoes'));
    }

    /**
     * Formulário de avaliação.
     */
    public function create()
    {
        abort_unless(
            auth()->user()?->tipo_usuario === 'cliente',
            403,
            'Somente clientes podem avaliar serviços.'
        );

        $agendamentos = Agendamento::with(['servico', 'prestador'])
            ->where('cliente_id', auth()->id())
            ->where('status', 'concluido')
            ->whereDoesntHave('avaliacao')
            ->latest('data')
            ->get();

        return view('avaliacoes.create', compact('agendamentos'));
    }

    /**
     * Registrar avaliação.
     */
    public function store(Request $request)
    {
        abort_unless(
            auth()->user()?->tipo_usuario === 'cliente',
            403,
            'Somente clientes podem avaliar serviços.'
        );

        $dados = $request->validate([
            'agendamento_id' => [
                'required',
                'integer',
                'exists:agendamentos,id',
            ],
            'nota' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'comentario' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use ($dados) {

            $agendamento = Agendamento::where(
                'id',
                $dados['agendamento_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $agendamento->cliente_id === auth()->id(),
                403,
                'Você não pode avaliar um serviço de outra pessoa.'
            );

            abort_unless(
                $agendamento->status === 'concluido',
                422,
                'Somente agendamentos concluídos podem ser avaliados.'
            );

            abort_if(
                $agendamento->avaliacao()->exists(),
                422,
                'Este agendamento já possui uma avaliação.'
            );

            Avaliacao::create([
                'agendamento_id' => $agendamento->id,
                'cliente_id' => $agendamento->cliente_id,
                'prestador_id' => $agendamento->prestador_id,
                'nota' => $dados['nota'],
                'comentario' => $dados['comentario'] ?? null,
            ]);
        });

        return redirect()
            ->route('avaliacoes.index')
            ->with('success', 'Avaliação registrada com sucesso!');
    }

    /**
     * Exibir avaliação.
     */
    public function show(Avaliacao $avaliacao)
    {
        $this->autorizar($avaliacao);

        $avaliacao->load([
            'cliente',
            'prestador',
            'agendamento.servico',
            'agendamento.prestador',
        ]);

        return view('avaliacoes.show', compact('avaliacao'));
    }

    /**
     * Exibir formulário de edição.
     */
    public function edit(Avaliacao $avaliacao)
    {
        $this->autorizar($avaliacao);

        abort_unless(
            auth()->user()?->tipo_usuario === 'cliente',
            403
        );

        return view('avaliacoes.edit', compact('avaliacao'));
    }

    /**
     * Atualizar avaliação.
     */
    public function update(
        Request $request,
        Avaliacao $avaliacao
    ) {
        $this->autorizar($avaliacao);

        abort_unless(
            auth()->user()?->tipo_usuario === 'cliente',
            403
        );

        $dados = $request->validate([
            'nota' => ['required', 'integer', 'between:1,5'],
            'comentario' => ['nullable', 'string', 'max:2000'],
        ]);

        $avaliacao->update($dados);

        return redirect()
            ->route('avaliacoes.index')
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    /**
     * Excluir avaliação.
     */
    public function destroy(Avaliacao $avaliacao)
    {
        $this->autorizar($avaliacao);

        abort_unless(
            auth()->user()?->tipo_usuario === 'administrador' ||
            $avaliacao->cliente_id === auth()->id(),
            403
        );

        $avaliacao->delete();

        return redirect()
            ->route('avaliacoes.index')
            ->with('success', 'Avaliação excluída com sucesso!');
    }

    /**
     * Verificar acesso à avaliação.
     */
    private function autorizar(Avaliacao $avaliacao): void
    {
        $usuario = auth()->user();

        abort_unless(
            $usuario->tipo_usuario === 'administrador' ||
            $avaliacao->cliente_id === $usuario->id ||
            $avaliacao->prestador_id === $usuario->id,
            403,
            'Você não tem permissão para acessar esta avaliação.'
        );
    }
}
