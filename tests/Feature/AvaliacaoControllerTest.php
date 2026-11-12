<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AvaliacaoControllerTest extends TestCase
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
            $table->string('local_atendimento')->nullable();
            $table->timestamps();
        });

        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('prestador_id');
            $table->unsignedBigInteger('servico_id');
            $table->date('data');
            $table->time('horario');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agendamento_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('prestador_id');
            $table->unsignedTinyInteger('nota');
            $table->text('comentario')->nullable();
            $table->timestamps();
        });

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Cliente A', 'email' => 'cliente-a@example.com', 'password' => 'password', 'tipo_usuario' => 'cliente'],
            ['id' => 2, 'name' => 'Prestador', 'email' => 'prestador@example.com', 'password' => 'password', 'tipo_usuario' => 'prestador'],
            ['id' => 3, 'name' => 'Cliente B', 'email' => 'cliente-b@example.com', 'password' => 'password', 'tipo_usuario' => 'cliente'],
            ['id' => 4, 'name' => 'Admin', 'email' => 'admin@example.com', 'password' => 'password', 'tipo_usuario' => 'administrador'],
        ]);

        DB::table('servicos')->insert([
            ['id' => 1, 'usuario_id' => 2, 'nome' => 'Serviço A', 'duracao' => 60, 'local_atendimento' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'usuario_id' => 2, 'nome' => 'Serviço B', 'duracao' => 60, 'local_atendimento' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('agendamentos')->insert([
            ['id' => 1, 'cliente_id' => 1, 'prestador_id' => 2, 'servico_id' => 1, 'data' => '2026-11-10', 'horario' => '09:00:00', 'status' => 'concluido', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'cliente_id' => 1, 'prestador_id' => 2, 'servico_id' => 2, 'data' => '2026-11-11', 'horario' => '09:00:00', 'status' => 'concluido', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'cliente_id' => 3, 'prestador_id' => 2, 'servico_id' => 1, 'data' => '2026-11-12', 'horario' => '09:00:00', 'status' => 'concluido', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('avaliacoes')->insert([
            ['id' => 1, 'agendamento_id' => 1, 'cliente_id' => 1, 'prestador_id' => 2, 'nota' => 4, 'comentario' => 'Bom atendimento', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'agendamento_id' => 2, 'cliente_id' => 1, 'prestador_id' => 2, 'nota' => 5, 'comentario' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'agendamento_id' => 3, 'cliente_id' => 3, 'prestador_id' => 2, 'nota' => 1, 'comentario' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function test_client_sees_their_rating_average_and_an_organized_listing(): void
    {
        $cliente = User::factory()->make([
            'id' => 1,
            'tipo_usuario' => 'cliente',
        ]);
        $this->actingAs($cliente);

        $response = $this->get(route('avaliacoes.index'));

        $response->assertOk()
            ->assertSee('Média das avaliações')
            ->assertSee('4,5')
            ->assertSee('Total de avaliações')
            ->assertSee('2')
            ->assertSee('Serviço A')
            ->assertSee('Serviço B')
            ->assertDontSee('Cliente B');
    }

    public function test_administrator_sees_the_rating_delete_action(): void
    {
        $administrador = User::factory()->make([
            'id' => 4,
            'tipo_usuario' => 'administrador',
        ]);
        $this->actingAs($administrador);

        $response = $this->get(route('avaliacoes.show', 1));

        $response->assertOk()
            ->assertSee('Excluir avaliação');
    }
}
