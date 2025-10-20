<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barrio;
use App\Models\Sector;

/**
 * Controlador encargado de gestionar las operaciones CRUD de los barrios.
 *
 * Este controlador administra la creación, visualización, actualización
 * y eliminación de barrios, así como la asignación de sectores a cada uno.
 *
 * Funcionalidades principales:
 * - Crear nuevos barrios con relación a un sector.
 * - Listar y filtrar barrios existentes.
 * - Editar y actualizar la información de los barrios.
 * - Eliminar barrios del sistema.
 *
 * @package App\Http\Controllers
 */
class barrioController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo barrio.
     *
     * @return \Illuminate\View\View
     *
     * Carga todos los sectores existentes para mostrarlos en el campo select
     * del formulario de creación, permitiendo asignar un sector al barrio.
     */
    public function crear()
    {
        // 🧭 Obtener todos los sectores para el formulario
        $sectores = Sector::all();

        return view("barrios.crear", compact('sectores'));
    }

    /**
     * Guarda un nuevo barrio en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos ingresados, crea una nueva instancia del modelo `Barrio`
     * y la guarda en la base de datos. Redirige al formulario con un mensaje de éxito.
     */
    public function store(Request $request)
    {
        // ✅ Validación de los campos requeridos
        $request->validate([
            'NombreBarrio' => 'required|string|max:50',
            'IdSector' => 'required|exists:sector,IdSector',
        ]);

        // 🧩 Crear y guardar el nuevo registro
        $barrio = new Barrio();
        $barrio->NombreBarrio = $request->NombreBarrio;
        $barrio->IdSector = $request->IdSector;
        $barrio->save();

        return redirect('/barrios/crear')->with('success', 'Barrio creado correctamente');
    }

    /**
     * Muestra la lista de todos los barrios registrados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     *
     * Permite aplicar filtros de búsqueda por nombre y
     * muestra los resultados paginados junto con su sector asociado.
     */
    public function leer(Request $request)
    {
        // 🔍 Inicia la consulta incluyendo la relación con 'sector'
        $query = Barrio::with('sector');

        // ✅ Filtrado por nombre del barrio
        if ($request->filled('nombre')) {
            $query->where('NombreBarrio', 'like', '%' . $request->nombre . '%');
        }

        // 📑 Ordenar alfabéticamente y aplicar paginación
        $barrios = $query->orderBy('NombreBarrio', 'asc')
                         ->paginate(10)
                         ->appends($request->query());

        return view('barrios.leer', compact('barrios'));
    }

    /**
     * Muestra el formulario para editar un barrio existente.
     *
     * @param  int  $IdBarrio
     * @return \Illuminate\View\View
     *
     * Carga los datos actuales del barrio y los sectores disponibles
     * para permitir su modificación.
     */
    public function edit($IdBarrio)
    {
        $barrio = Barrio::findOrFail($IdBarrio);
        $sectores = Sector::all();

        return view('barrios.actualizar', compact('barrio', 'sectores'));
    }

    /**
     * Actualiza la información de un barrio en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdBarrio
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos enviados y actualiza los registros existentes
     * del modelo `Barrio`. Luego redirige al listado con mensaje de éxito.
     */
    public function update(Request $request, $IdBarrio)
    {
        $request->validate([
            'NombreBarrio' => 'required|string|max:50',
            'IdSector' => 'required|exists:sector,IdSector',
        ]);

        $barrio = Barrio::findOrFail($IdBarrio);
        $barrio->NombreBarrio = $request->NombreBarrio;
        $barrio->IdSector = $request->IdSector;
        $barrio->save();

        return redirect()->route('barrios.leer')->with('success', 'Barrio actualizado correctamente');
    }

    /**
     * Elimina un barrio del sistema.
     *
     * @param  int  $IdBarrio
     * @return \Illuminate\Http\RedirectResponse
     *
     * Busca el barrio por ID y lo elimina permanentemente de la base de datos.
     * Retorna una redirección al listado con confirmación de eliminación.
     */
    public function destroy($IdBarrio)
    {
        $barrio = Barrio::findOrFail($IdBarrio);
        $barrio->delete();

        return redirect()->route('barrios.leer')->with('success', 'Barrio eliminado correctamente');
    }
}
