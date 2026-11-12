@extends('layouts.app')

@section('title', 'Avaliar serviço')

@section('content')
<style>
    .avaliacao-form {
        max-width: 850px;
        margin: 35px auto;
        padding: 0 18px;
        color: #333;
    }

    .avaliacao-form .cabecalho {
        background: linear-gradient(120deg, #CC092F 0%, #A80726 100%);
        color: white;
        padding: clamp(22px, 4vw, 32px);
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 10px 24px rgba(110, 6, 30, .16);
    }

    .avaliacao-form .cabecalho h1 {
        margin: 0 0 8px;
        font-size: clamp(24px, 3vw, 30px);
    }

    .avaliacao-form .cabecalho p { margin: 0; line-height: 1.6; }

    .avaliacao-form .card {
        background: white;
        border: 1px solid #E8E2E4;
        border-radius: 15px;
        padding: clamp(20px, 4vw, 30px);
        box-shadow: 0 8px 24px rgba(0,0,0,.045);
    }

    .avaliacao-form .campo {
        margin-bottom: 22px;
    }

    .avaliacao-form .campo > label,
    .avaliacao-form .campo > legend {
        display: block;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .avaliacao-form fieldset.campo {
        min-width: 0;
        padding: 0;
        border: 0;
    }

    .avaliacao-form select,
    .avaliacao-form textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #D7D1D3;
        border-radius: 9px;
        font-size: 15px;
        background: white;
        color: #333;
    }

    .avaliacao-form textarea {
        min-height: 130px;
        resize: vertical;
    }

    .avaliacao-form select:focus,
    .avaliacao-form textarea:focus {
        outline: none;
        border-color: #CC092F;
        box-shadow: 0 0 0 3px rgba(204,9,47,.10);
    }

    .avaliacao-form .estrelas {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 4px;
        width: fit-content;
    }

    .avaliacao-form .estrelas input {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        clip-path: inset(50%);
    }

    .avaliacao-form .estrelas label {
        display: grid;
        width: 48px;
        height: 48px;
        place-items: center;
        border: 1px solid transparent;
        border-radius: 10px;
        font-size: 32px;
        color: #B7B7B7;
        cursor: pointer;
        margin: 0;
        transition: color .15s ease, background .15s ease, border-color .15s ease;
    }

    .avaliacao-form .estrelas label:hover,
    .avaliacao-form .estrelas label:hover ~ label,
    .avaliacao-form .estrelas input:checked ~ label {
        color: #E5A000;
    }

    .avaliacao-form .estrelas input:focus-visible + label {
        outline: 3px solid #5E50A1;
        outline-offset: 2px;
        background: #FFF8E6;
    }

    .avaliacao-form .estrelas input:checked + label {
        background: #FFF8E6;
        border-color: #F2D58B;
    }

    .avaliacao-form .erro {
        color: #CC092F;
        font-size: 13px;
        margin-top: 6px;
    }

    .avaliacao-form .alerta {
        background: #FCECEF;
        color: #A80726;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 18px;
    }

    .avaliacao-form .ajuda {
        color: #777;
        font-size: 13px;
        margin-top: 7px;
        line-height: 1.5;
    }

    .avaliacao-form .botoes {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 25px;
    }

    .avaliacao-form .botao {
        display: inline-flex;
        min-height: 46px;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        border-radius: 9px;
        padding: 12px 20px;
        background: #CC092F;
        color: white;
        text-decoration: none;
        cursor: pointer;
        font-weight: 600;
        transition: background .2s ease, transform .2s ease;
    }

    .avaliacao-form .botao:hover {
        background: #A80726;
        color: white;
        transform: translateY(-1px);
    }

    .avaliacao-form .secundario {
        background: #F5F5F5;
        color: #333;
        border: 1px solid #DDD;
    }

    .avaliacao-form .secundario:hover {
        background: #EAEAEA;
        color: #333;
    }

    @media(max-width: 600px) {
        .avaliacao-form .card {
            padding: 18px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .avaliacao-form .botao,
        .avaliacao-form .estrelas label { transition: none; }
    }
</style>

<div class="avaliacao-form">

    <div class="cabecalho">
        <h1>Avaliar serviço</h1>
        <p>Compartilhe sua experiência e ajude outras pessoas.</p>
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

        @if($agendamentos->isEmpty())
            <div class="alerta" role="status">
                Você não possui atendimentos concluídos disponíveis para avaliação.
            </div>

            <a href="{{ route('agendamentos.index') }}" class="botao">
                Ver meus agendamentos
            </a>

        @else

            <form action="{{ route('avaliacoes.store') }}" method="POST">
                @csrf

                <div class="campo">
                    <label for="agendamento_id">Atendimento *</label>

                    <select
                        name="agendamento_id"
                        id="agendamento_id"
                        aria-invalid="{{ $errors->has('agendamento_id') ? 'true' : 'false' }}"
                        @if($errors->has('agendamento_id')) aria-describedby="agendamento-erro" @endif
                        required
                    >
                        <option value="">Selecione um atendimento</option>

                        @foreach($agendamentos as $agendamento)
                            <option
                                value="{{ $agendamento->id }}"
                                @selected(old('agendamento_id') == $agendamento->id)
                            >
                                {{ $agendamento->servico->nome ?? 'Serviço' }}
                                — {{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}
                                — {{ substr($agendamento->horario, 0, 5) }}
                            </option>
                        @endforeach
                    </select>

                    @error('agendamento_id')
                        <div class="erro" id="agendamento-erro">{{ $message }}</div>
                    @enderror

                    <div class="ajuda">
                        Somente atendimentos concluídos e ainda não avaliados aparecem aqui.
                    </div>
                </div>

                <fieldset class="campo">
                    <legend>Como você avalia o serviço? *</legend>

                    <div class="estrelas" role="radiogroup" aria-label="Nota do serviço">
                        @for($nota = 5; $nota >= 1; $nota--)
                            <input
                                type="radio"
                                id="estrela{{ $nota }}"
                                name="nota"
                                value="{{ $nota }}"
                                @checked(old('nota') == $nota)
                                aria-label="{{ $nota }} {{ $nota === 1 ? 'estrela' : 'estrelas' }}"
                                aria-invalid="{{ $errors->has('nota') ? 'true' : 'false' }}"
                                @if($errors->has('nota')) aria-describedby="nota-erro" @endif
                                required
                            >

                            <label for="estrela{{ $nota }}" title="{{ $nota }} {{ $nota === 1 ? 'estrela' : 'estrelas' }}">
                                <span aria-hidden="true">★</span>
                            </label>
                        @endfor
                    </div>

                    @error('nota')
                        <div class="erro" id="nota-erro">{{ $message }}</div>
                    @enderror

                    <div class="ajuda">
                        1 estrela: muito ruim. 5 estrelas: excelente.
                    </div>
                </fieldset>

                <div class="campo">
                    <label for="comentario">Comentário</label>

                    <textarea
                        name="comentario"
                        id="comentario"
                        aria-invalid="{{ $errors->has('comentario') ? 'true' : 'false' }}"
                        @if($errors->has('comentario')) aria-describedby="comentario-erro" @endif
                        placeholder="Conte como foi sua experiência com o serviço..."
                    >{{ old('comentario') }}</textarea>

                    @error('comentario')
                        <div class="erro" id="comentario-erro">{{ $message }}</div>
                    @enderror
                </div>

                <div class="botoes">
                    <button type="submit" class="botao">
                        Enviar avaliação
                    </button>

                    <a
                        href="{{ route('avaliacoes.index') }}"
                        class="botao secundario"
                    >
                        Cancelar
                    </a>
                </div>
            </form>

        @endif
    </div>
</div>
@endsection
