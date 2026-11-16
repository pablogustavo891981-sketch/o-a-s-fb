<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
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

        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('nome');
        });

        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('prestador_id');
            $table->unsignedBigInteger('servico_id');
            $table->date('data');
            $table->time('horario');
            $table->string('status');
        });

        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prestador_id');
        });
    }

    public function test_client_dashboard_reports_booking_counts_in_one_aggregate_query(): void
    {
        $cliente = $this->createUser(1, 'cliente');
        $prestador = $this->createUser(2, 'prestador');
        $this->createService(1, $prestador->id);
        $this->createBooking(1, $cliente->id, $prestador->id, 1, 'pendente');
        $this->createBooking(2, $cliente->id, $prestador->id, 1, 'concluido');

        $countQueries = 0;
        DB::listen(function ($query) use (&$countQueries): void {
            if (str_contains(strtolower($query->sql), 'count(')) {
                $countQueries++;
            }
        });

        $response = $this->actingAs($cliente)->get(route('dashboard'));

        $response->assertOk()
            ->assertViewHas('dados', [
                'total_anuncios' => 0,
                'total_servicos' => 0,
                'total_agendamentos' => 2,
                'agendamentos_pendentes' => 1,
                'avaliacoes_recebidas' => 0,
            ]);

        $this->assertSame(1, $countQueries);
    }

    public function test_provider_dashboard_reports_owned_records_and_pending_booking_counts(): void
    {
        $prestador = $this->createUser(2, 'prestador');
        $cliente = $this->createUser(1, 'cliente');
        $this->createService(1, $prestador->id);
        $this->createService(2, $prestador->id);
        DB::table('anuncios')->insert([
            ['usuario_id' => $prestador->id],
            ['usuario_id' => $prestador->id],
        ]);
        DB::table('avaliacoes')->insert([
            ['prestador_id' => $prestador->id],
        ]);
        $this->createBooking(1, $cliente->id, $prestador->id, 1, 'pendente');
        $this->createBooking(2, $cliente->id, $prestador->id, 2, 'confirmado');

        $response = $this->actingAs($prestador)->get(route('dashboard'));

        $response->assertOk()
            ->assertViewHas('dados', [
                'total_anuncios' => 2,
                'total_servicos' => 2,
                'total_agendamentos' => 2,
                'agendamentos_pendentes' => 1,
                'avaliacoes_recebidas' => 1,
            ]);
    }

    public function test_administrator_dashboard_reports_global_booking_counts(): void
    {
        $administrador = $this->createUser(3, 'administrador');
        $cliente = $this->createUser(1, 'cliente');
        $prestador = $this->createUser(2, 'prestador');
        $this->createService(1, $prestador->id);
        DB::table('anuncios')->insert([
            ['usuario_id' => $prestador->id],
        ]);
        DB::table('avaliacoes')->insert([
            ['prestador_id' => $prestador->id],
            ['prestador_id' => $prestador->id],
        ]);
        $this->createBooking(1, $cliente->id, $prestador->id, 1, 'pendente');
        $this->createBooking(2, $cliente->id, $prestador->id, 1, 'concluido');

        $response = $this->actingAs($administrador)->get(route('dashboard'));

        $response->assertOk()
            ->assertViewHas('dados', [
                'total_anuncios' => 1,
                'total_servicos' => 1,
                'total_agendamentos' => 2,
                'agendamentos_pendentes' => 1,
                'avaliacoes_recebidas' => 2,
            ]);
    }

    private function createUser(int $id, string $role): User
    {
        DB::table('users')->insert([
            'id' => $id,
            'name' => ucfirst($role),
            'email' => $role.'@example.com',
            'password' => 'password',
            'tipo_usuario' => $role,
        ]);

        return User::factory()->make([
            'id' => $id,
            'tipo_usuario' => $role,
        ]);
    }

    private function createService(int $id, int $prestadorId): void
    {
        DB::table('servicos')->insert([
            'id' => $id,
            'usuario_id' => $prestadorId,
            'nome' => 'Serviço '.$id,
        ]);
    }

    private function createBooking(
        int $id,
        int $clienteId,
        int $prestadorId,
        int $servicoId,
        string $status
    ): void {
        DB::table('agendamentos')->insert([
            'id' => $id,
            'cliente_id' => $clienteId,
            'prestador_id' => $prestadorId,
            'servico_id' => $servicoId,
            'data' => '2026-11-17',
            'horario' => '09:00:00',
            'status' => $status,
        ]);
    }
}
