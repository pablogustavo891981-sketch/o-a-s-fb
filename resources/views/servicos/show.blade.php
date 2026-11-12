@extends('layouts.app')

@section('title', 'Detalhes do Serviço')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('servicos.index') }}"
           class="text-decoration-none"
           style="color:#CC092F;">
            ← Voltar para serviços
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="row g-0">

            @if($servico->imagem)
                <div class="col-md-5">
                    <img src="{{ asset('storage/' . $servico->imagem) }}"
                         alt="Imagem do serviço {{ $servico->nome }}"
                         class="w-100 h-100"
                         style="min-height:300px; max-height:450px; object-fit:cover;">
                </div>
            @endif

            <div class="{{ $servico->imagem ? 'col-md-7' : 'col-12' }}">
                <div class="card-body p-4 p-md-5">

                    <span class="badge rounded-pill mb-3"
                          style="background:#FCECEF;color:#CC092F;">
                        {{ $servico->categoria->nome ?? 'Sem categoria' }}
                    </span>

                    <h2 class="fw-bold mb-3" style="color:#CC092F;">
                        {{ $servico->nome }}
                    </h2>

                    <p class="text-muted" style="white-space:pre-line;">
                        {{ $servico->descricao }}
                    </p>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-sm-6 mb-3">
                            <small class="text-muted">Preço</small>
                            <h4 class="fw-bold mb-0">
                                R$ {{ number_format($servico->preco, 2, ',', '.') }}
                            </h4>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <small class="text-muted">Duração</small>
                            <h4 class="fw-bold mb-0">
                                {{ $servico->duracao }} minutos
                            </h4>
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted">Prestador responsável</small>
                        <h5 class="fw-semibold">
                            {{ $servico->usuario->name ?? 'Prestador não identificado' }}
                        </h5>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted">Local do atendimento</small>
                        <p class="mb-0 fw-semibold" style="white-space:pre-line;">
                            {{ $servico->local_atendimento ?: 'A combinar com o prestador' }}
                        </p>
                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        @if(auth()->id() !== $servico->usuario_id && auth()->user()?->tipo_usuario !== 'administrador')
                            <a href="{{ route('agendamentos.create', ['servico_id' => $servico->id]) }}"
                               class="btn text-white"
                               style="background:#CC092F;">
                                Agendar serviço
                            </a>
                        @endif

                        @if(auth()->user()?->tipo_usuario === 'administrador' || auth()->id() === $servico->usuario_id)
                            <a href="{{ route('servicos.edit', $servico) }}"
                               class="btn btn-outline-danger">
                                Editar serviço
                            </a>

                            <form action="{{ route('servicos.destroy', $servico) }}"
                                  method="POST"
                                  onsubmit="return confirm('Tem certeza que deseja excluir ou desativar este serviço?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-secondary">
                                    Excluir serviço
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('servicos.index') }}"
                           class="btn btn-outline-secondary">
                            Voltar
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
