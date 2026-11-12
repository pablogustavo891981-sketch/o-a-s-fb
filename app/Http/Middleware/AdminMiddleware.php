<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()?->tipo_usuario !== 'administrador') {
            abort(403, 'Você não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
}
