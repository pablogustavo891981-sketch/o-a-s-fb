<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServicoController extends Controller
{
    /**
     * Verificar se o usuário pode alterar o serviço.
     */
    private function autorizar(Servico $servico): void
    {
        $usuario = auth()->user();

        abort_unless(
            $usuario->tipo_usuario === 'administrador' ||
            $servico->usuario_id === $usuario->id,
            403,
            'Você não tem permissão para alterar este serviço.'
        );
    }

    /**
     * Listar serviços disponíveis.
     */
    public function index(Request $request)
    {
        $consulta = Servico::with(['usuario', 'categoria'])
            ->where('ativo', true);

        if ($request->filled('busca')) {
            $busca = $request->busca;

            $consulta->where(function ($query) use ($busca) {
                $query->where('nome', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $consulta->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('preco_maximo')) {
            $consulta->where('preco', '<=', $request->preco_maximo);
        }

        $servicos = $consulta
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categorias = Categoria::where('ativa', true)
            ->orderBy('nome')
            ->get();

        return view('servicos.index', compact(
            'servicos',
            'categorias'
        ));
    }

    /**
     * Exibir formulário de cadastro.
     */
    public function create()
    {
        $categorias = Categoria::where('ativa', true)
            ->orderBy('nome')
            ->get();

        return view('servicos.create', compact('categorias'));
    }

    /**
     * Cadastrar serviço.
     */
    public function store(Request $request)
    {
        abort_unless(
            in_array(auth()->user()?->tipo_usuario, ['prestador', 'administrador']),
            403,
            'Somente prestadores podem cadastrar serviços.'
        );

        $dados = $request->validate([
            'categoria_id' => [
                'required',
                Rule::exists('categorias', 'id')->where('ativa', true),
            ],
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:3000'],
            'preco' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'duracao' => ['required', 'integer', 'min:1', 'max:1440'],
            'local_atendimento' => ['nullable', 'string', 'max:500'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')
                ->store('servicos', 'public');
        }

        $dados['usuario_id'] = auth()->id();
        $dados['ativo'] = true;

        Servico::create($dados);

        return redirect()
            ->route('servicos.index')
            ->with('success', 'Serviço cadastrado com sucesso!');
    }

    /**
     * Exibir detalhes do serviço.
     */
    public function show(Servico $servico)
    {
        abort_unless(
            $servico->ativo ||
            auth()->user()?->tipo_usuario === 'administrador' ||
            $servico->usuario_id === auth()->id(),
            404
        );

        $servico->load(['usuario', 'categoria']);

        return view('servicos.show', compact('servico'));
    }

    /**
     * Exibir formulário de edição.
     */
    public function edit(Servico $servico)
    {
        $this->autorizar($servico);

        $categorias = Categoria::where('ativa', true)
            ->orWhere('id', $servico->categoria_id)
            ->orderBy('nome')
            ->get();

        return view('servicos.edit', compact(
            'servico',
            'categorias'
        ));
    }

    /**
     * Atualizar serviço.
     */
    public function update(Request $request, Servico $servico)
    {
        $this->autorizar($servico);

        $dados = $request->validate([
            'categoria_id' => [
                'required',
                Rule::exists('categorias', 'id')
                    ->where(function ($query) use ($servico) {
                        $query->where('ativa', true)
                            ->orWhere('id', $servico->categoria_id);
                    }),
            ],
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:3000'],
            'preco' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'duracao' => ['required', 'integer', 'min:1', 'max:1440'],
            'local_atendimento' => ['nullable', 'string', 'max:500'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('imagem')) {
            if ($servico->imagem) {
                Storage::disk('public')->delete($servico->imagem);
            }

            $dados['imagem'] = $request->file('imagem')
                ->store('servicos', 'public');
        }

        $servico->update($dados);

        return redirect()
            ->route('servicos.index')
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    /**
     * Desativar ou excluir serviço.
     */
    public function destroy(Servico $servico)
    {
        $this->autorizar($servico);

        // Preservar histórico de agendamentos.
        if ($servico->agendamentos()->exists()) {
            $servico->update(['ativo' => false]);

            return redirect()
                ->route('servicos.index')
                ->with('success', 'Serviço desativado. O histórico de agendamentos foi preservado.');
        }

        if ($servico->imagem) {
            Storage::disk('public')->delete($servico->imagem);
        }

        $servico->delete();

        return redirect()
            ->route('servicos.index')
            ->with('success', 'Serviço excluído com sucesso!');
    }
}
