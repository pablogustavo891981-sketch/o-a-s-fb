<div class="accessibility-entry">
    <a class="accessibility-link" href="{{ route('acessibilidade') }}">
        <span aria-hidden="true">◉</span>
        Personalizar acessibilidade
    </a>
</div>

<style>
    body,
    body * {
        transition: background-color .32s ease, color .32s ease, border-color .32s ease;
    }

    @media (prefers-reduced-motion: reduce) {
        body,
        body * {
            transition-duration: .01ms !important;
        }
    }

    html.modo-escuro {
        color-scheme: dark;
        --fundo: #181719;
        --texto: #eee9eb;
        --cinza: #c4bbbe;
        --borda: #41383b;
        --rosa: #3a2a2f;
        --vermelho-escuro: #c32244;
    }

    html.modo-escuro body {
        background: linear-gradient(180deg, #1d1b1d 0%, #171618 100%);
        color: #eee9eb;
    }

    html.modo-escuro:not(.alto-contraste) body :not(button):not(button *):not(input):not(select):not(textarea):not(svg):not(path):not(.topbar):not(.topbar *):not(.auth-brand):not(.auth-brand *):not(.category-edit) {
        color: #eee9eb !important;
    }

    html.modo-escuro:not(.alto-contraste) body .tema-superficie-clara:not(button):not(button *):not(input):not(select):not(textarea):not(svg):not(path):not(.topbar):not(.topbar *):not(.auth-brand):not(.auth-brand *):not(.category-edit),
    html.modo-escuro:not(.alto-contraste) body .tema-superficie-clara :not(button):not(button *):not(input):not(select):not(textarea):not(svg):not(path):not(.topbar):not(.topbar *):not(.auth-brand):not(.auth-brand *):not(.category-edit) {
        color: #292929 !important;
    }

    html.modo-escuro:not(.alto-contraste) body .tema-botao-vermelho,
    html.modo-escuro:not(.alto-contraste) body .tema-botao-vermelho *:not(svg):not(path) {
        color: #fff !important;
    }

    html.modo-escuro .auth-shell,
    html.modo-escuro .landing .topbar,
    html.modo-escuro .hero-card,
    html.modo-escuro .journey-item,
    html.modo-escuro .feature {
        border-color: #41383b;
        background: #242123;
        color: #eee9eb;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .2);
    }

    html.modo-escuro .hero-card {
        background: linear-gradient(145deg, #242123 0%, #302326 100%);
    }

    html.modo-escuro .field input,
    html.modo-escuro .field select {
        border-color: #51484b;
        background: #302c2e;
        color: #f2ecee;
    }

    html.modo-escuro .form-heading p,
    html.modo-escuro .remember,
    html.modo-escuro .auth-switch,
    html.modo-escuro .brand-copy small,
    html.modo-escuro .hero-copy p,
    html.modo-escuro .journey-item span:last-child,
    html.modo-escuro .feature p,
    html.modo-escuro .landing footer {
        color: #c4bbbe;
    }

    html.modo-escuro .auth-switch a,
    html.modo-escuro .btn-outline {
        color: #ff829b;
    }

    html.modo-escuro .btn-outline {
        border-color: #67595e;
        background: #302c2e;
    }

    html.modo-escuro .eyebrow,
    html.modo-escuro .journey-number,
    html.modo-escuro .feature-icon {
        background: #3a2a2f;
        color: #ff829b;
    }

    html.modo-escuro .error-summary {
        border-color: #65404a;
        background: #39252a;
        color: #ffb3bf;
    }

    html.modo-escuro .error-summary h2,
    html.modo-escuro .error-summary a,
    html.modo-escuro .field-error-message,
    html.modo-escuro .invalid-feedback {
        color: #ffb3bf;
    }

    html.modo-escuro .accessibility-entry {
        border-color: #41383b;
        background: #242123;
    }

    html.modo-escuro .accessibility-link {
        border-color: #51484b;
        background: #302c2e;
        color: #f2ecee;
    }

    html.modo-escuro .accessibility-link:hover {
        border-color: #a80726;
        background: #3a2a2f;
        color: #fff;
    }

    html.modo-escuro .skip-link {
        background: #302c2e;
        color: #f2ecee;
    }

    .accessibility-link {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 14px;
        border: 1px solid #E5E5E5;
        border-radius: 9px;
        background: #fff;
        color: #861127;
        font-size: .9rem;
        font-weight: 700;
    }

    .accessibility-link:hover {
        border-color: #A80726;
        background: #FCECEF;
        color: #861127;
    }

    .accessibility-link:focus-visible {
        outline: 3px solid #5E50A1;
        outline-offset: 3px;
    }

    .accessibility-entry {
        display: flex;
        justify-content: flex-end;
        padding: 8px 5%;
        border-bottom: 1px solid #E5E5E5;
        background: #fff;
    }

    .skip-link {
        position: fixed;
        top: 8px;
        left: 8px;
        z-index: 1000;
        padding: 12px 16px;
        transform: translateY(-150%);
        border-radius: 8px;
        background: #fff;
        color: #861127;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(0, 0, 0, .2);
    }

    .skip-link:focus {
        transform: translateY(0);
    }

    @media (max-width: 560px) {
        .accessibility-entry {
            justify-content: center;
            padding: 8px 16px;
        }

        .accessibility-link {
            width: 100%;
        }
    }

    html.alto-contraste body,
    html.alto-contraste body *:not(img):not(svg):not(path) {
        border-color: #fff !important;
        background-color: #000 !important;
        box-shadow: none !important;
        color: #fff !important;
        text-shadow: none !important;
    }

    html.alto-contraste a {
        color: #ff0 !important;
        text-decoration: underline !important;
    }

    html.alto-contraste button,
    html.alto-contraste input,
    html.alto-contraste select,
    html.alto-contraste textarea {
        border: 2px solid #fff !important;
        background: #000 !important;
        color: #fff !important;
    }

    html.alto-contraste button:hover,
    html.alto-contraste button[aria-pressed="true"] {
        background: #ff0 !important;
        color: #000 !important;
    }

    html.alto-contraste :focus-visible {
        outline: 4px solid #ff0 !important;
        outline-offset: 3px !important;
    }

    html.alto-contraste svg {
        stroke: #ff0 !important;
    }
</style>

<script>
    (function () {
        const raiz = document.documentElement;
        const chaveTexto = 'oas-fb-tamanho-texto';
        const chaveContraste = 'oas-fb-alto-contraste';
        const chaveModoEscuro = 'oas-fb-modo-escuro';
        const tamanhoPadrao = 1;
        let tamanhoTexto = tamanhoPadrao;
        let erroAoCarregarPreferencias = false;

        try {
            const tamanhoSalvo = Number(localStorage.getItem(chaveTexto));

            if (Number.isFinite(tamanhoSalvo) && tamanhoSalvo >= 0.875 && tamanhoSalvo <= 1.5) {
                tamanhoTexto = tamanhoSalvo;
            }

            if (localStorage.getItem(chaveContraste) === 'sim') {
                raiz.classList.add('alto-contraste');
            }

            if (localStorage.getItem(chaveModoEscuro) === 'sim') {
                raiz.classList.add('modo-escuro');
            }
        } catch {
            erroAoCarregarPreferencias = true;
        }

        if (tamanhoTexto !== tamanhoPadrao) {
            raiz.style.fontSize = `${tamanhoTexto * 100}%`;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const diminuir = document.getElementById('texto-diminuir');
            const aumentar = document.getElementById('texto-aumentar');
            const restaurar = document.getElementById('texto-restaurar');
            const contraste = document.getElementById('alto-contraste');
            const modoEscuro = document.getElementById('modo-escuro');
            const status = document.getElementById('preferencias-status');

            function lerCorCss(valor) {
                const componentes = valor.match(/[\d.]+%?/g);

                if (!componentes || componentes.length < 3) {
                    return null;
                }

                return componentes.map(function (componente, indice) {
                    const numero = Number.parseFloat(componente);

                    if (componente.endsWith('%')) {
                        return numero / 100;
                    }

                    return indice < 3 ? numero / 255 : numero;
                });
            }

            function luminanciaDaCor(cor) {
                const [vermelho, verde, azul] = cor;

                return 0.2126 * vermelho + 0.7152 * verde + 0.0722 * azul;
            }

            function corDoFundo(elemento) {
                const fundos = [];
                let atual = elemento;

                while (atual && atual !== document.documentElement) {
                    const estilos = window.getComputedStyle(atual);
                    const camadas = [];
                    const cor = lerCorCss(estilos.backgroundColor);

                    if (cor && (cor.length < 4 || cor[3] > 0)) {
                        camadas.push(cor);
                    }

                    if (estilos.backgroundImage !== 'none') {
                        const coresDoGradiente = estilos.backgroundImage.match(/rgba?\([^)]+\)|#[\da-f]{3,8}/gi);

                        if (coresDoGradiente) {
                            const cores = coresDoGradiente.map(lerCorCss).filter(Boolean);

                            if (cores.length > 0) {
                                camadas.push(cores.reduce(function (media, corDoGradiente) {
                                    for (let indice = 0; indice < 3; indice += 1) {
                                        media[indice] += corDoGradiente[indice] / cores.length;
                                    }

                                    media[3] += (corDoGradiente[3] ?? 1) / cores.length;
                                    return media;
                                }, [0, 0, 0, 0]));
                            }
                        }
                    }

                    if (camadas.length > 0) {
                        fundos.push(camadas);
                    }

                    atual = atual.parentElement;
                }

                let corFinal = [0, 0, 0, 1];

                fundos.reverse().forEach(function (camadas) {
                    camadas.forEach(function (camada) {
                        const opacidade = camada[3] ?? 1;

                        for (let indice = 0; indice < 3; indice += 1) {
                            corFinal[indice] = camada[indice] * opacidade + corFinal[indice] * (1 - opacidade);
                        }
                    });
                });

                return corFinal;
            }

            function atualizarSuperficiesClaras() {
                if (!raiz.classList.contains('modo-escuro') || raiz.classList.contains('alto-contraste')) {
                    document.querySelectorAll('.tema-superficie-clara, .tema-botao-vermelho').forEach(function (elemento) {
                        elemento.classList.remove('tema-superficie-clara');
                        elemento.classList.remove('tema-botao-vermelho');
                    });

                    return;
                }

                document.querySelectorAll('body *').forEach(function (elemento) {
                    if (elemento.matches('button, input, select, textarea, .topbar, .topbar *, .auth-brand, .auth-brand *')) {
                        elemento.classList.remove('tema-superficie-clara');
                        return;
                    }

                    elemento.classList.toggle('tema-superficie-clara', luminanciaDaCor(corDoFundo(elemento)) >= 0.62);
                });

                document.querySelectorAll('button, a[role="button"], a.btn').forEach(function (botao) {
                    const corDeFundo = lerCorCss(window.getComputedStyle(botao).backgroundColor);
                    const vermelho = corDeFundo && corDeFundo.length >= 3
                        && (corDeFundo[3] ?? 1) >= 0.8
                        && corDeFundo[0] > 0.5
                        && corDeFundo[0] > corDeFundo[1] * 1.35
                        && corDeFundo[0] > corDeFundo[2] * 1.2;

                    botao.classList.toggle('tema-botao-vermelho', Boolean(vermelho));
                });
            }

            atualizarSuperficiesClaras();
            let temporizadorSuperficiesClaras;

            new MutationObserver(function (mutacoes) {
                if (!mutacoes.some(function (mutacao) {
                    return mutacao.addedNodes.length > 0
                        || mutacao.removedNodes.length > 0
                        || (mutacao.type === 'attributes' && mutacao.target.matches('button, a[role="button"], a.btn'));
                })) {
                    return;
                }

                window.clearTimeout(temporizadorSuperficiesClaras);
                temporizadorSuperficiesClaras = window.setTimeout(atualizarSuperficiesClaras, 100);
            }).observe(document.body, {
                attributes: true,
                attributeFilter: ['aria-pressed'],
                childList: true,
                subtree: true,
            });

            function anunciar(mensagem) {
                if (status) {
                    status.textContent = mensagem;
                }
            }

            if (erroAoCarregarPreferencias) {
                anunciar('As preferências salvas não puderam ser carregadas neste navegador.');
            }

            function salvarPreferencia(chave, valor) {
                try {
                    localStorage.setItem(chave, valor);
                } catch {
                    anunciar('A preferência está ativa nesta visita, mas não pôde ser salva neste navegador.');
                }
            }

            function atualizarBotaoModoEscuro(ativo) {
                if (!modoEscuro) {
                    return;
                }

                modoEscuro.setAttribute('aria-pressed', ativo ? 'true' : 'false');
                modoEscuro.textContent = ativo ? 'Desativar modo escuro' : 'Ativar modo escuro';
            }

            function aplicarModoEscuro(ativo, anunciarAlteracao = false) {
                raiz.classList.toggle('modo-escuro', ativo);
                atualizarBotaoModoEscuro(ativo);
                window.clearTimeout(temporizadorSuperficiesClaras);
                temporizadorSuperficiesClaras = window.setTimeout(
                    atualizarSuperficiesClaras,
                    window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 360
                );

                if (anunciarAlteracao) {
                    anunciar(ativo ? 'Modo escuro ativado.' : 'Modo escuro desativado.');
                }
            }

            function aplicarTamanhoTexto() {
                raiz.style.fontSize = `${tamanhoTexto * 100}%`;
                salvarPreferencia(chaveTexto, String(tamanhoTexto));
                anunciar(`Tamanho do texto: ${Math.round(tamanhoTexto * 100)} por cento.`);
            }

            if (diminuir) {
                diminuir.addEventListener('click', function () {
                    tamanhoTexto = Math.max(0.875, Math.round((tamanhoTexto - 0.125) * 1000) / 1000);
                    aplicarTamanhoTexto();
                });
            }

            if (aumentar) {
                aumentar.addEventListener('click', function () {
                    tamanhoTexto = Math.min(1.5, Math.round((tamanhoTexto + 0.125) * 1000) / 1000);
                    aplicarTamanhoTexto();
                });
            }

            if (restaurar) {
                restaurar.addEventListener('click', function () {
                    tamanhoTexto = tamanhoPadrao;
                    aplicarTamanhoTexto();
                });
            }

            if (contraste) {
                function atualizarBotaoContraste(ativo) {
                    contraste.setAttribute('aria-pressed', ativo ? 'true' : 'false');
                    contraste.textContent = ativo ? 'Desativar alto contraste' : 'Ativar alto contraste';
                }

                atualizarBotaoContraste(raiz.classList.contains('alto-contraste'));
                contraste.addEventListener('click', function () {
                    const ativo = raiz.classList.toggle('alto-contraste');
                    atualizarBotaoContraste(ativo);
                    salvarPreferencia(chaveContraste, ativo ? 'sim' : 'nao');
                    anunciar(ativo ? 'Alto contraste ativado.' : 'Alto contraste desativado.');
                    atualizarSuperficiesClaras();
                });
            }

            if (modoEscuro) {
                atualizarBotaoModoEscuro(raiz.classList.contains('modo-escuro'));
                modoEscuro.addEventListener('click', function () {
                    const ativo = !raiz.classList.contains('modo-escuro');
                    aplicarModoEscuro(ativo, true);
                    salvarPreferencia(chaveModoEscuro, ativo ? 'sim' : 'nao');
                });
            }

            window.addEventListener('storage', function (evento) {
                if (evento.key !== chaveModoEscuro) {
                    return;
                }

                aplicarModoEscuro(evento.newValue === 'sim');
            });

            document.querySelectorAll('form').forEach(function (form) {
                if (form.method.toLowerCase() !== 'post') {
                    return;
                }

                form.addEventListener('submit', function (event) {
                    if (event.defaultPrevented || !form.checkValidity()) {
                        return;
                    }

                    const botao = event.submitter || form.querySelector('button[type="submit"], input[type="submit"]');

                    if (!botao || botao.disabled) {
                        return;
                    }

                    botao.textContent = 'Enviando...';
                    botao.setAttribute('aria-busy', 'true');
                    botao.disabled = true;
                });
            });
        });
    })();
</script>
