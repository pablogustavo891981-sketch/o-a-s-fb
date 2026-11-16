 @extends('layouts.app')

@section('title', 'Meus agendamentos')

@section('content')

<style>
    .oas-page {
        max-width: 1160px;
        min-height: 0;
        margin: 0 auto;
        padding: 24px 0 32px;
        background: transparent;
        color: #333333;
    }

    .oas-header {
        margin-bottom: 22px;
        padding: clamp(22px, 4vw, 34px);
        border: 1px solid #F0DEE2;
        border-radius: 20px;
        background: linear-gradient(120deg, #FFF1F4 0%, #fff 75%);
        box-shadow: 0 10px 28px rgba(48, 25, 31, .045);
    }

    .oas-header h1 {
        font-size: 28px;
        font-weight: 750;
        margin-bottom: 8px;
    }

    .oas-header p {
        color: #777777;
        margin: 0;
    }

    .oas-card {
        background: #FFFFFF;
        border: 1px solid #EAE3E5;
        border-radius: 16px;
        padding: clamp(18px, 3vw, 24px);
        margin-bottom: 16px;
        box-shadow: 0 7px 20px rgba(34, 20, 25, .04);
        transition: border-color .18s ease, box-shadow .18s ease;
    }

    .oas-card:hover {
        border-color: #E8C4CC;
        box-shadow: 0 12px 25px rgba(34, 20, 25, .07);
    }

    .oas-card h5 {
        font-weight: 700;
        color: #333333;
    }

    .oas-muted {
        color: #777777;
        font-size: 14px;
    }

    .oas-label {
        color: #777777;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: .4px;
    }

    .oas-value {
        color: #333333;
        font-weight: 600;
        margin-top: 3px;
    }

    .oas-price {
        color: #CC092F;
        font-size: 19px;
        font-weight: 750;
    }

    .oas-status {
        display: inline-block;
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        background: #FCECEF;
        color: #A80726;
    }

    .status-confirmado,
    .status-concluido {
        background: #E8F5EB;
        color: #28743B;
    }

    .status-recusado,
    .status-cancelado {
        background: #EEEEEE;
        color: #555555;
    }

    .status-em_andamento {
        background: #FFF3E0;
        color: #935B00;
    }

    .btn-oas {
        background: #CC092F;
        color: #FFFFFF;
        border: 1px solid #CC092F;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-oas:hover {
        background: #A80726;
        border-color: #A80726;
        color: #FFFFFF;
    }

    .btn-oas-outline {
        background: #FFFFFF;
        color: #CC092F;
        border: 1px solid #CC092F;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-oas-outline:hover {
        background: #FCECEF;
        color: #A80726;
    }

    .oas-select {
        border: 1px solid #DDDDDD;
        border-radius: 8px;
        min-height: 40px;
    }

    .oas-select:focus {
        border-color: #CC092F;
        box-shadow: 0 0 0 .2rem rgba(204,9,47,.12);
    }

    .oas-empty {
        background: #FFFFFF;
        border: 1px dashed #CCCCCC;
        border-radius: 12px;
        text-align: center;
        padding: 45px 20px;
        color: #777777;
    }

    .oas-empty h5 {
        color: #333333;
        font-weight: 700;
    }

    .oas-page > .container {
        max-width: 1160px;
    }

    .oas-header {
        position: relative;
        overflow: hidden;
    }

    .oas-header::after {
        position: absolute;
        right: -44px;
        bottom: -96px;
        width: 210px;
        height: 210px;
        border: 1px solid rgba(204, 9, 47, .08);
        border-radius: 50%;
        box-shadow: 0 0 0 24px rgba(204, 9, 47, .025), 0 0 0 48px rgba(94, 80, 161, .025);
        content: "";
        pointer-events: none;
    }

    .oas-header h1,
    .oas-header p {
        position: relative;
        z-index: 1;
    }

    .oas-header h1 {
        color: #292929;
        font-size: clamp(24px, 3vw, 32px);
    }

    .oas-muted {
        padding: 6px 10px;
        border: 1px solid #F0E7E9;
        border-radius: 999px;
        background: #fff;
    }

    .oas-card > .row {
        grid-template-columns: minmax(0, 1fr) minmax(220px, .34fr);
        align-items: center;
        gap: 24px;
    }

    .oas-card > .row > .col-lg-8,
    .oas-card > .row > .col-lg-4 {
        grid-column: auto;
    }

    .oas-select {
        width: 100%;
        padding: 9px 11px;
        background: #fff;
    }

    .oas-empty {
        border-color: #E5CDD2;
        border-radius: 17px;
        background: #FFFCFC;
    }

    .oas-status {
        padding: 7px 11px;
    }

    .status-pendente {
        background: #FFF4D6;
        color: #805A00;
    }

    .status-confirmado,
    .status-concluido {
        background: #E8F6ED;
        color: #176B35;
    }

    .status-recusado,
    .status-cancelado {
        background: #F0F0F0;
        color: #555;
    }

    .status-em_andamento {
        background: #F3EDFF;
        color: #5E50A1;
    }

    .btn-oas,
    .btn-oas-outline {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        text-decoration: none;
        transition: background .18s ease, border-color .18s ease, color .18s ease, transform .18s ease;
    }

    .btn-oas:hover,
    .btn-oas-outline:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .oas-page {
            padding: 16px 0 24px;
        }

        .oas-card > .row {
            grid-template-columns: 1fr;
            gap: 14px;
        }
    }

    @media(max-width: 768px) {
        .oas-header {
            padding: 22px;
        }

        .oas-header h1 {
            font-size: 23px;
        }
    }
</style>

<div class="oas-page">
    <div class="container">

        <div class="oas-header">
            <h1>Agendamentos</h1>
            <p>Acompanhe solicitações, horários e atendimentos em um só lugar.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $erro)
                    <div>{{ $erro }}</div>
                @endforeach
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h4 class="fw-bold mb-2">Suas solicitações</h4>
            <span class="oas-muted">
                {{ $agendamentos->total() }} agendamento(s)
            </span>
        </div>

        @forelse($agendamentos as $agendamento)

            @php
                $usuario = auth()->user();
                $status = $agendamento->status;

                $statusNomes = [
                    'pendente' => 'Pendente',
                    'confirmado' => 'Confirmado',
                    'recusado' => 'Recusado',
                    'em_andamento' => 'Em andamento',
                    'concluido' => 'Concluído',
                    'cancelado' => 'Cancelado',
                ];

                $opcoesStatus = [];

                if ($usuario->tipo_usuario === 'administrador') {
                    $opcoesStatus = [
                        'pendente' => 'Pendente',
                        'confirmado' => 'Confirmado',
                        'recusado' => 'Recusado',
                        'em_andamento' => 'Em andamento',
                        'concluido' => 'Concluído',
                        'cancelado' => 'Cancelado',
                    ];
                } elseif ($usuario->tipo_usuario === 'cliente') {
                    if (in_array($status, ['pendente', 'confirmado'])) {
                        $opcoesStatus = ['cancelado' => 'Cancelar agendamento'];
                    }
                } elseif ($usuario->tipo_usuario === 'prestador') {
                    $transicoes = [
                        'pendente' => [
                            'confirmado' => 'Confirmar',
                            'recusado' => 'Recusar',
                        ],
                        'confirmado' => [
                            'em_andamento' => 'Iniciar atendimento',
                            'cancelado' => 'Cancelar',
                        ],
                        'em_andamento' => [
                            'concluido' => 'Concluir atendimento',
                        ],
                    ];

                    $opcoesStatus = $transicoes[$status] ?? [];
                }
            @endphp

            <div class="oas-card">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-8">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                            <div>
                                <span class="oas-label">Serviço</span>
                                <h5 class="mt-1 mb-0">
                                    {{ $agendamento->servico->nome ?? 'Serviço não disponível' }}
                                </h5>
                            </div>

                            <span class="oas-status status-{{ $status }}">
                                {{ $statusNomes[$status] ?? ucfirst($status) }}
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="oas-label">Data</div>
                                <div class="oas-value">
                                    {{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="oas-label">Horário</div>
                                <div class="oas-value">
                                    {{ substr($agendamento->horario, 0, 5) }}
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="oas-label">Valor</div>
                                <div class="oas-price">
                                    R$ {{ number_format($agendamento->servico->preco ?? 0, 2, ',', '.') }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="oas-label">Cliente</div>
                                <div class="oas-value">
                                    {{ $agendamento->cliente->name ?? 'Não informado' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="oas-label">Prestador</div>
                                <div class="oas-value">
                                    {{ $agendamento->prestador->name ?? 'Não informado' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('agendamentos.show', $agendamento) }}"
                                class="btn btn-oas">
                                Ver detalhes
                            </a>

                            @if(count($opcoesStatus) > 0)
                                <form method="POST"
                                    action="{{ route('agendamentos.update', $agendamento) }}"
                                    onsubmit="return confirm('Deseja realmente alterar o status deste agendamento?')">
                                    @csrf
                                    @method('PUT')

                                    <select name="status" class="form-select oas-select mb-2" required>
                                        <option value="">Alterar status...</option>
                                        @foreach($opcoesStatus as $valor => $nome)
                                            <option value="{{ $valor }}">{{ $nome }}</option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-oas-outline w-100">
                                        Atualizar status
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        @empty
            <div class="oas-empty">
                <h5>Nenhum agendamento encontrado</h5>
                <p class="mb-0">
                    Quando houver solicitações ou atendimentos, eles aparecerão aqui.
                </p>
            </div>
        @endforelse

        <div class="mt-4 d-flex justify-content-center">
            {{ $agendamentos->links() }}
        </div>

    </div>
</div>

@endsection