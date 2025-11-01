<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\usuariolog;

/**
 * Controlador encargado del registro de nuevos usuarios del sistema.
 *
 * Este controlador gestiona la vista y el proceso de registro para
 * usuarios del módulo de autenticación `usuariolog`. Implementa validación,
 * encriptación de contraseñas y manejo de errores comunes.
 *
 * Funcionalidades principales:
 * - Mostrar el formulario de registro.
 * - Validar los datos de entrada del usuario.
 * - Registrar un nuevo usuario en la base de datos.
 *
 * @package App\Http\Controllers
 */
class registrarseController extends Controller
{
    /**
     * Muestra la vista del formulario de registro.
     *
     * @return \Illuminate\View\View
     *
     * Obtiene el usuario autenticado (si existe) mediante el guard `usuariolog`
     * y lo pasa a la vista de registro.
     */
    public function registrarse()
    {
        $user = auth()->guard('usuariolog')->user();
        return view('auth/registrarse', compact('user'));
    }

    /**
     * Procesa el registro de un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Realiza la validación de los datos enviados, encripta la contraseña
     * utilizando `Hash::make()` y guarda el nuevo usuario en la tabla `usuariolog`.
     * Si la validación falla, retorna al formulario con mensajes de error.
     */
    public function registrar(Request $request)
    {
        // 🧾 Validación de campos
        $validator = Validator::make($request->all(), [
            'user_name' => [
                'required',
                'unique:usuariolog,user_name',
                'regex:/^[a-z0-9_\-\.]+$/', // Solo minúsculas, números y caracteres permitidos
            ],
            'user_pass' => 'required|min:3',
            'user_tipo' => 'required'
        ], [
            'user_name.regex' => 'El nombre de usuario solo puede contener letras minúsculas, números, guiones, guiones bajos y puntos.',
        ]);

        // ❌ Si hay errores, regresar con los mensajes de validación
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ✅ Crear nuevo usuario
        $user = new usuariolog();
        $user->user_name = $request->user_name; // El mutador del modelo lo convertirá a minúsculas
        $user->user_pass = Hash::make($request->user_pass); // Encriptar contraseña
        $user->user_tipo = $request->user_tipo;
        $user->save();

        // ✅ Redirigir con mensaje de éxito
        return redirect()->back()->with('success', '¡Registro de usuario exitoso!');
    }
}
