<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\usuariolog;

/**
 * Controlador encargado de la autenticación de usuarios del sistema.
 *
 * Gestiona el inicio y cierre de sesión utilizando el guard personalizado `usuariolog`.
 * Implementa validación de credenciales, autenticación segura mediante hash de contraseñas
 * y manejo de sesión.
 *
 * Funcionalidades principales:
 * - Mostrar el formulario de login.
 * - Validar credenciales de usuario.
 * - Iniciar sesión (login) en el guard `usuariolog`.
 * - Cerrar sesión (logout) y limpiar la sesión actual.
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /* ============================================================
       🔐 FORMULARIO DE LOGIN
    ============================================================ */

    /**
     * Muestra la vista del formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     *
     * Retorna la vista `auth.login` donde el usuario puede ingresar
     * sus credenciales para autenticarse.
     */
    public function ShowLoginForm()
    {
        return view('auth.login');
    }

    /* ============================================================
       ✅ PROCESAR LOGIN
    ============================================================ */

    /**
     * Procesa el inicio de sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida las credenciales ingresadas y verifica que coincidan
     * con un registro existente en la tabla `usuariolog`.
     *
     * Si las credenciales son correctas, inicia sesión mediante el guard `usuariolog`
     * y redirige al panel principal (`/dashboard`).
     * Si no coinciden, retorna al formulario con un mensaje de error.
     */
    public function login(Request $request)
    {
        // 🧾 Obtener credenciales del formulario
        $credentials = $request->only('user_name', 'user_pass');

        // 🔍 Buscar usuario por nombre de usuario
        $user = usuariolog::where('user_name', $credentials['user_name'])->first();

        // 🔐 Verificar existencia y coincidencia de contraseña
        if ($user && Hash::check($credentials['user_pass'], $user->user_pass)) {
            Auth::guard('usuariolog')->login($user);
            return redirect()->intended('/dashboard');
        }

        // ❌ Si falla la autenticación
        return back()->withErrors([
            'user_name' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /* ============================================================
       🚪 CERRAR SESIÓN
    ============================================================ */

    /**
     * Cierra la sesión activa del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Cierra la sesión del guard `usuariolog`, invalida la sesión
     * actual y regenera el token CSRF. Luego redirige al formulario de login.
     */
    public function logout(Request $request)
    {
        // 🔒 Cerrar sesión del guard personalizado
        Auth::guard('usuariolog')->logout();

        // 🧹 Limpiar la sesión actual
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔁 Redirigir al formulario de inicio
        return redirect('/login');
    }
}
