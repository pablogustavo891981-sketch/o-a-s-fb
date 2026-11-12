 @extends('layouts.app')

@section('title', 'Meus agendamentos')

@section('content')

<style>
    .oas-page {
        background: #F5F5F5;
        min-height: 80vh;
        padding: 38px 0 60px;
        color: #333333;
    }

    .oas-header {
        background: #FFFFFF;
        border-left: 6px solid #CC092F;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 28px;
        box-shadow: 0 4px 15px rgba(0,0,0,.04);
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
        border: 1px solid #E5E5E5;
        border-radius: 12px;
        padding: 22px;
        margin-bottom: 18px;
        box-shadow: 0 4px 14px rgba(0,0,0,.035);
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