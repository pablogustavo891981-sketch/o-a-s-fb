@extends('layouts.app')

@section('title', 'Mural de anúncios')

@push('styles')
    <style>
        .mural-page {
            display: grid;
            max-width: 1160px;
            gap: 22px;
        }

        .mural-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            padding: clamp(22px, 4vw, 34px);
            border: 1px solid #F0DEE2;
            border-radius: 20px;
            background: linear-gradient(120deg, #FFF1F4 0%, #fff 75%);
            box-shadow: 0 10px 28px rgba(48, 25, 31, .045);
        }

        .mural-heading-copy {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            min-width: 0;
        }

        .mural-heading-icon {
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

        .mural-heading-icon svg {
            width: 25px;
            height: 25px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .mural-eyebrow {
            margin: 0 0 5px;
            color: #A80726;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .mural-title {
            margin: 0 0 5px;
            color: #292929;
            font-size: clamp(1.45rem, 3vw, 2rem);
            font-weight: 750;
            line-height: 1.2;
        }

        .mural-subtitle {
            margin: 0;
            color: #686168;
            font-size: 14px;
        }

        .mural-publish {
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
            transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
        }

        .mural-publish:hover {
            transform: translateY(-1px);
            background: #A80726;
            box-shadow: 0 11px 22px rgba(204, 9, 47, .2);
            color: #fff;
        }

        .mural-publish span {
            font-size: 19px;
            line-height: 1;
        }

        .mural-alert {
            padding: 13px 16px;
            border: 1px solid #CBE8D1;
            border-radius: 11px;
            background: #EAF6ED;
            color: #176B35;
            font-size: 14px;
        }

        .mural-alert-error {
            border-color: #F1C7D0;
            background: #FFF0F2;
            color: #A80726;
        }

        .mural-filter-panel {
            display: grid;
            gap: 14px;
            padding: 19px;
            border: 1px solid #EAE3E5;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 7px 20px rgba(34, 20, 25, .035);
        }

        .mural-filter-heading {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 0;
            color: #333;
            font-size: 13px;
            font-weight: 750;
        }

        .mural-filter-heading svg {
            width: 17px;
            height: 17px;
            fill: none;
            stroke: #A80726;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .mural-filter {
            display: grid;
            grid-template-columns: minmax(220px, 1.5fr) minmax(190px, 1fr) auto auto;
            align-items: end;
            gap: 11px;
        }

        .mural-field {
            display: grid;
            min-width: 0;
            gap: 6px;
        }

        .mural-field label {
            color: #5D565C;
            font-size: 12px;
            font-weight: 700;
        }

        .mural-field .form-control {
            min-height: 44px;
            border-color: #E5E0E2;
            border-radius: 9px;
            background-color: #fff;
        }

        .mural-field .form-control:focus {
            border-color: #CC092F;
            box-shadow: 0 0 0 .2rem rgba(204, 9, 47, .1);
        }

        .mural-filter-button,
        .mural-clear-button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 9px 14px;
            border: 1px solid transparent;
            border-radius: 9px;
            cursor: pointer;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .mural-filter-button {
            background: #CC092F;
            color: #fff;
        }

        .mural-filter-button:hover {
            background: #A80726;
        }

        .mural-clear-button {
            border-color: #E6DDE0;
            background: #fff;
            color: #5D565C;
        }

        .mural-clear-button:hover {
            border-color: #D7C6CB;
            background: #FCF8F9;
            color: #292929;
        }

        .mural-results {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
            padding: 0 2px;
        }

        .mural-results h2 {
            margin: 0;
            color: #292929;
            font-size: 17px;
            font-weight: 750;
        }

        .mural-results-count {
            color: #777;
            font-size: 12px;
        }

        .mural-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            align-items: stretch;
            gap: 18px;
        }

        .mural-card {
            display: flex;
            min-width: 0;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #EAE3E5;
            border-radius: 17px;
            background: #fff;
            box-shadow: 0 7px 20px rgba(34, 20, 25, .04);
            transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
        }

        .mural-card:hover {
            transform: translateY(-3px);
            border-color: #E8C4CC;
            box-shadow: 0 13px 27px rgba(34, 20, 25, .08);
        }

        .mural-media {
            position: relative;
            overflow: hidden;
            height: 190px;
            background: linear-gradient(135deg, #FFF1F4, #F2EFFA);
        }

        .mural-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mural-placeholder {
            display: grid;
            width: 100%;
            height: 100%;
            place-items: center;
            color: #B20A2C;
        }

        .mural-placeholder svg {
            width: 47px;
            height: 47px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.4;
            opacity: .8;
        }

        .mural-card-content {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 13px;
            padding: 19px;
        }

        .mural-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .mural-category-tag {
            overflow: hidden;
            color: #5E50A1;
            font-size: 11px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mural-status {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 6px;
            padding: 6px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
        }

        .mural-status::before {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            content: "";
        }

        .mural-status-active {
            background: #E8F6ED;
            color: #176B35;
        }

        .mural-status-pending {
            background: #FFF4D6;
            color: #805A00;
        }

        .mural-status-inactive {
            background: #F0F0F0;
            color: #555;
        }

        .mural-status-rejected {
            background: #FCE8ED;
            color: #A80726;
        }

        .mural-card-title {
            display: -webkit-box;
            overflow: hidden;
            margin: 0;
            color: #292929;
            font-size: 16px;
            font-weight: 750;
            line-height: 1.4;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .mural-description {
            display: -webkit-box;
            overflow: hidden;
            min-height: 63px;
            margin: 0;
            color: #686168;
            font-size: 13px;
            line-height: 1.6;
            white-space: pre-line;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .mural-author {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 0;
            color: #686168;
            font-size: 12px;
        }

        .mural-author-icon {
            display: grid;
            width: 30px;
            height: 30px;
            flex: 0 0 30px;
            place-items: center;
            border-radius: 50%;
            background: #F7F2F4;
            color: #A80726;
            font-size: 12px;
            font-weight: 800;
        }

        .mural-link {
            display: inline-flex;
            min-height: 40px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: auto;
            padding: 9px 13px;
            border: 1px solid #F0D8DE;
            border-radius: 9px;
            background: #FFF9FA;
            color: #A80726;
            font-size: 12px;
            font-weight: 750;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .mural-link:hover {
            border-color: #CC092F;
            background: #CC092F;
            color: #fff;
        }

        .mural-link span {
            font-size: 16px;
            line-height: 1;
        }

        .mural-empty {
            display: grid;
            justify-items: center;
            padding: 48px 24px;
            border: 1px dashed #E5CDD2;
            border-radius: 17px;
            background: #FFFCFC;
            text-align: center;
        }

        .mural-empty-icon {
            display: grid;
            width: 54px;
            height: 54px;
            margin-bottom: 15px;
            place-items: center;
            border-radius: 16px;
            background: #FFF1F4;
            color: #CC092F;
        }

        .mural-empty-icon svg {
            width: 25px;
            height: 25px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .mural-empty h2 {
            margin: 0 0 6px;
            color: #292929;
            font-size: 17px;
        }

        .mural-empty p {
            margin: 0;
            color: #686168;
            font-size: 13px;
            line-height: 1.6;
        }

        .mural-pagination {
            display: flex;
            justify-content: center;
            margin-top: 2px;
        }

        @media (max-width: 1000px) {
            .mural-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .mural-filter {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .mural-heading {
                align-items: stretch;
                flex-direction: column;
            }

            .mural-publish {
                width: 100%;
            }

            .mural-filter {
                grid-template-columns: 1fr;
            }

            .mural-filter-button,
            .mural-clear-button {
                width: 100%;
            }

            .mural-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .mural-card,
            .mural-publish,
            .mural-link {
                transition: none;
            }
        }
    </style>
@endpush

@section('content')
    <main class="container py-4 mural-page">
        <header class="mural-heading">
            <div class="mural-heading-copy">
                <span class="mural-heading-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 10v4h3l8 4V6l-8 4H4Z"></path>
                        <path d="m7 14 1.5 5h3L10 15.5"></path>
                        <path d="M18 9a4 4 0 0 1 0 6"></path>
                    </svg>
                </span>
                <div>
                    <p class="mural-eyebrow">Comunidade O.A.S.</p>
                    <h1 class="mural-title">Mural de anúncios</h1>
                    <p class="mural-subtitle">Encontre ofertas, divulgue seu trabalho e compartilhe oportunidades.</p>
                </div>
            </div>

            <a href="{{ route('anuncios.create') }}" class="mural-publish">
                <span aria-hidden="true">+</span>
                Publicar anúncio
            </a>
        </header>

        @if(session('success'))
            <div class="mural-alert" role="status">{{ session('success') }}</div>
        @endif

        @if(session('erro'))
            <div class="mural-alert mural-alert-error" role="alert">{{ session('erro') }}</div>
        @endif

        <section class="mural-filter-panel" aria-labelledby="mural-filter-heading">
            <h2 class="mural-filter-heading" id="mural-filter-heading">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 5h16l-6.5 7.5v5L10 19v-6.5L4 5Z"></path>
                </svg>
                Encontre um anúncio
            </h2>

            <form method="GET" action="{{ route('anuncios.index') }}" class="mural-filter" role="search">
                <div class="mural-field">
                    <label for="busca-anuncios">Palavra-chave</label>
                    <input
                        id="busca-anuncios"
                        class="form-control"
                        type="search"
                        name="busca"
                        value="{{ request('busca') }}"
                        placeholder="O que você está procurando?"
                    >
                </div>

                <div class="mural-field">
                    <label for="categoria-anuncios">Categoria</label>
                    <select id="categoria-anuncios" class="form-control" name="categoria_id">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" @selected(request('categoria_id') == $categoria->id)>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="mural-filter-button">Buscar anúncios</button>
                @if(request()->filled('busca') || request()->filled('categoria_id'))
                    <a href="{{ route('anuncios.index') }}" class="mural-clear-button">Limpar filtros</a>
                @endif
            </form>
        </section>

        <section aria-labelledby="mural-results-heading">
            <header class="mural-results">
                <h2 id="mural-results-heading">Anúncios disponíveis</h2>
                <span class="mural-results-count">
                    {{ $anuncios->total() }} {{ $anuncios->total() === 1 ? 'resultado' : 'resultados' }}
                </span>
            </header>

            @if($anuncios->isEmpty())
                <div class="mural-empty">
                    <span class="mural-empty-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <circle cx="10.8" cy="10.8" r="6.8"></circle>
                            <path d="m16 16 4 4M8 10.8h5.5"></path>
                        </svg>
                    </span>
                    <h2>Nenhum anúncio encontrado</h2>
                    <p>Experimente alterar os filtros ou publique o primeiro anúncio da comunidade.</p>
                </div>
            @else
                <div class="mural-grid">
                    @foreach($anuncios as $anuncio)
                        @php
                            $meuAnuncio = $anuncio->usuario_id === auth()->id();
                            $statusClasses = [
                                'ativo' => ['Ativo', 'mural-status-active'],
                                'pendente' => ['Em análise', 'mural-status-pending'],
                                'inativo' => ['Inativo', 'mural-status-inactive'],
                                'rejeitado' => ['Rejeitado', 'mural-status-rejected'],
                            ];
                            [$statusLabel, $statusClass] = $statusClasses[$anuncio->status] ?? ['Desconhecido', 'mural-status-inactive'];
                        @endphp

                        <article class="mural-card">
                            <div class="mural-media">
                                @if($anuncio->imagem)
                                    <img
                                        src="{{ asset('storage/'.$anuncio->imagem) }}"
                                        alt="{{ $anuncio->titulo }}"
                                        class="mural-image"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="mural-placeholder" aria-hidden="true">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M4 10v4h3l8 4V6l-8 4H4Z"></path>
                                            <path d="m7 14 1.5 5h3L10 15.5"></path>
                                            <path d="M18 9a4 4 0 0 1 0 6"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="mural-card-content">
                                <div class="mural-card-meta">
                                    <span class="mural-category-tag">{{ $anuncio->categoria->nome ?? 'Sem categoria' }}</span>
                                    @if($meuAnuncio)
                                        <span class="mural-status {{ $statusClass }}">{{ $statusLabel }}</span>
                                    @endif
                                </div>

                                <h3 class="mural-card-title">{{ $anuncio->titulo }}</h3>
                                <p class="mural-description">{{ $anuncio->descricao }}</p>

                                <p class="mural-author">
                                    <span class="mural-author-icon" aria-hidden="true">
                                        {{ mb_strtoupper(mb_substr($anuncio->usuario->name ?? 'U', 0, 1)) }}
                                    </span>
                                    <span>Publicado por <strong>{{ $anuncio->usuario->name ?? 'Usuário' }}</strong></span>
                                </p>

                                <a href="{{ route('anuncios.show', $anuncio) }}" class="mural-link">
                                    Ver anúncio
                                    <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mural-pagination">
                    {{ $anuncios->links() }}
                </div>
            @endif
        </section>
    </main>
@endsection
