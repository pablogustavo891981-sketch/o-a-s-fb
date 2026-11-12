@extends('layouts.app')
@section('title', 'Editar anúncio')

@section('content')
<div class="page-heading">
    <h2>Editar anúncio</h2>
    <p>Atualize as informações da sua publicação.</p>
</div>

<div class="content-card">
    <form action="{{ route('anuncios.update', $anuncio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="titulo">Título</label>
            <input class="form-control" type="text" id="titulo" name="titulo" value="{{ old('titulo', $anuncio->titulo) }}" required>
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoria</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(old('categoria_id', $anuncio->categoria_id) == $categoria->id)>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="6" required>{{ old('descricao', $anuncio->descricao) }}</textarea>
        </div>

        <div class="form-group">
            <label for="contato">Contato</label>
            <input class="form-control" type="text" id="contato" name="contato" value="{{ old('contato', $anuncio->contato) }}" required>
        </div>

        <div class="form-group">
            <label for="informacoes_oferta">Informações adicionais</label>
            <textarea class="form-control" id="informacoes_oferta" name="informacoes_oferta" rows="3">{{ old('informacoes_oferta', $anuncio->informacoes_oferta) }}</textarea>
        </div>

        @if($anuncio->imagem)
            <div class="form-group">
                <label>Imagem atual</label>
                <img src="{{ asset('storage/'.$anuncio->imagem) }}" alt="Imagem atual" style="display:block;width:220px;max-width:100%;border-radius:8px;margin-bottom:12px;">
            </div>
        @endif

        <div class="form-group">
            <label for="imagem">Substituir imagem (opcional)</label>
            <input class="form-control" type="file" id="imagem" name="imagem" accept="image/jpeg,image/png,image/webp">
        </div>

        <button type="submit" class="btn">Salvar alterações</button>
        <a href="{{ route('anuncios.show', $anuncio) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
