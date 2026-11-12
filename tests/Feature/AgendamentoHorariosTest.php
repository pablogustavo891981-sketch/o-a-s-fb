<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AgendamentoHorariosTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('tipo_usuario');
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('nome');
            $table->unsignedInteger('duracao');
            $table->string('local_atendimento', 500)->nullable();
            $table->boolean('ativo');
        });

        Schema::create('disponibilidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedTinyInteger('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->boolean('ativo');
        });

        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('prestador_id');
            $table->unsignedBigInteger('servico_id');
            $table->string('telefone_cliente');
            $table->date('data');
            $table->time('horario');
            $table->string('status');
        });
    }

    public function test_it_returns_only_future_slots_that_fit_the_service_and_do_not_overlap_bookings(): void
    {
        $this->travelTo('2026-11-10 08:00:00');
        $cliente = User::factory()->make([
            'id' => 1,
            'tipo_usuario' => 'cliente',
        ]);
        $this->actingAs($cliente);

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Cliente', 'email' => 'cliente@example.com', 'password' => 'password', 'tipo_usuario' => 'cliente'],
            ['id' => 2, 'name' => 'Prestador', 'email' => 'prestador@example.com', 'password' => 'password', 'tipo_usuario' => 'prestador'],
        ]);

        DB::table('servicos')->insert([
            ['id' => 1, 'usuario_id' => 2, 'nome' => 'Atendimento', 'duracao' => 60, 'ativo' => true],
        ]);
        DB::table('disponibilidades')->insert([
            ['usuario_id' => 2, 'dia_semana' => 2, 'hora_inicio' => '09:00:00', 'hora_fim' => '12:00:00', 'ativo' => true],
        ]);
        DB::table('agendamentos')->insert([
            [
                'cliente_id' => 1,
                'prestador_id' => 2,
                'servico_id' => 1,
                'telefone_cliente' => '(11) 99999-1234',
                'data' => '2026-11-10',
                'horario' => '10:00:00',
                'status' => 'pendente',
            ],
        ]);

        $response = $this->getJson(route('agendamentos.horarios-disponiveis', [
            'servico_id' => 1,
            'data' => '2026-11-10',
        ]));

        $response->assertOk()
            ->assertExactJson([
                'horarios' => ['09:00', '11:00'],
                'local_atendimento' => null,
            ]);
    }

    public function test_it_returns_available_calendar_days_and_service_location(): void
    {
        $this->travelTo('2026-11-10 08:00:00');
        $cliente = User::factory()->make([
            'id' => 1,
            'tipo_usuario' => 'cliente',
        ]);
        $this->actingAs($cliente);

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Cliente', 'email' => 'cliente@example.com', 'password' => 'password', 'tipo_usuario' => 'cliente'],
            ['id' => 2, 'name' => 'Prestador', 'email' => 'prestador@example.com', 'password' => 'password', 'tipo_usuario' => 'prestador'],
        ]);
        DB::table('servicos')->insert([
            [
                'id' => 1,
                'usuario_id' => 2,
                'nome' => 'Atendimento',
                'duracao' => 60,
                'local_atendimento' => 'Rua das Flores, 123',
                'ativo' => true,
            ],
        ]);
        DB::table('disponibilidades')->insert([
            ['usuario_id' => 2, 'dia_semana' => 2, 'hora_inicio' => '09:00:00', 'hora_fim' => '12:00:00', 'ativo' => true],
        ]);
        DB::table('agendamentos')->insert([
            [
                'cliente_id' => 1,
                'prestador_id' => 2,
                'servico_id' => 1,
                'telefone_cliente' => '(11) 99999-1234',
                'data' => '2026-11-10',
                'horario' => '09:00:00',
                'status' => 'pendente',
            ],
            [
                'cliente_id' => 1,
                'prestador_id' => 2,
                'servico_id' => 1,
                'telefone_cliente' => '(11) 99999-1234',
                'data' => '2026-11-17',
                'horario' => '09:00:00',
                'status' => 'cancelado',
            ],
        ]);

        $response = $this->getJson(route('agendamentos.datas-disponiveis', [
            'servico_id' => 1,
            'mes' => '2026-11',
        ]));

        $response->assertOk()
            ->assertExactJson([
                'datas' => ['2026-11-10', '2026-11-17', '2026-11-24'],
                'local_atendimento' => 'Rua das Flores, 123',
            ]);
    }

    public function test_it_returns_a_clear_message_when_the_selected_service_cannot_be_booked(): void
    {
        $cliente = User::factory()->make([
            'id' => 1,
            'tipo_usuario' => 'cliente',
        ]);
        $this->actingAs($cliente);

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Cliente', 'email' => 'cliente@example.com', 'password' => 'password', 'tipo_usuario' => 'cliente'],
            ['id' => 2, 'name' => 'Prestador', 'email' => 'prestador@example.com', 'password' => 'password', 'tipo_usuario' => 'prestador'],
        ]);
        DB::table('servicos')->insert([
            ['id' => 1, 'usuario_id' => 2, 'nome' => 'Serviço inativo', 'duracao' => 60, 'ativo' => false],
        ]);

        $response = $this->getJson(route('agendamentos.horarios-disponiveis', [
            'servico_id' => 1,
            'data' => '2026-11-11',
        ]));

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'servico_id' => 'Selecione um serviço válido para agendamento.',
            ]);
    }
}
