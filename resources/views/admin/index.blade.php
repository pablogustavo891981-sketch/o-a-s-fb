@extends('layouts.app')

@section('title', 'Painel administrativo')

@section('content')

<style>
    .admin-container {
        max-width: 1160px;
        margin: 0 auto;
        padding: 24px 15px 32px;
        color: #333;
    }

    .admin-header {
        margin-bottom: 28px;
        padding: 30px;
        border: 1px solid rgba(204, 9, 47, .08);
        border-left: 6px solid #CC092F;
        border-radius: 18px;
        background: linear-gradient(120deg, #fff 0%, #fff8f9 100%);
        box-shadow: 0 12px 30px rgba(45, 28, 35, .05);
    }

    .admin-header h1 {
        color: #CC092F;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 700;
        margin-bottom: 5px;
    }

    .admin-header p {
        color: #777;
        margin: 0;
    }

    .admin-section-title {
        font-size: 20px;
        font-weight: 700;
        margin: 32px 0 15px;
        color: #292929;
    }

    .admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 15px;
    }

    .admin-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border: 1px solid #EEE8EA;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,.035);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .admin-card:hover {
        transform: translateY(-3px);
        border-color: #F1C7D0;
        box-shadow: 0 14px 28px rgba(80, 31, 45, .09);
    }

    .admin-card small {
        display: block;
        color: #777;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .admin-card strong {
        display: block;
        font-size: 30px;
        color: #CC092F;
    }

    .admin-card a {
        display: inline-block;
        margin-top: 12px;
        color: #CC092F;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: color .2s ease;
    }

    .admin-card a:hover {
        text-decoration: underline;
    }

    .admin-shortcuts {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
    }

    .admin-shortcut {
        display: block;
        padding: 16px;
        background: #FCECEF;
        border: 1px solid #F4D1D9;
        border-radius: 12px;
        color: #A80726;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: transform .2s ease, color .2s ease, background .2s ease, box-shadow .2s ease;
    }

    .admin-shortcut:hover {
        background: #CC092F;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(204, 9, 47, .15);
    }

    .admin-table-container {
        background: #fff;
        border: 1px solid #EAE6E7;
        border-radius: 14px;
        overflow-x: auto;
        box-shadow: 0 8px 20px rgba(0,0,0,.03);
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 550px;
    }

    .admin-table th,
    .admin-table td {
        padding: 13px 15px;
        border-bottom: 1px solid #E5E5E5;
        text-align: left;
        font-size: 14px;
    }

    .admin-table th {
        background: #FBF7F8;
        color: #555;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    .admin-table tbody tr:hover {
        background: #FFFAFB;
    }

    .admin-table a {
        color: #CC092F;
        font-weight: 600;
        text-decoration: none;
    }

    .admin-table a:hover {
        text-decoration: underline;
    }

    .admin-status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        background: #FCECEF;
        color: #A80726;
        font-size: 12px;
        font-weight: 600;
    }

    .admin-empty {
        padding: 22px;
        text-align: center;
        color: #777;
    }

    .admin-header {
    margin-bottom: 24px;
    padding: clamp(22px, 4vw, 34px);
    border: 1px solid #F0DEE2;
    border-radius: 20px;
    background: linear-gradient(120deg, #FFF1F4 0%, #fff 75%);
    box-shadow: 0 10px 28px rgba(48, 25, 31, .045);
    }

    .admin-header h1 {
    color: #292929;
    }

    .admin-section-title {
    margin-top: 28px;
    font-size: 18px;
    }

    .admin-grid {
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 190px), 1fr));
    gap: 14px;
    }

    .admin-card {
    border-color: #EAE3E5;
    border-radius: 16px;
    box-shadow: 0 7px 20px rgba(34, 20, 25, .04);
    }

    .admin-card strong {
    font-size: clamp(25px, 3vw, 30px);
    line-height: 1.2;
    }

    .admin-shortcuts {
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 160px), 1fr));
    }

    .admin-shortcut {
    border-radius: 14px;
    }

    .admin-table-container {
    border-color: #EAE3E5;
    border-radius: 16px;
    box-shadow: 0 7px 20px rgba(34, 20, 25, .035);
    }

    .admin-table th {
    background: #FFF7F8;
    }

    .admin-table tbody tr:last-child td {
    border-bottom: 0;
    }

    .admin-empty {
    padding: 30px 22px;
    }

    @media (max-width: 600px) {
    .admin-header h1 {
        font-size: 23px;
        }

        .admin-container {
            padding: 18px 10px;
        }

        .admin-header {
            padding: 22px;
        }
    }
</style>

<div class="admin-container">

    <div class="admin-header">
        <h1>Painel administrativo</h1>
        <p>Bem-vindo à área de gerenciamento da plataforma de Agendamento e Oferta de Serviços da Fundação Bradesco.</p>
    </div>

    {{-- Estatísticas --}}
    <h2 class="admin-section-title">Visão geral</h2>

    <div class="admin-grid">

        <div class="admin-card">
            <small>Total de usuários</small>
            <strong>{{ $estatisticas['usuarios'] }}</strong>
            <a href="{{ route('admin.usuarios') }}">Gerenciar usuários</a>
        </div>

        <div class="admin-card">
            <small>Clientes</small>
            <strong>{{ $estatisticas['clientes'] }}</strong>
        </div>

        <div class="admin-card">
            <small>Prestadores</small>
            <strong>{{ $estatisticas['prestadores'] }}</strong>
        </div>

        <div class="admin-card">
            <small>Total de anúncios</small>
            <strong>{{ $estatisticas['anuncios'] }}</strong>
            <a href="{{ route('admin.anuncios') }}">Moderar anúncios</a>
        </div>

        <div class="admin-card">
            <small>Anúncios pendentes</small>
            <strong>{{ $estatisticas['anuncios_pendentes'] }}</strong>
            <a href="{{ route('admin.anuncios', ['status' => 'pendente']) }}">Ver pendências</a>
        </div>

        <div class="admin-card">
            <small>Total de serviços</small>
            <strong>{{ $estatisticas['servicos'] }}</strong>
            <a href="{{ route('admin.servicos') }}">Gerenciar serviços</a>
        </div>

        <div class="admin-card">
            <small>Serviços ativos</small>
            <strong>{{ $estatisticas['servicos_ativos'] }}</strong>
        </div>

        <div class="admin-card">
            <small>Total de agendamentos</small>
            <strong>{{ $estatisticas['agendamentos'] }}</strong>
            <a href="{{ route('admin.agendamentos') }}">Ver agendamentos</a>
        </div>

        <div class="admin-card">
            <small>Agendamentos pendentes</small>
            <strong>{{ $estatisticas['agendamentos_pendentes'] }}</strong>
        </div>

        <div class="admin-card">
            <small>Avaliações</small>
            <strong>{{ $estatisticas['avaliacoes'] }}</strong>
            <a href="{{ route('admin.avaliacoes') }}">Consultar avaliações</a>
        </div>

        <div class="admin-card">
            <small>Categorias</small>
            <strong>{{ $estatisticas['categorias'] }}</strong>
            <a href="{{ route('categorias.index') }}">Gerenciar categorias</a>
        </div>

    </div>

    {{-- Atalhos --}}
    <h2 class="admin-section-title">Gerenciamento</h2>

    <div class="admin-shortcuts">
        <a class="admin-shortcut" href="{{ route('admin.usuarios') }}">Usuários</a>
        <a class="admin-shortcut" href="{{ route('admin.anuncios') }}">Anúncios</a>
        <a class="admin-shortcut" href="{{ route('admin.servicos') }}">Serviços</a>
        <a class="admin-shortcut" href="{{ route('admin.agendamentos') }}">Agendamentos</a>
        <a class="admin-shortcut" href="{{ route('admin.avaliacoes') }}">Avaliações</a>
        <a class="admin-shortcut" href="{{ route('categorias.index') }}">Categorias</a>
    </div>

    {{-- Anúncios pendentes --}}
    <h2 class="admin-section-title">Anúncios aguardando análise</h2>

    <div class="admin-table-container">
        @if($anunciosPendentes->isEmpty())
            <div class="admin-empty">
                Não existem anúncios aguardando análise.
            </div>
        @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Anúncio</th>
                        <th>Categoria</th>
                        <th>Responsável</th>
                        <th>Data</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($anunciosPendentes as $anuncio)
                        <tr>
                            <td>{{ $anuncio->titulo }}</td>
                            <td>{{ $anuncio->categoria->nome ?? 'Sem categoria' }}</td>
                            <td>{{ $anuncio->usuario->name ?? 'Usuário não encontrado' }}</td>
                            <td>{{ $anuncio->created_at?->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.anuncios') }}">Analisar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Agendamentos recentes --}}
    <h2 class="admin-section-title">Agendamentos recentes</h2>

    <div class="admin-table-container">
        @if($agendamentosRecentes->isEmpty())
            <div class="admin-empty">
                Ainda não existem agendamentos cadastrados.
            </div>
        @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Cliente</th>
                        <th>Prestador</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($agendamentosRecentes as $agendamento)
                        <tr>
                            <td>{{ $agendamento->servico->nome ?? 'Serviço indisponível' }}</td>
                            <td>{{ $agendamento->cliente->name ?? 'Não informado' }}</td>
                            <td>{{ $agendamento->prestador->name ?? 'Não informado' }}</td>
                            <td>
                                {{ $agendamento->data
                                    ? \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y')
                                    : '—' }}
                            </td>
                            <td>{{ $agendamento->horario ?? '—' }}</td>
                            <td>
                                <span class="admin-status">
                                    {{ ucfirst(str_replace('_', ' ', $agendamento->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.agendamentos') }}">Consultar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

@endsection
