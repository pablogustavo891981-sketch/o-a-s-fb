<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DisponibilidadeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('disponibilidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedTinyInteger('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->boolean('ativo');
            $table->timestamps();
        });
    }

    public function test_client_cannot_access_availability_management_or_create_records(): void
    {
        $cliente = User::factory()->make([
            'id' => 17,
            'tipo_usuario' => 'cliente',
        ]);

        $this->actingAs($cliente)
            ->get(route('disponibilidades.index'))
            ->assertForbidden();

        $this->get(route('disponibilidades.create'))
            ->assertForbidden();

        $this->post(route('disponibilidades.store'), [
            'dia_semana' => 1,
            'hora_inicio' => '09:00',
            'hora_fim' => '12:00',
        ])->assertForbidden();

        $this->assertDatabaseCount('disponibilidades', 0);
    }

    public function test_client_cannot_view_or_change_an_own_availability_record(): void
    {
        $cliente = User::factory()->make([
            'id' => 17,
            'tipo_usuario' => 'cliente',
        ]);
        DB::table('disponibilidades')->insert([
            'id' => 1,
            'usuario_id' => $cliente->id,
            'dia_semana' => 1,
            'hora_inicio' => '09:00:00',
            'hora_fim' => '12:00:00',
            'ativo' => true,
        ]);

        $this->actingAs($cliente)
            ->get(route('disponibilidades.show', 1))
            ->assertForbidden();

        $this->get(route('disponibilidades.edit', 1))
            ->assertForbidden();

        $this->put(route('disponibilidades.update', 1), [
            'dia_semana' => 2,
            'hora_inicio' => '10:00',
            'hora_fim' => '13:00',
        ])->assertForbidden();

        $this->delete(route('disponibilidades.destroy', 1))
            ->assertForbidden();

        $this->assertDatabaseHas('disponibilidades', [
            'id' => 1,
            'dia_semana' => 1,
        ]);
    }

    public function test_provider_can_create_their_availability(): void
    {
        $prestador = User::factory()->make([
            'id' => 23,
            'tipo_usuario' => 'prestador',
        ]);

        $response = $this->actingAs($prestador)
            ->post(route('disponibilidades.store'), [
                'dia_semana' => 1,
                'hora_inicio' => '09:00',
                'hora_fim' => '12:00',
                'ativo' => '1',
            ]);

        $response->assertRedirect(route('disponibilidades.index'));
        $this->assertDatabaseHas('disponibilidades', [
            'usuario_id' => 23,
            'dia_semana' => 1,
            'hora_inicio' => '09:00',
            'hora_fim' => '12:00',
            'ativo' => 1,
        ]);
    }

    public function test_administrator_cannot_create_an_availability_for_their_non_provider_account(): void
    {
        $administrador = User::factory()->make([
            'id' => 24,
            'tipo_usuario' => 'administrador',
        ]);

        $this->actingAs($administrador)
            ->get(route('disponibilidades.create'))
            ->assertForbidden();

        $this->post(route('disponibilidades.store'), [
            'dia_semana' => 1,
            'hora_inicio' => '09:00',
            'hora_fim' => '12:00',
        ])->assertForbidden();

        $this->assertDatabaseCount('disponibilidades', 0);
    }

    public function test_provider_cannot_view_another_providers_availability(): void
    {
        $prestador = User::factory()->make([
            'id' => 23,
            'tipo_usuario' => 'prestador',
        ]);
        DB::table('disponibilidades')->insert([
            'id' => 1,
            'usuario_id' => 24,
            'dia_semana' => 1,
            'hora_inicio' => '09:00:00',
            'hora_fim' => '12:00:00',
            'ativo' => true,
        ]);

        $this->actingAs($prestador)
            ->get(route('disponibilidades.show', 1))
            ->assertForbidden();
    }
}
