<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class AgendamentoTelefoneTest extends TestCase
{
    public function test_agendamento_form_uses_the_registered_client_phone(): void
    {
        $cliente = User::factory()->make([
            'tipo_usuario' => 'cliente',
            'telefone' => '(11) 99999-1234',
        ]);

        $this->actingAs($cliente);

        $html = view('agendamentos.create', [
            'errors' => new ViewErrorBag(),
            'servicos' => collect([
                (object) [
                    'id' => 1,
                    'nome' => 'Manutenção',
                    'preco' => 80,
                    'local_atendimento' => 'Rua das Flores, 123',
                ],
            ]),
        ])->render();

        $this->assertStringContainsString('name="telefone_cliente"', $html);
        $this->assertStringContainsString('name="horario"', $html);
        $this->assertStringContainsString('horarios-disponiveis', $html);
        $this->assertStringContainsString('calendario-dias', $html);
        $this->assertStringContainsString('Rua das Flores, 123', $html);
        $this->assertStringContainsString('value="(11) 99999-1234"', $html);
    }

    public function test_client_phone_is_accepted_under_the_field_name_expected_by_the_controller(): void
    {
        $cliente = User::factory()->make([
            'tipo_usuario' => 'cliente',
        ]);

        $response = $this->actingAs($cliente)->post(route('agendamentos.store'), [
            'telefone_cliente' => '(11) 99999-1234',
        ]);

        $response->assertSessionHasErrors(['servico_id', 'data', 'horario']);

        $this->assertFalse(session('errors')->has('telefone_cliente'));
    }
}
