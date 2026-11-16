<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('tipo_usuario');
            $table->string('telefone')->nullable();
            $table->timestamps();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->boolean('ativa');
            $table->timestamps();
        });

        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('categoria_id');
            $table->string('titulo');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->boolean('ativo');
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
        });
    }

    public function test_administrator_dashboard_returns_all_statistics_using_six_count_queries(): void
    {
        $administrador = User::factory()->create([
            'tipo_usuario' => 'administrador',
        ]);
        DB::table('users')->insert([
            ['id' => 2, 'name' => 'Cliente', 'email' => 'cliente@example.com', 'password' => 'password', 'tipo_usuario' => 'cliente'],
            ['id' => 3, 'name' => 'Prestador', 'email' => 'prestador@example.com', 'password' => 'password', 'tipo_usuario' => 'prestador'],
        ]);
        DB::table('anuncios')->insert([
            ['usuario_id' => 2, 'categoria_id' => 1, 'titulo' => 'Pendente', 'status' => 'pendente'],
            ['usuario_id' => 2, 'categoria_id' => 1, 'titulo' => 'Ativo', 'status' => 'ativo'],
        ]);
        DB::table('servicos')->insert([
            ['ativo' => true],
            ['ativo' => false],
        ]);
        DB::table('agendamentos')->insert([
            ['cliente_id' => 2, 'prestador_id' => 3, 'servico_id' => 1, 'data' => '2026-11-17', 'horario' => '09:00:00', 'status' => 'pendente'],
            ['cliente_id' => 2, 'prestador_id' => 3, 'servico_id' => 1, 'data' => '2026-11-18', 'horario' => '09:00:00', 'status' => 'confirmado'],
        ]);
        DB::table('categorias')->insert([
            ['nome' => 'Tecnologia', 'ativa' => true],
        ]);
        $countQueries = 0;
        DB::listen(function (QueryExecuted $query) use (&$countQueries): void {
            if (str_contains(strtolower($query->sql), 'count(')) {
                $countQueries++;
            }
        });

        $response = $this->actingAs($administrador)->get(route('admin.index'));

        $response->assertOk()
            ->assertViewHas('estatisticas', [
                'usuarios' => 3,
                'clientes' => 1,
                'prestadores' => 1,
                'anuncios' => 2,
                'anuncios_pendentes' => 1,
                'servicos' => 2,
                'servicos_ativos' => 1,
                'agendamentos' => 2,
                'agendamentos_pendentes' => 1,
                'avaliacoes' => 0,
                'categorias' => 1,
            ]);

        $this->assertSame(6, $countQueries);
    }
}
