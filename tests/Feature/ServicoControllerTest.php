<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ServicoControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->boolean('ativa');
            $table->timestamps();
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('categoria_id');
            $table->string('nome');
            $table->text('descricao');
            $table->decimal('preco', 10, 2);
            $table->unsignedInteger('duracao');
            $table->string('local_atendimento')->nullable();
            $table->string('imagem')->nullable();
            $table->boolean('ativo');
            $table->timestamps();
        });
    }

    public function test_provider_can_update_a_service_that_keeps_its_inactive_category(): void
    {
        $prestador = User::factory()->make([
            'id' => 23,
            'tipo_usuario' => 'prestador',
        ]);
        DB::table('categorias')->insert([
            'id' => 1,
            'nome' => 'Categoria desativada',
            'ativa' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('servicos')->insert([
            'id' => 1,
            'usuario_id' => $prestador->id,
            'categoria_id' => 1,
            'nome' => 'Serviço anterior',
            'descricao' => 'Descrição anterior',
            'preco' => 50,
            'duracao' => 60,
            'ativo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($prestador)
            ->put(route('servicos.update', 1), [
                'categoria_id' => 1,
                'nome' => 'Serviço atualizado',
                'descricao' => 'Descrição atualizada',
                'preco' => 75,
                'duracao' => 90,
                'local_atendimento' => 'Atendimento local',
            ]);

        $response->assertRedirect(route('servicos.index'));
        $this->assertDatabaseHas('servicos', [
            'id' => 1,
            'categoria_id' => 1,
            'nome' => 'Serviço atualizado',
            'descricao' => 'Descrição atualizada',
        ]);
    }
}
