@extends('layouts.app')
@section('title', $anuncio->titulo)

@section('content')
<div class="page-heading">
    <h2>{{ $anuncio->titulo }}</h2>
    <p>Publicado por {{ $anuncio->usuario->name ?? 'Usuário' }}</p>
</div>

<div class="content-card">
    @if($anuncio->imagem)
        <img src="{{ asset('storage/'.$anuncio->imagem) }}" alt="{{ $anuncio->titulo }}" style="width:100%;max-height:400px;object-fit:contain;border-radius:10px;margin-bottom:25px;">
    @endif

    <p style="color:#5E50A1;font-weight:bold;margin-bottom:15px;">
        {{ $anuncio->categoria->nome ?? 'Sem categoria' }}
    </p>

    <h3 style="margin-bottom:12px;">Descrição</h3>
    <p style="line-height:1.8;white-space:pre-line;">{{ $anuncio->descricao }}</p>

    @if($anuncio->informacoes_oferta)
        <h3 style="margin:25px 0 12px;">Informações adicionais</h3>
        <p style="line-height:1.8;white-space:pre-line;">{{ $anuncio->informacoes_oferta }}</p>
    @endif

    <div style="background:#F8F8F8;padding:18px;border-radius:8px;margin-top:25px;">
        <strong>Contato:</strong>
        <p style="margin-top:8px;">{{ $anuncio->contato }}</p>
    </div>

    <div style="margin-top:25px;">
        <a href="{{ route('anuncios.index') }}" class="btn btn-secondary">Voltar ao mural</a>

        @if(auth()->id() === $anuncio->usuario_id || auth()->user()?->tipo_usuario === 'administrador')
            <a href="{{ route('anuncios.edit', $anuncio) }}" class="btn">Editar anúncio</a>

            <form action="{{ route('anuncios.destroy', $anuncio) }}" method="POST" style="display:inline;" onsubmit="return confirm('Deseja excluir este anúncio?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background:#777;">Excluir</button>
            </form>
        @endif
    </div>
</div>
@endsection
