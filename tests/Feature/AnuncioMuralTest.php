<?php

namespace Tests\Feature;

use App\Models\Anuncio;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AnuncioMuralTest extends TestCase
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
            $table->text('descricao');
            $table->string('contato');
            $table->text('informacoes_oferta')->nullable();
            $table->string('imagem')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function test_mural_renders_organized_ad_cards_and_search_controls(): void
    {
        $cliente = User::factory()->create([
            'name' => 'Cliente do Mural',
            'tipo_usuario' => 'cliente',
        ]);
        $outroUsuario = User::factory()->create([
            'name' => 'Prestador Local',
            'tipo_usuario' => 'prestador',
        ]);
        $categoria = Categoria::create([
            'nome' => 'Serviços',
            'descricao' => 'Serviços da comunidade.',
            'ativa' => true,
        ]);
        $anuncioAtivo = Anuncio::create([
            'usuario_id' => $outroUsuario->id,
            'categoria_id' => $categoria->id,
            'titulo' => 'Aulas de informática',
            'descricao' => 'Aulas para iniciantes.',
            'contato' => '11999990000',
            'status' => 'ativo',
        ]);
        Anuncio::create([
            'usuario_id' => $cliente->id,
            'categoria_id' => $categoria->id,
            'titulo' => 'Meu anúncio em análise',
            'descricao' => 'Anúncio aguardando aprovação.',
            'contato' => '11999990001',
            'status' => 'pendente',
        ]);
        $this->actingAs($cliente);

        $response = $this->get(route('anuncios.index'));

        $response->assertOk()
            ->assertSee('class="mural-grid"', false)
            ->assertSee('class="mural-filter"', false)
            ->assertSee('Aulas de informática')
            ->assertSee('Serviços')
            ->assertSee('Prestador Local')
            ->assertSee('Meu anúncio em análise')
            ->assertSee('Em análise')
            ->assertSee(route('anuncios.show', $anuncioAtivo), false)
            ->assertSee(route('anuncios.create'), false);
    }

    public function test_mural_keeps_search_and_category_filters_working(): void
    {
        $cliente = User::factory()->create([
            'tipo_usuario' => 'cliente',
        ]);
        $categoriaSelecionada = Categoria::create([
            'nome' => 'Tecnologia',
            'ativa' => true,
        ]);
        $outraCategoria = Categoria::create([
            'nome' => 'Educação',
            'ativa' => true,
        ]);
        Anuncio::create([
            'usuario_id' => $cliente->id,
            'categoria_id' => $categoriaSelecionada->id,
            'titulo' => 'Conserto de computador',
            'descricao' => 'Manutenção especializada.',
            'contato' => '11999990002',
            'status' => 'ativo',
        ]);
        Anuncio::create([
            'usuario_id' => $cliente->id,
            'categoria_id' => $outraCategoria->id,
            'titulo' => 'Aulas de matemática',
            'descricao' => 'Aulas para todos os níveis.',
            'contato' => '11999990003',
            'status' => 'ativo',
        ]);
        $this->actingAs($cliente);

        $response = $this->get(route('anuncios.index', [
            'busca' => 'computador',
            'categoria_id' => $categoriaSelecionada->id,
        ]));

        $response->assertOk()
            ->assertSee('Conserto de computador')
            ->assertDontSee('Aulas de matemática')
            ->assertSee('value="computador"', false)
            ->assertSee('Limpar filtros');
    }
}
