@extends('layouts.app')

@section('title', 'Cadastrar Disponibilidade')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('disponibilidades.index') }}"
           class="text-decoration-none"
           style="color:#CC092F;">
            ← Voltar para disponibilidades
        </a>

        <h2 class="fw-bold mt-3" style="color:#CC092F;">
            Cadastrar disponibilidade
        </h2>

        <p class="text-muted">
            Informe os dias e horários em que você poderá atender clientes.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Verifique os campos:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('disponibilidades.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="dia_semana" class="form-label fw-semibold">
                        Dia da semana
                    </label>

                    <select name="dia_semana"
                            id="dia_semana"
                            class="form-select"
                            required>
                        <option value="">Selecione um dia</option>

                        <option value="0" @selected(old('dia_semana') === '0')>Domingo</option>
                        <option value="1" @selected(old('dia_semana') === '1')>Segunda-feira</option>
                        <option value="2" @selected(old('dia_semana') === '2')>Terça-feira</option>
                        <option value="3" @selected(old('dia_semana') === '3')>Quarta-feira</option>
                        <option value="4" @selected(old('dia_semana') === '4')>Quinta-feira</option>
                        <option value="5" @selected(old('dia_semana') === '5')>Sexta-feira</option>
                        <option value="6" @selected(old('dia_semana') === '6')>Sábado</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="hora_inicio" class="form-label fw-semibold">
                            Horário de início
                        </label>

                        <input type="time"
                               name="hora_inicio"
                               id="hora_inicio"
                               class="form-control"
                               value="{{ old('hora_inicio') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="hora_fim" class="form-label fw-semibold">
                            Horário de término
                        </label>

                        <input type="time"
                               name="hora_fim"
                               id="hora_fim"
                               class="form-control"
                               value="{{ old('hora_fim') }}"
                               required>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox"
                           name="ativo"
                           id="ativo"
                           value="1"
                           class="form-check-input"
                           @checked(old('ativo', '1') == '1')>

                    <label for="ativo" class="form-check-label">
                        Disponibilidade ativa
                    </label>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit"
                            class="btn text-white"
                            style="background:#CC092F;">
                        Salvar horário
                    </button>

                    <a href="{{ route('disponibilidades.index') }}"
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
