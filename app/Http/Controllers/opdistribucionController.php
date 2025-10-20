<?php

namespace App\Http\Controllers;

use App\Models\OperadorDistribucion;
use App\Models\Usuario;
use App\Models\Sector;
use Illuminate\Http\Request;

/**
 * Controlador encargado de gestionar las operaciones del módulo
 * de **Operadores de Distribución**.
 *
 * Este controlador maneja todas las operaciones CRUD y de gestión del
 * registro de operadores asignados a sectores, incluyendo su horario
 * de trabajo, estado y relación con los usuarios del sistema.
 *
 * Funcionalidades principales:
 * - Crear nuevas distribuciones.
 * - Listar y filtrar distribuciones existentes.
 * - Editar y actualizar registros.
 * - Activar/inactivar distribuciones.
 * - Eliminar registros.
 *
 * @package App\Http\Controllers
 */
class opdistribucionController extends Controller
{
    /**
     * Muestra el formulario para crear una nueva distribución.
     *
     * @return \Illuminate\View\View
     *
     * Carga todos los usuarios (operadores) y sectores existentes para
     * permitir la asignación de un operador a un sector específico.
     */
    public function crear()
    {
        $operadores = Usuario::all(); 
        $sectores = Sector::all();

        return view('distribucion.crear', compact('operadores', 'sectores'));
    }

    /**
     * Guarda una nueva distribución en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos ingresados y crea un nuevo registro de distribución,
     * incluyendo las fechas de inicio y fin, el operador asignado y el sector.
     */
    public function store(Request $request)
    {
        $request->validate([
            'HoraInicio' => 'required|date_format:Y-m-d\TH:i',
            'HoraFinal' => 'required|date_format:Y-m-d\TH:i|after_or_equal:HoraInicio',
            'IdUsuarioOperador' => 'required|integer|exists:usuario,IdUsuario', 
            'IdSector' => 'required|integer|exists:sector,IdSector',
        ]);

        OperadorDistribucion::create([
            'HoraInicio' => $request->HoraInicio,
            'HoraFinal' => $request->HoraFinal,
            'IdUsuarioOperador' => $request->IdUsuarioOperador, 
            'IdSector' => $request->IdSector,
            'Estado' => 1, // Activo por defecto
        ]);

        return redirect()->route('distribucion.index')->with('success', 'Distribución creada correctamente.');
    }

    /**
     * Muestra la lista de todas las distribuciones registradas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     *
     * Permite aplicar filtros por operador y sector. Carga las relaciones
     * con el modelo `Usuario` (operador) y `Sector` para mostrar información
     * contextual en la vista.
     */
    public function index(Request $request)
    {
        $operadores = Usuario::all(); 
        $sectores = Sector::all();

        // 🔗 Se incluyen las relaciones con usuario y sector
        $query = OperadorDistribucion::with(['usuarioOperador', 'sector']); 

        // 🎯 Filtro por operador
        if ($request->filled('operador')) {
            $query->where('IdUsuarioOperador', $request->operador); 
        }

        // 🎯 Filtro por sector
        if ($request->filled('sector')) {
            $query->where('IdSector', $request->sector);
        }

        // 📋 Obtener resultados
        $distribuciones = $query->get();

        return view('distribucion.leer', compact('distribuciones', 'operadores', 'sectores'));
    }

    /**
     * Muestra el formulario para editar una distribución existente.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     *
     * Busca la distribución por su ID y carga los datos junto con la lista
     * completa de operadores y sectores para su actualización.
     */
    public function edit($id)
    {
        $distribucion = OperadorDistribucion::findOrFail($id);
        $operadores = Usuario::all(); 
        $sectores = Sector::all();

        return view('distribucion.actualizar', compact('distribucion', 'operadores', 'sectores'));
    }

    /**
     * Actualiza la información de una distribución existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos y actualiza el registro con los nuevos valores,
     * incluyendo horarios, operador, sector y estado.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'HoraInicio' => 'required|date_format:Y-m-d\TH:i', 
            'HoraFinal' => 'required|date_format:Y-m-d\TH:i|after_or_equal:HoraInicio',
            'IdUsuarioOperador' => 'required|integer|exists:usuario,IdUsuario', 
            'IdSector' => 'required|integer|exists:sector,IdSector',
            'Estado' => 'required|boolean',
        ]);

        $distribucion = OperadorDistribucion::findOrFail($id);
        $distribucion->HoraInicio = $request->HoraInicio;
        $distribucion->HoraFinal = $request->HoraFinal;
        $distribucion->IdUsuarioOperador = $request->IdUsuarioOperador; 
        $distribucion->IdSector = $request->IdSector;
        $distribucion->Estado = $request->Estado;
        $distribucion->save();

        return redirect()->route('distribucion.index')->with('success', 'Distribución actualizada correctamente.');
    }

    /**
     * Cambia el estado (activo/inactivo) de una distribución.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Alterna el estado del registro entre activo (1) e inactivo (0)
     * sin eliminarlo físicamente de la base de datos.
     */
    public function toggleEstado($id)
    {
        $distribucion = OperadorDistribucion::findOrFail($id);
        $distribucion->Estado = !$distribucion->Estado;
        $distribucion->save();

        return redirect()->route('distribucion.index')->with('success', 'Estado de la distribución actualizado correctamente.');
    }

    /**
     * Elimina una distribución de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Elimina de forma permanente la distribución seleccionada y redirige
     * al listado principal con un mensaje de confirmación.
     */
    public function destroy($id)
    {
        $distribucion = OperadorDistribucion::findOrFail($id);
        $distribucion->delete();

        return redirect()->route('distribucion.index')->with('success', 'Distribución eliminada correctamente.');
    }
}
