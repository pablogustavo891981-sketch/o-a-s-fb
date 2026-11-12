<div class="accessibility-entry">
    <a class="accessibility-link" href="{{ route('acessibilidade') }}">
        <span aria-hidden="true">◉</span>
        Personalizar acessibilidade
    </a>
</div>

<style>
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
            const status = document.getElementById('preferencias-status');

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
                });
            }

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
