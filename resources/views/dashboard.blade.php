@extends('layouts.app')

@section('title', 'Painel inicial')

@section('content')
<style>
    .dashboard { display: grid; gap: 24px; }
    .dashboard-hero {
        position: relative;
        overflow: hidden;
        padding: clamp(24px, 4vw, 38px);
        border: 1px solid rgba(204, 9, 47, .09);
        border-left: 6px solid #CC092F;
        border-radius: 18px;
        background: linear-gradient(120deg, #fff 0%, #fff7f8 100%);
        box-shadow: 0 12px 28px rgba(45, 28, 35, .05);
    }
    .dashboard-hero::after {
        position: absolute;
        right: -52px;
        bottom: -100px;
        width: 240px;
        height: 240px;
        border: 1px solid rgba(204, 9, 47, .08);
        border-radius: 50%;
        box-shadow: 0 0 0 28px rgba(204, 9, 47, .025), 0 0 0 56px rgba(94, 80, 161, .025);
        content: "";
    }
    .dashboard-hero > * { position: relative; z-index: 1; }
    .dashboard-eyebrow {
        display: inline-block;
        margin-bottom: 10px;
        color: #CC092F;
        font-size: .73rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
    }
    .dashboard-hero h2 { margin: 0 0 8px; color: #292929; font-size: clamp(1.6rem, 3vw, 2.2rem); }
    .dashboard-hero p { max-width: 680px; margin: 0; color: #666; line-height: 1.65; }
    .dashboard-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 190px), 1fr)); gap: 15px; }
    .dashboard-stat {
        display: block;
        padding: 21px;
        border: 1px solid #EAE6E7;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(35, 20, 28, .035);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .dashboard-stat:hover { transform: translateY(-3px); border-color: #F1C7D0; box-shadow: 0 14px 26px rgba(66, 27, 38, .08); }
    .dashboard-stat span { display: block; color: #666; font-size: .86rem; font-weight: 600; }
    .dashboard-stat strong { display: block; margin-top: 9px; color: #CC092F; font-size: 2rem; line-height: 1; }
    .dashboard-stat.roxo strong { color: #5E50A1; }
    .dashboard-stat.amarelo strong { color: #9A6B00; }
    .dashboard-section-heading { display: flex; align-items: end; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
    .dashboard-section-heading h3 { margin: 0; color: #292929; font-size: 1.2rem; }
    .dashboard-section-heading p { margin: 5px 0 0; color: #777; font-size: .9rem; }
    .dashboard-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 14px; }
    .dashboard-action {
        display: flex;
        min-height: 112px;
        flex-direction: column;
        justify-content: space-between;
        gap: 14px;
        padding: 19px;
        border: 1px solid #EAE6E7;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(35, 20, 28, .035);
        transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
    }
    .dashboard-action:hover { transform: translateY(-3px); border-color: #E8B7C1; box-shadow: 0 14px 26px rgba(66, 27, 38, .08); }
    .dashboard-action strong { color: #292929; font-size: 1rem; }
    .dashboard-action span { color: #CC092F; font-size: .85rem; font-weight: 700; }
    .dashboard-table-wrap { overflow-x: auto; border: 1px solid #EAE6E7; border-radius: 14px; background: #fff; box-shadow: 0 8px 20px rgba(35, 20, 28, .035); }
    .dashboard-table { min-width: 650px; }
    .dashboard-status { display: inline-block; padding: 6px 10px; border-radius: 999px; background: #FCECEF; color: #A80726; font-size: .76rem; font-weight: 700; }
    .dashboard-details { color: #CC092F; font-weight: 700; white-space: nowrap; }
    .dashboard-details:hover { color: #A80726; text-decoration: underline; }
    .dashboard-empty { padding: 30px 20px; color: #666; text-align: center; }
    .dashboard-empty strong { display: block; margin-bottom: 6px; color: #292929; }
    @media (max-width: 640px) {
        .dashboard-section-heading { align-items: flex-start; flex-direction: column; }
    }
    @media (prefers-reduced-motion: reduce) {
        .dashboard-stat, .dashboard-action { transition-duration: .01ms; }
    }
</style>

<div class="dashboard">
    <header class="dashboard-hero">
        <span class="dashboard-eyebrow">Fundação Bradesco · O.A.S-FB</span>
        <h2>Olá, {{ $usuario->name }}!</h2>
        <p>Este é seu espaço para acompanhar serviços, anúncios e agendamentos. Escolha uma ação rápida ou consulte suas atividades recentes.</p>
    </header>

    <section class="dashboard-stats" aria-label="Resumo das atividades">
        @if($usuario->tipo_usuario !== 'cliente')
            <a href="{{ route('anuncios.index') }}" class="dashboard-stat">
                <span>Meus anúncios</span>
                <strong>{{ $dados['total_anuncios'] }}</strong>
            </a>
            <a href="{{ route('servicos.index') }}" class="dashboard-stat roxo">
                <span>Meus serviços</span>
                <strong>{{ $dados['total_servicos'] }}</strong>
            </a>
        @endif
        <a href="{{ route('agendamentos.index') }}" class="dashboard-stat">
            <span>Agendamentos</span>
            <strong>{{ $dados['total_agendamentos'] }}</strong>
        </a>
        <a href="{{ route('agendamentos.index') }}" class="dashboard-stat amarelo">
            <span>Agendamentos pendentes</span>
            <strong>{{ $dados['agendamentos_pendentes'] }}</strong>
        </a>
        @if($usuario->tipo_usuario !== 'cliente')
            <a href="{{ route('avaliacoes.index') }}" class="dashboard-stat roxo">
                <span>Avaliações recebidas</span>
                <strong>{{ $dados['avaliacoes_recebidas'] }}</strong>
            </a>
        @endif
    </section>

    <section aria-labelledby="acoes-heading">
        <div class="dashboard-section-heading">
            <div>
                <h3 id="acoes-heading">Acesso rápido</h3>
                <p>Atalhos para as tarefas mais comuns do seu perfil.</p>
            </div>
        </div>

        <div class="dashboard-actions">
            @if($usuario->tipo_usuario === 'cliente')
                <a href="{{ route('servicos.index') }}" class="dashboard-action">
                    <strong>Encontrar um serviço</strong>
                    <span>Explorar serviços →</span>
                </a>
                <a href="{{ route('anuncios.index') }}" class="dashboard-action">
                    <strong>Ver oportunidades</strong>
                    <span>Acessar o mural →</span>
                </a>
                <a href="{{ route('agendamentos.index') }}" class="dashboard-action">
                    <strong>Acompanhar solicitações</strong>
                    <span>Meus agendamentos →</span>
                </a>
            @elseif($usuario->tipo_usuario === 'prestador')
                <a href="{{ route('servicos.create') }}" class="dashboard-action">
                    <strong>Divulgar um serviço</strong>
                    <span>Cadastrar serviço →</span>
                </a>
                <a href="{{ route('anuncios.create') }}" class="dashboard-action">
                    <strong>Publicar uma oportunidade</strong>
                    <span>Criar anúncio →</span>
                </a>
                <a href="{{ route('disponibilidades.index') }}" class="dashboard-action">
                    <strong>Organizar horários</strong>
                    <span>Minhas disponibilidades →</span>
                </a>
            @else
                <a href="{{ route('admin.index') }}" class="dashboard-action">
                    <strong>Gerenciar a plataforma</strong>
                    <span>Abrir administração →</span>
                </a>
                <a href="{{ route('admin.anuncios') }}" class="dashboard-action">
                    <strong>Analisar anúncios</strong>
                    <span>Acessar moderação →</span>
                </a>
                <a href="{{ route('admin.agendamentos') }}" class="dashboard-action">
                    <strong>Consultar agendamentos</strong>
                    <span>Ver todos →</span>
                </a>
            @endif
        </div>
    </section>

    <section aria-labelledby="recentes-heading">
        <div class="dashboard-section-heading">
            <div>
                <h3 id="recentes-heading">Agendamentos recentes</h3>
                <p>Consulte rapidamente o andamento dos atendimentos.</p>
            </div>
            <a href="{{ route('agendamentos.index') }}" class="dashboard-details">Ver todos</a>
        </div>

        <div class="dashboard-table-wrap">
            @if($agendamentosRecentes->isEmpty())
                <div class="dashboard-empty">
                    <strong>Nenhum agendamento por enquanto</strong>
                    <span>Quando houver uma solicitação, ela aparecerá nesta lista.</span>
                </div>
            @else
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Serviço</th>
                            @if($usuario->tipo_usuario === 'cliente')
                                <th>Prestador</th>
                            @elseif($usuario->tipo_usuario === 'prestador')
                                <th>Cliente</th>
                            @else
                                <th>Cliente</th>
                                <th>Prestador</th>
                            @endif
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agendamentosRecentes as $agendamento)
                            <tr>
                                <td>{{ $agendamento->servico->nome ?? 'Serviço indisponível' }}</td>
                                @if($usuario->tipo_usuario === 'cliente')
                                    <td>{{ $agendamento->prestador->name ?? 'Não informado' }}</td>
                                @elseif($usuario->tipo_usuario === 'prestador')
                                    <td>{{ $agendamento->cliente->name ?? 'Não informado' }}</td>
                                @else
                                    <td>{{ $agendamento->cliente->name ?? 'Não informado' }}</td>
                                    <td>{{ $agendamento->prestador->name ?? 'Não informado' }}</td>
                                @endif
                                <td>{{ $agendamento->data ? \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') : '—' }}</td>
                                <td>{{ $agendamento->horario ? substr($agendamento->horario, 0, 5) : '—' }}</td>
                                <td><span class="dashboard-status">{{ ucfirst(str_replace('_', ' ', $agendamento->status)) }}</span></td>
                                <td><a href="{{ route('agendamentos.show', $agendamento) }}" class="dashboard-details">Detalhes</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
</div>
@endsection
