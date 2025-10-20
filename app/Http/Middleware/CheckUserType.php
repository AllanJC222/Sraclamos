<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware personalizado para validar el tipo de usuario autenticado.
 *
 * Este middleware verifica si el usuario autenticado mediante el guard `usuariolog`
 * posee el tipo de usuario requerido para acceder a una ruta o sección del sistema.
 *
 * Si el tipo de usuario no coincide, se realiza una redirección automática
 * hacia el panel principal (`dashboard`).
 *
 * Ejemplo de uso en rutas:
 * ```php
 * Route::get('/admin', [AdminController::class, 'index'])
 *      ->middleware('checkUserType:AD'); // Solo usuarios tipo "AD" pueden acceder
 * ```
 *
 * @package App\Http\Middleware
 */
class CheckUserType
{
    /**
     * Maneja una solicitud entrante y verifica el tipo de usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $type  Tipo de usuario permitido (por ejemplo: 'AD', 'TE', 'EM')
     * @return mixed
     *
     * Si el usuario no está autenticado o su tipo no coincide con el permitido,
     * se redirige automáticamente al `dashboard`.
     */
    public function handle(Request $request, Closure $next, $type)
    {
        // ✅ Verifica si el usuario está autenticado y su tipo es el esperado
        if (Auth::guard('usuariolog')->check() && Auth::guard('usuariolog')->user()->user_tipo != $type) {
            return redirect('dashboard');
        }

        // ✅ Permite continuar con la solicitud
        return $next($request);
    }
}
