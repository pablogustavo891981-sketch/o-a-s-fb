<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_attempts_are_limited_per_email_and_ip_address(): void
    {
        $email = 'rate-limit-'.uniqid().'@example.com';

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.store'), [
                'email' => $email,
                'password' => '',
            ])->assertRedirect();
        }

        $response = $this->post(route('login.store'), [
            'email' => $email,
            'password' => '',
        ]);

        $response->assertTooManyRequests();
    }
}
