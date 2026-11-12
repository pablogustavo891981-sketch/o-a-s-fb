@extends('layouts.app')

@section('title', 'Detalhes da Disponibilidade')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('disponibilidades.index') }}"
           class="text-decoration-none"
           style="color:#CC092F;">
            ← Voltar para disponibilidades
        </a>

        <h2 class="fw-bold mt-3" style="color:#CC092F;">
            Detalhes da disponibilidade
        </h2>

        <p class="text-muted">
            Consulte as informações do horário cadastrado.
        </p>
    </div>

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
        <div class="card-body p-4">

            <div class="mb-4">
                <small class="text-muted">Dia da semana</small>
                <h4 class="fw-bold mb-0">
                    {{ $diasSemana[$disponibilidade->dia_semana] ?? 'Dia inválido' }}
                </h4>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Horário de início</small>
                    <h5 class="fw-semibold">
                        {{ substr($disponibilidade->hora_inicio, 0, 5) }}
                    </h5>
                </div>

                <div class="col-md-6 mb-3">
                    <small class="text-muted">Horário de término</small>
                    <h5 class="fw-semibold">
                        {{ substr($disponibilidade->hora_fim, 0, 5) }}
                    </h5>
                </div>
            </div>

            @if(auth()->user()?->tipo_usuario === 'administrador')
                <div class="mb-4">
                    <small class="text-muted">Prestador responsável</small>
                    <h5 class="fw-semibold">
                        {{ $disponibilidade->usuario->name ?? 'Usuário não encontrado' }}
                    </h5>
                </div>
            @endif

            <div class="mb-4">
                <small class="text-muted">Situação</small>
                <div>
                    @if($disponibilidade->ativo)
                        <span class="badge rounded-pill px-3 py-2"
                              style="background:#E8F5E9;color:#26733A;">
                            Ativo
                        </span>
                    @else
                        <span class="badge rounded-pill px-3 py-2"
                              style="background:#FCECEF;color:#CC092F;">
                            Inativo
                        </span>
                    @endif
                </div>
            </div>

            <div class="text-muted small mb-4">
                <p class="mb-1">
                    Cadastrado em:
                    {{ $disponibilidade->created_at?->format('d/m/Y H:i') }}
                </p>

                <p class="mb-0">
                    Última atualização:
                    {{ $disponibilidade->updated_at?->format('d/m/Y H:i') }}
                </p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('disponibilidades.edit', $disponibilidade) }}"
                   class="btn text-white"
                   style="background:#CC092F;">
                    Editar horário
                </a>

                <form action="{{ route('disponibilidades.destroy', $disponibilidade) }}"
                      method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta disponibilidade?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger">
                        Excluir
                    </button>
                </form>

                <a href="{{ route('disponibilidades.index') }}"
                   class="btn btn-outline-secondary">
                    Voltar
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
