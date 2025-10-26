<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Abonado;
use App\Models\Sector;

/**
 * Controlador que gestiona todas las operaciones relacionadas con los abonados.
 *
 * Incluye funcionalidades para:
 * - Crear nuevos abonados.
 * - Listar, buscar y paginar abonados.
 * - Editar y actualizar registros existentes.
 * - Activar o desactivar abonados mediante cambio de estado.
 *
 * @package App\Http\Controllers
 */
class abonadoController extends Controller
{
    /**
     * Muestra el formulario para registrar un nuevo abonado.
     *
     * @return \Illuminate\View\View
     * Devuelve la vista `abonados.crear` con la lista de sectores disponibles.
     */
    public function crear()
    {
        // Obtener todos los sectores disponibles para el menú desplegable
        $sectores = Sector::all();

        return view('abonados.crear', compact('sectores'));
    }

    /**
     * Almacena un nuevo abonado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida los datos del formulario y crea un nuevo registro de abonado.
     * Si la validación falla, se redirige con mensajes de error.
     */
    public function store(Request $request)
    {
        
        // ✅ Validación de campos requeridos
        $request->validate([
            'ClaveCatastral' => 'required|string|max:20|unique:abonados,ClaveCatastral',
            'NoIdentidad' => ['required', 'regex:/^\d{4}-\d{4}-\d{5}$/', 'max:20',  'unique:abonados,NoIdentidad' ],
            'CodigoAbonado' => 'required|string|max:20|unique:abonados,CodigoAbonado',
            'NombreAbonado' => 'required|string|max:45',
            'UsoDeSuelo' => 'required|string|max:45',
            'TipoActividad' => 'required|string|max:45',
            'IdSector' => 'required|exists:sector,IdSector',
            'Direccion' => 'required|string|max:150',
            'Celular' => [
            'required',
            'regex:/^[0-9]{8}$/',     
            'unique:abonados,Celular' 
                ],
            'Estado' => 'required|boolean',
        ], [
            'NoIdentidad.regex' => 'El formato debe ser 0080-1234-56789 (4-4-5 dígitos).',
            'NoIdentidad.unique' => 'Ya existe un abonado con ese número de identidad.',
            'ClaveCatastral.unique' => 'Ya existe un abonado con esa clave catastral.',
            'CodigoAbonado.unique' => 'Ya existe un abonado con ese código.',
            'Celular.regex' => 'El número de celular debe contener exactamente 8 dígitos (sin guiones ni letras).',
            'Celular.unique' => 'Ya existe un abonado con ese número de celular.',
        ]);
        

 
        // 🧩 Creación del objeto y asignación de valores
        $abonado = new Abonado();
        $abonado->ClaveCatastral = $request->ClaveCatastral;
        $abonado->NoIdentidad = $request->NoIdentidad;
        $abonado->CodigoAbonado = $request->CodigoAbonado;
        $abonado->NombreAbonado = $request->NombreAbonado;
        $abonado->UsoDeSuelo = $request->UsoDeSuelo;
        $abonado->TipoActividad = $request->TipoActividad;
        $abonado->IdSector = $request->IdSector;
        $abonado->Direccion = $request->Direccion;
        $abonado->Celular = $request->Celular;
        $abonado->Estado = $request->Estado;
        $abonado->save();

        // 🚀 Redirige al formulario con mensaje de éxito
        return redirect('/abonados/leer')->with('success', 'Abonado creado correctamente');
    }

    /**
     * Muestra la lista de abonados con soporte de búsqueda, orden y paginación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     *
     * Permite filtrar por ClaveCatastral, NombreAbonado o CódigoAbonado.
     * También admite ordenamiento dinámico y mantiene el estado de la búsqueda.
     */
    public function leer(Request $request)
    {
        // 1️⃣ Inicia la consulta incluyendo la relación con el sector
        $query = Abonado::with('sector');

        // 2️⃣ Filtro de búsqueda (si se envía parámetro "buscar")
        if ($request->has('buscar') && !empty($request->buscar)) {
            $termino = '%' . $request->buscar . '%';
            $query->where(function($q) use ($termino) {
                $q->where('ClaveCatastral', 'like', $termino)
                  ->orWhere('NombreAbonado', 'like', $termino)
                  ->orWhere('CodigoAbonado', 'like', $termino);
            });
        }

        // 3️⃣ Orden dinámico (por columna y dirección)
        $sortBy = $request->get('sort_by', 'ClaveCatastral');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // 4️⃣ Paginación para rendimiento
        $abonados = $query->paginate(15);

        // 5️⃣ Retorna la vista con los datos filtrados y parámetros de estado
        return view('abonados.leer', [
            'abonados' => $abonados,
            'busqueda' => $request->buscar,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
        ]);
    }

    /**
     * Muestra el formulario para editar un abonado existente.
     *
     * @param  int  $IdAbonados
     * @return \Illuminate\View\View
     *
     * Busca el abonado por su ID y carga la lista de sectores para selección.
     */
    public function edit($IdAbonados)
    {
        $abonado = Abonado::findOrFail($IdAbonados);
        $sectores = Sector::all();

        return view('abonados.actualizar', compact('abonado', 'sectores'));
    }

    /**
     * Actualiza los datos de un abonado existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdAbonado
     * @return \Illuminate\Http\RedirectResponse
     *
     * Valida la información y actualiza los campos modificados.
     */
    public function update(Request $request, $IdAbonado)
    {
        $abonado = Abonado::findOrFail($IdAbonado);
        
          $request->validate([
             'ClaveCatastral' => [
            'required',
            'string',
            'max:20',
            Rule::unique('abonados', 'ClaveCatastral')->ignore($abonado->IdAbonado, 'IdAbonado'),
        ],
        'NoIdentidad' => [
            'required',
            'regex:/^\d{4}-\d{4}-\d{5}$/',
            'max:20',
            Rule::unique('abonados', 'NoIdentidad')->ignore($abonado->IdAbonado, 'IdAbonado'),
        ],
        'CodigoAbonado' => [
            'required',
            'string',
            'max:20',
            Rule::unique('abonados', 'CodigoAbonado')->ignore($abonado->IdAbonado, 'IdAbonado'),
        ],
            'NombreAbonado' => 'required|string|max:45',
            'UsoDeSuelo' => 'required|string|max:45',
            'TipoActividad' => 'required|string|max:45',
            'IdSector' => 'required|exists:sector,IdSector',
            'Direccion' => 'required|string|max:150',
            'Celular' => [
            'required',
            'regex:/^[0-9]{8}$/',
            Rule::unique('abonados', 'Celular')->ignore($abonado->IdAbonado, 'IdAbonado'),
            ],
            'Estado' => 'required|boolean',
        ], [
            'NoIdentidad.regex' => 'El formato debe ser 0080-1234-56789 (4-4-5 dígitos).',
            'NoIdentidad.unique' => 'Ya existe un abonado con ese número de identidad.',
            'ClaveCatastral.unique' => 'Ya existe un abonado con esa clave catastral.',
            'CodigoAbonado.unique' => 'Ya existe un abonado con ese código.',
            'Celular.regex' => 'El número de celular debe contener exactamente 8 dígitos (sin guiones ni letras).',
            'Celular.unique' => 'Ya existe un abonado con ese número de celular.',
        ]);

        // 🧾 Buscar y actualizar el abonado
        $abonado = Abonado::findOrFail($IdAbonado);
        $abonado->update([
            'ClaveCatastral' => $request->ClaveCatastral,
            'NoIdentidad' => $request->NoIdentidad,
            'CodigoAbonado' => $request->CodigoAbonado,
            'NombreAbonado' => $request->NombreAbonado,
            'UsoDeSuelo' => $request->UsoDeSuelo,
            'TipoActividad' => $request->TipoActividad,
            'IdSector' => $request->IdSector,
            'Direccion' => $request->Direccion,
            'Celular' => $request->Celular,
            'Estado' => $request->Estado,
        ]);

        return redirect()->route('abonados.leer')->with('success', 'Abonado actualizado correctamente.');
    }

    /**
     * Cambia el estado de un abonado (activo ↔ inactivo).
     *
     * @param  int  $IdAbonados
     * @return \Illuminate\Http\RedirectResponse
     *
     * Permite activar o desactivar abonados sin eliminarlos de la base de datos.
     */
    public function toggleEstado($IdAbonados)
    {
        // 🔄 Buscar el abonado por ID
        $abonado = Abonado::findOrFail($IdAbonados);

        // Cambiar el valor de estado (1 ↔ 0)
        $abonado->Estado = !$abonado->Estado;
        $abonado->save();

        return redirect()->route('abonados.leer')->with('success', 'El estado del abonado se ha actualizado correctamente.');
    }
}
