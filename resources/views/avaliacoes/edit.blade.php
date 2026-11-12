@extends('layouts.app')

@section('title', 'Editar avaliação')

@section('content')
<style>
    .editar-avaliacao {
        max-width: 850px;
        margin: 35px auto;
        padding: 0 18px;
        color: #333;
    }

    .editar-avaliacao .cabecalho {
        background: linear-gradient(120deg, #CC092F 0%, #A80726 100%);
        color: white;
        padding: clamp(22px, 4vw, 32px);
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 10px 24px rgba(110, 6, 30, .16);
    }

    .editar-avaliacao .cabecalho h1 {
        margin: 0 0 8px;
        font-size: clamp(24px, 3vw, 30px);
    }

    .editar-avaliacao .cabecalho p { margin: 0; line-height: 1.6; }

    .editar-avaliacao .card {
        background: white;
        border: 1px solid #E8E2E4;
        border-radius: 15px;
        padding: clamp(20px, 4vw, 30px);
        box-shadow: 0 8px 24px rgba(0,0,0,.045);
    }

    .editar-avaliacao .campo {
        margin-bottom: 22px;
    }

    .editar-avaliacao .campo > label,
    .editar-avaliacao .campo > legend {
        display: block;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .editar-avaliacao fieldset.campo {
        min-width: 0;
        padding: 0;
        border: 0;
    }

    .editar-avaliacao textarea {
        width: 100%;
        min-height: 130px;
        padding: 12px;
        border: 1px solid #D7D1D3;
        border-radius: 9px;
        font-size: 15px;
        resize: vertical;
    }

    .editar-avaliacao textarea:focus {
        outline: none;
        border-color: #CC092F;
        box-shadow: 0 0 0 3px rgba(204,9,47,.10);
    }

    .editar-avaliacao .estrelas {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 4px;
        width: fit-content;
    }

    .editar-avaliacao .estrelas input {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        clip-path: inset(50%);
    }

    .editar-avaliacao .estrelas label {
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
    }

    .editar-avaliacao .estrelas label:hover,
    .editar-avaliacao .estrelas label:hover ~ label,
    .editar-avaliacao .estrelas input:checked ~ label {
        color: #E5A000;
    }

    .editar-avaliacao .estrelas input:focus-visible + label {
        outline: 3px solid #5E50A1;
        outline-offset: 2px;
        background: #FFF8E6;
    }

    .editar-avaliacao .estrelas input:checked + label {
        background: #FFF8E6;
        border-color: #F2D58B;
    }

    .editar-avaliacao .informacao {
        background: #FFF7F8;
        border: 1px solid #F1DDE1;
        padding: 16px;
        border-radius: 10px;
        margin-bottom: 22px;
    }

    .editar-avaliacao .informacao small {
        display: block;
        color: #777;
        margin-bottom: 5px;
    }

    .editar-avaliacao .erro {
        color: #CC092F;
        font-size: 13px;
        margin-top: 6px;
    }

    .editar-avaliacao .alerta {
        background: #FCECEF;
        color: #A80726;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 18px;
    }

    .editar-avaliacao .botoes {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 25px;
    }

    .editar-avaliacao .botao {
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

    .editar-avaliacao .botao:hover {
        background: #A80726;
        color: white;
        transform: translateY(-1px);
    }

    .editar-avaliacao .secundario {
        background: #F5F5F5;
        color: #333;
        border: 1px solid #DDD;
    }

    .editar-avaliacao .secundario:hover {
        background: #EAEAEA;
        color: #333;
    }

    @media(max-width: 600px) {
        .editar-avaliacao .card {
            padding: 18px;
        }

        @media (prefers-reduced-motion: reduce) {
            .editar-avaliacao .botao,
            .editar-avaliacao .estrelas label { transition: none; }
        }
    }
</style>

<div class="editar-avaliacao">

    <div class="cabecalho">
        <h1>Editar avaliação</h1>
        <p>Atualize sua nota e seu comentário sobre o serviço.</p>
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

        <div class="informacao">
            <small>Serviço avaliado</small>
            <strong>
                {{ $avaliacao->agendamento->servico->nome ?? 'Não informado' }}
            </strong>
        </div>

        <form
            action="{{ route('avaliacoes.update', $avaliacao->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <fieldset class="campo">
                <legend>Atualize sua nota *</legend>

                <div class="estrelas" role="radiogroup" aria-label="Nota do serviço">
                    @for($nota = 5; $nota >= 1; $nota--)
                        <input
                            type="radio"
                            id="estrela{{ $nota }}"
                            name="nota"
                            value="{{ $nota }}"
                            @checked((int) old('nota', $avaliacao->nota) === $nota)
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
            </fieldset>

            <div class="campo">
                <label for="comentario">Comentário</label>

                <textarea
                    name="comentario"
                    id="comentario"
                    aria-invalid="{{ $errors->has('comentario') ? 'true' : 'false' }}"
                    @if($errors->has('comentario')) aria-describedby="comentario-erro" @endif
                    placeholder="Conte como foi sua experiência..."
                >{{ old('comentario', $avaliacao->comentario) }}</textarea>

                @error('comentario')
                    <div class="erro" id="comentario-erro">{{ $message }}</div>
                @enderror
            </div>

            <div class="botoes">
                <button type="submit" class="botao">
                    Salvar alterações
                </button>

                <a
                    href="{{ route('avaliacoes.show', $avaliacao->id) }}"
                    class="botao secundario"
                >
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
