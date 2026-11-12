<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_public_landing_page_links_to_separate_accessibility_settings(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('href="#conteudo-principal"', false)
            ->assertSee('Personalizar acessibilidade')
            ->assertSee('href="'.route('acessibilidade').'"', false)
            ->assertDontSee('id="texto-aumentar"', false)
            ->assertSee('id="conteudo-principal"', false);
    }

    public function test_accessibility_page_contains_readability_and_contrast_settings(): void
    {
        $response = $this->get(route('acessibilidade'));

        $response->assertOk()
            ->assertSee('Personalizar acessibilidade')
            ->assertSee('Tamanho do texto')
            ->assertSee('Contraste da tela')
            ->assertSee('id="texto-aumentar"', false)
            ->assertSee('id="texto-diminuir"', false)
            ->assertSee('id="texto-restaurar"', false)
            ->assertSee('id="alto-contraste"', false)
            ->assertSee('Suas preferências são salvas neste navegador');
    }

    public function test_login_and_registration_link_to_separate_accessibility_settings(): void
    {
        foreach ([route('login'), route('cadastro')] as $url) {
            $response = $this->get($url);

            $response->assertOk()
                ->assertSee('Personalizar acessibilidade')
                ->assertSee('href="'.route('acessibilidade').'"', false)
                ->assertSee('Pular para o conteúdo principal');
        }
    }

    public function test_common_framework_messages_use_brazilian_portuguese(): void
    {
        $this->assertSame('pt_BR', app()->getLocale());
        $this->assertSame('Próxima &raquo;', __('pagination.next'));
        $this->assertSame(
            'O campo e-mail é obrigatório.',
            __('validation.required', ['attribute' => __('validation.attributes.email')])
        );
        $this->assertSame('E-mail ou senha incorretos.', __('auth.failed'));
        $this->assertSame('Página não encontrada', __('Not Found'));
    }

    public function test_login_errors_identify_the_fields_that_need_correction(): void
    {
        $response = $this->from(route('login'))
            ->followingRedirects()
            ->post(route('login.store'), [
                'email' => '',
                'password' => '',
            ]);

        $response->assertOk()
            ->assertSee('Encontramos 2 erros no formulário')
            ->assertSee('data-validation-field="email"', false)
            ->assertSee('data-validation-field="password"', false);
    }
}
