@extends('layouts.app')

@section('title', 'Minhas Disponibilidades')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color:#CC092F;">
                Disponibilidades
            </h2>
            <p class="text-muted mb-0">
                Gerencie os dias e horários disponíveis para agendamentos.
            </p>
        </div>

        <a href="{{ route('disponibilidades.create') }}"
           class="btn text-white"
           style="background:#CC092F;">
            + Novo horário
        </a>
    </div>

    @if(session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger">
            {{ session('erro') }}
        </div>
    @endif

    @php
        $diasSemana = [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];
    @endphp

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            @if($disponibilidades->isEmpty())
                <div class="text-center py-5 px-3">
                    <h5 class="fw-bold">Nenhum horário cadastrado</h5>
                    <p class="text-muted">
                        Cadastre seus horários para que os clientes possam solicitar agendamentos.
                    </p>

                    <a href="{{ route('disponibilidades.create') }}"
                       class="btn text-white"
                       style="background:#CC092F;">
                        Cadastrar disponibilidade
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#FCECEF;">
                            <tr>
                                <th class="px-3 py-3">Dia da semana</th>
                                <th>Horário inicial</th>
                                <th>Horário final</th>
                                @if(auth()->user()?->tipo_usuario === 'administrador')
                                    <th>Prestador</th>
                                @endif
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($disponibilidades as $disponibilidade)
                                <tr>
                                    <td class="px-3 fw-semibold">
                                        {{ $diasSemana[$disponibilidade->dia_semana] ?? 'Dia inválido' }}
                                    </td>

                                    <td>
                                        {{ substr($disponibilidade->hora_inicio, 0, 5) }}
                                    </td>

                                    <td>
                                        {{ substr($disponibilidade->hora_fim, 0, 5) }}
                                    </td>

                                    @if(auth()->user()?->tipo_usuario === 'administrador')
                                        <td>
                                            {{ $disponibilidade->usuario->name ?? 'Usuário não encontrado' }}
                                        </td>
                                    @endif

                                    <td>
                                        @if($disponibilidade->ativo)
                                            <span class="badge rounded-pill"
                                                  style="background:#E8F5E9;color:#26733A;">
                                                Ativo
                                            </span>
                                        @else
                                            <span class="badge rounded-pill"
                                                  style="background:#FCECEF;color:#CC092F;">
                                                Inativo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            <a href="{{ route('disponibilidades.show', $disponibilidade) }}"
                                               class="btn btn-sm btn-outline-secondary">
                                                Ver
                                            </a>

                                            <a href="{{ route('disponibilidades.edit', $disponibilidade) }}"
                                               class="btn btn-sm btn-outline-danger">
                                                Editar
                                            </a>

                                            <form action="{{ route('disponibilidades.destroy', $disponibilidade) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir este horário?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm text-white"
                                                        style="background:#CC092F;">
                                                    Excluir
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $disponibilidades->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
