@extends('layouts.app')
@section('title', 'Publicar anúncio')

@section('content')
<div class="page-heading">
    <h2>Publicar anúncio</h2>
    <p>Compartilhe sua oferta com a comunidade.</p>
</div>

<div class="content-card">
    <form action="{{ route('anuncios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="titulo">Título do anúncio</label>
            <input class="form-control" type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" maxlength="150" required>
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoria</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                <option value="">Selecione uma categoria</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="6" required>{{ old('descricao') }}</textarea>
        </div>

        <div class="form-group">
            <label for="contato">Contato</label>
            <input class="form-control" type="text" id="contato" name="contato" value="{{ old('contato') }}" required>
        </div>

        <div class="form-group">
            <label for="informacoes_oferta">Informações adicionais (opcional)</label>
            <textarea class="form-control" id="informacoes_oferta" name="informacoes_oferta" rows="3">{{ old('informacoes_oferta') }}</textarea>
        </div>

        <div class="form-group">
            <label for="imagem">Imagem do anúncio (opcional)</label>
            <input class="form-control" type="file" id="imagem" name="imagem" accept="image/jpeg,image/png,image/webp">
            <small style="color:#777;">Formatos JPG, PNG ou WEBP. Limite de 5 MB.</small>
        </div>

        <button type="submit" class="btn">Enviar anúncio</button>
        <a href="{{ route('anuncios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
