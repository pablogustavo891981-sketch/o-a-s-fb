<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#CC092F">
    <title>Fundação Bradesco | Agendamento e Oferta de Serviços</title>
    <style>
        :root {
            --vermelho: #CC092F;
            --vermelho-escuro: #A80726;
            --rosa: #FCECEF;
            --roxo: #5E50A1;
            --texto: #292929;
            --cinza: #626262;
            --borda: #ECE7E8;
            --fundo: #F7F5F6;
        }

        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            background: radial-gradient(circle at 8% 8%, rgba(204,9,47,.09), transparent 28rem), var(--fundo);
            color: var(--texto);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 1rem;
            line-height: 1.6;
        }
        a { color: inherit; text-decoration: none; }
        .landing { min-height: 100vh; padding: 24px clamp(16px, 4vw, 56px) 48px; }
        .topbar, .hero, .features { width: min(100%, 1200px); margin-right: auto; margin-left: auto; }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 14px 20px;
            border: 1px solid rgba(204,9,47,.08);
            border-radius: 18px;
            background: rgba(255,255,255,.9);
            box-shadow: 0 12px 30px rgba(35,20,28,.05);
        }
        .brand { display: flex; align-items: center; gap: 13px; }
        .brand-mark {
            display: grid;
            width: 44px;
            height: 44px;
            place-items: center;
            border-radius: 12px;
            background: linear-gradient(140deg, var(--vermelho), var(--vermelho-escuro));
            color: #fff;
            font-size: .8rem;
            font-weight: 800;
        }
        .brand-logo { display: block; width: 150px; max-height: 52px; object-fit: contain; object-position: left center; }
        .brand-copy small {
            display: block;
            margin-bottom: 4px;
            color: var(--cinza);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        .brand-copy strong { font-size: .98rem; }
        .nav-actions, .cta-group { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; }
        .btn {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn:focus-visible, a:focus-visible { outline: 3px solid rgba(94,80,161,.45); outline-offset: 3px; }
        .btn-outline { border-color: rgba(204,9,47,.25); color: var(--vermelho); background: #fff; }
        .btn-primary { color: #fff; background: var(--vermelho); box-shadow: 0 10px 22px rgba(204,9,47,.18); }
        .btn-primary:hover { background: var(--vermelho-escuro); }

        .hero {
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            align-items: center;
            gap: clamp(28px, 5vw, 64px);
            padding: clamp(48px, 8vw, 92px) 18px 56px;
        }
        .eyebrow {
            display: inline-block;
            margin-bottom: 18px;
            padding: 8px 13px;
            border-radius: 999px;
            background: var(--rosa);
            color: var(--vermelho);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        h1 { max-width: 700px; margin: 0 0 18px; font-size: clamp(2.35rem, 5vw, 4rem); line-height: 1.06; }
        .hero-copy p { max-width: 630px; margin: 0; color: var(--cinza); font-size: 1.08rem; line-height: 1.75; }
        .cta-group { margin-top: 28px; }
        .hero-card {
            padding: clamp(22px, 4vw, 36px);
            border: 1px solid rgba(204,9,47,.09);
            border-radius: 26px;
            background: linear-gradient(145deg, #fff 0%, #fff7f8 70%, #f7f4fb 100%);
            box-shadow: 0 20px 46px rgba(45,28,35,.07);
        }
        .hero-card h2 { margin: 0 0 22px; font-size: 1.2rem; }
        .journey { display: grid; gap: 14px; }
        .journey-item {
            display: grid;
            grid-template-columns: 42px 1fr;
            align-items: start;
            gap: 13px;
            padding: 16px;
            border: 1px solid var(--borda);
            border-radius: 15px;
            background: rgba(255,255,255,.9);
        }
        .journey-number {
            display: grid;
            width: 40px;
            height: 40px;
            place-items: center;
            border-radius: 12px;
            background: var(--rosa);
            color: var(--vermelho);
            font-weight: 800;
        }
        .journey-item strong { display: block; margin: 1px 0 5px; }
        .journey-item span:last-child { color: var(--cinza); font-size: .9rem; line-height: 1.5; }
        .features { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; padding: 0 18px; }
        .feature {
            padding: 22px;
            border: 1px solid var(--borda);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(35,20,28,.035);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .feature:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(35,20,28,.08); }
        .feature-icon {
            display: grid;
            width: 44px;
            height: 44px;
            margin-bottom: 15px;
            place-items: center;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--rosa), #f1edfb);
            color: var(--vermelho);
            font-size: 1.15rem;
            font-weight: 800;
        }
        .feature h3 { margin: 0 0 9px; font-size: 1.05rem; }
        .feature p { margin: 0; color: var(--cinza); font-size: .92rem; line-height: 1.65; }
        footer { padding: 34px 18px 0; color: var(--cinza); text-align: center; font-size: .82rem; }

        @media (max-width: 820px) {
            .hero { grid-template-columns: 1fr; padding-top: 54px; }
            .features { grid-template-columns: 1fr; }
        }
        @media (max-width: 560px) {
            .topbar { align-items: flex-start; flex-direction: column; padding: 16px; }
            .nav-actions { width: 100%; }
            .nav-actions .btn { flex: 1; }
            .hero { padding-right: 4px; padding-left: 4px; }
            .features { padding-right: 4px; padding-left: 4px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
    <a class="skip-link" href="#conteudo-principal">Pular para o conteúdo principal</a>
    <div class="landing">
        <header class="topbar">
            <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="brand">
                <img
                    src="{{ asset('images/logo-fundacao-bradesco.png') }}"
                    alt="Fundação Bradesco"
                    class="brand-logo"
                    onerror="this.hidden = true; this.nextElementSibling.hidden = false"
                >
                <span class="brand-mark" aria-hidden="true" hidden>FB</span>
                <span class="brand-copy">
                    <small>Fundação Bradesco</small>
                    <strong>Agendamento e Oferta de Serviços</strong>
                </span>
            </a>

            <nav class="nav-actions" aria-label="Acesso à plataforma">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Acessar painel</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Entrar</a>
                    <a href="{{ route('cadastro') }}" class="btn btn-primary">Criar conta</a>
                @endauth
            </nav>
        </header>

        @include('components.accessibility-controls')

        <main class="hero" id="conteudo-principal" tabindex="-1">
            <section class="hero-copy">
                <span class="eyebrow">Conectando pessoas e serviços</span>
                <h1>Encontre o serviço certo e agende com facilidade.</h1>
                <p>
                    Uma plataforma para descobrir serviços e oportunidades, organizar agendamentos
                    e aproximar clientes e prestadores da comunidade da Fundação Bradesco.
                </p>
                <div class="cta-group">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Ir para meu painel</a>
                    @else
                        <a href="{{ route('cadastro') }}" class="btn btn-primary">Começar agora</a>
                        <a href="{{ route('login') }}" class="btn btn-outline">Já tenho uma conta</a>
                    @endauth
                </div>
            </section>

            <aside class="hero-card" aria-label="Como funciona a plataforma">
                <h2>Um fluxo simples para começar</h2>
                <div class="journey">
                    <div class="journey-item">
                        <span class="journey-number">1</span>
                        <span><strong>Encontre</strong><span>Explore serviços, categorias e anúncios da comunidade.</span></span>
                    </div>
                    <div class="journey-item">
                        <span class="journey-number">2</span>
                        <span><strong>Combine</strong><span>Consulte os detalhes e solicite um horário adequado.</span></span>
                    </div>
                    <div class="journey-item">
                        <span class="journey-number">3</span>
                        <span><strong>Acompanhe</strong><span>Consulte seus agendamentos e mantenha tudo organizado.</span></span>
                    </div>
                </div>
            </aside>
        </main>

        <section class="features" aria-label="Recursos da plataforma">
            <article class="feature">
                <span class="feature-icon" aria-hidden="true">01</span>
                <h3>Descoberta organizada</h3>
                <p>Encontre serviços e ofertas separados por categorias e com informações claras.</p>
            </article>
            <article class="feature">
                <span class="feature-icon" aria-hidden="true">02</span>
                <h3>Agendamentos acompanhados</h3>
                <p>Consulte solicitações e acompanhe o andamento dos atendimentos na plataforma.</p>
            </article>
            <article class="feature">
                <span class="feature-icon" aria-hidden="true">03</span>
                <h3>Espaço para a comunidade</h3>
                <p>Clientes, prestadores e administradores contam com recursos pensados para cada perfil.</p>
            </article>
        </section>

        <footer>Agendamento e Oferta de Serviços · Fundação Bradesco</footer>
    </div>
</body>
</html>
