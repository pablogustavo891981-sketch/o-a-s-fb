<?php

namespace App\Http\Controllers;

use App\Models\Disponibilidade;
use Illuminate\Http\Request;

class DisponibilidadeController extends Controller
{
    private function autorizar(Disponibilidade $disponibilidade): void
    {
        $usuario = auth()->user();

        abort_unless(
            $usuario?->tipo_usuario === 'administrador' ||
                ($usuario?->tipo_usuario === 'prestador' &&
                    $usuario->id === $disponibilidade->usuario_id),
            403,
            'Você não tem permissão para acessar esta disponibilidade.'
        );
    }

    private function autorizarGerenciamento(): void
    {
        abort_unless(
            in_array(auth()->user()?->tipo_usuario, ['prestador', 'administrador'], true),
            403,
            'Somente prestadores podem gerenciar disponibilidades.'
        );
    }

    private function autorizarCadastro(): void
    {
        abort_unless(
            auth()->user()?->tipo_usuario === 'prestador',
            403,
            'Somente prestadores podem cadastrar disponibilidades.'
        );
    }

    public function index()
    {
        $this->autorizarGerenciamento();

        $usuario = auth()->user();

        $disponibilidades = Disponibilidade::with('usuario')
            ->when(
                $usuario->tipo_usuario !== 'administrador',
                fn ($query) => $query->where('usuario_id', $usuario->id)
            )
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->paginate(15);

        return view('disponibilidades.index', compact('disponibilidades'));
    }

    public function create()
    {
        $this->autorizarCadastro();

        return view('disponibilidades.create');
    }

    public function store(Request $request)
    {
        $this->autorizarCadastro();

        $dados = $request->validate([
            'dia_semana' => ['required', 'integer', 'between:0,6'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'ativo' => ['nullable', 'boolean'],
        ], [
            'dia_semana.required' => 'Selecione o dia da semana.',
            'dia_semana.between' => 'Selecione um dia válido.',
            'hora_inicio.required' => 'Informe o horário inicial.',
            'hora_inicio.date_format' => 'O horário inicial é inválido.',
            'hora_fim.required' => 'Informe o horário final.',
            'hora_fim.date_format' => 'O horário final é inválido.',
            'hora_fim.after' => 'O horário final deve ser posterior ao inicial.',
        ]);

        $dados['usuario_id'] = auth()->id();
        $dados['ativo'] = $request->boolean('ativo', true);

        Disponibilidade::create($dados);

        return redirect()
            ->route('disponibilidades.index')
            ->with('sucesso', 'Disponibilidade cadastrada com sucesso!');
    }

    public function show(Disponibilidade $disponibilidade)
    {
        $this->autorizar($disponibilidade);

        $disponibilidade->load('usuario');

        return view('disponibilidades.show', compact('disponibilidade'));
    }

    public function edit(Disponibilidade $disponibilidade)
    {
        $this->autorizar($disponibilidade);

        return view('disponibilidades.edit', compact('disponibilidade'));
    }

    public function update(Request $request, Disponibilidade $disponibilidade)
    {
        $this->autorizar($disponibilidade);

        $dados = $request->validate([
            'dia_semana' => ['required', 'integer', 'between:0,6'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'ativo' => ['nullable', 'boolean'],
        ], [
            'dia_semana.required' => 'Selecione o dia da semana.',
            'dia_semana.between' => 'Selecione um dia válido.',
            'hora_inicio.required' => 'Informe o horário inicial.',
            'hora_inicio.date_format' => 'O horário inicial é inválido.',
            'hora_fim.required' => 'Informe o horário final.',
            'hora_fim.date_format' => 'O horário final é inválido.',
            'hora_fim.after' => 'O horário final deve ser posterior ao inicial.',
        ]);

        $dados['ativo'] = $request->boolean('ativo');

        $disponibilidade->update($dados);

        return redirect()
            ->route('disponibilidades.index')
            ->with('sucesso', 'Disponibilidade atualizada com sucesso!');
    }

    public function destroy(Disponibilidade $disponibilidade)
    {
        $this->autorizar($disponibilidade);

        $disponibilidade->delete();

        return redirect()
            ->route('disponibilidades.index')
            ->with('sucesso', 'Disponibilidade excluída com sucesso!');
    }
}
