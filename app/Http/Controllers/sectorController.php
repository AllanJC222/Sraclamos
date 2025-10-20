<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;

/**
 * Controlador encargado de la gestión de sectores.
 *
 * Este controlador administra las operaciones CRUD sobre los sectores,
 * permitiendo crear, listar, actualizar y eliminar registros.
 *
 * Cada sector representa una división geográfica o administrativa
 * dentro del sistema, la cual puede estar relacionada con abonados
 * o reclamos.
 *
 * Funcionalidades principales:
 * - Crear nuevos sectores.
 * - Listar todos los sectores registrados.
 * - Editar y actualizar sectores existentes.
 * - Eliminar sectores.
 *
 * @package App\Http\Controllers
 */
class sectorController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo sector.
     *
     * @return \Illuminate\View\View
     *
     * Carga la vista `sectores.crear` para registrar un nuevo sector.
     */
    public function crear()
    {
        return view("sectores.crear");
    }

    /**
     * Guarda un nuevo sector en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos enviados desde el formulario y crea un nuevo
     * registro en la tabla `sector`.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NombreSector' => 'required|string|max:50',
        ]);

        $sector = new Sector();
        $sector->NombreSector = $request->NombreSector;
        $sector->save();

        return redirect('/sectores/crear')->with('success', 'Sector creado correctamente');
    }

    /**
     * Muestra la lista de todos los sectores registrados.
     *
     * @return \Illuminate\View\View
     *
     * Obtiene todos los sectores desde la base de datos y los envía
     * a la vista `sectores.leer` para su visualización.
     */
    public function leer()
    {
        $sectores = Sector::all();
        return view('sectores.leer', compact('sectores'));
    }

    /**
     * Muestra el formulario para editar un sector existente.
     *
     * @param  int  $IdSector
     * @return \Illuminate\View\View
     *
     * Busca el sector correspondiente al ID proporcionado y carga la
     * vista `sectores.actualizar` con sus datos.
     */
    public function edit($IdSector)
    {
        $sector = Sector::findOrFail($IdSector);
        return view('sectores.actualizar', compact('sector'));
    }

    /**
     * Actualiza los datos de un sector existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdSector
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida la información enviada desde el formulario de edición,
     * actualiza el nombre del sector y guarda los cambios en la base de datos.
     */
    public function update(Request $request, $IdSector)
    {
        $request->validate([
            'NombreSector' => 'required|string|max:50',
        ]);

        $sector = Sector::findOrFail($IdSector);
        $sector->NombreSector = $request->NombreSector;
        $sector->save();

        return redirect()->route('sectores.leer')->with('success', 'Sector actualizado correctamente');
    }

    /**
     * Elimina un sector de la base de datos.
     *
     * @param  int  $IdSector
     * @return \Illuminate\Http\RedirectResponse
     *
     * Busca el sector por ID y lo elimina permanentemente.
     * Luego redirige al listado con un mensaje de confirmación.
     */
    public function destroy($IdSector)
    {
        $sector = Sector::findOrFail($IdSector);
        $sector->delete();

        return redirect()->route('sectores.leer')->with('success', 'Sector eliminado correctamente');
    }
}
