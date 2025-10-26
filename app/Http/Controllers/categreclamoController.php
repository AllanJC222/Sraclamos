<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaReclamo;

/**
 * Controlador encargado de gestionar las categorías de reclamos.
 *
 * Este controlador administra las operaciones CRUD sobre las categorías de reclamos,
 * permitiendo crear, visualizar, actualizar y eliminar categorías desde el panel de administración.
 *
 * Funcionalidades principales:
 * - Crear nuevas categorías.
 * - Listar todas las categorías existentes.
 * - Editar y actualizar información de categorías.
 * - Eliminar categorías del sistema.
 *
 * @package App\Http\Controllers
 */
class categreclamoController extends Controller
{
    /**
     * Muestra el formulario para crear una nueva categoría de reclamo.
     *
     * @return \Illuminate\View\View
     *
     * Obtiene el usuario autenticado del guard `usuariolog` y lo envía a la vista
     * para mostrar quién está realizando la acción.
     */
    public function crear()
    {
        $user = auth()->guard('usuariolog')->user();
        return view("categoria.crear", compact('user'));
    }

    /**
     * Guarda una nueva categoría de reclamo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos del formulario y crea una nueva instancia de `CategoriaReclamo`.
     * Si la validación es exitosa, se guarda el registro y se redirige con un mensaje de confirmación.
     */
    public function store(Request $request)
    {
        // ✅ Validación de campos
        $request->validate([
            'Nombre' => 'required|string|max:50',
        ]);

        // 🧩 Creación y guardado del registro
        $categoria = new CategoriaReclamo();
        $categoria->Nombre = $request->Nombre;
        $categoria->save();

        return redirect('/categoria/crear')->with('success', 'Categoría creada correctamente');
    }

    /**
     * Muestra la lista completa de categorías de reclamos registradas.
     *
     * @return \Illuminate\View\View
     *
     * Recupera todas las categorías existentes desde la base de datos
     * y las envía a la vista `categoria.leer` para ser listadas.
     */
    public function leer()
    {
        $categorias = CategoriaReclamo::all();

        return view('categoria.leer', compact('categorias'));
    }

    /**
     * Muestra el formulario de edición para una categoría específica.
     *
     * @param  int  $IdCategoria
     * @return \Illuminate\View\View
     *
     * Busca la categoría por su ID y carga la vista de actualización con sus datos.
     */
    public function edit($IdCategoria)
    {
        $categoria = CategoriaReclamo::findOrFail($IdCategoria);

        return view('categoria.actualizar', compact('categoria'));
    }

    /**
     * Actualiza los datos de una categoría existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdCategoria
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida la información enviada desde el formulario y actualiza los campos del modelo `CategoriaReclamo`.
     * Al finalizar, redirige al listado de categorías con un mensaje de éxito.
     */
    public function update(Request $request, $IdCategoria)
    {
        $request->validate([
            'Nombre' => 'required|string|max:50',
        ]);

        $categoria = CategoriaReclamo::findOrFail($IdCategoria);
        $categoria->Nombre = $request->Nombre;
        $categoria->save();

        return redirect()->route('categoria.leer')->with('success', 'Categoría actualizada correctamente');
    }

    /**
     * Elimina una categoría de reclamo de la base de datos.
     *
     * @param  int  $IdCategoria
     * @return \Illuminate\Http\RedirectResponse
     *
     * Busca la categoría por su ID y la elimina definitivamente.
     * Luego redirige al listado con un mensaje de confirmación.
     */
    public function destroy($IdCategoria)
    {
        $categoria = CategoriaReclamo::findOrFail($IdCategoria);
        $categoria->delete();

        return redirect()->route('categoria.leer')->with('success', 'Categoría eliminada correctamente');
    }
}
