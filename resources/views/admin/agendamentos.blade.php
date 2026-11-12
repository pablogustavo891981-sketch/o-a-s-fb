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
        padding: 10px 15px;
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
        padding: 14px;
        border-bottom: 1px solid #E5E5E5;
        text-align: left;
        font-size: 13px;
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

    .btn-visualizar {
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
        <h1>Gerenciamento de agendamentos</h1>
        <p>Consulte os agendamentos realizados entre clientes e prestadores de serviços.</p>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('admin.agendamentos') }}" class="filtros">

        <input
            type="date"
            name="data"
            value="{{ request('data') }}"
            aria-label="Filtrar por data"
        >

        <select name="status">
            <option value="">Todos os status</option>

            <option value="pendente" @selected(request('status') === 'pendente')>
                Pendente
            </option>

            <option value="confirmado" @selected(request('status') === 'confirmado')>
                Confirmado
            </option>

            <option value="recusado" @selected(request('status') === 'recusado')>
                Recusado
            </option>

            <option value="em_andamento" @selected(request('status') === 'em_andamento')>
                Em andamento
            </option>

            <option value="concluido" @selected(request('status') === 'concluido')>
                Concluído
            </option>

            <option value="cancelado" @selected(request('status') === 'cancelado')>
                Cancelado
            </option>
        </select>

        <button type="submit" class="btn btn-primary">
            Filtrar
        </button>

        <a href="{{ route('admin.agendamentos') }}" class="btn btn-secondary">
            Limpar filtros
        </a>

    </form>

    {{-- Tabela --}}
    <div class="tabela-container">

        @if($agendamentos->isEmpty())

            <div class="vazio">
                Nenhum agendamento encontrado.
            </div>

        @else

            <table class="tabela">

                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Cliente</th>
                        <th>Prestador</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Status</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($agendamentos as $agendamento)

                        <tr>

                            <td>
                                {{ $agendamento->servico->nome ?? 'Serviço indisponível' }}
                            </td>

                            <td>
                                {{ $agendamento->cliente->name ?? 'Não informado' }}
                            </td>

                            <td>
                                {{ $agendamento->prestador->name ?? 'Não informado' }}
                            </td>

                            <td>
                                {{ $agendamento->data
                                    ? \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y')
                                    : '—' }}
                            </td>

                            <td>
                                {{ $agendamento->horario ?? '—' }}
                            </td>

                            <td>
                                <span class="status">
                                    {{ ucfirst(str_replace('_', ' ', $agendamento->status)) }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('agendamentos.show', $agendamento) }}"
                                    class="btn btn-visualizar"
                                >
                                    Visualizar
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

    <div class="paginacao">
        {{ $agendamentos->links() }}
    </div>

</div>

@endsection
