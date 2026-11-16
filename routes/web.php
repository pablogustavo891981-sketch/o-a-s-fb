<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisponibilidadeController;
use App\Http\Controllers\ServicoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/acessibilidade', 'acessibilidade')
    ->name('acessibilidade');

/*
|--------------------------------------------------------------------------
| Autenticação
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/cadastro', [AuthController::class, 'mostrarCadastro'])
        ->name('cadastro');

    Route::post('/cadastro', [AuthController::class, 'cadastrar'])
        ->name('cadastro.store');

    Route::get('/login', [AuthController::class, 'mostrarLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'entrar'])
        ->middleware('throttle:login')
        ->name('login.store');

});

/*
|--------------------------------------------------------------------------
| Área autenticada
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Sair da conta
    Route::post('/logout', [AuthController::class, 'sair'])
        ->name('logout');

    // Painel principal
    Route::get('/painel', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Categorias
    Route::resource('categorias', CategoriaController::class);

    // Mural de anúncios
    Route::resource('anuncios', AnuncioController::class);

    // Serviços
    Route::resource('servicos', ServicoController::class);

    // Disponibilidade dos prestadores
    Route::resource('disponibilidades', DisponibilidadeController::class);

    // Agendamentos
    Route::get('/agendamentos/horarios-disponiveis', [
        AgendamentoController::class,
        'horariosDisponiveis',
    ])->name('agendamentos.horarios-disponiveis');

    Route::get('/agendamentos/datas-disponiveis', [
        AgendamentoController::class,
        'datasDisponiveis',
    ])->name('agendamentos.datas-disponiveis');

    Route::resource('agendamentos', AgendamentoController::class)
        ->except(['edit']);

    // Avaliações
    Route::resource('avaliacoes', AvaliacaoController::class)
        ->parameters(['avaliacoes' => 'avaliacao']);

    /*
    |--------------------------------------------------------------------------
    | Administração
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->controller(AdminController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            // Usuários
            Route::get('/usuarios', 'usuarios')
                ->name('usuarios');

            Route::put('/usuarios/{usuario}', 'atualizarUsuario')
                ->name('usuarios.update');

            // Anúncios
            Route::get('/anuncios', 'anuncios')
                ->name('anuncios');

            Route::put('/anuncios/{anuncio}/status', 'atualizarStatusAnuncio')
                ->name('anuncios.status');

            // Serviços
            Route::get('/servicos', 'servicos')
                ->name('servicos');

            Route::put('/servicos/{servico}/status', 'atualizarStatusServico')
                ->name('servicos.status');

            // Agendamentos
            Route::get('/agendamentos', 'agendamentos')
                ->name('agendamentos');

            // Avaliações
            Route::get('/avaliacoes', 'avaliacoes')
                ->name('avaliacoes');

        });

});
