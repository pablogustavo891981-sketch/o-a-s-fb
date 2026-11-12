@extends('layouts.app')

@section('content')

<style>
    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 25px 15px;
        color: #333;
    }

    .admin-header {
        margin-bottom: 25px;
    }

    .admin-header h1 {
        color: #CC092F;
        font-size: 27px;
        font-weight: 700;
    }

    .admin-header p {
        color: #777;
    }

    .admin-filtros {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
        padding: 18px;
        background: #fff;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
    }

    .admin-filtros input,
    .admin-filtros select {
        flex: 1;
        min-width: 180px;
        padding: 11px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-primary {
        background: #CC092F;
        color: #fff;
    }

    .btn-primary:hover {
        background: #A80726;
        color: #fff;
    }

    .btn-secondary {
        background: #eee;
        color: #444;
    }

    .admin-table-container {
        overflow-x: auto;
        background: #fff;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
    }

    .admin-table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
    }

    .admin-table th,
    .admin-table td {
        padding: 14px;
        border-bottom: 1px solid #E5E5E5;
        text-align: left;
        font-size: 14px;
    }

    .admin-table th {
        background: #F5F5F5;
        color: #555;
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    .admin-table select {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        max-width: 150px;
    }

    .tipo {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        background: #FCECEF;
        color: #A80726;
        font-size: 12px;
        font-weight: 600;
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

    .admin-vazio {
        padding: 25px;
        text-align: center;
        color: #777;
    }

    .paginacao {
        margin-top: 20px;
    }

    @media (max-width: 600px) {
        .admin-container {
            padding: 18px 10px;
        }

        .admin-header h1 {
            font-size: 23px;
        }
    }
</style>

<div class="admin-container">

    <div class="admin-header">
        <h1>Gerenciamento de usuários</h1>
        <p>Consulte as contas cadastradas e gerencie os tipos de usuário da plataforma.</p>
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

    {{-- Pesquisa e filtros --}}
    <form method="GET" action="{{ route('admin.usuarios') }}" class="admin-filtros">

        <input
            type="text"
            name="busca"
            placeholder="Pesquisar por nome ou e-mail"
            value="{{ request('busca') }}"
        >

        <select name="tipo_usuario">
            <option value="">Todos os tipos</option>
            <option value="cliente" @selected(request('tipo_usuario') === 'cliente')>
                Cliente
            </option>
            <option value="prestador" @selected(request('tipo_usuario') === 'prestador')>
                Prestador
            </option>
            <option value="administrador" @selected(request('tipo_usuario') === 'administrador')>
                Administrador
            </option>
        </select>

        <button type="submit" class="btn btn-primary">
            Pesquisar
        </button>

        <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary">
            Limpar
        </a>

    </form>

    {{-- Tabela de usuários --}}
    <div class="admin-table-container">

        @if($usuarios->isEmpty())

            <div class="admin-vazio">
                Nenhum usuário encontrado.
            </div>

        @else

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Tipo de conta</th>
                        <th>Alterar tipo</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($usuarios as $usuario)

                        <tr>
                            <td>{{ $usuario->name }}</td>

                            <td>{{ $usuario->email }}</td>

                            <td>
                                <span class="tipo">
                                    {{ ucfirst($usuario->tipo_usuario) }}
                                </span>
                            </td>

                            <td>

                                @if($usuario->id === auth()->id())

                                    <span style="color:#777; font-size:13px;">
                                        Conta atual
                                    </span>

                                @elseif($usuario->tipo_usuario === 'administrador')

                                    <span style="color:#777; font-size:13px;">
                                        Não permitido
                                    </span>

                                @else

                                    <form
                                        method="POST"
                                        action="{{ route('admin.usuarios.update', $usuario) }}"
                                        style="display:flex; flex-wrap:wrap; gap:7px; align-items:center;"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <select name="tipo_usuario" required>
                                            <option
                                                value="cliente"
                                                @selected($usuario->tipo_usuario === 'cliente')
                                            >
                                                Cliente
                                            </option>

                                            <option
                                                value="prestador"
                                                @selected($usuario->tipo_usuario === 'prestador')
                                            >
                                                Prestador
                                            </option>
                                        </select>

                                        <button type="submit" class="btn btn-primary">
                                            Salvar
                                        </button>

                                    </form>

                                @endif

                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

    <div class="paginacao">
        {{ $usuarios->links() }}
    </div>

</div>

@endsection
