<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Anuncio;
use App\Models\Avaliacao;
use App\Models\Categoria;
use App\Models\Servico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Garantir que somente administradores acessem o controller.
     */
    private function verificarAdministrador(): void
    {
        abort_unless(
            auth()->check() &&
            auth()->user()?->tipo_usuario === 'administrador',
            403,
            'Acesso permitido somente para administradores.'
        );
    }

    /**
     * Painel principal.
     */
    public function index()
    {
        $this->verificarAdministrador();

        $estatisticasUsuarios = User::query()
            ->selectRaw('COUNT(*) AS total')
            ->selectRaw('COUNT(CASE WHEN tipo_usuario = ? THEN 1 END) AS clientes', ['cliente'])
            ->selectRaw('COUNT(CASE WHEN tipo_usuario = ? THEN 1 END) AS prestadores', ['prestador'])
            ->first();

        $estatisticasAnuncios = Anuncio::query()
            ->selectRaw('COUNT(*) AS total')
            ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) AS pendentes', ['pendente'])
            ->first();

        $estatisticasServicos = Servico::query()
            ->selectRaw('COUNT(*) AS total')
            ->selectRaw('COUNT(CASE WHEN ativo = 1 THEN 1 END) AS ativos')
            ->first();

        $estatisticasAgendamentos = Agendamento::query()
            ->selectRaw('COUNT(*) AS total')
            ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) AS pendentes', ['pendente'])
            ->first();

        $estatisticas = [
            'usuarios' => (int) $estatisticasUsuarios->total,
            'clientes' => (int) $estatisticasUsuarios->clientes,
            'prestadores' => (int) $estatisticasUsuarios->prestadores,
            'anuncios' => (int) $estatisticasAnuncios->total,
            'anuncios_pendentes' => (int) $estatisticasAnuncios->pendentes,
            'servicos' => (int) $estatisticasServicos->total,
            'servicos_ativos' => (int) $estatisticasServicos->ativos,
            'agendamentos' => (int) $estatisticasAgendamentos->total,
            'agendamentos_pendentes' => (int) $estatisticasAgendamentos->pendentes,
            'avaliacoes' => Avaliacao::count(),
            'categorias' => Categoria::count(),
        ];

        $anunciosPendentes = Anuncio::with(['usuario', 'categoria'])
            ->where('status', 'pendente')
            ->latest()
            ->limit(5)
            ->get();

        $agendamentosRecentes = Agendamento::with([
            'cliente',
            'prestador',
            'servico',
        ])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.index', compact(
            'estatisticas',
            'anunciosPendentes',
            'agendamentosRecentes'
        ));
    }

    /**
     * Listar usuários.
     */
    public function usuarios(Request $request)
    {
        $this->verificarAdministrador();

        $consulta = User::query();

        if ($request->filled('busca')) {
            $busca = $request->busca;

            $consulta->where(function ($query) use ($busca) {
                $query->where('name', 'like', "%{$busca}%")
                    ->orWhere('email', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('tipo_usuario')) {
            $consulta->where('tipo_usuario', $request->tipo_usuario);
        }

        $usuarios = $consulta->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.usuarios', compact('usuarios'));
    }

    /**
     * Alterar o tipo de uma conta.
     */
    public function atualizarUsuario(Request $request, User $usuario)
    {
        $this->verificarAdministrador();

        abort_if(
            $usuario->id === auth()->id(),
            403,
            'Você não pode alterar seu próprio perfil administrativo.'
        );

        $dados = $request->validate([
            'tipo_usuario' => [
                'required',
                Rule::in(['cliente', 'prestador']),
            ],
        ]);

        $usuario->update($dados);

        return back()->with('success', 'Tipo de usuário atualizado com sucesso!');
    }

    /**
     * Listar anúncios para moderação.
     */
    public function anuncios(Request $request)
    {
        $this->verificarAdministrador();

        $consulta = Anuncio::with(['usuario', 'categoria']);

        if ($request->filled('status')) {
            $consulta->where('status', $request->status);
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;

            $consulta->where(function ($query) use ($busca) {
                $query->where('titulo', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
            });
        }

        $anuncios = $consulta->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.anuncios', compact('anuncios'));
    }

    /**
     * Aprovar, rejeitar, desativar ou reavaliar um anúncio.
     */
    public function atualizarStatusAnuncio(
        Request $request,
        Anuncio $anuncio
    ) {
        $this->verificarAdministrador();

        $dados = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'ativo',
                    'inativo',
                    'pendente',
                    'rejeitado',
                ]),
            ],
        ]);

        $anuncio->update([
            'status' => $dados['status'],
        ]);

        $mensagens = [
            'ativo' => 'Anúncio aprovado e publicado com sucesso!',
            'inativo' => 'Anúncio desativado com sucesso!',
            'pendente' => 'Anúncio devolvido para análise!',
            'rejeitado' => 'Anúncio rejeitado com sucesso!',
        ];

        return back()->with('success', $mensagens[$dados['status']]);
    }

    /**
     * Listar serviços.
     */
    public function servicos(Request $request)
    {
        $this->verificarAdministrador();

        $consulta = Servico::with(['usuario', 'categoria']);

        if ($request->filled('busca')) {
            $busca = $request->busca;

            $consulta->where(function ($query) use ($busca) {
                $query->where('nome', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('ativo')) {
            $consulta->where('ativo', $request->ativo === '1');
        }

        $servicos = $consulta->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.servicos', compact('servicos'));
    }

    /**
     * Ativar ou desativar um serviço.
     */
    public function atualizarStatusServico(
        Request $request,
        Servico $servico
    ) {
        $this->verificarAdministrador();

        $dados = $request->validate([
            'ativo' => ['required', 'boolean'],
        ]);

        $servico->update([
            'ativo' => $dados['ativo'],
        ]);

        return back()->with('success', 'Status do serviço atualizado com sucesso!');
    }

    /**
     * Consultar todos os agendamentos.
     */
    public function agendamentos(Request $request)
    {
        $this->verificarAdministrador();

        $consulta = Agendamento::with([
            'cliente',
            'prestador',
            'servico',
        ]);

        if ($request->filled('status')) {
            $consulta->where('status', $request->status);
        }

        if ($request->filled('data')) {
            $consulta->whereDate('data', $request->data);
        }

        $agendamentos = $consulta
            ->latest('data')
            ->latest('horario')
            ->paginate(20)
            ->withQueryString();

        return view('admin.agendamentos', compact('agendamentos'));
    }

    /**
     * Consultar avaliações.
     */
    public function avaliacoes()
    {
        $this->verificarAdministrador();

        $avaliacoes = Avaliacao::with([
            'cliente',
            'prestador',
            'agendamento.servico',
        ])
            ->latest()
            ->paginate(20);

        return view('admin.avaliacoes', compact('avaliacoes'));
    }
}
