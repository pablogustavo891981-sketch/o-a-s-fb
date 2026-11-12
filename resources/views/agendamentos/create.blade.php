@extends('layouts.app')

@section('content')
<style>
    .form-agendamento {
        max-width: 850px;
        margin: 35px auto;
        padding: 0 18px;
        color: #333;
    }

    .form-agendamento .cabecalho {
        background: #CC092F;
        color: white;
        padding: 28px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .form-agendamento .cabecalho h1 {
        margin: 0 0 8px;
        font-size: 26px;
    }

    .form-agendamento .card {
        background: white;
        border: 1px solid #E5E5E5;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .form-agendamento .campo {
        margin-bottom: 20px;
    }

    .form-agendamento label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-agendamento input,
    .form-agendamento select,
    .form-agendamento textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #DDD;
        border-radius: 7px;
        font-size: 15px;
        background: white;
        color: #333;
    }

    .form-agendamento input:focus,
    .form-agendamento select:focus,
    .form-agendamento textarea:focus {
        outline: none;
        border-color: #CC092F;
        box-shadow: 0 0 0 3px rgba(204,9,47,.10);
    }

    .form-agendamento textarea {
        min-height: 110px;
        resize: vertical;
    }

    .form-agendamento .grade {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-agendamento .erro {
        color: #CC092F;
        font-size: 13px;
        margin-top: 6px;
    }

    .form-agendamento .alerta {
        background: #FCECEF;
        color: #A80726;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 18px;
    }

    .form-agendamento .botoes {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 25px;
    }

    .form-agendamento .botao {
        display: inline-block;
        border: 0;
        border-radius: 7px;
        padding: 12px 20px;
        background: #CC092F;
        color: white;
        text-decoration: none;
        cursor: pointer;
        font-weight: 600;
    }

    .form-agendamento .botao:hover {
        background: #A80726;
        color: white;
    }

    .form-agendamento .secundario {
        background: #F5F5F5;
        color: #333;
        border: 1px solid #DDD;
    }

    .form-agendamento .secundario:hover {
        background: #EAEAEA;
        color: #333;
    }

    .form-agendamento .ajuda {
        color: #777;
        font-size: 13px;
        margin-top: 6px;
    }

    .form-agendamento .calendario {
        margin-top: 12px;
        padding: 16px;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
        background: #FFFCFC;
    }

    .form-agendamento .calendario-cabecalho {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .form-agendamento .calendario-cabecalho button {
        width: 38px;
        height: 38px;
        border: 1px solid #E5E5E5;
        border-radius: 8px;
        background: white;
        color: #A80726;
        cursor: pointer;
        font-size: 20px;
    }

    .form-agendamento .calendario-cabecalho button:disabled {
        cursor: not-allowed;
        opacity: .4;
    }

    .form-agendamento .calendario-mes {
        font-weight: 700;
        text-transform: capitalize;
    }

    .form-agendamento .calendario-grade {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 5px;
    }

    .form-agendamento .calendario-dia-semana,
    .form-agendamento .calendario-dia {
        display: grid;
        min-height: 38px;
        place-items: center;
        border-radius: 8px;
        font-size: 13px;
    }

    .form-agendamento .calendario-dia-semana {
        color: #777;
        font-weight: 700;
    }

    .form-agendamento .calendario-dia {
        border: 1px solid transparent;
        background: #F2F2F2;
        color: #888;
    }

    .form-agendamento button.calendario-dia {
        cursor: pointer;
    }

    .form-agendamento .calendario-dia.disponivel {
        border-color: #F1C7D0;
        background: #FCECEF;
        color: #A80726;
        font-weight: 700;
    }

    .form-agendamento .calendario-dia.disponivel:hover,
    .form-agendamento .calendario-dia.selecionado {
        background: #CC092F;
        color: white;
    }

    .form-agendamento .calendario-legenda {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
        color: #666;
        font-size: 12px;
    }

    .form-agendamento .calendario-legenda span {
        width: 12px;
        height: 12px;
        border-radius: 4px;
        background: #FCECEF;
        border: 1px solid #F1C7D0;
    }

    @media(max-width: 600px) {
        .form-agendamento .grade {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-agendamento .card {
            padding: 18px;
        }
    }
</style>

@php
    $servicoSelecionado = old('servico_id', request('servico_id'));
@endphp

<div class="form-agendamento">

    <div class="cabecalho">
        <h1>Solicitar agendamento</h1>
        <p>Preencha os dados abaixo para solicitar um serviço.</p>
    </div>

    @if($errors->any())
        <div class="alerta">
            <strong>Verifique os seguintes campos:</strong>
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">

        @if($servicos->isEmpty())
            <div class="alerta">
                Não existem serviços disponíveis para agendamento no momento.
            </div>

            <a href="{{ route('servicos.index') }}" class="botao">
                Ver serviços
            </a>
        @else

            <form action="{{ route('agendamentos.store') }}" method="POST">
                @csrf

                <div class="campo">
                    <label for="servico_id">Serviço desejado *</label>

                    <select name="servico_id" id="servico_id" required>
                        <option value="">Selecione um serviço</option>

                        @foreach($servicos as $servico)
                            <option
                                value="{{ $servico->id }}"
                                data-local-atendimento="{{ $servico->local_atendimento }}"
                                @selected((string) $servicoSelecionado === (string) $servico->id)
                            >
                                {{ $servico->nome }}
                                — R$ {{ number_format($servico->preco, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>

                    @error('servico_id')
                        <div class="erro">{{ $message }}</div>
                    @enderror

                    <div class="ajuda">
                        Escolha o serviço que deseja contratar.
                    </div>
                </div>

                <div class="grade">
                    <div class="campo">
                        <label for="data">Data desejada *</label>

                        <input
                            type="date"
                            name="data"
                            id="data"
                            value="{{ old('data') }}"
                            min="{{ now()->format('Y-m-d') }}"
                            required
                        >

                        @error('data')
                            <div class="erro">{{ $message }}</div>
                        @enderror

                        <div class="calendario" aria-label="Calendário com dias disponíveis">
                            <div class="calendario-cabecalho">
                                <button type="button" id="mes-anterior" aria-label="Mês anterior">‹</button>
                                <span class="calendario-mes" id="calendario-mes" aria-live="polite"></span>
                                <button type="button" id="proximo-mes" aria-label="Próximo mês">›</button>
                            </div>
                            <div class="calendario-grade" aria-hidden="true">
                                <span class="calendario-dia-semana">Seg</span>
                                <span class="calendario-dia-semana">Ter</span>
                                <span class="calendario-dia-semana">Qua</span>
                                <span class="calendario-dia-semana">Qui</span>
                                <span class="calendario-dia-semana">Sex</span>
                                <span class="calendario-dia-semana">Sáb</span>
                                <span class="calendario-dia-semana">Dom</span>
                            </div>
                            <div class="calendario-grade" id="calendario-dias" aria-live="polite"></div>
                            <div class="calendario-legenda">
                                <span aria-hidden="true"></span>
                                Dias com horários disponíveis
                            </div>
                            <div class="ajuda" id="calendario-status" role="status" aria-live="polite">
                                Escolha um serviço para consultar os dias disponíveis.
                            </div>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="horario">Horário desejado *</label>

                        <select
                            name="horario"
                            id="horario"
                            aria-describedby="horarios-status"
                            required
                            disabled
                        >
                            <option value="">Selecione o serviço e a data primeiro</option>
                        </select>

                        @error('horario')
                            <div class="erro">{{ $message }}</div>
                        @enderror

                        <div class="ajuda" id="horarios-status" role="status" aria-live="polite">
                            Escolha um serviço e uma data para consultar os horários livres.
                        </div>
                    </div>
                </div>

                <div class="campo">
                    <label>Local do atendimento</label>
                    <div class="ajuda" id="local-atendimento">
                        O local será informado pelo prestador do serviço.
                    </div>
                </div>

                <div class="campo">
                    <label for="telefone_cliente">Telefone para contato *</label>

                    <input
                        type="tel"
                        name="telefone_cliente"
                        id="telefone_cliente"
                        value="{{ old('telefone_cliente', auth()->user()->telefone) }}"
                        autocomplete="tel"
                        placeholder="(00) 00000-0000"
                        required
                    >

                    @error('telefone_cliente')
                        <div class="erro">{{ $message }}</div>
                    @enderror
                </div>

                <div class="campo">
                    <label for="observacoes">Observações</label>

                    <textarea
                        name="observacoes"
                        id="observacoes"
                        placeholder="Informe detalhes adicionais, se necessário."
                    >{{ old('observacoes') }}</textarea>

                    @error('observacoes')
                        <div class="erro">{{ $message }}</div>
                    @enderror
                </div>

                <p class="ajuda">
                    * Campos obrigatórios. A solicitação ficará pendente
                    até a confirmação do prestador.
                </p>

                <div class="botoes">
                    <button type="submit" class="botao">
                        Enviar solicitação
                    </button>

                    <a
                        href="{{ route('servicos.index') }}"
                        class="botao secundario"
                    >
                        Voltar aos serviços
                    </a>
                </div>
            </form>

        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const servico = document.getElementById('servico_id');
        const data = document.getElementById('data');
        const horario = document.getElementById('horario');
        const status = document.getElementById('horarios-status');
        const calendarDays = document.getElementById('calendario-dias');
        const calendarMonth = document.getElementById('calendario-mes');
        const calendarStatus = document.getElementById('calendario-status');
        const previousMonth = document.getElementById('mes-anterior');
        const nextMonth = document.getElementById('proximo-mes');
        const locationLabel = document.getElementById('local-atendimento');
        const slotsUrl = @json(route('agendamentos.horarios-disponiveis'));
        const datesUrl = @json(route('agendamentos.datas-disponiveis'));
        const horarioAnterior = @json(old('horario'));
        const hoje = new Date();
        hoje.setDate(1);
        hoje.setHours(0, 0, 0, 0);
        const mesFinal = new Date(hoje.getFullYear(), hoje.getMonth() + 12, 1);
        let mesExibido = data.value
            ? new Date(`${data.value}T12:00:00`)
            : new Date();
        mesExibido.setDate(1);
        let requisicaoHorarios;
        let requisicaoDatas;
        let datasDisponiveis = [];

        function formatarMes(date) {
            return new Intl.DateTimeFormat('pt-BR', {
                month: 'long',
                year: 'numeric',
            }).format(date);
        }

        function dataIso(date) {
            const ano = date.getFullYear();
            const mes = String(date.getMonth() + 1).padStart(2, '0');
            const dia = String(date.getDate()).padStart(2, '0');
            return `${ano}-${mes}-${dia}`;
        }

        function atualizarCalendario() {
            const ano = mesExibido.getFullYear();
            const mes = mesExibido.getMonth();
            const primeiroDia = new Date(ano, mes, 1);
            const deslocamento = (primeiroDia.getDay() + 6) % 7;
            const quantidadeDias = new Date(ano, mes + 1, 0).getDate();
            const mesAtual = new Date(ano, mes, 1);

            calendarMonth.textContent = formatarMes(mesExibido);
            previousMonth.disabled = mesAtual <= hoje;
            nextMonth.disabled = mesAtual >= mesFinal;
            calendarDays.replaceChildren();

            for (let espaco = 0; espaco < deslocamento; espaco++) {
                const vazio = document.createElement('span');
                vazio.className = 'calendario-dia';
                vazio.setAttribute('aria-hidden', 'true');
                calendarDays.append(vazio);
            }

            for (let dia = 1; dia <= quantidadeDias; dia++) {
                const date = new Date(ano, mes, dia);
                const iso = dataIso(date);
                const disponivel = datasDisponiveis.includes(iso);
                const botao = document.createElement(disponivel ? 'button' : 'span');
                botao.className = `calendario-dia${disponivel ? ' disponivel' : ''}`;
                botao.textContent = String(dia);

                if (disponivel) {
                    botao.type = 'button';
                    botao.setAttribute('aria-label', `${dia} de ${formatarMes(mesExibido)}, disponível`);
                    botao.setAttribute('aria-pressed', data.value === iso ? 'true' : 'false');

                    if (data.value === iso) {
                        botao.classList.add('selecionado');
                    }

                    botao.addEventListener('click', function () {
                        data.value = iso;
                        data.dispatchEvent(new Event('change', { bubbles: true }));
                        atualizarCalendario();
                    });
                } else {
                    botao.setAttribute('aria-hidden', 'true');
                }

                calendarDays.append(botao);
            }
        }

        function atualizarLocal() {
            const opcao = servico.selectedOptions[0];
            const local = opcao?.dataset.localAtendimento?.trim();
            locationLabel.textContent = local || 'A combinar com o prestador';
        }

        async function carregarDatasDisponiveis() {
            if (requisicaoDatas) {
                requisicaoDatas.abort();
            }

            datasDisponiveis = [];
            atualizarCalendario();

            if (!servico.value) {
                calendarStatus.textContent = 'Escolha um serviço para consultar os dias disponíveis.';
                return;
            }

            const controle = new AbortController();
            requisicaoDatas = controle;
            calendarStatus.textContent = 'Consultando dias disponíveis...';

            const parametros = new URLSearchParams({
                servico_id: servico.value,
                mes: `${mesExibido.getFullYear()}-${String(mesExibido.getMonth() + 1).padStart(2, '0')}`,
            });

            try {
                const resposta = await fetch(`${datesUrl}?${parametros.toString()}`, {
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    signal: controle.signal,
                });
                const resultado = await resposta.json();

                if (requisicaoDatas !== controle) {
                    return;
                }

                if (!resposta.ok) {
                    const erros = Object.values(resultado.errors || {}).flat();
                    calendarStatus.textContent = erros[0] || resultado.message || 'Não foi possível consultar os dias disponíveis.';
                    return;
                }

                datasDisponiveis = Array.isArray(resultado.datas) ? resultado.datas : [];
                const local = resultado.local_atendimento?.trim();
                locationLabel.textContent = local || 'A combinar com o prestador';
                atualizarCalendario();

                calendarStatus.textContent = datasDisponiveis.length
                    ? 'Os dias em vermelho têm horários livres para este serviço.'
                    : 'Não há dias com horários disponíveis neste mês.';
            } catch (erro) {
                if (erro.name === 'AbortError') {
                    return;
                }

                calendarStatus.textContent = 'Não foi possível consultar os dias disponíveis agora. Verifique sua conexão e tente novamente.';
            }
        }

        async function carregarHorarios(restaurarHorario = false) {
            if (requisicaoHorarios) {
                requisicaoHorarios.abort();
            }

            horario.replaceChildren(new Option('Selecione um horário', ''));
            horario.disabled = true;

            if (!servico.value || !data.value) {
                status.textContent = 'Escolha um serviço e um dia disponível para consultar os horários.';
                return;
            }

            const controle = new AbortController();
            requisicaoHorarios = controle;
            status.textContent = 'Consultando horários disponíveis...';

            const parametros = new URLSearchParams({
                servico_id: servico.value,
                data: data.value,
            });

            try {
                const resposta = await fetch(`${slotsUrl}?${parametros.toString()}`, {
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    signal: controle.signal,
                });
                const resultado = await resposta.json();

                if (requisicaoHorarios !== controle) {
                    return;
                }

                if (!resposta.ok) {
                    const erros = Object.values(resultado.errors || {}).flat();
                    status.textContent = erros[0] || resultado.message || 'Não foi possível consultar os horários.';
                    return;
                }

                if (!Array.isArray(resultado.horarios) || resultado.horarios.length === 0) {
                    status.textContent = 'Não há horários disponíveis nesta data para o serviço selecionado.';
                    return;
                }

                if (!Array.isArray(resultado.horarios) || resultado.horarios.length === 0) {
                    status.textContent = 'Não há horários disponíveis nesta data para o serviço selecionado.';
                    return;
                }

                resultado.horarios.forEach(function (hora) {
                    horario.add(new Option(hora, hora));
                });

                horario.disabled = false;

                if (restaurarHorario && horarioAnterior) {
                    horario.value = horarioAnterior;
                }

                status.textContent = 'Selecione um dos horários disponíveis.';
            } catch (erro) {
                if (erro.name === 'AbortError') {
                    return;
                }

                status.textContent = 'Não foi possível consultar os horários agora. Verifique sua conexão e tente novamente.';
            }
        }

        previousMonth.addEventListener('click', function () {
            mesExibido.setMonth(mesExibido.getMonth() - 1);
            carregarDatasDisponiveis();
        });
        nextMonth.addEventListener('click', function () {
            mesExibido.setMonth(mesExibido.getMonth() + 1);
            carregarDatasDisponiveis();
        });
        servico.addEventListener('change', function () {
            atualizarLocal();
            carregarDatasDisponiveis();
            carregarHorarios();
        });
        data.addEventListener('change', function () {
            if (data.value) {
                const dataSelecionada = new Date(`${data.value}T12:00:00`);

                if (
                    dataSelecionada.getMonth() !== mesExibido.getMonth() ||
                    dataSelecionada.getFullYear() !== mesExibido.getFullYear()
                ) {
                    mesExibido = new Date(dataSelecionada.getFullYear(), dataSelecionada.getMonth(), 1);
                    carregarDatasDisponiveis();
                }
            }

            atualizarCalendario();
            carregarHorarios();
        });

        atualizarLocal();
        atualizarCalendario();
        if (servico.value && data.value) {
            carregarHorarios(true);
        }
        if (servico.value) {
            carregarDatasDisponiveis();
        }
    });
</script>
@endpush
