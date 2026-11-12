@extends('layouts.app')

@section('content')
<style>
    .agendamento-detalhes {
        max-width: 950px;
        margin: 35px auto;
        padding: 0 18px;
        color: #333;
    }

    .agendamento-detalhes .cabecalho {
        background: #CC092F;
        color: white;
        padding: 28px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .agendamento-detalhes .cabecalho h1 {
        margin: 0 0 8px;
        font-size: 26px;
    }

    .agendamento-detalhes .card {
        background: white;
        border: 1px solid #E5E5E5;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .agendamento-detalhes h2 {
        color: #A80726;
        font-size: 19px;
        margin: 0 0 20px;
    }

    .agendamento-detalhes .informacoes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 20px;
    }

    .agendamento-detalhes .campo small {
        display: block;
        color: #777;
        margin-bottom: 5px;
    }

    .agendamento-detalhes .campo strong {
        font-size: 15px;
        overflow-wrap: anywhere;
    }

    .agendamento-detalhes .status {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 20px;
        background: #FCECEF;
        color: #A80726;
        font-weight: bold;
        text-transform: capitalize;
    }

    .agendamento-detalhes .acoes {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .agendamento-detalhes .botao {
        display: inline-block;
        border: 0;
        border-radius: 7px;
        padding: 11px 18px;
        background: #CC092F;
        color: white;
        text-decoration: none;
        cursor: pointer;
        font-weight: 600;
    }

    .agendamento-detalhes .botao:hover {
        background: #A80726;
        color: white;
    }

    .agendamento-detalhes .botao-secundario {
        background: #F5F5F5;
        color: #333;
        border: 1px solid #DDD;
    }

    .agendamento-detalhes .botao-secundario:hover {
        background: #EAEAEA;
        color: #333;
    }

    .agendamento-detalhes textarea,
    .agendamento-detalhes select {
        width: 100%;
        max-width: 450px;
        padding: 11px;
        border: 1px solid #DDD;
        border-radius: 7px;
        margin-top: 8px;
    }

    .agendamento-detalhes .alerta {
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 18px;
        background: #FCECEF;
        color: #A80726;
    }

    @media(max-width: 600px) {
        .agendamento-detalhes .cabecalho {
            padding: 20px;
        }

        .agendamento-detalhes .card {
            padding: 18px;
        }
    }
</style>

@php
    $usuario = auth()->user();
    $tipoUsuario = $usuario->tipo_usuario;

    $statusNomes = [
        'pendente' => 'Pendente',
        'confirmado' => 'Confirmado',
        'recusado' => 'Recusado',
        'em_andamento' => 'Em andamento',
        'concluido' => 'Concluído',
        'cancelado' => 'Cancelado',
    ];

    $opcoesStatus = [];

    if ($tipoUsuario === 'admin') {
        $opcoesStatus = [
            'confirmado' => 'Confirmar',
            'recusado' => 'Recusar',
            'em_andamento' => 'Iniciar atendimento',
            'concluido' => 'Concluir',
            'cancelado' => 'Cancelar',
        ];
    } elseif ($tipoUsuario === 'prestador') {
        if ($agendamento->status === 'pendente') {
            $opcoesStatus = [
                'confirmado' => 'Confirmar',
                'recusado' => 'Recusar',
            ];
        } elseif ($agendamento->status === 'confirmado') {
            $opcoesStatus = [
                'em_andamento' => 'Iniciar atendimento',
                'cancelado' => 'Cancelar',
            ];
        } elseif ($agendamento->status === 'em_andamento') {
            $opcoesStatus = [
                'concluido' => 'Concluir atendimento',
            ];
        }
    } elseif (
        $tipoUsuario === 'cliente' &&
        in_array($agendamento->status, ['pendente', 'confirmado'])
    ) {
        $opcoesStatus = [
            'cancelado' => 'Cancelar agendamento',
        ];
    }
@endphp

<div class="agendamento-detalhes">

    <div class="cabecalho">
        <h1>Detalhes do agendamento</h1>
        <p>Consulte as informações e acompanhe a situação do serviço.</p>
    </div>

    @if(session('success'))
        <div class="alerta">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alerta">
            <strong>Não foi possível realizar a operação:</strong>
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <h2>Informações do serviço</h2>

        <div class="informacoes">
            <div class="campo">
                <small>Serviço</small>
                <strong>{{ $agendamento->servico->nome ?? 'Não informado' }}</strong>
            </div>

            <div class="campo">
                <small>Valor</small>
                <strong>
                    R$ {{ number_format($agendamento->servico->preco ?? 0, 2, ',', '.') }}
                </strong>
            </div>

            <div class="campo">
                <small>Duração</small>
                <strong>
                    {{ $agendamento->servico->duracao ?? 'Não informada' }}
                    @if(is_numeric($agendamento->servico->duracao ?? null))
                        minutos
                    @endif
                </strong>
            </div>

            <div class="campo">
                <small>Local do atendimento</small>
                <strong style="white-space:pre-line;">
                    {{ $agendamento->servico->local_atendimento ?: 'A combinar com o prestador' }}
                </strong>
            </div>

            <div class="campo">
                <small>Situação</small>
                <span class="status">
                    {{ $statusNomes[$agendamento->status] ?? $agendamento->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Data e horário</h2>

        <div class="informacoes">
            <div class="campo">
                <small>Data</small>
                <strong>
                    {{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}
                </strong>
            </div>

            <div class="campo">
                <small>Horário</small>
                <strong>
                    {{ substr($agendamento->horario, 0, 5) }}
                </strong>
            </div>

            <div class="campo">
                <small>Telefone informado</small>
                <strong>{{ $agendamento->telefone_cliente ?? 'Não informado' }}</strong>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Participantes</h2>

        <div class="informacoes">
            <div class="campo">
                <small>Cliente</small>
                <strong>
                    {{ $agendamento->cliente->name ?? 'Não informado' }}
                </strong>
            </div>

            <div class="campo">
                <small>Prestador</small>
                <strong>
                    {{ $agendamento->prestador->name ?? 'Não informado' }}
                </strong>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Observações</h2>

        <p>
            {{ $agendamento->observacoes ?: 'Nenhuma observação foi informada.' }}
        </p>
    </div>

    @if(count($opcoesStatus))
        <div class="card">
            <h2>Atualizar situação</h2>

            <form
                action="{{ route('agendamentos.update', $agendamento->id) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <label for="status">Selecione a nova situação:</label>

                <select name="status" id="status" required>
                    @foreach($opcoesStatus as $valor => $nome)
                        <option value="{{ $valor }}">{{ $nome }}</option>
                    @endforeach
                </select>

                <div class="acoes">
                    <button type="submit" class="botao">
                        Atualizar agendamento
                    </button>
                </div>
            </form>
        </div>
    @endif

    @if(
        $tipoUsuario === 'cliente' &&
        $agendamento->status === 'concluido' &&
        !$agendamento->avaliacao
    )
        <div class="card">
            <h2>Avalie o serviço</h2>
            <p>O atendimento foi concluído. Conte como foi sua experiência!</p>

            <a
                href="{{ route('avaliacoes.create') }}"
                class="botao"
            >
                Avaliar serviço
            </a>
        </div>
    @endif

    @if($agendamento->avaliacao)
        <div class="card">
            <h2>Avaliação registrada</h2>

            <p>
                Nota:
                <strong>{{ $agendamento->avaliacao->nota }}/5</strong>
            </p>

            <p>
                {{ $agendamento->avaliacao->comentario ?: 'Sem comentário.' }}
            </p>

            <a
                href="{{ route('avaliacoes.show', $agendamento->avaliacao->id) }}"
                class="botao"
            >
                Ver avaliação
            </a>
        </div>
    @endif

    <div class="acoes">
        <a href="{{ route('agendamentos.index') }}"
           class="botao botao-secundario">
            Voltar para agendamentos
        </a>
    </div>

</div>
@endsection
