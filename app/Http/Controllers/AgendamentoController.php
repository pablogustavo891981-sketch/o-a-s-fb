<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Disponibilidade;
use App\Models\Servico;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AgendamentoController extends Controller
{
    /**
     * Listar agendamentos conforme o perfil.
     */
    public function index()
    {
        $usuario = auth()->user();

        $consulta = Agendamento::with([
            'cliente',
            'prestador',
            'servico',
        ]);

        if ($usuario->tipo_usuario === 'cliente') {
            $consulta->where('cliente_id', $usuario->id);
        } elseif ($usuario->tipo_usuario === 'prestador') {
            $consulta->where('prestador_id', $usuario->id);
        }

        $agendamentos = $consulta
            ->latest('data')
            ->latest('horario')
            ->paginate(15);

        return view('agendamentos.index', compact('agendamentos'));
    }

    /**
     * Exibir formulário de solicitação.
     */
    public function create()
    {
        $servicos = Servico::query()
            ->select(['id', 'nome', 'preco', 'local_atendimento'])
            ->where('ativo', true)
            ->whereHas('usuario', function ($query) {
                $query->where('tipo_usuario', 'prestador');
            })
            ->orderBy('nome')
            ->get();

        return view('agendamentos.create', compact('servicos'));
    }

    private function servicoAgendavel(int $servicoId): Servico
    {
        $servico = Servico::query()
            ->with('usuario:id,tipo_usuario')
            ->where('ativo', true)
            ->find($servicoId);

        if ($servico === null || $servico->usuario?->tipo_usuario !== 'prestador') {
            throw ValidationException::withMessages([
                'servico_id' => 'Selecione um serviço válido para agendamento.',
            ]);
        }

        return $servico;
    }

    public function horariosDisponiveis(Request $request): JsonResponse
    {
        abort_unless(
            auth()->user()?->tipo_usuario === 'cliente',
            403,
            'Somente clientes podem consultar horários disponíveis.'
        );

        $dados = $request->validate([
            'servico_id' => ['required', 'integer'],
            'data' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ], [
            'servico_id' => 'Selecione um serviço válido para agendamento.',
        ]);

        $servico = $this->servicoAgendavel((int) $dados['servico_id']);

        $data = Carbon::createFromFormat('Y-m-d', $dados['data']);
        $disponibilidades = Disponibilidade::query()
            ->where('usuario_id', $servico->usuario_id)
            ->where('dia_semana', $data->dayOfWeek)
            ->where('ativo', true)
            ->orderBy('hora_inicio')
            ->get();

        $reservas = Agendamento::with('servico:id,duracao')
            ->where('prestador_id', $servico->usuario_id)
            ->where('data', '>=', $data->toDateString())
            ->where('data', '<', $data->copy()->addDay()->toDateString())
            ->whereIn('status', ['pendente', 'confirmado', 'em_andamento'])
            ->get();

        return response()->json([
            'horarios' => $this->horariosParaData(
                $servico,
                $data,
                $disponibilidades,
                $reservas
            ),
            'local_atendimento' => $servico->local_atendimento,
        ]);
    }

    public function datasDisponiveis(Request $request): JsonResponse
    {
        abort_unless(
            auth()->user()?->tipo_usuario === 'cliente',
            403,
            'Somente clientes podem consultar datas disponíveis.'
        );

        $dados = $request->validate([
            'servico_id' => ['required', 'integer'],
            'mes' => ['required', 'date_format:Y-m'],
        ], [
            'servico_id' => 'Selecione um serviço válido para agendamento.',
        ]);

        $servico = $this->servicoAgendavel((int) $dados['servico_id']);

        $inicioMes = Carbon::createFromFormat('Y-m-d', $dados['mes'].'-01')->startOfMonth();
        $inicioMesAtual = now()->startOfMonth();
        $limiteMes = now()->addMonths(12)->startOfMonth();

        if ($inicioMes->lt($inicioMesAtual) || $inicioMes->gt($limiteMes)) {
            throw ValidationException::withMessages([
                'mes' => 'Consulte uma data entre este mês e os próximos 12 meses.',
            ]);
        }

        $fimMes = $inicioMes->copy()->endOfMonth();
        $disponibilidades = Disponibilidade::query()
            ->where('usuario_id', $servico->usuario_id)
            ->where('ativo', true)
            ->orderBy('hora_inicio')
            ->get()
            ->groupBy('dia_semana');

        $reservas = Agendamento::with('servico:id,duracao')
            ->where('prestador_id', $servico->usuario_id)
            ->whereBetween('data', [$inicioMes->toDateString(), $fimMes->toDateString()])
            ->whereIn('status', ['pendente', 'confirmado', 'em_andamento'])
            ->get()
            ->groupBy(fn (Agendamento $reserva) => $reserva->data->toDateString());

        $datas = [];

        for ($data = $inicioMes->copy()->max(now()->startOfDay()); $data->lte($fimMes); $data->addDay()) {
            $horariosDoDia = $disponibilidades->get($data->dayOfWeek, collect());

            if ($horariosDoDia->isEmpty()) {
                continue;
            }

            $reservasDoDia = $reservas->get($data->toDateString(), new EloquentCollection);
            $horarios = $this->horariosParaData(
                $servico,
                $data,
                $horariosDoDia,
                $reservasDoDia
            );

            if ($horarios !== []) {
                $datas[] = $data->toDateString();
            }
        }

        return response()->json([
            'datas' => $datas,
            'local_atendimento' => $servico->local_atendimento,
        ]);
    }

    private function horariosParaData(
        Servico $servico,
        Carbon $data,
        EloquentCollection $disponibilidades,
        EloquentCollection $reservas
    ): array {
        $candidatos = [];

        foreach ($disponibilidades as $disponibilidade) {
            $inicioDisponibilidade = Carbon::parse(
                $data->toDateString().' '.$disponibilidade->getRawOriginal('hora_inicio')
            );
            $fimDisponibilidade = Carbon::parse(
                $data->toDateString().' '.$disponibilidade->getRawOriginal('hora_fim')
            );

            for (
                $inicio = $inicioDisponibilidade->copy();
                $inicio->copy()->addMinutes($servico->duracao)->lte($fimDisponibilidade);
                $inicio->addMinutes(30)
            ) {
                if ($inicio->lte(now())) {
                    continue;
                }

                $candidatos[$inicio->format('H:i')] = $inicio->copy();
            }
        }

        ksort($candidatos);

        $intervalosReservados = [];

        foreach ($reservas as $reserva) {
            $inicioReserva = Carbon::parse(
                $reserva->data->toDateString().' '.$reserva->horario
            )->getTimestamp();

            $intervalosReservados[] = [
                'inicio' => $inicioReserva,
                'fim' => $inicioReserva + ($reserva->servico->duracao * 60),
            ];
        }

        usort(
            $intervalosReservados,
            fn (array $a, array $b): int => $a['inicio'] <=> $b['inicio']
        );

        $horarios = [];
        $indiceReserva = 0;

        foreach ($candidatos as $horario => $inicio) {
            $inicioTimestamp = $inicio->getTimestamp();
            $fimTimestamp = $inicioTimestamp + ($servico->duracao * 60);

            while (
                isset($intervalosReservados[$indiceReserva]) &&
                $intervalosReservados[$indiceReserva]['fim'] <= $inicioTimestamp
            ) {
                $indiceReserva++;
            }

            $intervaloAtual = $intervalosReservados[$indiceReserva] ?? null;

            if ($intervaloAtual === null || $intervaloAtual['inicio'] >= $fimTimestamp) {
                $horarios[] = $horario;
            }
        }

        return $horarios;
    }

    /**
     * Criar uma solicitação de agendamento.
     */
    public function store(Request $request)
    {
        abort_unless(
            auth()->user()?->tipo_usuario === 'cliente',
            403,
            'Somente clientes podem solicitar agendamentos.'
        );

        $dados = $request->validate([
            'servico_id' => ['required', 'integer'],
            'data' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'horario' => [
                'required',
                'date_format:H:i',
            ],
            'telefone_cliente' => [
                'required',
                'string',
                'max:20',
            ],
            'observacoes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $agendamento = DB::transaction(function () use ($dados) {
            $servico = $this->servicoAgendavel((int) $dados['servico_id']);

            $prestadorId = $servico->usuario_id;

            $inicio = Carbon::parse(
                $dados['data'].' '.$dados['horario']
            );

            if ($inicio->lte(now())) {
                throw ValidationException::withMessages([
                    'horario' => 'Escolha um horário futuro.',
                ]);
            }

            $fim = $inicio->copy()->addMinutes($servico->duracao);

            // Não permitir serviços que ultrapassem a meia-noite.
            if ($fim->toDateString() !== $inicio->toDateString()) {
                throw ValidationException::withMessages([
                    'horario' => 'O serviço precisa terminar no mesmo dia.',
                ]);
            }

            $diaSemana = $inicio->dayOfWeek;

            /*
             * Bloquear os registros de disponibilidade do prestador
             * durante a verificação, evitando reservas simultâneas
             * dentro do mesmo conjunto de horários.
             */
            $disponibilidades = Disponibilidade::query()
                ->where('usuario_id', $prestadorId)
                ->where('dia_semana', $diaSemana)
                ->where('ativo', true)
                ->lockForUpdate()
                ->get();

            $horarioDisponivel = $disponibilidades->contains(
                function (Disponibilidade $disponibilidade) use ($inicio, $fim): bool {
                    $inicioDisponibilidade = Carbon::parse($disponibilidade->hora_inicio);
                    $fimDisponibilidade = Carbon::parse($disponibilidade->hora_fim);

                    return $inicio->format('H:i:s') >= $inicioDisponibilidade->format('H:i:s')
                        && $fim->format('H:i:s') <= $fimDisponibilidade->format('H:i:s');
                }
            );

            if (! $horarioDisponivel) {
                throw ValidationException::withMessages([
                    'horario' => 'O prestador não atende nesse dia ou horário.',
                ]);
            }

            // Buscar reservas que podem ocupar o intervalo.
            $reservas = Agendamento::with('servico')
                ->where('prestador_id', $prestadorId)
                ->where('data', '>=', $inicio->toDateString())
                ->where('data', '<', $inicio->copy()->startOfDay()->addDay()->toDateString())
                ->whereIn('status', [
                    'pendente',
                    'confirmado',
                    'em_andamento',
                ])
                ->lockForUpdate()
                ->get();

            foreach ($reservas as $reserva) {
                $inicioExistente = Carbon::parse(
                    $reserva->data->format('Y-m-d').
                    ' '.
                    $reserva->horario
                );

                $fimExistente = $inicioExistente->copy()
                    ->addMinutes($reserva->servico->duracao);

                // Verificar sobreposição entre os horários.
                if (
                    $inicio->lt($fimExistente) &&
                    $fim->gt($inicioExistente)
                ) {
                    throw ValidationException::withMessages([
                        'horario' => 'Este horário já está ocupado. Escolha outro.',
                    ]);
                }
            }

            return Agendamento::create([
                'cliente_id' => auth()->id(),
                'prestador_id' => $prestadorId,
                'servico_id' => $servico->id,
                'telefone_cliente' => $dados['telefone_cliente'],
                'data' => $dados['data'],
                'horario' => $dados['horario'],
                'status' => 'pendente',
                'observacoes' => $dados['observacoes'] ?? null,
            ]);
        });

        return redirect()
            ->route('agendamentos.show', $agendamento)
            ->with('success', 'Solicitação enviada ao prestador!');
    }

    /**
     * Exibir detalhes do agendamento.
     */
    public function show(Agendamento $agendamento)
    {
        $this->autorizarVisualizacao($agendamento);

        $agendamento->load([
            'cliente',
            'prestador',
            'servico',
            'avaliacao',
        ]);

        return view('agendamentos.show', compact('agendamento'));
    }

    /**
     * Atualizar o status do agendamento.
     */
    public function update(
        Request $request,
        Agendamento $agendamento
    ) {
        $usuario = auth()->user();

        $this->autorizarVisualizacao($agendamento);

        $dados = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'confirmado',
                    'recusado',
                    'em_andamento',
                    'concluido',
                    'cancelado',
                ]),
            ],
        ]);

        $novoStatus = $dados['status'];
        $statusAtual = $agendamento->status;

        // Administrador pode gerenciar os estados.
        if ($usuario->tipo_usuario === 'administrador') {
            $agendamento->update(['status' => $novoStatus]);
        }

        // Cliente pode cancelar sua própria solicitação.
        elseif ($usuario->tipo_usuario === 'cliente') {

            abort_unless(
                $novoStatus === 'cancelado' &&
                in_array($statusAtual, ['pendente', 'confirmado']),
                403,
                'Você não pode realizar essa alteração.'
            );

            $agendamento->update(['status' => 'cancelado']);
        }

        // Prestador controla a execução do atendimento.
        else {
            abort_unless(
                in_array($statusAtual, ['pendente', 'confirmado', 'em_andamento']),
                403,
                'Este agendamento não pode mais ser alterado.'
            );

            $transicoes = [
                'pendente' => ['confirmado', 'recusado'],
                'confirmado' => ['em_andamento', 'cancelado'],
                'em_andamento' => ['concluido'],
            ];

            abort_unless(
                in_array(
                    $novoStatus,
                    $transicoes[$statusAtual] ?? []
                ),
                403,
                'Essa mudança de status não é permitida.'
            );

            $agendamento->update(['status' => $novoStatus]);
        }

        return redirect()
            ->route('agendamentos.show', $agendamento)
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Excluir agendamento.
     */
    public function destroy(Agendamento $agendamento)
    {
        $usuario = auth()->user();

        abort_unless(
            $usuario->tipo_usuario === 'administrador',
            403,
            'Somente administradores podem excluir agendamentos.'
        );

        $agendamento->delete();

        return redirect()
            ->route('agendamentos.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }

    /**
     * Verificar quem pode visualizar o agendamento.
     */
    private function autorizarVisualizacao(
        Agendamento $agendamento
    ): void {
        $usuario = auth()->user();

        abort_unless(
            $usuario->tipo_usuario === 'administrador' ||
            $agendamento->cliente_id === $usuario->id ||
            $agendamento->prestador_id === $usuario->id,
            403,
            'Você não tem permissão para acessar este agendamento.'
        );
    }
}
