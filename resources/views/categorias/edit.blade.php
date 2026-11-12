@extends('layouts.app')

@section('title', 'Editar categoria')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('categorias.index') }}"
           class="text-decoration-none"
           style="color: #CC092F;">
            ← Voltar para categorias
        </a>

        <h2 class="fw-bold mt-3" style="color: #CC092F;">
            Editar categoria
        </h2>

        <p class="text-muted">
            Atualize as informações desta categoria.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('categorias.update', $categoria) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label fw-semibold">
                        Nome da categoria
                    </label>

                    <input type="text"
                           name="nome"
                           id="nome"
                           class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $categoria->nome) }}"
                           maxlength="100"
                           required>

                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label fw-semibold">
                        Descrição
                    </label>

                    <textarea name="descricao"
                              id="descricao"
                              rows="4"
                              maxlength="1000"
                              class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao', $categoria->descricao) }}</textarea>

                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Situação
                    </label>

                    <select name="ativa"
                            class="form-select @error('ativa') is-invalid @enderror"
                            required>

                        <option value="1"
                            {{ old('ativa', $categoria->ativa ? '1' : '0') == '1' ? 'selected' : '' }}>
                            Ativa
                        </option>

                        <option value="0"
                            {{ old('ativa', $categoria->ativa ? '1' : '0') == '0' ? 'selected' : '' }}>
                            Inativa
                        </option>

                    </select>

                    @error('ativa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit"
                            class="btn text-white"
                            style="background-color: #CC092F;">
                        Salvar alterações
                    </button>

                    <a href="{{ route('categorias.index') }}"
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection