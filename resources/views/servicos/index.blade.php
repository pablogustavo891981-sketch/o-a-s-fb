 @extends('layouts.app')

@section('title', 'Serviços disponíveis')

@section('content')

<style>
    :root {
        --bradesco-red: #CC092F;
        --bradesco-red-dark: #A80726;
        --bradesco-red-light: #FCECEF;
        --bradesco-white: #FFFFFF;
        --bradesco-background: #F5F5F5;
        --bradesco-text: #333333;
        --bradesco-muted: #777777;
        --bradesco-border: #E5E5E5;
    }

    .servicos-page {
        background: var(--bradesco-background);
        min-height: 80vh;
        padding: 30px 0 60px;
        color: var(--bradesco-text);
    }

    .servicos-banner {
        background: linear-gradient(120deg, var(--bradesco-white) 0%, #fff8f9 100%);
        border-left: 6px solid var(--bradesco-red);
        border-radius: 18px;
        padding: clamp(24px, 4vw, 36px);
        margin-bottom: 30px;
        box-shadow: 0 12px 28px rgba(45,28,35,.05);
    }

    .servicos-banner h1 {
        color: var(--bradesco-text);
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 750;
        margin-bottom: 10px;
    }

    .servicos-banner p {
        color: var(--bradesco-muted);
        margin: 0;
    }

    .btn-cadastrar {
        background: var(--bradesco-red);
        color: white;
        border: 1px solid var(--bradesco-red);
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .btn-cadastrar:hover {
        background: var(--bradesco-red-dark);
        border-color: var(--bradesco-red-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(204,9,47,.16);
    }

    .filtro-card {
        background: white;
        border: 1px solid var(--bradesco-border);
        border-radius: 15px;
        padding: 24px;
        margin-bottom: 32px;
        box-shadow: 0 4px 15px rgba(0,0,0,.035);
    }

    .filtro-card h5 {
        color: var(--bradesco-text);
        font-weight: 700;
        margin-bottom: 20px;
    }

    .filtro-card label {
        display: block;
        color: var(--bradesco-text);
        font-weight: 600;
        margin-bottom: 8px;
    }

    .filtro-card .form-control,
    .filtro-card .form-select {
        min-height: 46px;
        border: 1px solid var(--bradesco-border);
        border-radius: 8px;
        color: var(--bradesco-text);
    }

    .filtro-card .form-control:focus,
    .filtro-card .form-select:focus {
        border-color: var(--bradesco-red);
        box-shadow: 0 0 0 .2rem rgba(204,9,47,.12);
    }

    .btn-pesquisar {
        background: var(--bradesco-red);
        color: white;
        border: 1px solid var(--bradesco-red);
        border-radius: 8px;
        min-height: 46px;
        width: 100%;
        font-weight: 600;
    }

    .btn-pesquisar:hover {
        background: var(--bradesco-red-dark);
        color: white;
    }

    .servicos-titulo {
        color: var(--bradesco-text);
        font-weight: 750;
    }

    .servicos-contagem {
        color: var(--bradesco-muted);
        font-size: 14px;
    }

    .servico-card {
        background: white;
        border: 1px solid var(--bradesco-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(35,20,28,.04);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
    }

    .servico-card:hover {
        transform: translateY(-5px);
        border-color: #F1C7D0;
        box-shadow: 0 16px 30px rgba(66,27,38,.1);
    }

    .servico-imagem {
        width: 100%;
        height: 215px;
        object-fit: cover;
        background: #EEEEEE;
        transition: transform .35s ease;
    }

    .servico-card:hover .servico-imagem {
        transform: scale(1.025);
    }

    .servico-sem-imagem {
        height: 215px;
        background: linear-gradient(135deg, var(--bradesco-red-light), #F2EFFA);
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--bradesco-red);
        font-size: 48px;
    }

    .servico-card .card-body {
        padding: 22px;
    }

    .categoria-tag {
        display: inline-block;
        background: var(--bradesco-red-light);
        color: var(--bradesco-red-dark);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 13px;
    }

    .servico-card h5 {
        color: var(--bradesco-text);
        font-size: 19px;
        font-weight: 700;
    }

    .servico-descricao {
        color: var(--bradesco-muted);
        font-size: 14px;
        min-height: 48px;
    }

    .servico-preco {
        color: var(--bradesco-red);
        font-size: 22px;
        font-weight: 750;
    }

    .servico-info {
        color: var(--bradesco-muted);
        font-size: 13px;
        margin-top: 5px;
    }

    .btn-detalhes {
        background: white;
        border: 1px solid var(--bradesco-red);
        color: var(--bradesco-red);
        border-radius: 9px;
        font-weight: 600;
        transition: color .2s ease, background .2s ease, transform .2s ease;
    }

    .btn-detalhes:hover {
        background: var(--bradesco-red-light);
        color: var(--bradesco-red-dark);
    }

    .btn-agendar {
        background: var(--bradesco-red);
        border: 1px solid var(--bradesco-red);
        color: white;
        border-radius: 9px;
        font-weight: 600;
        transition: color .2s ease, background .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    .btn-agendar:hover {
        background: var(--bradesco-red-dark);
        border-color: var(--bradesco-red-dark);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(204,9,47,.16);
    }

    .btn-editar {
        border: 1px solid #777777;
        color: #555555;
        background: white;
        border-radius: 8px;
    }

    .btn-editar:hover {
        background: #EEEEEE;
        color: #333333;
    }

    .servicos-vazio {
        background: white;
        border: 1px dashed #CCCCCC;
        border-radius: 16px;
        padding: 45px 20px;
        text-align: center;
        color: var(--bradesco-muted);
    }

    .servicos-vazio h5 {
        color: var(--bradesco-text);
        font-weight: 700;
    }

    .servicos-page .alert-success {
        background: #EDF7EF;
        border-color: #C7E5CD;
        color: #276738;
    }

    .servicos-page .pagination .page-link {
        color: var(--bradesco-red);
        border-color: var(--bradesco-border);
    }

    .servicos-page .pagination .active .page-link {
        background: var(--bradesco-red);
        border-color: var(--bradesco-red);
        color: white;
    }

    .servicos-page {
        max-width: 1160px;
        min-height: 0;
        margin: 0 auto;
        padding: 24px 0 32px;
        background: transparent;
    }

    .servicos-banner {
        margin-bottom: 22px;
        border: 1px solid #F0DEE2;
        border-left: 1px solid #F0DEE2;
        border-radius: 20px;
        background: linear-gradient(120deg, #FFF1F4 0%, #fff 75%);
        box-shadow: 0 10px 28px rgba(48, 25, 31, .045);
    }

    .filtro-card {
        margin-bottom: 24px;
        border-color: #EAE3E5;
        border-radius: 16px;
        box-shadow: 0 7px 20px rgba(34, 20, 25, .035);
    }

    .servico-card {
        height: 100%;
        border-color: #EAE3E5;
        border-radius: 17px;
        box-shadow: 0 7px 20px rgba(34, 20, 25, .04);
    }

    .servico-card .card-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 15px;
    }

    .servico-card .card-body > div:last-child {
        margin-top: auto;
    }

    .servico-imagem,
    .servico-sem-imagem {
        height: 200px;
    }

    .servicos-vazio {
        border-color: #E5CDD2;
        border-radius: 17px;
        background: #FFFCFC;
    }

    .servicos-contagem {
        padding: 6px 10px;
        border: 1px solid #F0E7E9;
        border-radius: 999px;
        background: #fff;
    }

    @media (max-width: 768px) {
        .servicos-banner {
            padding: 25px;
        }

        .servicos-banner h1 {
            font-size: 24px;
        }
    }

    @media (max-width: 480px) {
        .servicos-page {
            padding: 16px 0 24px;
        }

        .servicos-banner,
        .filtro-card {
            padding: 18px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .servico-card, .servico-imagem, .btn-cadastrar, .btn-detalhes, .btn-agendar {
            transition-duration: .01ms;
        }
    }
</style>

<div class="servicos-page">
    <div class="container">

        <div class="servicos-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Encontre o serviço ideal</h1>
                    <p>
                        Descubra serviços oferecidos pela nossa comunidade
                        e agende com facilidade.
                    </p>
                </div>

                @if(in_array(auth()->user()?->tipo_usuario, ['prestador', 'administrador']))
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('servicos.create') }}" class="btn-cadastrar">
                            + Cadastrar serviço
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="filtro-card">
            <h5>Pesquisar serviços</h5>

            <form method="GET" action="{{ route('servicos.index') }}">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label>Nome ou descrição</label>
                        <input type="text" name="busca" class="form-control"
                            value="{{ request('busca') }}"
                            placeholder="O que você está procurando?">
                    </div>

                    <div class="col-md-3">
                        <label>Categoria</label>
                        <select name="categoria_id" class="form-select">
                            <option value="">Todas as categorias</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    @selected(request('categoria_id') == $categoria->id)>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Preço máximo (R$)</label>
                        <input type="number" name="preco_maximo"
                            class="form-control" min="0" step="0.01"
                            value="{{ request('preco_maximo') }}"
                            placeholder="Ex.: 100,00">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-pesquisar">
                            Pesquisar
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h4 class="servicos-titulo mb-2">Serviços disponíveis</h4>
            <span class="servicos-contagem">
                {{ $servicos->total() }} serviço(s) encontrado(s)
            </span>
        </div>

        <div class="row g-4">
            @forelse($servicos as $servico)

                <div class="col-sm-6 col-lg-4">
                    <div class="card servico-card h-100">

                        @if($servico->imagem)
                            <img src="{{ asset('storage/' . $servico->imagem) }}"
                                class="servico-imagem"
                                alt="{{ $servico->nome }}">
                        @else
                            <div class="servico-sem-imagem">
                                <span>✦</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">

                            <div>
                                <span class="categoria-tag">
                                    {{ $servico->categoria->nome ?? 'Sem categoria' }}
                                </span>

                                <h5>{{ $servico->nome }}</h5>

                                <p class="servico-descricao">
                                    {{ Str::limit($servico->descricao, 110) }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <div class="servico-preco">
                                    R$ {{ number_format($servico->preco, 2, ',', '.') }}
                                </div>

                                <div class="servico-info">
                                    Duração: {{ $servico->duracao }} minutos
                                </div>

                                <div class="servico-info">
                                    Prestador:
                                    {{ $servico->usuario->name ?? 'Não informado' }}
                                </div>
                            </div>

                            <div class="mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('servicos.show', $servico) }}"
                                        class="btn btn-detalhes flex-fill">
                                        Detalhes
                                    </a>

                                    <a href="{{ route('agendamentos.create', ['servico_id' => $servico->id]) }}"
                                        class="btn btn-agendar flex-fill">
                                        Agendar
                                    </a>
                                </div>

                                @if(auth()->id() === $servico->usuario_id ||
                                    auth()->user()?->tipo_usuario === 'administrador')
                                    <a href="{{ route('servicos.edit', $servico) }}"
                                        class="btn btn-editar w-100 mt-2">
                                        Editar serviço
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12">
                    <div class="servicos-vazio">
                        <h5>Nenhum serviço encontrado</h5>
                        <p class="mb-0">
                            Tente alterar os filtros ou volte mais tarde.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $servicos->links() }}
        </div>

    </div>
</div>

@endsection