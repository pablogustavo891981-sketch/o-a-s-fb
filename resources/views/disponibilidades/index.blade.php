@extends('layouts.app')

@section('title', 'Minhas disponibilidades')

@push('styles')
    <style>
        .availability-page {
            max-width: 1160px;
        }

        .availability-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 22px;
            padding: clamp(22px, 4vw, 34px);
            border: 1px solid #F0DEE2;
            border-radius: 20px;
            background: linear-gradient(120deg, #FFF1F4 0%, #fff 75%);
            box-shadow: 0 10px 28px rgba(48, 25, 31, .045);
        }

        .availability-heading-copy {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            min-width: 0;
        }

        .availability-heading-icon {
            display: grid;
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            place-items: center;
            border: 1px solid #F2D5DC;
            border-radius: 15px;
            background: #fff;
            color: #CC092F;
            box-shadow: 0 6px 16px rgba(204, 9, 47, .08);
        }

        .availability-heading-icon svg {
            width: 25px;
            height: 25px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .availability-eyebrow {
            margin: 0 0 5px;
            color: #A80726;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .availability-title {
            margin: 0 0 5px;
            color: #292929;
            font-size: clamp(1.45rem, 3vw, 2rem);
            font-weight: 750;
            line-height: 1.2;
        }

        .availability-subtitle {
            margin: 0;
            color: #686168;
            font-size: 14px;
        }

        .availability-create {
            display: inline-flex;
            min-height: 44px;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 10px;
            background: #CC092F;
            box-shadow: 0 8px 18px rgba(204, 9, 47, .16);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .availability-create:hover {
            transform: translateY(-1px);
            background: #A80726;
            box-shadow: 0 11px 22px rgba(204, 9, 47, .2);
            color: #fff;
        }

        .availability-alert {
            margin-bottom: 16px;
            padding: 13px 16px;
            border: 1px solid #CBE8D1;
            border-radius: 11px;
            background: #EAF6ED;
            color: #176B35;
            font-size: 14px;
        }

        .availability-alert-error {
            border-color: #F1C7D0;
            background: #FFF0F2;
            color: #A80726;
        }

        .availability-list {
            display: grid;
            gap: 13px;
        }

        .availability-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 18px;
            padding: 19px 21px;
            border: 1px solid #EAE3E5;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 7px 20px rgba(34, 20, 25, .04);
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .availability-card:hover {
            border-color: #E8C4CC;
            box-shadow: 0 11px 24px rgba(34, 20, 25, .07);
        }

        .availability-main {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
        }

        .availability-day-icon {
            display: grid;
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            place-items: center;
            border-radius: 14px;
            background: #FFF1F4;
            color: #A80726;
        }

        .availability-day-icon svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .availability-day {
            margin: 0 0 4px;
            color: #292929;
            font-size: 15px;
            font-weight: 750;
        }

        .availability-hours {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 7px;
            color: #5D565C;
            font-size: 13px;
        }

        .availability-time {
            padding: 5px 9px;
            border: 1px solid #EEE7E9;
            border-radius: 8px;
            background: #FCFAFA;
            color: #383238;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .availability-provider {
            margin: 6px 0 0;
            color: #777;
            font-size: 12px;
        }

        .availability-side {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 15px;
        }

        .availability-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 750;
            white-space: nowrap;
        }

        .availability-status::before {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            content: "";
        }

        .availability-status-active {
            background: #E8F6ED;
            color: #176B35;
        }

        .availability-status-inactive {
            background: #F0F0F0;
            color: #5B5B5B;
        }

        .availability-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 7px;
        }

        .availability-actions form {
            margin: 0;
        }

        .availability-action {
            display: inline-flex;
            min-height: 36px;
            align-items: center;
            justify-content: center;
            padding: 7px 11px;
            border: 1px solid #E6DDE0;
            border-radius: 9px;
            background: #fff;
            color: #504950;
            cursor: pointer;
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .availability-action:hover {
            border-color: #D7C6CB;
            background: #FCF8F9;
            color: #292929;
        }

        .availability-action-edit {
            border-color: #F0D8DE;
            color: #A80726;
        }

        .availability-action-edit:hover,
        .availability-action-delete:hover {
            border-color: #E8C4CC;
            background: #FFF5F7;
            color: #A80726;
        }

        .availability-empty {
            display: grid;
            justify-items: center;
            padding: 48px 24px;
            border: 1px dashed #E5CDD2;
            border-radius: 17px;
            background: #FFFCFC;
            text-align: center;
        }

        .availability-empty-icon {
            display: grid;
            width: 54px;
            height: 54px;
            margin-bottom: 15px;
            place-items: center;
            border-radius: 16px;
            background: #FFF1F4;
            color: #CC092F;
        }

        .availability-empty-icon svg {
            width: 25px;
            height: 25px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .availability-empty h2 {
            margin: 0 0 6px;
            color: #292929;
            font-size: 17px;
        }

        .availability-empty p {
            max-width: 460px;
            margin: 0 0 18px;
            color: #686168;
            font-size: 13px;
            line-height: 1.6;
        }

        .availability-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        @media (max-width: 850px) {
            .availability-card {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .availability-side {
                justify-content: space-between;
                padding-top: 13px;
                border-top: 1px solid #F0E7E9;
            }
        }

        @media (max-width: 600px) {
            .availability-heading {
                align-items: stretch;
                flex-direction: column;
            }

            .availability-create {
                width: 100%;
            }

            .availability-side {
                align-items: flex-start;
                flex-direction: column;
                gap: 11px;
            }

            .availability-actions {
                width: 100%;
                justify-content: stretch;
            }

            .availability-action,
            .availability-actions form {
                flex: 1 1 auto;
            }

            .availability-actions form .availability-action {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
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

    <main class="container py-4 availability-page">
        <header class="availability-heading">
            <div class="availability-heading-copy">
                <span class="availability-heading-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="8.5"></circle>
                        <path d="M12 7v5l3.5 2"></path>
                    </svg>
                </span>
                <div>
                    <p class="availability-eyebrow">Agenda de atendimento</p>
                    <h1 class="availability-title">Minhas disponibilidades</h1>
                    <p class="availability-subtitle">Organize os dias e horários em que você pode atender.</p>
                </div>
            </div>

            @if(auth()->user()->tipo_usuario === 'prestador')
                <a href="{{ route('disponibilidades.create') }}" class="availability-create">
                    <span aria-hidden="true">+</span>
                    Novo horário
                </a>
            @endif
        </header>

        @if(session('sucesso'))
            <div class="availability-alert" role="status">{{ session('sucesso') }}</div>
        @endif

        @if(session('erro'))
            <div class="availability-alert availability-alert-error" role="alert">{{ session('erro') }}</div>
        @endif

        @if($disponibilidades->isEmpty())
            <section class="availability-empty">
                <span class="availability-empty-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="8.5"></circle>
                        <path d="M12 7v5l3.5 2M19 5l2 2"></path>
                    </svg>
                </span>
                <h2>Nenhum horário cadastrado</h2>
                <p>Cadastre seus horários para que os clientes saibam quando podem solicitar um agendamento.</p>
                @if(auth()->user()->tipo_usuario === 'prestador')
                    <a href="{{ route('disponibilidades.create') }}" class="availability-create">Cadastrar disponibilidade</a>
                @endif
            </section>
        @else
            <section class="availability-list" aria-label="Horários cadastrados">
                @foreach($disponibilidades as $disponibilidade)
                    <article class="availability-card">
                        <div class="availability-main">
                            <span class="availability-day-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24">
                                    <rect x="4" y="5.5" width="16" height="15" rx="2"></rect>
                                    <path d="M8 3.5v4M16 3.5v4M4 10h16"></path>
                                </svg>
                            </span>
                            <div>
                                <h2 class="availability-day">{{ $diasSemana[$disponibilidade->dia_semana] ?? 'Dia inválido' }}</h2>
                                <div class="availability-hours">
                                    <span class="availability-time">{{ substr($disponibilidade->hora_inicio, 0, 5) }}</span>
                                    <span aria-hidden="true">até</span>
                                    <span class="availability-time">{{ substr($disponibilidade->hora_fim, 0, 5) }}</span>
                                </div>
                                @if(auth()->user()?->tipo_usuario === 'administrador')
                                    <p class="availability-provider">Prestador: {{ $disponibilidade->usuario->name ?? 'Usuário não encontrado' }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="availability-side">
                            @if($disponibilidade->ativo)
                                <span class="availability-status availability-status-active">Ativo</span>
                            @else
                                <span class="availability-status availability-status-inactive">Inativo</span>
                            @endif

                            <div class="availability-actions">
                                <a href="{{ route('disponibilidades.show', $disponibilidade) }}" class="availability-action">Ver</a>
                                <a href="{{ route('disponibilidades.edit', $disponibilidade) }}" class="availability-action availability-action-edit">Editar</a>
                                <form
                                    action="{{ route('disponibilidades.destroy', $disponibilidade) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este horário?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="availability-action availability-action-delete">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>

            <div class="availability-pagination">
                {{ $disponibilidades->links() }}
            </div>
        @endif
    </main>
@endsection
