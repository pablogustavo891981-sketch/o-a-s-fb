@extends('layouts.app')

@section('title', 'Detalhes da avaliação')

@section('content')
<style>
    .avaliacao-detalhes {
        max-width: 850px;
        margin: 35px auto;
        padding: 0 18px;
        color: #333;
    }

    .avaliacao-detalhes .cabecalho {
        background: linear-gradient(120deg, #CC092F 0%, #A80726 100%);
        color: white;
        padding: clamp(22px, 4vw, 32px);
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 10px 24px rgba(110, 6, 30, .16);
    }

    .avaliacao-detalhes .cabecalho h1 {
        margin: 0 0 8px;
        font-size: clamp(24px, 3vw, 30px);
    }

    .avaliacao-detalhes .cabecalho p { margin: 0; line-height: 1.6; }

    .avaliacao-detalhes .card {
        background: white;
        border: 1px solid #E8E2E4;
        border-radius: 15px;
        padding: clamp(20px, 4vw, 28px);
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(0,0,0,.045);
    }

    .avaliacao-detalhes h2 {
        color: #292929;
        font-size: 19px;
        margin: 0 0 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #F0E9EB;
    }

    .avaliacao-detalhes .informacoes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .avaliacao-detalhes .campo small {
        display: block;
        color: #777;
        margin-bottom: 5px;
    }

    .avaliacao-detalhes .campo strong {
        overflow-wrap: anywhere;
    }

    .avaliacao-detalhes .estrelas {
        color: #A66B00;
        font-size: 32px;
        letter-spacing: 2px;
    }

    .avaliacao-detalhes .nota-destaque {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .avaliacao-detalhes .nota-numero {
        color: #292929;
        font-size: 20px;
    }

    .avaliacao-detalhes .comentario {
        background: #FFF7F8;
        border: 1px solid #F1DDE1;
        border-radius: 10px;
        padding: 20px;
        line-height: 1.7;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .avaliacao-detalhes .comentario-vazio {
        color: #777;
        font-style: italic;
    }

    .avaliacao-detalhes .botoes {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .avaliacao-detalhes .botao {
        display: inline-flex;
        min-height: 46px;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        border-radius: 9px;
        padding: 11px 18px;
        background: #CC092F;
        color: white;
        text-decoration: none;
        cursor: pointer;
        font-weight: 600;
        transition: background .2s ease, transform .2s ease;
    }

    .avaliacao-detalhes .botao:hover {
        background: #A80726;
        color: white;
        transform: translateY(-1px);
    }

    .avaliacao-detalhes .secundario {
        background: #F5F5F5;
        color: #333;
        border: 1px solid #DDD;
    }

    .avaliacao-detalhes .secundario:hover {
        background: #EAEAEA;
        color: #333;
    }

    .avaliacao-detalhes .excluir {
        background: #777;
    }

    .avaliacao-detalhes .excluir:hover {
        background: #555;
    }

    @media(max-width: 600px) {
        .avaliacao-detalhes .card {
            padding: 18px;
        }

        @media (prefers-reduced-motion: reduce) {
            .avaliacao-detalhes .botao { transition: none; }
        }
    }
</style>

@php
    $usuario = auth()->user();

    $podeEditar = $usuario->tipo_usuario === 'cliente'
        && $avaliacao->cliente_id === $usuario->id;

    $podeExcluir = $usuario->tipo_usuario === 'administrador'
        || $podeEditar;
@endphp

<div class="avaliacao-detalhes">

    <div class="cabecalho">
        <h1>Detalhes da avaliação</h1>
        <p>Confira a opinião registrada sobre o serviço.</p>
    </div>

    <div class="card">
        <h2>Serviço avaliado</h2>

        <div class="informacoes">
            <div class="campo">
                <small>Serviço</small>
                <strong>
                    {{ $avaliacao->agendamento->servico->nome ?? 'Não informado' }}
                </strong>
            </div>

            <div class="campo">
                <small>Data do atendimento</small>
                <strong>
                    {{ \Carbon\Carbon::parse($avaliacao->agendamento->data)->format('d/m/Y') }}
                </strong>
            </div>

            <div class="campo">
                <small>Prestador</small>
                <strong>
                    {{ $avaliacao->prestador->name ?? $avaliacao->agendamento->prestador->name ?? 'Não informado' }}
                </strong>
            </div>

            <div class="campo">
                <small>Cliente</small>
                <strong>
                    {{ $avaliacao->cliente->name ?? 'Não informado' }}
                </strong>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Nota atribuída</h2>

        <div class="nota-destaque">
            <div class="estrelas" aria-hidden="true">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= $avaliacao->nota ? '★' : '☆' }}
                @endfor
            </div>
            <strong class="nota-numero" aria-label="Nota {{ $avaliacao->nota }} de 5 estrelas">
                {{ $avaliacao->nota }} de 5 estrelas
            </strong>
        </div>
    </div>

    <div class="card">
        <h2>Comentário</h2>

        <div class="comentario {{ $avaliacao->comentario ? '' : 'comentario-vazio' }}">
            {{ $avaliacao->comentario ?: 'Nenhum comentário foi registrado.' }}
        </div>
    </div>

    <div class="card">
        <h2>Registro da avaliação</h2>

        <div class="informacoes">
            <div class="campo">
                <small>Data de criação</small>
                <strong>
                    {{ $avaliacao->created_at->format('d/m/Y H:i') }}
                </strong>
            </div>

            @if($avaliacao->updated_at && $avaliacao->updated_at->ne($avaliacao->created_at))
                <div class="campo">
                    <small>Última atualização</small>
                    <strong>
                        {{ $avaliacao->updated_at->format('d/m/Y H:i') }}
                    </strong>
                </div>
            @endif
        </div>
    </div>

    <div class="botoes">

        @if($podeEditar)
            <a
                href="{{ route('avaliacoes.edit', $avaliacao->id) }}"
                class="botao"
            >
                Editar avaliação
            </a>
        @endif

        @if($podeExcluir)
            <form
                action="{{ route('avaliacoes.destroy', $avaliacao->id) }}"
                method="POST"
                onsubmit="return confirm('Tem certeza de que deseja excluir esta avaliação?')"
            >
                @csrf
                @method('DELETE')

                <button type="submit" class="botao excluir">
                    Excluir avaliação
                </button>
            </form>
        @endif

        <a
            href="{{ route('avaliacoes.index') }}"
            class="botao secundario"
        >
            Voltar para avaliações
        </a>

    </div>

</div>
@endsection
