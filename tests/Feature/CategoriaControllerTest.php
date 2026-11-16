<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CategoriaControllerTest extends TestCase
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
            $table->unsignedBigInteger('categoria_id');
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
        });
    }

    public function test_administrator_sees_the_category_card_grid_and_its_styles(): void
    {
        $administrador = User::factory()->create([
            'tipo_usuario' => 'administrador',
        ]);
        $categoria = Categoria::create([
            'nome' => 'Tecnologia',
            'descricao' => 'Produtos e serviços de tecnologia.',
            'ativa' => true,
        ]);
        $this->actingAs($administrador);

        $response = $this->get(route('categorias.index'));

        $response->assertOk()
            ->assertSee('class="categories-grid"', false)
            ->assertSee('.categories-grid', false)
            ->assertSee('Tecnologia')
            ->assertSee('Produtos e serviços de tecnologia.')
            ->assertSee(route('categorias.show', $categoria), false)
            ->assertSee(route('categorias.create'), false);
    }

    public function test_category_details_render_related_counts_loaded_by_the_controller(): void
    {
        $administrador = User::factory()->create([
            'tipo_usuario' => 'administrador',
        ]);
        $categoria = Categoria::create([
            'nome' => 'Tecnologia',
            'descricao' => 'Produtos e serviços de tecnologia.',
            'ativa' => true,
        ]);
        DB::table('anuncios')->insert([
            ['categoria_id' => $categoria->id],
            ['categoria_id' => $categoria->id],
        ]);
        DB::table('servicos')->insert([
            ['categoria_id' => $categoria->id],
        ]);

        $response = $this->actingAs($administrador)
            ->get(route('categorias.show', $categoria));

        $response->assertOk()
            ->assertSee('<strong class="category-stat-value">2</strong>', false)
            ->assertSee('<strong class="category-stat-value">1</strong>', false);
    }
}
