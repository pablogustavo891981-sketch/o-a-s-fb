@extends('layouts.app')

@section('title', 'Categorias')

@push('styles')
    <style>
        .categories-page {
            max-width: 1160px;
        }

        .categories-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
            padding: clamp(22px, 4vw, 34px);
            border: 1px solid #F0DEE2;
            border-radius: 20px;
            background: linear-gradient(120deg, #FFF1F4 0%, #fff 75%);
            box-shadow: 0 10px 28px rgba(48, 25, 31, .045);
        }

        .categories-heading-copy {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            min-width: 0;
        }

        .categories-heading-icon {
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

        .categories-heading-icon svg {
            width: 25px;
            height: 25px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .categories-eyebrow {
            margin: 0 0 5px;
            color: #A80726;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .categories-title {
            margin: 0 0 5px;
            color: #292929;
            font-size: clamp(1.45rem, 3vw, 2rem);
            font-weight: 750;
            line-height: 1.2;
        }

        .categories-subtitle {
            margin: 0;
            color: #686168;
            font-size: 14px;
        }

        .categories-create {
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

        .categories-create:hover {
            transform: translateY(-1px);
            background: #A80726;
            box-shadow: 0 11px 22px rgba(204, 9, 47, .2);
            color: #fff;
        }

        .categories-create span {
            font-size: 19px;
            line-height: 1;
        }

        .categories-alert {
            margin-bottom: 18px;
            padding: 13px 16px;
            border: 1px solid #CBE8D1;
            border-radius: 11px;
            background: #EAF6ED;
            color: #176B35;
            font-size: 14px;
        }

        .categories-alert-error {
            border-color: #F1C7D0;
            background: #FFF0F2;
            color: #A80726;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .category-item {
            display: flex;
            min-width: 0;
            flex-direction: column;
            gap: 18px;
            padding: 21px;
            border: 1px solid #EAE3E5;
            border-radius: 17px;
            background: #fff;
            box-shadow: 0 7px 20px rgba(34, 20, 25, .04);
            transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
        }

        .category-item:hover {
            transform: translateY(-3px);
            border-color: #E8C4CC;
            box-shadow: 0 13px 27px rgba(34, 20, 25, .08);
        }

        .category-item-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .category-item-heading {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 0;
        }

        .category-item-icon {
            display: grid;
            width: 39px;
            height: 39px;
            flex: 0 0 39px;
            place-items: center;
            border-radius: 12px;
            background: #FFF1F4;
            color: #B20A2C;
        }

        .category-item-icon svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .category-item-name {
            margin: 1px 0 0;
            overflow-wrap: anywhere;
            color: #292929;
            font-size: 16px;
            font-weight: 750;
            line-height: 1.35;
        }

        .category-item-status {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 6px;
            padding: 6px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 750;
        }

        .category-item-status::before {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            content: "";
        }

        .category-item-status-active {
            background: #E8F6ED;
            color: #176B35;
        }

        .category-item-status-inactive {
            background: #F0F0F0;
            color: #5B5B5B;
        }

        .category-item-description {
            min-height: 44px;
            margin: 0;
            color: #686168;
            font-size: 13px;
            line-height: 1.65;
            overflow-wrap: anywhere;
        }

        .category-item-counts {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 9px;
        }

        .category-item-count {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 0;
            padding: 10px;
            border: 1px solid #F0E7E9;
            border-radius: 11px;
            background: #FCFAFA;
        }

        .category-item-count-icon {
            display: grid;
            width: 30px;
            height: 30px;
            flex: 0 0 30px;
            place-items: center;
            border-radius: 9px;
            background: #fff;
            color: #A80726;
        }

        .category-item-count-services .category-item-count-icon {
            color: #5E50A1;
        }

        .category-item-count-icon svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .category-item-count-label {
            display: block;
            color: #777;
            font-size: 10px;
            font-weight: 700;
            line-height: 1.2;
        }

        .category-item-count-value {
            display: block;
            margin-top: 2px;
            color: #333;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.2;
        }

        .category-item-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid #F0E7E9;
        }

        .category-action {
            display: inline-flex;
            min-height: 38px;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border: 1px solid #E6DDE0;
            border-radius: 9px;
            background: #fff;
            color: #4F4850;
            font-size: 12px;
            font-weight: 700;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .category-action:hover {
            border-color: #CBB7BD;
            background: #FCF8F9;
            color: #292929;
        }

        .category-action-edit {
            border-color: #F0D8DE;
            color: #A80726;
        }

        .category-action-edit:hover {
            border-color: #E8C4CC;
            background: #FFF5F7;
            color: #A80726;
        }

        .category-action-delete {
            margin: 0;
        }

        .category-action-delete button {
            min-height: 38px;
            padding: 8px 12px;
            border: 1px solid #F0D8DE;
            border-radius: 9px;
            background: #fff;
            color: #A80726;
            cursor: pointer;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            transition: background .18s ease, border-color .18s ease;
        }

        .category-action-delete button:hover {
            border-color: #E8C4CC;
            background: #FFF5F7;
        }

        .categories-empty {
            padding: 50px 24px;
            border: 1px dashed #E5CDD2;
            border-radius: 17px;
            background: #FFFCFC;
            text-align: center;
        }

        .categories-empty-icon {
            display: grid;
            width: 54px;
            height: 54px;
            margin: 0 auto 15px;
            place-items: center;
            border-radius: 16px;
            background: #FFF1F4;
            color: #CC092F;
            font-size: 25px;
        }

        .categories-empty h2 {
            margin: 0 0 6px;
            color: #292929;
            font-size: 18px;
        }

        .categories-empty p {
            margin: 0 0 18px;
            color: #686168;
            font-size: 14px;
        }

        .categories-pagination {
            margin-top: 22px;
        }

        @media (max-width: 1050px) {
            .categories-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 680px) {
            .categories-heading {
                align-items: stretch;
                flex-direction: column;
            }

            .categories-create {
                width: 100%;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .category-item,
            .categories-create {
                transition: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4 categories-page">
        <header class="categories-heading">
            <div class="categories-heading-copy">
                <span class="categories-heading-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H11l9 9-7 7-9-9V5.5Z"></path>
                        <circle cx="7.5" cy="7.5" r=".75"></circle>
                    </svg>
                </span>
                <div>
                    <p class="categories-eyebrow">Organização do catálogo</p>
                    <h1 class="categories-title">Categorias</h1>
                    <p class="categories-subtitle">Encontre e organize anúncios e serviços por assunto.</p>
                </div>
            </div>

            @if(auth()->user()?->tipo_usuario === 'administrador')
                <a href="{{ route('categorias.create') }}" class="categories-create">
                    <span aria-hidden="true">+</span>
                    Nova categoria
                </a>
            @endif
        </header>

        @if(session('success'))
            <div class="categories-alert" role="status">{{ session('success') }}</div>
        @endif

        @if(session('erro'))
            <div class="categories-alert categories-alert-error" role="alert">{{ session('erro') }}</div>
        @endif

        @if($categorias->count() > 0)
            <section class="categories-grid" aria-label="Lista de categorias">
                @foreach($categorias as $categoria)
                    <article class="category-item">
                        <div class="category-item-top">
                            <div class="category-item-heading">
                                <span class="category-item-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H11l9 9-7 7-9-9V5.5Z"></path>
                                        <circle cx="7.5" cy="7.5" r=".75"></circle>
                                    </svg>
                                </span>
                                <h2 class="category-item-name">{{ $categoria->nome }}</h2>
                            </div>

                            @if($categoria->ativa)
                                <span class="category-item-status category-item-status-active">Ativa</span>
                            @else
                                <span class="category-item-status category-item-status-inactive">Inativa</span>
                            @endif
                        </div>

                        <p class="category-item-description">
                            {{ Str::limit($categoria->descricao ?: 'Nenhuma descrição cadastrada.', 100) }}
                        </p>

                        <div class="category-item-counts" aria-label="Conteúdo vinculado">
                            <div class="category-item-count">
                                <span class="category-item-count-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M4 10v4h3l8 4V6l-8 4H4Z"></path>
                                        <path d="m7 14 1.5 5h3L10 15.5"></path>
                                        <path d="M18 9a4 4 0 0 1 0 6"></path>
                                    </svg>
                                </span>
                                <span>
                                    <span class="category-item-count-label">Anúncios</span>
                                    <strong class="category-item-count-value">{{ $categoria->anuncios_count }}</strong>
                                </span>
                            </div>

                            <div class="category-item-count category-item-count-services">
                                <span class="category-item-count-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M4 8.5 12 4l8 4.5-8 4.5-8-4.5Z"></path>
                                        <path d="m4 12 8 4.5 8-4.5"></path>
                                        <path d="m4 15.5 8 4.5 8-4.5"></path>
                                    </svg>
                                </span>
                                <span>
                                    <span class="category-item-count-label">Serviços</span>
                                    <strong class="category-item-count-value">{{ $categoria->servicos_count }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="category-item-actions">
                            <a href="{{ route('categorias.show', $categoria) }}" class="category-action">Ver detalhes</a>

                            @if(auth()->user()?->tipo_usuario === 'administrador')
                                <a href="{{ route('categorias.edit', $categoria) }}" class="category-action category-action-edit">Editar</a>

                                <form
                                    action="{{ route('categorias.destroy', $categoria) }}"
                                    method="POST"
                                    class="category-action-delete"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Excluir</button>
                                </form>
                            @endif
                        </div>
                    </article>
                @endforeach
            </section>

            <div class="categories-pagination">
                {{ $categorias->links() }}
            </div>
        @else
            <section class="categories-empty">
                <span class="categories-empty-icon" aria-hidden="true">◇</span>
                <h2>Nenhuma categoria cadastrada</h2>
                <p>Ainda não existem categorias disponíveis no sistema.</p>

                @if(auth()->user()?->tipo_usuario === 'administrador')
                    <a href="{{ route('categorias.create') }}" class="categories-create">
                        <span aria-hidden="true">+</span>
                        Cadastrar primeira categoria
                    </a>
                @endif
            </section>
        @endif
    </div>
@endsection
