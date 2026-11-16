@extends('layouts.app')

@section('title', 'Personalizar acessibilidade')

@section('content')
<style>
    .accessibility-page {
        max-width: 900px;
        margin: 0 auto;
    }

    .accessibility-heading {
        margin-bottom: 24px;
        padding: clamp(22px, 4vw, 34px);
        border-left: 6px solid #CC092F;
        border-radius: 16px;
        background: linear-gradient(120deg, #fff 0%, #fff7f8 100%);
        box-shadow: 0 10px 24px rgba(45, 28, 35, .05);
    }

    .accessibility-heading h2 {
        margin: 0 0 8px;
        color: #A80726;
        font-size: clamp(1.5rem, 3vw, 2rem);
    }

    .accessibility-heading p {
        margin: 0;
        color: #555;
        line-height: 1.65;
    }

    .accessibility-option {
        margin-bottom: 18px;
        padding: clamp(18px, 3vw, 26px);
        border: 1px solid #E5E5E5;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 6px 18px rgba(35, 20, 28, .035);
    }

    .accessibility-option h3 {
        margin: 0 0 8px;
        color: #292929;
        font-size: 1.15rem;
    }

    .accessibility-option p {
        margin: 0 0 16px;
        color: #626262;
        line-height: 1.6;
    }

    .accessibility-option-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .accessibility-option button {
        min-width: 48px;
        min-height: 48px;
        padding: 10px 16px;
        border: 1px solid #CC092F;
        border-radius: 9px;
        background: #CC092F;
        color: #fff;
        cursor: pointer;
        font: inherit;
        font-weight: 700;
        transition: background .2s ease, transform .2s ease;
    }

    .accessibility-option button:hover {
        transform: translateY(-1px);
        background: #A80726;
    }

    .accessibility-option button.secondary {
        border-color: #D7D7D7;
        background: #fff;
        color: #292929;
    }

    .accessibility-option button.secondary:hover {
        background: #F7F5F6;
    }

    .accessibility-option button[aria-pressed="true"] {
        border-color: #5E50A1;
        background: #5E50A1;
        color: #fff;
    }

    .accessibility-option button:focus-visible {
        outline: 3px solid #5E50A1;
        outline-offset: 3px;
    }

    .accessibility-preview {
        margin-top: 16px;
        padding: 16px;
        border: 1px dashed #D7D7D7;
        border-radius: 10px;
        color: #292929;
        line-height: 1.7;
    }

    .accessibility-status {
        min-height: 1.5em;
        margin-top: 18px;
        color: #176B35;
        font-weight: 700;
    }

    html.modo-escuro .accessibility-heading,
    html.modo-escuro .accessibility-option {
        border-color: #41383b;
        background: #242123;
        color: #eee9eb;
    }

    html.modo-escuro .accessibility-heading {
        background: linear-gradient(120deg, #242123 0%, #302326 100%);
        border-left-color: #CC092F;
    }

    html.modo-escuro .accessibility-heading h2,
    html.modo-escuro .accessibility-option h3,
    html.modo-escuro .accessibility-preview {
        color: #f2ecee;
    }

    html.modo-escuro .accessibility-heading p,
    html.modo-escuro .accessibility-option p {
        color: #c4bbbe;
    }

    html.modo-escuro .accessibility-option button.secondary {
        border-color: #51484b;
        background: #302c2e;
        color: #f2ecee;
    }

    html.modo-escuro .accessibility-option button.secondary:hover {
        background: #3a3437;
    }

    html.modo-escuro .accessibility-preview {
        border-color: #51484b;
        background: #302c2e;
    }

    html.modo-escuro .accessibility-status {
        color: #8de0a8;
    }

    @media (max-width: 520px) {
        .accessibility-option-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .accessibility-option button {
            width: 100%;
        }
    }
</style>

<section class="accessibility-page">
    <header class="accessibility-heading">
        <h2>Personalizar acessibilidade</h2>
        <p>
            Ajuste a leitura e o contraste para deixar a plataforma mais confortável para você.
            Suas preferências são salvas neste navegador e aplicadas às outras páginas.
        </p>
    </header>

    <section class="accessibility-option" aria-labelledby="tamanho-texto-titulo">
        <h3 id="tamanho-texto-titulo">Tamanho do texto</h3>
        <p>Use os botões para deixar as letras menores ou maiores. Você pode restaurar o tamanho padrão quando quiser.</p>
        <div class="accessibility-option-actions">
            <button type="button" id="texto-diminuir" aria-label="Diminuir tamanho do texto">A− Diminuir</button>
            <button type="button" id="texto-aumentar" aria-label="Aumentar tamanho do texto">A+ Aumentar</button>
            <button type="button" class="secondary" id="texto-restaurar">Restaurar tamanho normal</button>
        </div>
        <div class="accessibility-preview">
            Prévia: este texto ajuda você a perceber como a leitura fica com o tamanho escolhido.
        </div>
    </section>

    <section class="accessibility-option" aria-labelledby="contraste-titulo">
        <h3 id="contraste-titulo">Contraste da tela</h3>
        <p>O alto contraste realça textos e elementos para facilitar a visualização.</p>
        <div class="accessibility-option-actions">
            <button type="button" id="alto-contraste" aria-pressed="false">Ativar alto contraste</button>
        </div>
    </section>

    <section class="accessibility-option" aria-labelledby="modo-escuro-titulo">
        <h3 id="modo-escuro-titulo">Modo escuro</h3>
        <p>Use cores escuras na plataforma para tornar a navegação mais confortável. A preferência fica salva neste navegador.</p>
        <div class="accessibility-option-actions">
            <button type="button" id="modo-escuro" aria-pressed="false">Ativar modo escuro</button>
        </div>
    </section>

    <p class="accessibility-status" id="preferencias-status" role="status" aria-live="polite">
        As alterações são aplicadas imediatamente.
    </p>
</section>
@endsection
