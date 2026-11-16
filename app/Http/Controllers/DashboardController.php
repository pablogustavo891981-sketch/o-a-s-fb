<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Anuncio;
use App\Models\Avaliacao;
use App\Models\Servico;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        $dados = [
            'total_anuncios' => 0,
            'total_servicos' => 0,
            'total_agendamentos' => 0,
            'agendamentos_pendentes' => 0,
            'avaliacoes_recebidas' => 0,
        ];

        $agendamentosRecentes = collect();

        /*
        |--------------------------------------------------------------------------
        | Painel do cliente
        |--------------------------------------------------------------------------
        */

        if ($usuario->tipo_usuario === 'cliente') {
            $metricasAgendamentos = Agendamento::query()
                ->where('cliente_id', $usuario->id)
                ->selectRaw('COUNT(*) AS total')
                ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) AS pendentes', ['pendente'])
                ->first();

            $dados['total_agendamentos'] = (int) $metricasAgendamentos->total;
            $dados['agendamentos_pendentes'] = (int) $metricasAgendamentos->pendentes;

            $agendamentosRecentes = Agendamento::with([
                'prestador',
                'servico',
            ])
                ->where('cliente_id', $usuario->id)
                ->latest('data')
                ->limit(5)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Painel do prestador
        |--------------------------------------------------------------------------
        */

        elseif ($usuario->tipo_usuario === 'prestador') {
            $dados['total_anuncios'] = Anuncio::where('usuario_id', $usuario->id)->count();
            $dados['total_servicos'] = Servico::where('usuario_id', $usuario->id)->count();

            $metricasAgendamentos = Agendamento::query()
                ->where('prestador_id', $usuario->id)
                ->selectRaw('COUNT(*) AS total')
                ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) AS pendentes', ['pendente'])
                ->first();

            $dados['total_agendamentos'] = (int) $metricasAgendamentos->total;
            $dados['agendamentos_pendentes'] = (int) $metricasAgendamentos->pendentes;
            $dados['avaliacoes_recebidas'] = Avaliacao::where('prestador_id', $usuario->id)->count();

            $agendamentosRecentes = Agendamento::with([
                'cliente',
                'servico',
            ])
                ->where('prestador_id', $usuario->id)
                ->latest('data')
                ->limit(5)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Painel administrativo
        |--------------------------------------------------------------------------
        */

        elseif ($usuario->tipo_usuario === 'administrador') {
            $dados['total_anuncios'] = Anuncio::count();
            $dados['total_servicos'] = Servico::count();

            $metricasAgendamentos = Agendamento::query()
                ->selectRaw('COUNT(*) AS total')
                ->selectRaw('COUNT(CASE WHEN status = ? THEN 1 END) AS pendentes', ['pendente'])
                ->first();

            $dados['total_agendamentos'] = (int) $metricasAgendamentos->total;
            $dados['agendamentos_pendentes'] = (int) $metricasAgendamentos->pendentes;
            $dados['avaliacoes_recebidas'] = Avaliacao::count();

            $agendamentosRecentes = Agendamento::with([
                'cliente',
                'prestador',
                'servico',
            ])
                ->latest('data')
                ->limit(5)
                ->get();
        }

        return view('dashboard', compact(
            'usuario',
            'dados',
            'agendamentosRecentes'
        ));
    }
}
