<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;

/**
 * Controlador encargado de la gestión de usuarios del sistema.
 *
 * Este controlador permite crear, listar, editar, actualizar y cambiar el estado
 * de los usuarios registrados. Está protegido por el middleware `auth:usuariolog`
 * para garantizar que solo usuarios autenticados puedan acceder.
 *
 * Funcionalidades principales:
 * - Registrar nuevos usuarios.
 * - Consultar y filtrar usuarios existentes.
 * - Editar información de usuario.
 * - Activar o desactivar usuarios.
 *
 * @package App\Http\Controllers
 */
class usuarioController extends Controller
{
    /**
     * Aplica el middleware de autenticación a todas las rutas del controlador.
     *
     * Solo los usuarios autenticados con el guard `usuariolog` podrán acceder.
     */
    public function __construct()
    {
        $this->middleware('auth:usuariolog');
    }

    /**
     * Muestra el dashboard principal para el usuario autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function iniciar()
    {
        $user = auth()->guard('usuariolog')->user();
        return view('dashboard.dashboard', compact('user'));
    }

    /* ============================================================
       🧩 CREAR USUARIO
    ============================================================ */

    /**
     * Muestra el formulario de creación de un nuevo usuario.
     *
     * @return \Illuminate\View\View
     *
     * Carga la vista `usuarios.crear` con la lista de roles disponibles
     * para asignar al nuevo usuario.
     */
    public function crear()
    {
        $user = auth()->guard('usuariolog')->user();
        $roles = Rol::all();

        return view('usuarios.crear', compact('roles', 'user'));
    }

    /* ============================================================
       💾 GUARDAR NUEVO USUARIO
    ============================================================ */

    /**
     * Guarda un nuevo usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos del formulario y crea un nuevo registro en la tabla `usuario`.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NombreUsuario' => 'required|string|max:50',
            'ApellidoUsuario' => 'required|string|max:50',
            'Email' => 'required|email|max:100|unique:usuario,Email',
            'Celular' => 'required|string|max:15',
            'IdRol' => 'required|integer',
        ]);

        $usuario = new Usuario();
        $usuario->NombreUsuario = $request->NombreUsuario;
        $usuario->ApellidoUsuario = $request->ApellidoUsuario;
        $usuario->Email = $request->Email;
        $usuario->Celular = $request->Celular;
        $usuario->IdRol = $request->IdRol;
        $usuario->Estado = 1; // Activo por defecto
        $usuario->save();

        return redirect()->route('usuarios.leer')->with('success', 'Usuario creado correctamente');
    }

    /* ============================================================
       📋 LISTAR Y FILTRAR USUARIOS
    ============================================================ */

    /**
     * Muestra la lista de usuarios registrados con opciones de búsqueda y ordenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     *
     * Permite filtrar usuarios por nombre, apellido, correo o número de celular.
     * Incluye paginación y orden dinámico de columnas.
     */
    public function leer(Request $request)
    {
        $query = Usuario::with('rol');

        // 🔍 Filtros de búsqueda
        if ($request->has('buscar') && !empty($request->buscar)) {
            $termino = '%' . $request->buscar . '%';
            $query->where(function ($q) use ($termino) {
                $q->where('NombreUsuario', 'like', $termino)
                  ->orWhere('ApellidoUsuario', 'like', $termino)
                  ->orWhere('Email', 'like', $termino)
                  ->orWhere('Celular', 'like', $termino);
            });
        }

        // 🔄 Orden dinámico
        $sortBy = $request->get('sort_by', 'NombreUsuario');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // 📄 Paginación
        $usuarios = $query->paginate(15);

        return view('usuarios.leer', [
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
     * Muestra el formulario para editar un usuario existente.
     *
     * @param  int  $idUsuario
     * @return \Illuminate\View\View
     */
    public function edit($idUsuario)
    {
        $usuario = Usuario::findOrFail($idUsuario);
        $roles = Rol::all();

        return view('usuarios.actualizar', compact('usuario', 'roles'));
    }

    /* ============================================================
       🔁 ACTUALIZAR USUARIO
    ============================================================ */

    /**
     * Actualiza la información de un usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idUsuario
     * @return \Illuminate\Http\RedirectResponse
     *
     * Si el campo `Contrasena` está lleno, se actualiza y se encripta.
     */
    public function update(Request $request, $idUsuario)
    {
        $request->validate([
            'NombreUsuario' => 'required|string|max:50',
            'ApellidoUsuario' => 'required|string|max:50',
            'Email' => 'required|email|max:100|unique:usuario,Email,' . $idUsuario . ',IdUsuario',
            'Celular' => 'required|string|max:15',
            'IdRol' => 'required|integer',
            'Estado' => 'required|boolean',
        ]);

        $usuario = Usuario::findOrFail($idUsuario);
        $usuario->NombreUsuario = $request->NombreUsuario;
        $usuario->ApellidoUsuario = $request->ApellidoUsuario;
        $usuario->Email = $request->Email;
        $usuario->Celular = $request->Celular;

        // 🔐 Actualización opcional de contraseña
        if ($request->filled('Contrasena')) {
            $usuario->Contrasena = bcrypt($request->Contrasena);
        }

        $usuario->IdRol = $request->IdRol;
        $usuario->Estado = $request->Estado;
        $usuario->save();

        return redirect()->route('usuarios.leer')->with('success', 'Usuario actualizado correctamente');
    }

    /* ============================================================
       🔘 ACTIVAR / DESACTIVAR USUARIO
    ============================================================ */

    /**
     * Cambia el estado activo/inactivo de un usuario.
     *
     * @param  int  $idUsuario
     * @return \Illuminate\Http\RedirectResponse
     *
     * Alterna el estado del usuario entre activo (1) e inactivo (0)
     * sin eliminar el registro de la base de datos.
     */
    public function toggleEstado($idUsuario)
    {
        $usuario = Usuario::findOrFail($idUsuario);
        $usuario->Estado = !$usuario->Estado;
        $usuario->save();

        return redirect()->route('usuarios.leer')
            ->with('success', 'El estado del usuario se ha actualizado correctamente.');
    }
}
