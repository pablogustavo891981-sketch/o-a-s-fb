@extends('layouts.app')

@section('title', 'Cadastrar serviço')

@push('styles')
    <style>
        .service-create-page {
            max-width: 1040px;
        }

        .service-create-back {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 20px;
            color: #A80726;
            font-size: 13px;
            font-weight: 700;
        }

        .service-create-back:hover {
            color: #CC092F;
        }

        .service-create-heading {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 23px;
            padding: clamp(22px, 4vw, 32px);
            border: 1px solid #F0DEE2;
            border-radius: 20px;
            background: linear-gradient(120deg, #FFF1F4 0%, #fff 75%);
            box-shadow: 0 10px 28px rgba(48, 25, 31, .045);
        }

        .service-create-heading-icon {
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

        .service-create-heading-icon svg {
            width: 25px;
            height: 25px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .service-create-eyebrow {
            margin: 0 0 5px;
            color: #A80726;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .service-create-title {
            margin: 0 0 6px;
            color: #292929;
            font-size: clamp(1.45rem, 3vw, 2rem);
            font-weight: 750;
            line-height: 1.2;
        }

        .service-create-subtitle {
            margin: 0;
            color: #686168;
            font-size: 14px;
            line-height: 1.6;
        }

        .service-form-card {
            overflow: hidden;
            border: 1px solid #EAE3E5;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 9px 24px rgba(34, 20, 25, .045);
        }

        .service-form-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px clamp(20px, 4vw, 32px);
            border-bottom: 1px solid #F0E7E9;
            background: #FFFCFC;
        }

        .service-form-step {
            display: grid;
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            place-items: center;
            border-radius: 10px;
            background: #FCECEF;
            color: #A80726;
            font-size: 13px;
            font-weight: 800;
        }

        .service-form-card-header h2 {
            margin: 0;
            color: #292929;
            font-size: 15px;
            font-weight: 750;
        }

        .service-form-card-header p {
            margin: 2px 0 0;
            color: #777;
            font-size: 12px;
        }

        .service-form {
            display: grid;
            gap: 26px;
            padding: clamp(20px, 4vw, 32px);
        }

        .service-form-section {
            display: grid;
            gap: 16px;
        }

        .service-form-section + .service-form-section {
            padding-top: 24px;
            border-top: 1px solid #F0E7E9;
        }

        .service-form-section-heading {
            margin: 0;
            color: #292929;
            font-size: 14px;
            font-weight: 750;
        }

        .service-form-section-description {
            margin: -11px 0 0;
            color: #777;
            font-size: 12px;
            line-height: 1.5;
        }

        .service-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .service-form-field {
            display: grid;
            min-width: 0;
            align-content: start;
            gap: 7px;
        }

        .service-form-field-full {
            grid-column: 1 / -1;
        }

        .service-form-field label {
            color: #3D373C;
            font-size: 12px;
            font-weight: 750;
        }

        .service-form-required {
            color: #A80726;
        }

        .service-form-optional {
            color: #777;
            font-weight: 500;
        }

        .service-form-field .form-control,
        .service-form-field .form-select {
            width: 100%;
            min-height: 46px;
            padding: 11px 12px;
            border: 1px solid #E2DADD;
            border-radius: 10px;
            background-color: #fff;
            color: #292929;
            font: inherit;
            font-size: 13px;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .service-form-field textarea.form-control {
            min-height: 118px;
            resize: vertical;
            line-height: 1.6;
        }

        .service-form-field textarea.service-form-location {
            min-height: 82px;
        }

        .service-form-field .form-control::placeholder {
            color: #999;
        }

        .service-form-field .form-control:focus,
        .service-form-field .form-select:focus {
            border-color: #CC092F;
            outline: 0;
            box-shadow: 0 0 0 3px rgba(204, 9, 47, .1);
        }

        .service-form-field .is-invalid {
            border-color: #CC092F;
        }

        .service-form-help {
            margin: 0;
            color: #777;
            font-size: 11px;
            line-height: 1.5;
        }

        .service-form-error {
            color: #A80726;
            font-size: 12px;
            line-height: 1.45;
        }

        .service-form-price-wrap {
            position: relative;
        }

        .service-form-price-wrap span {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #777;
            font-size: 12px;
            font-weight: 700;
            pointer-events: none;
        }

        .service-form-price-wrap input {
            padding-left: 43px !important;
        }

        .service-form-upload {
            display: grid;
            gap: 10px;
            padding: 16px;
            border: 1px dashed #DCC8CD;
            border-radius: 13px;
            background: #FFFCFC;
        }

        .service-form-upload .form-control {
            min-height: auto;
            padding: 9px;
            background: #fff;
        }

        .service-form-upload-icon {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 11px;
            background: #FCECEF;
            color: #A80726;
        }

        .service-form-upload-icon svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .service-form-upload-title {
            margin: 0;
            color: #383238;
            font-size: 12px;
            font-weight: 750;
        }

        .service-form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 5px;
        }

        .service-form-submit,
        .service-form-cancel {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border: 1px solid transparent;
            border-radius: 10px;
            cursor: pointer;
            font: inherit;
            font-size: 13px;
            font-weight: 750;
            text-decoration: none;
            transition: background .18s ease, border-color .18s ease, color .18s ease, transform .18s ease;
        }

        .service-form-submit {
            background: #CC092F;
            color: #fff;
        }

        .service-form-submit:hover {
            transform: translateY(-1px);
            background: #A80726;
            color: #fff;
        }

        .service-form-cancel {
            border-color: #E3DADD;
            background: #fff;
            color: #555;
        }

        .service-form-cancel:hover {
            border-color: #D7C6CB;
            background: #FCF8F9;
            color: #292929;
        }

        .service-category-notice {
            padding: 12px 14px;
            border: 1px solid #F1C7D0;
            border-radius: 10px;
            background: #FFF4F6;
            color: #861127;
            font-size: 12px;
            line-height: 1.55;
        }

        .service-category-notice a {
            color: #A80726;
            font-weight: 750;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        @media (max-width: 640px) {
            .service-form-grid {
                grid-template-columns: 1fr;
            }

            .service-form-field-full {
                grid-column: auto;
            }

            .service-form-actions {
                flex-direction: column;
            }

            .service-form-submit,
            .service-form-cancel {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .service-form-field .form-control,
            .service-form-field .form-select,
            .service-form-submit,
            .service-form-cancel {
                transition: none;
            }
        }
    </style>
@endpush

@section('content')
    <main class="container py-4 service-create-page">
        <a href="{{ route('servicos.index') }}" class="service-create-back">
            <span aria-hidden="true">←</span>
            Voltar para serviços
        </a>

        <header class="service-create-heading">
            <span class="service-create-heading-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <rect x="3.5" y="7" width="17" height="13" rx="2"></rect>
                    <path d="M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7M3.5 12h17M12 10v5M9.5 12.5h5"></path>
                </svg>
            </span>
            <div>
                <p class="service-create-eyebrow">Seja encontrado</p>
                <h1 class="service-create-title">Cadastre seu serviço</h1>
                <p class="service-create-subtitle">
                    Apresente seu trabalho com clareza para que as pessoas encontrem as informações necessárias para agendar.
                </p>
            </div>
        </header>

        <section class="service-form-card" aria-labelledby="service-form-title">
            <header class="service-form-card-header">
                <span class="service-form-step" aria-hidden="true">1</span>
                <div>
                    <h2 id="service-form-title">Informações do serviço</h2>
                    <p>Preencha os campos obrigatórios para publicar.</p>
                </div>
            </header>

            <form action="{{ route('servicos.store') }}" method="POST" enctype="multipart/form-data" class="service-form">
                @csrf

                <section class="service-form-section" aria-labelledby="service-details-heading">
                    <h3 class="service-form-section-heading" id="service-details-heading">Sobre o serviço</h3>
                    <p class="service-form-section-description">Escolha um nome direto e explique o que está incluído.</p>

                    <div class="service-form-grid">
                        <div class="service-form-field">
                            <label for="nome">Nome do serviço <span class="service-form-required" aria-hidden="true">*</span></label>
                            <input
                                type="text"
                                name="nome"
                                id="nome"
                                class="form-control @error('nome') is-invalid @enderror"
                                value="{{ old('nome') }}"
                                placeholder="Ex.: Manutenção de computadores"
                                maxlength="255"
                                autocomplete="off"
                                required
                                @error('nome') aria-invalid="true" aria-describedby="nome-erro" @enderror
                            >
                            @error('nome')
                                <span class="service-form-error" id="nome-erro">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="service-form-field">
                            <label for="categoria_id">Categoria <span class="service-form-required" aria-hidden="true">*</span></label>
                            <select
                                name="categoria_id"
                                id="categoria_id"
                                class="form-select @error('categoria_id') is-invalid @enderror"
                                required
                                @error('categoria_id') aria-invalid="true" aria-describedby="categoria-erro" @enderror
                            >
                                <option value="">Selecione uma categoria</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                                        {{ $categoria->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <span class="service-form-error" id="categoria-erro">{{ $message }}</span>
                            @enderror
                            @if($categorias->isEmpty())
                                <span class="service-category-notice">
                                    Não há categorias ativas para selecionar. <a href="{{ route('categorias.index') }}">Consulte as categorias</a> ou peça ao administrador para cadastrar uma.
                                </span>
                            @endif
                        </div>

                        <div class="service-form-field service-form-field-full">
                            <label for="descricao">Descrição do serviço <span class="service-form-required" aria-hidden="true">*</span></label>
                            <textarea
                                name="descricao"
                                id="descricao"
                                class="form-control @error('descricao') is-invalid @enderror"
                                rows="5"
                                maxlength="3000"
                                placeholder="Descreva o serviço, o que está incluído e como funciona o atendimento."
                                required
                                @error('descricao') aria-invalid="true" aria-describedby="descricao-erro" @enderror
                            >{{ old('descricao') }}</textarea>
                            <p class="service-form-help">Até 3.000 caracteres. Informações claras ajudam as pessoas a escolher.</p>
                            @error('descricao')
                                <span class="service-form-error" id="descricao-erro">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="service-form-section" aria-labelledby="service-pricing-heading">
                    <h3 class="service-form-section-heading" id="service-pricing-heading">Preço e duração</h3>
                    <p class="service-form-section-description">Informe o valor e o tempo aproximado de cada atendimento.</p>

                    <div class="service-form-grid">
                        <div class="service-form-field">
                            <label for="preco">Preço <span class="service-form-required" aria-hidden="true">*</span></label>
                            <div class="service-form-price-wrap">
                                <span aria-hidden="true">R$</span>
                                <input
                                    type="number"
                                    name="preco"
                                    id="preco"
                                    class="form-control @error('preco') is-invalid @enderror"
                                    value="{{ old('preco') }}"
                                    min="0"
                                    max="99999999.99"
                                    step="0.01"
                                    placeholder="0,00"
                                    required
                                    @error('preco') aria-invalid="true" aria-describedby="preco-erro" @enderror
                                >
                            </div>
                            <p class="service-form-help">Você pode informar um valor igual a zero.</p>
                            @error('preco')
                                <span class="service-form-error" id="preco-erro">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="service-form-field">
                            <label for="duracao">Duração <span class="service-form-required" aria-hidden="true">*</span></label>
                            <input
                                type="number"
                                name="duracao"
                                id="duracao"
                                class="form-control @error('duracao') is-invalid @enderror"
                                value="{{ old('duracao') }}"
                                min="1"
                                max="1440"
                                placeholder="Ex.: 60"
                                required
                                @error('duracao') aria-invalid="true" aria-describedby="duracao-erro" @enderror
                            >
                            <p class="service-form-help">Informe o tempo em minutos, de 1 a 1.440.</p>
                            @error('duracao')
                                <span class="service-form-error" id="duracao-erro">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="service-form-section" aria-labelledby="service-location-heading">
                    <h3 class="service-form-section-heading" id="service-location-heading">Atendimento e imagem</h3>
                    <p class="service-form-section-description">Ajude as pessoas a entender onde o serviço é realizado e como ele se apresenta.</p>

                    <div class="service-form-grid">
                        <div class="service-form-field service-form-field-full">
                            <label for="local_atendimento">Local do atendimento <span class="service-form-optional">(opcional)</span></label>
                            <textarea
                                name="local_atendimento"
                                id="local_atendimento"
                                class="form-control service-form-location @error('local_atendimento') is-invalid @enderror"
                                rows="2"
                                maxlength="500"
                                placeholder="Informe o endereço, um ponto de referência ou se o atendimento é online."
                                @error('local_atendimento') aria-invalid="true" aria-describedby="local-erro" @enderror
                            >{{ old('local_atendimento') }}</textarea>
                            <p class="service-form-help">Esse local ficará visível para quem consultar o serviço e o calendário.</p>
                            @error('local_atendimento')
                                <span class="service-form-error" id="local-erro">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="service-form-field service-form-field-full">
                            <label for="imagem">Imagem do serviço <span class="service-form-optional">(opcional)</span></label>
                            <div class="service-form-upload">
                                <span class="service-form-upload-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24">
                                        <rect x="3.5" y="4.5" width="17" height="15" rx="2"></rect>
                                        <circle cx="8.5" cy="9" r="1.5"></circle>
                                        <path d="m4 17 5-5 3 3 2-2 6 5"></path>
                                    </svg>
                                </span>
                                <p class="service-form-upload-title">Escolha uma imagem para apresentar seu serviço</p>
                                <input
                                    type="file"
                                    name="imagem"
                                    id="imagem"
                                    class="form-control @error('imagem') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    aria-describedby="imagem-ajuda @error('imagem') imagem-erro @enderror"
                                    @error('imagem') aria-invalid="true" @enderror
                                >
                                <p class="service-form-help" id="imagem-ajuda">JPG, JPEG, PNG ou WEBP. Tamanho máximo: 5 MB.</p>
                                @error('imagem')
                                    <span class="service-form-error" id="imagem-erro">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>

                <div class="service-form-actions">
                    <button type="submit" class="service-form-submit">
                        Cadastrar serviço
                        <span aria-hidden="true">→</span>
                    </button>
                    <a href="{{ route('servicos.index') }}" class="service-form-cancel">Cancelar</a>
                </div>
            </form>
        </section>
    </main>
@endsection
