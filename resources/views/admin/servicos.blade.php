@extends('layouts.app')

@section('title', 'Gerenciamento de serviços')

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
        border: none;
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
        gap: 7px;
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

    .admin-container {
        max-width: 1160px;
        padding: 24px 15px 32px;
    }

    .admin-header {
        margin-bottom: 22px;
        padding: clamp(22px, 4vw, 34px);
        border: 1px solid #F0DEE2;
        border-radius: 20px;
        background: linear-gradient(120deg, #FFF1F4 0%, #fff 75%);
        box-shadow: 0 10px 28px rgba(48, 25, 31, .045);
    }

    .admin-header h1 {
        margin: 0 0 5px;
        color: #292929;
        font-size: clamp(23px, 3vw, 30px);
    }

    .admin-header p {
        margin: 0;
        line-height: 1.6;
    }

    .filtros {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) minmax(180px, .7fr) auto auto;
        align-items: end;
        margin-bottom: 16px;
        border-color: #EAE3E5;
        border-radius: 15px;
        box-shadow: 0 7px 20px rgba(34, 20, 25, .035);
    }

    .filtros input,
    .filtros select {
        min-height: 44px;
        padding: 10px 12px;
        border-color: #E2DADD;
        border-radius: 9px;
    }

    .filtros input:focus,
    .filtros select:focus {
        border-color: #CC092F;
        outline: 0;
        box-shadow: 0 0 0 3px rgba(204, 9, 47, .1);
    }

    .btn {
        min-height: 40px;
        padding: 9px 13px;
        border-radius: 9px;
        transition: background .18s ease, border-color .18s ease, color .18s ease, transform .18s ease;
    }

    .btn-primary:hover,
    .btn-success:hover,
    .btn-danger:hover,
    .btn-secondary:hover {
        transform: translateY(-1px);
    }

    .tabela-container {
        border-color: #EAE3E5;
        border-radius: 15px;
        box-shadow: 0 7px 20px rgba(34, 20, 25, .035);
    }

    .tabela {
        min-width: 900px;
    }

    .tabela th {
        background: #FFF7F8;
        white-space: nowrap;
    }

    .tabela tbody tr:hover {
        background: #FFFAFB;
    }

    .tabela td strong {
        color: #292929;
    }

    .tabela td small {
        display: inline-block;
        max-width: 300px;
        margin-top: 4px;
        color: #777;
        line-height: 1.45;
    }

    .status-ativo {
        background: #E8F6ED;
        color: #176B35;
    }

    .status-inativo {
        background: #F0F0F0;
        color: #555;
    }

    .acoes {
        gap: 7px;
    }

    .acoes form {
        margin: 0;
    }

    .mensagem {
        border: 1px solid #CBE8D1;
        border-radius: 10px;
    }

    .erro {
        border-color: #F1C7D0;
    }

    .admin-result-heading {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
        margin: 0 2px 12px;
    }

    .admin-result-heading h2 {
        margin: 0;
        color: #292929;
        font-size: 16px;
    }

    .admin-result-heading span {
        color: #777;
        font-size: 12px;
    }

    .vazio {
        padding: 34px 22px;
    }

    @media (max-width: 600px) {
        .admin-container {
            padding: 16px 10px 24px;
        }

        .filtros {
            grid-template-columns: 1fr;
        }

        .filtros .btn {
            width: 100%;
            text-align: center;
        }

        .admin-result-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 4px;
        }
    }

</style>

<div class="admin-container">

    <div class="admin-header">
        <h1>Gerenciamento de serviços</h1>
        <p>Consulte os serviços cadastrados e controle sua disponibilidade na plataforma.</p>
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
    <form method="GET" action="{{ route('admin.servicos') }}" class="filtros">

        <input
            type="text"
            name="busca"
            aria-label="Pesquisar serviços"
            placeholder="Pesquisar por nome ou descrição"
            value="{{ request('busca') }}"
        >

        <select name="ativo" aria-label="Filtrar por disponibilidade">
            <option value="">Todos os serviços</option>
            <option value="1" @selected(request('ativo') === '1')>
                Ativos
            </option>
            <option value="0" @selected(request('ativo') === '0')>
                Inativos
            </option>
        </select>

        <button type="submit" class="btn btn-primary">
            Pesquisar
        </button>

        <a href="{{ route('admin.servicos') }}" class="btn btn-secondary">
            Limpar
        </a>

    </form>

    <div class="admin-result-heading">
        <h2>Serviços cadastrados</h2>
        <span>{{ $servicos->total() }} {{ $servicos->total() === 1 ? 'serviço' : 'serviços' }}</span>
    </div>

    {{-- Tabela de serviços --}}
    <div class="tabela-container">

        @if($servicos->isEmpty())

            <div class="vazio">
                Nenhum serviço encontrado.
            </div>

        @else

            <table class="tabela">

                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Categoria</th>
                        <th>Prestador</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($servicos as $servico)

                        <tr>

                            <td>
                                <strong>{{ $servico->nome }}</strong>
                                <br>
                                <small>
                                    {{ \Illuminate\Support\Str::limit($servico->descricao, 60) }}
                                </small>
                            </td>

                            <td>
                                {{ $servico->categoria->nome ?? 'Sem categoria' }}
                            </td>

                            <td>
                                {{ $servico->usuario->name ?? 'Não informado' }}
                            </td>

                            <td>
                                R$ {{ number_format((float) $servico->preco, 2, ',', '.') }}
                            </td>

                            <td>
                                <span class="status {{ $servico->ativo ? 'status-ativo' : 'status-inativo' }}">
                                    {{ $servico->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>

                            <td>
                                <div class="acoes">

                                    <a
                                        href="{{ route('servicos.show', $servico) }}"
                                        class="btn btn-secondary"
                                    >
                                        Visualizar
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.servicos.status', $servico) }}"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <input
                                            type="hidden"
                                            name="ativo"
                                            value="{{ $servico->ativo ? 0 : 1 }}"
                                        >

                                        <button
                                            type="submit"
                                            class="btn {{ $servico->ativo ? 'btn-danger' : 'btn-success' }}"
                                        >
                                            {{ $servico->ativo ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

    <div class="paginacao">
        {{ $servicos->links() }}
    </div>

</div>

@endsection
