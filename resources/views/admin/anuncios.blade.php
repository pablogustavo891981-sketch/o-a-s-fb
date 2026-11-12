@extends('layouts.app')

@section('content')

<style>
    .admin-container {
        max-width: 1200px;
        margin: auto;
        padding: 25px 15px;
        color: #333;
    }

    .admin-header h1 {
        color: #CC092F;
        font-size: 27px;
        font-weight: 700;
    }

    .admin-header p {
        color: #777;
        margin-bottom: 25px;
    }

    .filtros {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px;
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
    }

    .filtros input,
    .filtros select {
        flex: 1;
        min-width: 180px;
        padding: 11px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .btn {
        display: inline-block;
        padding: 9px 13px;
        border: 0;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-primary {
        background: #CC092F;
        color: white;
    }

    .btn-primary:hover {
        background: #A80726;
        color: white;
    }

    .btn-secondary {
        background: #eee;
        color: #444;
    }

    .btn-success {
        background: #e8f5e9;
        color: #256029;
    }

    .btn-danger {
        background: #FCECEF;
        color: #A80726;
    }

    .tabela-container {
        overflow-x: auto;
        background: white;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
    }

    .tabela {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .tabela th,
    .tabela td {
        padding: 13px;
        border-bottom: 1px solid #E5E5E5;
        text-align: left;
        font-size: 13px;
        vertical-align: middle;
    }

    .tabela th {
        background: #F5F5F5;
        color: #555;
    }

    .tabela tr:last-child td {
        border-bottom: none;
    }

    .status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        background: #FCECEF;
        color: #A80726;
        font-size: 12px;
        font-weight: 600;
    }

    .acoes {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .acoes form {
        margin: 0;
    }

    .mensagem {
        padding: 13px 16px;
        border-radius: 7px;
        margin-bottom: 18px;
    }

    .sucesso {
        background: #e8f5e9;
        color: #256029;
    }

    .erro {
        background: #FCECEF;
        color: #A80726;
    }

    .vazio {
        padding: 25px;
        text-align: center;
        color: #777;
    }

    .paginacao {
        margin-top: 20px;
    }
</style>

<div class="admin-container">

    <div class="admin-header">
        <h1>Moderação de anúncios</h1>
        <p>Consulte, aprove, rejeite e desative anúncios publicados na plataforma.</p>
    </div>

    @if(session('success'))
        <div class="mensagem sucesso">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mensagem erro">
            @foreach($errors->all() as $erro)
                <div>{{ $erro }}</div>
            @endforeach
        </div>
    @endif

    {{-- Filtros --}}
    <form method="GET" action="{{ route('admin.anuncios') }}" class="filtros">

        <input
            type="text"
            name="busca"
            placeholder="Pesquisar anúncio"
            value="{{ request('busca') }}"
        >

        <select name="status">
            <option value="">Todos os status</option>
            <option value="pendente" @selected(request('status') === 'pendente')>Pendente</option>
            <option value="ativo" @selected(request('status') === 'ativo')>Ativo</option>
            <option value="inativo" @selected(request('status') === 'inativo')>Inativo</option>
            <option value="rejeitado" @selected(request('status') === 'rejeitado')>Rejeitado</option>
        </select>

        <button type="submit" class="btn btn-primary">Pesquisar</button>

        <a href="{{ route('admin.anuncios') }}" class="btn btn-secondary">Limpar</a>

    </form>

    {{-- Lista de anúncios --}}
    <div class="tabela-container">

        @if($anuncios->isEmpty())

            <div class="vazio">
                Nenhum anúncio encontrado.
            </div>

        @else

            <table class="tabela">

                <thead>
                    <tr>
                        <th>Anúncio</th>
                        <th>Categoria</th>
                        <th>Responsável</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($anuncios as $anuncio)

                        <tr>

                            <td>
                                <strong>{{ $anuncio->titulo }}</strong>
                                <br>
                                <small>
                                    {{ \Illuminate\Support\Str::limit($anuncio->descricao, 65) }}
                                </small>
                            </td>

                            <td>
                                {{ $anuncio->categoria->nome ?? 'Sem categoria' }}
                            </td>

                            <td>
                                {{ $anuncio->usuario->name ?? 'Não informado' }}
                            </td>

                            <td>
                                {{ $anuncio->created_at?->format('d/m/Y') }}
                            </td>

                            <td>
                                <span class="status">
                                    {{ ucfirst($anuncio->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="acoes">

                                    <a
                                        href="{{ route('anuncios.show', $anuncio) }}"
                                        class="btn btn-secondary"
                                    >
                                        Visualizar
                                    </a>

                                    @if($anuncio->status !== 'ativo')
                                        <form
                                            method="POST"
                                            action="{{ route('admin.anuncios.status', $anuncio) }}"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="ativo">

                                            <button type="submit" class="btn btn-success">
                                                Aprovar
                                            </button>
                                        </form>
                                    @endif

                                    @if($anuncio->status !== 'pendente')
                                        <form
                                            method="POST"
                                            action="{{ route('admin.anuncios.status', $anuncio) }}"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="pendente">

                                            <button type="submit" class="btn btn-secondary">
                                                Reavaliar
                                            </button>
                                        </form>
                                    @endif

                                    @if($anuncio->status !== 'rejeitado')
                                        <form
                                            method="POST"
                                            action="{{ route('admin.anuncios.status', $anuncio) }}"
                                            onsubmit="return confirm('Tem certeza que deseja rejeitar este anúncio?')"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejeitado">

                                            <button type="submit" class="btn btn-danger">
                                                Rejeitar
                                            </button>
                                        </form>
                                    @endif

                                    @if($anuncio->status === 'ativo')
                                        <form
                                            method="POST"
                                            action="{{ route('admin.anuncios.status', $anuncio) }}"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="inativo">

                                            <button type="submit" class="btn btn-secondary">
                                                Desativar
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

    <div class="paginacao">
        {{ $anuncios->links() }}
    </div>

</div>

@endsection
