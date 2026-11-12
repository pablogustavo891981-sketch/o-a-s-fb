<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ServicoCreatePageTest extends TestCase
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
    }

    public function test_provider_sees_the_organized_service_registration_form(): void
    {
        $prestador = User::factory()->create([
            'tipo_usuario' => 'prestador',
        ]);
        Categoria::create([
            'nome' => 'Tecnologia',
            'ativa' => true,
        ]);
        $this->actingAs($prestador);

        $response = $this->get(route('servicos.create'));

        $response->assertOk()
            ->assertSee('Cadastre seu serviço')
            ->assertSee('Sobre o serviço')
            ->assertSee('Preço e duração')
            ->assertSee('Atendimento e imagem')
            ->assertSee('name="categoria_id"', false)
            ->assertSee('name="imagem"', false)
            ->assertSee(route('servicos.store'), false)
            ->assertSee('Tecnologia');
    }
}
