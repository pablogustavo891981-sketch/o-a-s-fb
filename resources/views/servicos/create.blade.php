@extends('layouts.app')

@section('title', 'Cadastrar Serviço')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('servicos.index') }}"
           class="text-decoration-none"
           style="color:#CC092F;">
            ← Voltar para serviços
        </a>

        <h2 class="fw-bold mt-3" style="color:#CC092F;">
            Cadastrar serviço
        </h2>

        <p class="text-muted">
            Divulgue seu serviço para que outras pessoas possam encontrá-lo e agendar um atendimento.
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

            <form action="{{ route('servicos.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label fw-semibold">
                        Nome do serviço
                    </label>

                    <input type="text"
                           name="nome"
                           id="nome"
                           class="form-control"
                           value="{{ old('nome') }}"
                           placeholder="Ex.: Manutenção de computadores"
                           maxlength="255"
                           required>
                </div>

                <div class="mb-3">
                    <label for="categoria_id" class="form-label fw-semibold">
                        Categoria
                    </label>

                    <select name="categoria_id"
                            id="categoria_id"
                            class="form-select"
                            required>
                        <option value="">Selecione uma categoria</option>

                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                @selected(old('categoria_id') == $categoria->id)>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>

                    @if($categorias->isEmpty())
                        <small class="text-danger">
                            Não existem categorias ativas. Cadastre uma categoria antes de continuar.
                        </small>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label fw-semibold">
                        Descrição do serviço
                    </label>

                    <textarea name="descricao"
                              id="descricao"
                              class="form-control"
                              rows="5"
                              maxlength="3000"
                              placeholder="Descreva o serviço oferecido..."
                              required>{{ old('descricao') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="local_atendimento" class="form-label fw-semibold">
                        Local do atendimento
                    </label>

                    <textarea name="local_atendimento"
                              id="local_atendimento"
                              class="form-control"
                              rows="2"
                              maxlength="500"
                              placeholder="Informe o endereço, ponto de referência ou se o atendimento é online">{{ old('local_atendimento') }}</textarea>

                    <small class="text-muted">
                        Esse local ficará visível para quem consultar o serviço e o calendário.
                    </small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="preco" class="form-label fw-semibold">
                            Preço (R$)
                        </label>

                        <input type="number"
                               name="preco"
                               id="preco"
                               class="form-control"
                               value="{{ old('preco') }}"
                               min="0"
                               max="99999999.99"
                               step="0.01"
                               placeholder="0,00"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="duracao" class="form-label fw-semibold">
                            Duração (minutos)
                        </label>

                        <input type="number"
                               name="duracao"
                               id="duracao"
                               class="form-control"
                               value="{{ old('duracao') }}"
                               min="1"
                               max="1440"
                               placeholder="Ex.: 60"
                               required>

                        <small class="text-muted">
                            Informe a duração em minutos.
                        </small>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="imagem" class="form-label fw-semibold">
                        Imagem do serviço (opcional)
                    </label>

                    <input type="file"
                           name="imagem"
                           id="imagem"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-muted">
                        Formatos permitidos: JPG, JPEG, PNG e WEBP. Tamanho máximo: 5 MB.
                    </small>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit"
                            class="btn text-white"
                            style="background:#CC092F;">
                        Cadastrar serviço
                    </button>

                    <a href="{{ route('servicos.index') }}"
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
