<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#CC092F">
    <title>Cadastro | Agendamento e Oferta de Serviços</title>
    <style>
        :root {
            color-scheme: light;
            --vermelho: #CC092F;
            --vermelho-escuro: #A80726;
            --roxo: #5E50A1;
            --texto: #292929;
            --cinza: #666;
            --borda: #E5E5E5;
            --fundo: #F7F5F6;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 28px;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at 12% 12%, rgba(204, 9, 47, .12), transparent 30rem),
                radial-gradient(circle at 90% 90%, rgba(94, 80, 161, .10), transparent 28rem),
                var(--fundo);
            color: var(--texto);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 1rem;
            line-height: 1.6;
        }

        .auth-shell {
            width: min(100%, 1040px);
            display: grid;
            grid-template-columns: .85fr 1.15fr;
            overflow: hidden;
            border: 1px solid rgba(204, 9, 47, .08);
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 24px 70px rgba(35, 20, 28, .12);
        }

        .auth-brand {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 48px;
            padding: 48px;
            overflow: hidden;
            color: #fff;
            background: linear-gradient(145deg, var(--vermelho) 0%, var(--vermelho-escuro) 58%, var(--roxo) 140%);
        }

        .auth-brand::after {
            position: absolute;
            right: -85px;
            bottom: -115px;
            width: 280px;
            height: 280px;
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 50%;
            box-shadow: 0 0 0 35px rgba(255,255,255,.05), 0 0 0 70px rgba(255,255,255,.04);
            content: "";
        }

        .brand-mark {
            display: inline-grid;
            width: 54px;
            height: 54px;
            place-items: center;
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 16px;
            background: rgba(255,255,255,.14);
            font-size: 1.15rem;
            font-weight: 800;
        }
        .brand-logo-wrap {
            display: inline-flex;
            min-height: 64px;
            align-items: center;
            padding: 8px 12px;
            border-radius: 14px;
            background: rgba(255,255,255,.96);
        }
        .brand-logo { display: block; width: 170px; max-height: 48px; object-fit: contain; }

        .brand-copy, .brand-foot { position: relative; z-index: 1; }
        .brand-copy small {
            display: block;
            margin-bottom: 12px;
            color: rgba(255,255,255,.8);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .brand-copy h1 { margin: 0 0 14px; font-size: clamp(1.8rem, 3vw, 2.5rem); line-height: 1.12; }
        .brand-copy p, .brand-foot { margin: 0; color: rgba(255,255,255,.86); line-height: 1.7; }
        .brand-foot { font-size: .85rem; }

        .auth-content { padding: clamp(30px, 5vw, 56px); }
        .form-heading { margin-bottom: 26px; }
        .form-heading small {
            color: var(--vermelho);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        .form-heading h2 { margin: 8px 0; font-size: 1.8rem; }
        .form-heading p { margin: 0; color: var(--cinza); line-height: 1.6; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 16px; }
        .field { margin-bottom: 17px; }
        .field label { display: block; margin-bottom: 8px; font-size: .9rem; font-weight: 700; }
        .field input, .field select {
            width: 100%;
            min-height: 46px;
            padding: 11px 13px;
            border: 1px solid var(--borda);
            border-radius: 10px;
            background: #fff;
            color: var(--texto);
            font: inherit;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .field input:focus, .field select:focus {
            outline: 0;
            border-color: var(--vermelho);
            box-shadow: 0 0 0 4px rgba(204, 9, 47, .11);
        }
        .submit-button {
            width: 100%;
            min-height: 50px;
            border: 0;
            border-radius: 10px;
            background: var(--vermelho);
            color: #fff;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(204, 9, 47, .16);
            transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
        }
        .submit-button:hover { transform: translateY(-1px); background: var(--vermelho-escuro); box-shadow: 0 14px 24px rgba(204, 9, 47, .22); }
        .submit-button:focus-visible, a:focus-visible { outline: 3px solid rgba(94, 80, 161, .45); outline-offset: 3px; }
        .error-summary {
            margin-bottom: 20px;
            padding: 14px 16px;
            border: 1px solid #F2C6CE;
            border-left: 5px solid var(--vermelho);
            border-radius: 10px;
            background: #FFF4F6;
            color: #8F102B;
            box-shadow: 0 8px 18px rgba(130, 18, 42, .06);
        }
        .error-summary h2 { margin: 0 0 7px; color: #861127; font-size: 15px; }
        .error-summary p { margin: 0 0 8px; font-size: 13px; line-height: 1.5; }
        .error-summary ul { display: grid; gap: 5px; margin: 0; padding-left: 20px; }
        .error-summary a { color: #861127; font-size: 13px; font-weight: 600; text-decoration: underline; text-underline-offset: 2px; }
        .error-summary a:hover { color: var(--vermelho); }
        .error-summary-item-unlinked { text-decoration: none !important; }
        .field-error-message, .invalid-feedback { display: block; margin-top: 6px; color: #A80726; font-size: 13px; line-height: 1.45; }
        .has-validation-error { border-color: var(--vermelho) !important; box-shadow: 0 0 0 3px rgba(204, 9, 47, .11) !important; }
        .auth-switch { margin: 22px 0 0; color: var(--cinza); text-align: center; font-size: .92rem; }
        .auth-switch a { color: var(--vermelho); font-weight: 700; text-decoration: none; }
        .auth-switch a:hover { text-decoration: underline; }

        @media (max-width: 760px) {
            body { padding: 14px; }
            .auth-shell { max-width: 520px; grid-template-columns: 1fr; border-radius: 18px; }
            .auth-brand { gap: 22px; padding: 24px 28px; }
            .brand-copy h1 { font-size: 1.55rem; }
            .brand-foot { display: none; }
            .auth-content { padding: 30px 26px; }
        }
        @media (max-width: 520px) { .form-grid { grid-template-columns: 1fr; } }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
<a class="skip-link" href="#conteudo-principal">Pular para o conteúdo principal</a>
@include('components.accessibility-controls')
<main class="auth-shell" id="conteudo-principal" tabindex="-1">
    <aside class="auth-brand">
        <div class="brand-logo-wrap">
            <img
                src="{{ asset('images/logo-fundacao-bradesco.png') }}"
                alt="Fundação Bradesco"
                class="brand-logo"
                onerror="this.hidden = true; this.closest('.brand-logo-wrap').nextElementSibling.hidden = false"
            >
        </div>
        <div class="brand-mark" aria-hidden="true" hidden>FB</div>
        <div class="brand-copy">
            <small>Fundação Bradesco</small>
            <h1>Faça parte da nossa comunidade.</h1>
            <p>Crie sua conta para encontrar serviços, publicar oportunidades e organizar seus agendamentos.</p>
        </div>
        <p class="brand-foot">Agendamento e Oferta de Serviços</p>
    </aside>

    <section class="auth-content" aria-labelledby="register-title">
        <header class="form-heading">
            <small>Cadastro gratuito</small>
            <h2 id="register-title">Crie sua conta</h2>
            <p>Preencha seus dados para começar.</p>
        </header>

        @if($errors->any())
            <section class="error-summary" role="alert" aria-live="assertive" aria-labelledby="error-summary-title" tabindex="-1">
                <h2 id="error-summary-title">{{ $errors->count() === 1 ? 'Encontramos 1 erro no formulário' : 'Encontramos '.$errors->count().' erros no formulário' }}</h2>
                <p>Clique em uma mensagem para ir ao campo que precisa de correção.</p>
                <ul>
                    @foreach($errors->getMessages() as $campo => $mensagens)
                        @foreach($mensagens as $mensagem)
                            <li>
                                <a href="#" data-validation-field="{{ $campo }}" data-validation-message="{{ $mensagem }}">{{ $mensagem }}</a>
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            </section>
        @endif

        <form action="{{ route('cadastro.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="field">
                    <label for="name">Nome completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required>
                </div>

                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                </div>

                <div class="field">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" autocomplete="tel">
                </div>

                <div class="field">
                    <label for="tipo_usuario">Tipo de conta</label>
                    <select id="tipo_usuario" name="tipo_usuario" required>
                        <option value="cliente" @selected(old('tipo_usuario', 'cliente') === 'cliente')>Cliente</option>
                        <option value="prestador" @selected(old('tipo_usuario') === 'prestador')>Prestador de serviços</option>
                    </select>
                </div>

                <div class="field">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" required>
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmar senha</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
                </div>
            </div>

            <button type="submit" class="submit-button">Criar minha conta</button>
        </form>

        <p class="auth-switch">Já possui uma conta? <a href="{{ route('login') }}">Entrar</a></p>
    </section>
</main>
@include('components.validation-enhancement')
</body>
</html>
