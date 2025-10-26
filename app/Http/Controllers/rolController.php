<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

/**
 * Controlador encargado de la gestión de roles de usuario.
 *
 * Este controlador administra todas las operaciones CRUD del módulo de roles,
 * incluyendo la creación, edición, actualización, eliminación y visualización.
 *
 * También aplica un middleware de autenticación (`auth:usuariolog`) para restringir
 * el acceso únicamente a usuarios autenticados.
 *
 * Funcionalidades principales:
 * - Crear nuevos roles.
 * - Listar todos los roles.
 * - Editar y actualizar roles.
 * - Eliminar roles con control de integridad referencial.
 *
 * @package App\Http\Controllers
 */
class rolController extends Controller
{
    /**
     * Aplica el middleware de autenticación a todas las acciones del controlador.
     *
     * Solo los usuarios autenticados con el guard `usuariolog` pueden acceder
     * a las rutas que dependen de este controlador.
     */
    public function __construct()
    {
        $this->middleware('auth:usuariolog');
    }

    /**
     * Muestra el panel principal (dashboard) para el usuario autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function iniciar()
    {
        $user = auth()->guard('usuariolog')->user();
        return view('dashboard.dashboard', compact('user'));
    }

    /**
     * Muestra la vista para crear un nuevo rol.
     *
     * @return \Illuminate\View\View
     *
     * Carga el formulario de creación de roles.
     * Actualmente, redirige a la vista `roles.leer` para visualización.
     */
    public function crear()
    {
        /*
        Ejemplo para generar un hash de contraseña de prueba:
        $password = Hash::make('123');
        dd($password);
        */
        return view("roles.leer");
    }

    /**
     * Almacena un nuevo rol en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos enviados y crea un nuevo registro en la tabla `rol`
     * con el estado activo por defecto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NombreRol' => 'required|string|max:50',
        ]);

        $rol = new Rol();
        $rol->NombreRol = $request->NombreRol;
        $rol->Estado = 1; // Activo por defecto
        $rol->save();

        return redirect('/roles/leer')->with('success', 'Rol creado exitosamente');
    }

    /**
     * Muestra la lista completa de roles registrados.
     *
     * @return \Illuminate\View\View
     */
    public function leer()
    {
        $roles = Rol::all();
        return view('roles.leer', compact('roles'));
    }

    /**
     * Muestra el formulario de edición para un rol específico.
     *
     * @param  int  $IdRol
     * @return \Illuminate\View\View
     *
     * Busca el rol en la base de datos y carga sus datos en la vista de edición.
     */
    public function edit($IdRol)
    {
        $rol = Rol::findOrFail($IdRol);
        return view('roles.actualizar', compact('rol'));
    }

    /**
     * Actualiza los datos de un rol existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdRol
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los campos `NombreRol` y `Estado`, asegurando que el estado sea booleano (0 o 1),
     * y guarda los cambios en la base de datos.
     */
    public function update(Request $request, $IdRol)
    {
        $request->validate([
            'NombreRol' => 'required|string|max:50',
            'Estado' => 'required|boolean',
        ]);

        $rol = Rol::findOrFail($IdRol);
        $rol->NombreRol = $request->NombreRol;
        $rol->Estado = $request->Estado;
        $rol->save();

        return redirect()->route('roles.leer')->with('success', 'Rol actualizado correctamente');
    }

    /**
     * Elimina un rol de la base de datos.
     *
     * @param  int  $IdRol
     * @return \Illuminate\Http\RedirectResponse
     *
     * Intenta eliminar el rol especificado. Si el rol tiene usuarios asociados
     * o registros dependientes, captura la excepción de integridad referencial
     * (código SQL 23000) y muestra un mensaje de error al usuario.
     */
    public function destroy($IdRol)
    {
        $rol = Rol::findOrFail($IdRol);

        try {
            $rol->delete();
            return redirect()->route('roles.leer')->with('success', 'Rol eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === "23000") {
                return redirect()->route('roles.leer')->with(
                    'error',
                    'Error: No se puede eliminar el rol porque tiene usuarios o registros asociados.'
                );
            }
            throw $e;
        }
    }
}
