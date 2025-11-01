<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuariolog;

/**
 * Controlador encargado de la administración de usuarios del sistema de login.
 *
 * Este controlador gestiona las operaciones CRUD para los usuarios que
 * acceden al sistema mediante el módulo de autenticación `usuariolog`.
 *
 * Funcionalidades principales:
 * - Listar usuarios con filtros y paginación.
 * - Editar y actualizar credenciales de usuario.
 * - Eliminar usuarios del sistema.
 *
 * @package App\Http\Controllers
 */
class usuariologController extends Controller
{
    /* ============================================================
       📋 LISTADO DE USUARIOS
    ============================================================ */

    /**
     * Muestra el listado de usuarios del sistema de login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     *
     * Permite aplicar búsqueda y ordenamiento dinámico por nombre o tipo
     * de usuario, con resultados paginados.
     */
    public function leer(Request $request)
    {
        // 🔍 Construcción de la consulta con búsqueda opcional
        $query = usuariolog::query();

        if ($request->has('buscar') && !empty($request->buscar)) {
            // Normalizar término de búsqueda a minúsculas para user_name
            $termino = '%' . strtolower(trim($request->buscar)) . '%';
            $query->where('user_name', 'like', $termino)
                  ->orWhere('user_tipo', 'like', $termino);
        }

        // 🔄 Ordenamiento dinámico
        $sortBy = $request->get('sort_by', 'user_name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // 📄 Paginación
        $usuarios = $query->paginate(10);

        return view('usuariolog.leer', [
            'usuarios' => $usuarios,
            'busqueda' => $request->buscar,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
        ]);
    }

    /* ============================================================
       ✏️ EDITAR USUARIO
    ============================================================ */

    /**
     * Muestra el formulario de edición para un usuario específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     *
     * Busca al usuario por su ID y carga la vista `usuariolog.actualizar`
     * con los datos actuales del usuario.
     */
    public function edit($id)
    {
        $usuario = usuariolog::findOrFail($id);
        return view('usuariolog.actualizar', compact('usuario'));
    }

    /* ============================================================
       💾 ACTUALIZAR USUARIO
    ============================================================ */

    /**
     * Actualiza la información de un usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los campos del formulario, incluyendo la posibilidad de
     * actualizar la contraseña (solo si se envía un nuevo valor).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9_\-\.]+$/', // Solo minúsculas, números y caracteres permitidos
            ],
            'user_tipo' => 'required|string|max:2',
            'user_pass' => 'nullable|string|max:256',
        ], [
            'user_name.regex' => 'El nombre de usuario solo puede contener letras minúsculas, números, guiones, guiones bajos y puntos.',
        ]);

        $usuario = usuariolog::findOrFail($id);
        $usuario->user_name = $request->user_name; // El mutador del modelo lo convertirá a minúsculas
        $usuario->user_tipo = $request->user_tipo;

        // 🔐 Encriptar contraseña si se envía un nuevo valor
        if ($request->filled('user_pass')) {
            $usuario->user_pass = bcrypt($request->user_pass);
        }

        $usuario->save();

        return redirect()->route('usuariolog.leer')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /* ============================================================
       🗑️ ELIMINAR USUARIO
    ============================================================ */

    /**
     * Elimina un usuario del sistema de login.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Busca el usuario por ID y lo elimina de la base de datos.
     * Redirige al listado con un mensaje de confirmación.
     */
    public function destroy($id)
    {
        $usuario = usuariolog::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuariolog.leer')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
