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

    .avaliacoes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 18px;
    }

    .avaliacao-card {
        background: white;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 7px rgba(0,0,0,.04);
    }

    .avaliacao-card h3 {
        margin: 0 0 12px;
        font-size: 17px;
        color: #333;
    }

    .estrelas {
        color: #CC092F;
        font-size: 22px;
        letter-spacing: 2px;
        margin-bottom: 12px;
    }

    .nota {
        color: #777;
        font-size: 13px;
        margin-left: 5px;
    }

    .comentario {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        margin: 15px 0;
        overflow-wrap: anywhere;
    }

    .informacoes {
        border-top: 1px solid #eee;
        padding-top: 12px;
        color: #777;
        font-size: 13px;
        line-height: 1.8;
    }

    .informacoes strong {
        color: #444;
    }

    .data {
        color: #999;
        font-size: 12px;
        margin-top: 12px;
    }

    .vazio {
        padding: 35px;
        text-align: center;
        background: white;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
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
        <h1>Avaliações dos serviços</h1>
        <p>Consulte as notas e os comentários enviados pelos clientes da plataforma.</p>
    </div>

    @if($avaliacoes->isEmpty())

        <div class="vazio">
            <h3>Nenhuma avaliação encontrada.</h3>
            <p>Ainda não existem avaliações cadastradas na plataforma.</p>
        </div>

    @else

        <div class="avaliacoes-grid">

            @foreach($avaliacoes as $avaliacao)

                <div class="avaliacao-card">

                    <h3>
                        {{ $avaliacao->agendamento->servico->nome ?? 'Serviço não informado' }}
                    </h3>

                    <div class="estrelas">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $avaliacao->nota ? '★' : '☆' }}
                        @endfor

                        <span class="nota">
                            {{ $avaliacao->nota }}/5
                        </span>
                    </div>

                    <div class="comentario">
                        @if($avaliacao->comentario)
                            "{{ $avaliacao->comentario }}"
                        @else
                            <em>Esta avaliação não possui comentário.</em>
                        @endif
                    </div>

                    <div class="informacoes">

                        <div>
                            <strong>Cliente:</strong>
                            {{ $avaliacao->cliente->name ?? 'Não informado' }}
                        </div>

                        <div>
                            <strong>Prestador:</strong>
                            {{ $avaliacao->prestador->name ?? 'Não informado' }}
                        </div>

                    </div>

                    <div class="data">
                        Avaliada em:
                        {{ $avaliacao->created_at?->format('d/m/Y H:i') }}
                    </div>

                </div>

            @endforeach

        </div>

    @endif

    <div class="paginacao">
        {{ $avaliacoes->links() }}
    </div>

</div>

@endsection
