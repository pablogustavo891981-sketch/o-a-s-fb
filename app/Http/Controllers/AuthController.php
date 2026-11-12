<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Exibir tela de cadastro.
     */
    public function mostrarCadastro()
    {
        return view('auth.register');
    }

    /**
     * Cadastrar novo usuário.
     */
    public function cadastrar(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'tipo_usuario' => ['required', 'in:cliente,prestador'],
        ]);

        $usuario = User::create([
            'name' => $dados['name'],
            'email' => $dados['email'],
            'telefone' => $dados['telefone'] ?? null,
            'password' => $dados['password'],
            'tipo_usuario' => $dados['tipo_usuario'],
        ]);

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Cadastro realizado com sucesso!');
    }

    /**
     * Exibir tela de login.
     */
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    /**
     * Autenticar usuário.
     */
    public function entrar(Request $request)
    {
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credenciais, $request->boolean('lembrar'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors([
                'email' => 'E-mail ou senha incorretos.',
            ])
            ->onlyInput('email');
    }

    /**
     * Encerrar sessão.
     */
    public function sair(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Você saiu da sua conta.');
    }
}
