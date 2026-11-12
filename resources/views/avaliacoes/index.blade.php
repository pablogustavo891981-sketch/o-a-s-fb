 @extends('layouts.app')

@section('title', 'Avaliações')

@section('content')

<style>
    .oas-avaliacoes {
        background: #F5F5F5;
        min-height: 80vh;
        padding: 38px 0 60px;
        color: #333333;
    }

    .avaliacoes-header {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #FFFFFF 0%, #FFF7F8 100%);
        border: 1px solid #F1DDE1;
        border-left: 6px solid #CC092F;
        border-radius: 16px;
        padding: clamp(22px, 4vw, 34px);
        margin-bottom: 22px;
        box-shadow: 0 10px 24px rgba(45,28,35,.05);
    }

    .avaliacoes-header h1 {
        color: #292929;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 750;
        margin: 0 0 8px;
    }

    .avaliacoes-header p {
        color: #777777;
        margin: 0;
        line-height: 1.6;
    }

    .avaliacoes-resumo {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 190px), 1fr));
        gap: 12px;
        margin-bottom: 28px;
    }

    .avaliacoes-indicador {
        display: flex;
        min-height: 88px;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        border: 1px solid #EAE6E7;
        border-radius: 13px;
        background: #fff;
        box-shadow: 0 5px 16px rgba(35,20,28,.035);
    }

    .indicador-icone {
        display: grid;
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        place-items: center;
        border-radius: 12px;
        background: #FCECEF;
        color: #A80726;
        font-size: 20px;
        font-weight: 800;
    }

    .avaliacoes-indicador small {
        display: block;
        color: #666;
        font-size: 13px;
        font-weight: 600;
    }

    .avaliacoes-indicador strong {
        display: block;
        margin-top: 3px;
        color: #292929;
        font-size: 20px;
    }

    .avaliacoes-secao-titulo {
        display: flex;
        align-items: end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }

    .avaliacoes-secao-titulo h2 {
        margin: 0;
        color: #292929;
        font-size: 20px;
    }

    .avaliacoes-secao-titulo p {
        margin: 4px 0 0;
        color: #777;
        font-size: 14px;
    }

    .avaliacao-card {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(220px, .34fr);
        gap: 22px;
        background: #FFFFFF;
        border: 1px solid #E5E5E5;
        border-radius: 15px;
        padding: clamp(18px, 3vw, 24px);
        margin-bottom: 18px;
        box-shadow: 0 5px 18px rgba(0,0,0,.035);
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .avaliacao-card:hover {
        border-color: #E8B7C1;
        box-shadow: 0 12px 24px rgba(0,0,0,.07);
        transform: translateY(-1px);
    }

    .avaliacao-card h5 {
        margin: 11px 0 8px;
        color: #292929;
        font-weight: 700;
        font-size: 18px;
    }

    .avaliacao-servico {
        color: #CC092F;
        font-weight: 700;
        font-size: 17px;
    }

    .avaliacao-nota {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #A66B00;
        font-size: 20px;
        letter-spacing: 1px;
    }

    .avaliacao-nota .estrela-vazia {
        color: #C8C8C8;
    }

    .avaliacao-comentario {
        color: #555555;
        line-height: 1.7;
        margin: 13px 0 0;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .avaliacao-comentario-vazio {
        color: #777;
        font-size: 14px;
        font-style: italic;
    }

    .avaliacao-info {
        color: #777777;
        font-size: 13px;
    }

    .avaliacao-contexto {
        display: grid;
        align-content: start;
        gap: 12px;
        padding-left: 20px;
        border-left: 1px solid #EEE8EA;
    }

    .avaliacao-contexto-item small {
        display: block;
        margin-bottom: 3px;
        color: #777;
        font-size: 12px;
    }

    .avaliacao-contexto-item strong {
        color: #333;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .avaliacao-acoes {
        display: grid;
        align-content: start;
        gap: 8px;
        margin-top: 4px;
    }

    .avaliacao-tag {
        display: inline-block;
        background: #FCECEF;
        color: #A80726;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        width: fit-content;
    }

    .btn-avaliacao {
        display: inline-flex;
        min-height: 46px;
        align-items: center;
        justify-content: center;
        gap: 7px;
        background: #CC092F;
        border: 1px solid #CC092F;
        color: white;
        border-radius: 9px;
        font-weight: 600;
        padding: 10px 16px;
        text-decoration: none;
        transition: background .2s ease, transform .2s ease;
    }

    .btn-avaliacao:hover {
        background: #A80726;
        border-color: #A80726;
        color: white;
        transform: translateY(-1px);
    }

    .btn-avaliacao-outline {
        background: #fff;
        color: #A80726;
        border: 1px solid #E8B7C1;
        border-radius: 9px;
        font-weight: 700;
        min-height: 44px;
        padding: 10px 14px;
    }

    .btn-avaliacao-outline:hover {
        background: #FCECEF;
        color: #A80726;
    }

    .avaliacoes-vazio {
        background: white;
        border: 1px dashed #D6C9CC;
        border-radius: 15px;
        padding: clamp(30px, 6vw, 52px) 20px;
        text-align: center;
        color: #777777;
        box-shadow: 0 5px 18px rgba(0,0,0,.025);
    }

    .avaliacoes-vazio h5 {
        color: #333333;
        font-weight: 700;
        margin: 0 0 8px;
    }

    .avaliacoes-vazio p {
        margin: 0 auto 18px;
        max-width: 480px;
        line-height: 1.6;
    }

    .avaliacoes-vazio-icone {
        display: grid;
        width: 56px;
        height: 56px;
        margin: 0 auto 14px;
        place-items: center;
        border-radius: 16px;
        background: #FCECEF;
        color: #A80726;
        font-size: 25px;
    }

    @media(max-width: 768px) {
        .avaliacoes-header {
            padding: 22px;
        }

        .avaliacao-card {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .avaliacao-contexto {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            padding: 15px 0 0;
            border-top: 1px solid #EEE8EA;
            border-left: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .avaliacao-card,
        .btn-avaliacao {
            transition: none;
        }
    }
</style>

<div class="oas-avaliacoes">
    <div class="container">

        <div class="avaliacoes-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1>Avaliações</h1>
                    <p>
                        @if(auth()->user()?->tipo_usuario === 'cliente')
                            Consulte suas avaliações e compartilhe como foi sua experiência.
                        @elseif(auth()->user()?->tipo_usuario === 'prestador')
                            Acompanhe as opiniões dos clientes sobre os serviços que você oferece.
                        @else
                            Consulte as avaliações registradas na plataforma.
                        @endif
                    </p>
                </div>

                @if(auth()->user()?->tipo_usuario === 'cliente')
                    <a href="{{ route('avaliacoes.create') }}" class="btn-avaliacao">
                        <span aria-hidden="true">＋</span>
                        Avaliar um serviço
                    </a>
                @endif
            </div>
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

        <div class="avaliacoes-resumo" aria-label="Resumo das avaliações">
            <div class="avaliacoes-indicador">
                <span class="indicador-icone" aria-hidden="true">★</span>
                <span>
                    <small>Média das avaliações</small>
                    <strong>
                        {{ $mediaAvaliacoes !== null ? number_format($mediaAvaliacoes, 1, ',', '.') : '—' }}
                        @if($mediaAvaliacoes !== null)<span class="avaliacao-info">/ 5</span>@endif
                    </strong>
                </span>
            </div>
            <div class="avaliacoes-indicador">
                <span class="indicador-icone" aria-hidden="true">▤</span>
                <span>
                    <small>Total de avaliações</small>
                    <strong>{{ $avaliacoes->total() }}</strong>
                </span>
            </div>
        </div>

        <div class="avaliacoes-secao-titulo">
            <div>
                <h2>Histórico de avaliações</h2>
                <p>Mais recentes primeiro</p>
            </div>
        </div>

        @forelse($avaliacoes as $avaliacao)

            <div class="avaliacao-card">
                <div>
                    <span class="avaliacao-tag">Avaliação de serviço</span>
                    <h5>{{ $avaliacao->agendamento->servico->nome ?? 'Serviço não disponível' }}</h5>

                    <div class="avaliacao-nota">
                        <span aria-hidden="true">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $avaliacao->nota)
                                    ★
                                @else
                                    <span class="estrela-vazia">★</span>
                                @endif
                            @endfor
                        </span>
                        <span class="avaliacao-info" aria-label="Nota {{ $avaliacao->nota }} de 5">
                            {{ $avaliacao->nota }} de 5
                        </span>
                    </div>

                    @if($avaliacao->comentario)
                        <p class="avaliacao-comentario">{{ $avaliacao->comentario }}</p>
                    @else
                        <p class="avaliacao-comentario avaliacao-comentario-vazio">
                            Nenhum comentário foi adicionado.
                        </p>
                    @endif
                </div>

                <aside class="avaliacao-contexto" aria-label="Informações da avaliação">
                    @if(auth()->user()?->tipo_usuario !== 'cliente')
                        <div class="avaliacao-contexto-item">
                            <small>Cliente</small>
                            <strong>{{ $avaliacao->cliente->name ?? 'Não informado' }}</strong>
                        </div>
                    @endif

                    @if(auth()->user()?->tipo_usuario !== 'prestador')
                        <div class="avaliacao-contexto-item">
                            <small>Prestador</small>
                            <strong>{{ $avaliacao->prestador->name ?? 'Não informado' }}</strong>
                        </div>
                    @endif

                    <div class="avaliacao-contexto-item">
                        <small>Data da avaliação</small>
                        <strong>{{ $avaliacao->created_at->format('d/m/Y') }}</strong>
                    </div>

                    <div class="avaliacao-acoes">
                        <a href="{{ route('avaliacoes.show', $avaliacao) }}" class="btn-avaliacao-outline">
                            Ver detalhes
                        </a>

                        @if(auth()->user()?->tipo_usuario === 'cliente' &&
                            auth()->id() === $avaliacao->cliente_id)
                            <a href="{{ route('avaliacoes.edit', $avaliacao) }}" class="btn-avaliacao-outline">
                                Editar avaliação
                            </a>
                        @endif

                        @if(auth()->user()?->tipo_usuario === 'administrador' ||
                            auth()->id() === $avaliacao->cliente_id)
                            <form method="POST"
                                action="{{ route('avaliacoes.destroy', $avaliacao) }}"
                                onsubmit="return confirm('Deseja realmente excluir esta avaliação?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger w-100">
                                    Excluir avaliação
                                </button>
                            </form>
                        @endif
                    </div>
                </aside>
            </div>

        @empty
            <div class="avaliacoes-vazio">
                <span class="avaliacoes-vazio-icone" aria-hidden="true">★</span>
                <h5>Nenhuma avaliação encontrada</h5>
                <p>As avaliações registradas para seu perfil aparecerão aqui.</p>
                @if(auth()->user()?->tipo_usuario === 'cliente')
                    <a href="{{ route('avaliacoes.create') }}" class="btn-avaliacao">
                        Avaliar um serviço concluído
                    </a>
                @elseif(auth()->user()?->tipo_usuario === 'prestador')
                    <a href="{{ route('agendamentos.index') }}" class="btn-avaliacao">
                        Consultar meus agendamentos
                    </a>
                @endif
            </div>
        @endforelse

        <div class="mt-4 d-flex justify-content-center">
            {{ $avaliacoes->links() }}
        </div>

    </div>
</div>

@endsection