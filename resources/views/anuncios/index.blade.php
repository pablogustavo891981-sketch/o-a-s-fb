@extends('layouts.app')

@section('title', 'Mural de anúncios')

@section('content')
<style>
    .mural-page { display: grid; gap: 22px; }
    .mural-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: clamp(22px, 4vw, 36px);
        border: 1px solid rgba(204, 9, 47, .08);
        border-left: 6px solid #CC092F;
        border-radius: 18px;
        background: linear-gradient(120deg, #fff 0%, #fff7f8 100%);
        box-shadow: 0 12px 28px rgba(35, 20, 28, .05);
    }
    .mural-hero h2 { margin: 0 0 8px; color: #292929; font-size: clamp(1.5rem, 3vw, 2rem); }
    .mural-hero p { margin: 0; color: #666; line-height: 1.6; }
    .mural-action {
        flex: 0 0 auto;
        padding: 12px 18px;
        border-radius: 10px;
        background: #CC092F;
        color: #fff;
        font-weight: 700;
        box-shadow: 0 9px 18px rgba(204, 9, 47, .16);
        transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
    }
    .mural-action:hover { transform: translateY(-2px); background: #A80726; color: #fff; box-shadow: 0 13px 22px rgba(204, 9, 47, .2); }
    .mural-filter {
        display: flex;
        align-items: center;
        gap: 11px;
        flex-wrap: wrap;
        padding: 18px;
        border: 1px solid #EAE6E7;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(35, 20, 28, .03);
    }
    .mural-filter .form-control {
        min-height: 44px;
        border-color: #E5E5E5;
        border-radius: 9px;
    }
    .mural-filter .form-control:focus { border-color: #CC092F; box-shadow: 0 0 0 .2rem rgba(204, 9, 47, .1); }
    .mural-search { flex: 2 1 240px; }
    .mural-category { flex: 1 1 190px; }
    .mural-filter .btn { min-height: 44px; border-radius: 9px; }
    .mural-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 255px), 1fr)); gap: 20px; }
    .mural-card {
        display: flex;
        min-width: 0;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #EAE6E7;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(35, 20, 28, .04);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
    }
    .mural-card:hover { transform: translateY(-4px); border-color: #F1C7D0; box-shadow: 0 16px 30px rgba(66, 27, 38, .1); }
    .mural-image, .mural-placeholder { width: 100%; height: 190px; }
    .mural-image { object-fit: cover; background: #F5F5F5; }
    .mural-placeholder {
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #FCECEF, #F2EFFA);
        color: #CC092F;
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: .1em;
    }
    .mural-card-content { display: flex; flex: 1; flex-direction: column; padding: 19px; }
    .mural-meta { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .mural-category-tag {
        color: #5E50A1;
        font-size: .78rem;
        font-weight: 700;
    }
    .mural-status { padding: 5px 9px; border-radius: 999px; font-size: .72rem; font-weight: 700; white-space: nowrap; }
    .mural-card h3 { margin: 13px 0 8px; color: #292929; font-size: 1.1rem; line-height: 1.35; }
    .mural-description { margin: 0; color: #666; font-size: .9rem; line-height: 1.6; }
    .mural-author { margin: 16px 0 18px; color: #777; font-size: .82rem; }
    .mural-link {
        display: block;
        margin-top: auto;
        padding: 10px 14px;
        border: 1px solid #CC092F;
        border-radius: 9px;
        color: #CC092F;
        font-size: .9rem;
        font-weight: 700;
        text-align: center;
        transition: color .2s ease, background .2s ease;
    }
    .mural-link:hover { background: #CC092F; color: #fff; }
    .mural-empty {
        padding: 42px 20px;
        border: 1px dashed #D8C9CD;
        border-radius: 16px;
        background: #fff;
        color: #666;
        text-align: center;
    }
    .mural-empty strong { display: block; margin-bottom: 8px; color: #292929; font-size: 1.1rem; }
    @media (max-width: 640px) {
        .mural-hero { align-items: stretch; flex-direction: column; }
        .mural-action { text-align: center; }
        .mural-filter .btn { flex: 1 1 auto; }
    }
    @media (prefers-reduced-motion: reduce) {
        .mural-card, .mural-action, .mural-link { transition-duration: .01ms; }
    }
</style>

<div class="mural-page">
    <header class="mural-hero">
        <div>
            <h2>Mural de anúncios</h2>
            <p>Encontre ofertas, divulgue seus trabalhos e compartilhe oportunidades.</p>
        </div>
        <a href="{{ route('anuncios.create') }}" class="mural-action">+ Publicar anúncio</a>
    </header>

    <form method="GET" action="{{ route('anuncios.index') }}" class="mural-filter" role="search">
        <label class="visually-hidden" for="busca-anuncios">Buscar anúncios</label>
        <input id="busca-anuncios" class="form-control mural-search" type="search" name="busca" value="{{ request('busca') }}" placeholder="O que você está procurando?">

        <label class="visually-hidden" for="categoria-anuncios">Filtrar por categoria</label>
        <select id="categoria-anuncios" class="form-control mural-category" name="categoria_id">
            <option value="">Todas as categorias</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" @selected(request('categoria_id') == $categoria->id)>
                    {{ $categoria->nome }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn">Buscar</button>
        @if(request()->filled('busca') || request()->filled('categoria_id'))
            <a href="{{ route('anuncios.index') }}" class="btn btn-secondary">Limpar filtros</a>
        @endif
    </form>

    @if($anuncios->isEmpty())
        <div class="mural-empty">
            <strong>Nenhum anúncio encontrado</strong>
            <span>Experimente alterar os filtros ou publique o primeiro anúncio da comunidade.</span>
        </div>
    @else
        <div class="mural-grid">
            @foreach($anuncios as $anuncio)
                @php
                    $meuAnuncio = $anuncio->usuario_id === auth()->id();
                    $status = [
                        'ativo' => ['Ativo', '#E5F5EA', '#187A36'],
                        'pendente' => ['Em análise', '#FFF4D6', '#936500'],
                        'inativo' => ['Inativo', '#EEEEEE', '#555555'],
                        'rejeitado' => ['Rejeitado', '#FCE8ED', '#CC092F'],
                    ];
                    $aparencia = $status[$anuncio->status] ?? ['Desconhecido', '#EEEEEE', '#555555'];
                @endphp

                <article class="mural-card">
                    @if($anuncio->imagem)
                        <img src="{{ asset('storage/'.$anuncio->imagem) }}" alt="{{ $anuncio->titulo }}" class="mural-image" loading="lazy">
                    @else
                        <div class="mural-placeholder" aria-hidden="true">O.A.S</div>
                    @endif

                    <div class="mural-card-content">
                        <div class="mural-meta">
                            <span class="mural-category-tag">{{ $anuncio->categoria->nome ?? 'Sem categoria' }}</span>
                            @if($meuAnuncio)
                                <span class="mural-status" style="background: {{ $aparencia[1] }}; color: {{ $aparencia[2] }};">
                                    {{ $aparencia[0] }}
                                </span>
                            @endif
                        </div>

                        <h3>{{ $anuncio->titulo }}</h3>
                        <p class="mural-description">{{ \Illuminate\Support\Str::limit($anuncio->descricao, 110) }}</p>
                        <p class="mural-author">Por {{ $anuncio->usuario->name ?? 'Usuário' }}</p>

                        <a href="{{ route('anuncios.show', $anuncio) }}" class="mural-link">Ver anúncio</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $anuncios->links() }}
        </div>
    @endif
</div>
@endsection
