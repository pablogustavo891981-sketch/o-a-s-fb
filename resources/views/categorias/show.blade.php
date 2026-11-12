@extends('layouts.app')

@section('title', 'Detalhes da categoria')

@push('styles')
    <style>
        .category-page {
            max-width: 980px;
        }

        .category-back {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 22px;
            color: #A80726;
            font-size: 14px;
            font-weight: 700;
        }

        .category-back:hover {
            color: #CC092F;
        }

        .category-page-heading {
            margin-bottom: 22px;
        }

        .category-page-heading p {
            margin: 0 0 4px;
            color: #777;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .category-page-heading h1 {
            margin: 0;
            color: #292929;
            font-size: clamp(1.5rem, 3vw, 2rem);
            line-height: 1.25;
        }

        .category-card {
            overflow: hidden;
            border: 1px solid #EADDE0;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 16px 38px rgba(48, 25, 31, .07);
        }

        .category-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            padding: clamp(22px, 4vw, 38px);
            background: linear-gradient(125deg, #FFF5F7 0%, #fff 72%);
            border-bottom: 1px solid #F3E4E7;
        }

        .category-title-group {
            display: flex;
            align-items: flex-start;
            gap: 17px;
            min-width: 0;
        }

        .category-symbol {
            display: grid;
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            place-items: center;
            border: 1px solid #F2D5DC;
            border-radius: 16px;
            background: #fff;
            color: #CC092F;
            box-shadow: 0 6px 16px rgba(204, 9, 47, .08);
        }

        .category-symbol svg {
            width: 25px;
            height: 25px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .category-eyebrow {
            margin: 0 0 6px;
            color: #A80726;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .category-name {
            margin: 0 0 12px;
            overflow-wrap: anywhere;
            color: #292929;
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-weight: 750;
            line-height: 1.2;
        }

        .category-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .category-status::before {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            content: "";
        }

        .category-status-active {
            background: #E8F6ED;
            color: #176B35;
        }

        .category-status-inactive {
            background: #F0F0F0;
            color: #5B5B5B;
        }

        .category-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 0 0 auto;
            min-height: 44px;
            padding: 10px 16px;
            border-radius: 10px;
            background: #CC092F;
            box-shadow: 0 8px 18px rgba(204, 9, 47, .16);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
        }

        .category-edit:hover {
            transform: translateY(-1px);
            background: #A80726;
            box-shadow: 0 11px 22px rgba(204, 9, 47, .2);
            color: #fff;
        }

        .category-card-body {
            display: grid;
            gap: 28px;
            padding: clamp(22px, 4vw, 38px);
        }

        .category-section-heading {
            margin: 0 0 12px;
            color: #292929;
            font-size: 15px;
            font-weight: 750;
        }

        .category-description {
            padding: 19px 21px;
            border: 1px solid #F0E7E9;
            border-radius: 14px;
            background: #FCFAFA;
        }

        .category-description p {
            margin: 0;
            color: #555;
            font-size: 14px;
            line-height: 1.75;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        .category-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .category-stat {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
            padding: 19px;
            border: 1px solid;
            border-radius: 15px;
        }

        .category-stat-announcements {
            border-color: #F2D5DC;
            background: linear-gradient(135deg, #FFF5F7, #FFFAFB);
            color: #B20A2C;
        }

        .category-stat-services {
            border-color: #E1DDF3;
            background: linear-gradient(135deg, #F8F7FC, #FCFBFF);
            color: #5E50A1;
        }

        .category-stat-icon {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, .8);
        }

        .category-stat-icon svg {
            width: 21px;
            height: 21px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .category-stat-label {
            margin: 0 0 3px;
            color: #666;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .category-stat-value {
            display: block;
            color: inherit;
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .category-metadata {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            padding-top: 21px;
            border-top: 1px solid #EEE7E9;
        }

        .category-metadata-item {
            min-width: 0;
        }

        .category-metadata-item dt {
            margin-bottom: 5px;
            color: #777;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .category-metadata-item dd {
            margin: 0;
            color: #333;
            font-size: 13px;
            font-weight: 600;
        }

        @media (max-width: 640px) {
            .category-card-header {
                flex-direction: column;
                gap: 18px;
            }

            .category-edit {
                width: 100%;
            }

            .category-stats,
            .category-metadata {
                grid-template-columns: 1fr;
            }

            .category-stat {
                padding: 16px;
            }
        }
    </style>
@endpush

@section('content')
    <main class="container py-4 category-page">
        <a href="{{ route('categorias.index') }}" class="category-back">
            <span aria-hidden="true">←</span>
            <span>Voltar para categorias</span>
        </a>

        <header class="category-page-heading">
            <p>Organização do catálogo</p>
            <h1>Detalhes da categoria</h1>
        </header>

        <article class="category-card">
            <header class="category-card-header">
                <div class="category-title-group">
                    <span class="category-symbol" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H11l9 9-7 7-9-9V5.5Z"></path>
                            <circle cx="7.5" cy="7.5" r=".75"></circle>
                        </svg>
                    </span>
                    <div>
                        <p class="category-eyebrow">Categoria</p>
                        <h2 class="category-name">{{ $categoria->nome }}</h2>

                        @if($categoria->ativa)
                            <span class="category-status category-status-active">Ativa</span>
                        @else
                            <span class="category-status category-status-inactive">Inativa</span>
                        @endif
                    </div>
                </div>

                @if(auth()->user()?->tipo_usuario === 'administrador')
                    <a href="{{ route('categorias.edit', $categoria) }}" class="category-edit">
                        <span aria-hidden="true">✎</span>
                        Editar categoria
                    </a>
                @endif
            </header>

            <div class="category-card-body">
                <section aria-labelledby="category-description-heading">
                    <h3 id="category-description-heading" class="category-section-heading">Descrição</h3>
                    <div class="category-description">
                        <p>{{ $categoria->descricao ?: 'Nenhuma descrição cadastrada.' }}</p>
                    </div>
                </section>

                <section aria-labelledby="category-related-heading">
                    <h3 id="category-related-heading" class="category-section-heading">Conteúdo vinculado</h3>
                    <div class="category-stats">
                        <div class="category-stat category-stat-announcements">
                            <span class="category-stat-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24">
                                    <path d="M4 10v4h3l8 4V6l-8 4H4Z"></path>
                                    <path d="m7 14 1.5 5h3L10 15.5"></path>
                                    <path d="M18 9a4 4 0 0 1 0 6"></path>
                                </svg>
                            </span>
                            <div>
                                <p class="category-stat-label">Anúncios</p>
                                <strong class="category-stat-value">{{ $categoria->anuncios()->count() }}</strong>
                            </div>
                        </div>

                        <div class="category-stat category-stat-services">
                            <span class="category-stat-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24">
                                    <path d="M4 8.5 12 4l8 4.5-8 4.5-8-4.5Z"></path>
                                    <path d="m4 12 8 4.5 8-4.5"></path>
                                    <path d="m4 15.5 8 4.5 8-4.5"></path>
                                </svg>
                            </span>
                            <div>
                                <p class="category-stat-label">Serviços</p>
                                <strong class="category-stat-value">{{ $categoria->servicos()->count() }}</strong>
                            </div>
                        </div>
                    </div>
                </section>

                <dl class="category-metadata">
                    <div class="category-metadata-item">
                        <dt>Cadastrada em</dt>
                        <dd>{{ $categoria->created_at?->format('d/m/Y \à\s H:i') ?? '—' }}</dd>
                    </div>
                    <div class="category-metadata-item">
                        <dt>Última atualização</dt>
                        <dd>{{ $categoria->updated_at?->format('d/m/Y \à\s H:i') ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </article>
    </main>
@endsection
