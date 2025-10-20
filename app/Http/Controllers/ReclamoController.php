<?php

namespace App\Http\Controllers;

use App\Models\Reclamo;
use App\Models\CategoriaReclamo;
use App\Models\Abonado;
use App\Models\Sector;
use App\Models\Barrio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Exports\ReclamosExport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controlador principal del módulo de Reclamos.
 *
 * Gestiona tanto los reclamos internos (registrados por personal autorizado)
 * como los reclamos públicos (enviados por abonados). Contiene toda la lógica
 * necesaria para crear, listar, filtrar, exportar y consultar reclamos.
 *
 * Funcionalidades principales:
 * - CRUD completo de reclamos.
 * - Consulta de abonados por clave catastral.
 * - Formularios públicos e internos.
 * - Exportación a PDF y Excel.
 * - Seguimiento mediante código único.
 *
 * @package App\Http\Controllers
 */
class ReclamoController extends Controller
{
    /* ============================================================
       🔎 Buscar abonado por clave catastral (AJAX o formulario)
    ============================================================ */

    /**
     * Busca un abonado por su clave catastral.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Retorna los datos del abonado en formato JSON o un mensaje de error
     * si la clave no existe o no se envía correctamente.
     */
    public function getAbonadoByClaveCatastral(Request $request)
    {
        $clave = trim($request->query('clave_catastral', ''));

        if ($clave === '') {
            return response()->json(['message' => 'Debe enviar la clave catastral.'], 422);
        }

        $abonado = DB::table('abonados')
            ->join('sector', 'abonados.IdSector', '=', 'sector.IdSector')
            ->select(
                'abonados.IdAbonado',
                'abonados.NombreAbonado',
                'abonados.Celular',
                'abonados.IdSector',
                'sector.NombreSector'
            )
            ->where('abonados.ClaveCatastral', $clave)
            ->first();

        if (!$abonado) {
            return response()->json(['message' => 'No se encontró el abonado.'], 404);
        }

        return response()->json(['abonado' => $abonado], 200);
    }

    /* ============================================================
       📋 Listado de reclamos internos
    ============================================================ */

    /**
     * Muestra el listado de reclamos internos con filtros dinámicos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     *
     * Permite filtrar por categoría, abonado, operador, estado o código
     * de seguimiento. Los resultados incluyen relaciones para evitar N+1.
     */
    public function index(Request $request)
    {
        $query = Reclamo::with(['categoria', 'abonado', 'sector', 'barrio', 'operador']);

        // Aplicación de filtros según parámetros de búsqueda
        if ($request->filled('categoria')) {
            $query->where('IdCategoria', $request->categoria);
        }

        if ($request->filled('abonado')) {
            $query->whereHas('abonado', function ($q) use ($request) {
                $q->where('NombreAbonado', 'like', '%' . $request->abonado . '%');
            });
        }

        if ($request->filled('operador')) {
            $query->where('IdUsuarioOperador', $request->operador);
        }

        if ($request->filled('clave')) {
            $query->whereHas('abonado', function ($q) use ($request) {
                $q->where('ClaveCatastral', 'like', '%' . $request->clave . '%');
            });
        }

        if ($request->filled('codigo')) {
            $query->where('CodigoSeguimiento', 'like', '%' . $request->codigo . '%');
        }

        if ($request->filled('estado')) {
            $query->where('EstadoReclamo', $request->estado);
        }

        // Orden personalizado por estado
        $query->orderByRaw("
            CASE 
                WHEN EstadoReclamo = 'Pendiente' THEN 1
                WHEN EstadoReclamo = 'En Proceso' THEN 2
                WHEN EstadoReclamo = 'Resuelto' THEN 3
                ELSE 4
            END
        ")->orderByDesc('IdReclamo');

        $reclamos = $query->paginate(10)->appends($request->query());

        $categorias = CategoriaReclamo::orderBy('Nombre')->get();
        $operadores = Usuario::orderBy('NombreUsuario')->get();

        return view('reclamos.leer', compact('reclamos', 'categorias', 'operadores'));
    }

    /* ============================================================
       🆕 Formulario de creación interna (panel)
    ============================================================ */

    /**
     * Muestra el formulario interno para crear un reclamo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $categorias = CategoriaReclamo::orderBy('Nombre')->get();
        $sectores   = Sector::orderBy('NombreSector')->get();
        $barrios    = Barrio::orderBy('NombreBarrio')->get();
        $usuarios   = Usuario::where('Estado', 1)->orderBy('NombreUsuario')->get();

        $abonado = null;

        // Si se envía clave o nombre, busca coincidencia
        if ($request->filled('clave_catastral') || $request->filled('nombre_abonado')) {
            $query = Abonado::query();

            if ($request->filled('clave_catastral')) {
                $query->where('ClaveCatastral', $request->clave_catastral);
            }

            if ($request->filled('nombre_abonado')) {
                $query->where('NombreAbonado', 'like', '%' . $request->nombre_abonado . '%');
            }

            $abonado = $query->first();
        }

        return view('reclamos.crear', compact('categorias', 'sectores', 'barrios', 'usuarios', 'abonado'));
    }

    /* ============================================================
       💾 Guardar reclamo (interno o público)
    ============================================================ */

    /**
     * Guarda un reclamo en la base de datos (interno o público).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:255',
            'IdCategoria' => 'required|integer|exists:categoriareclamo,IdCategoria',
            'IdSector' => 'required|integer|exists:sector,IdSector',
            'IdBarrio' => 'required|integer|exists:barrio,IdBarrio',
            'IdAbonado' => 'required|integer|exists:abonados,IdAbonado',
            'CoordenadasUbicacion' => 'nullable|string|max:255',
            'ImagenEvidencia' => 'nullable|image|max:2048',
        ]);

        $reclamo = new Reclamo();
        $reclamo->Descripcion = $request->Descripcion;
        $reclamo->Comentario = $request->Comentario;
        $reclamo->IdCategoria = $request->IdCategoria;
        $reclamo->IdSector = $request->IdSector;
        $reclamo->IdBarrio = $request->IdBarrio;
        $reclamo->IdAbonado = $request->IdAbonado;
        $reclamo->CoordenadasUbicacion = $request->CoordenadasUbicacion;
        $reclamo->EstadoReclamo = 'Pendiente';
        $reclamo->CodigoSeguimiento = strtoupper(Str::random(10));

        $reclamo->IdUsuarioOperador = auth('usuariolog')->check()
            ? ($request->IdUsuarioOperador ?? null)
            : null;

        if ($request->hasFile('ImagenEvidencia')) {
            $reclamo->ImagenEvidencia = file_get_contents($request->file('ImagenEvidencia')->getRealPath());
        }

        $reclamo->save();

        return auth('usuariolog')->check()
            ? redirect()->route('reclamos.leer')->with('success', 'Reclamo guardado correctamente.')
            : redirect()->route('reclamos.publico.gracias', ['codigo' => $reclamo->CodigoSeguimiento])
                        ->with('success', 'Reclamo enviado correctamente.');
    }

    /* ============================================================
       📄 Detalle del reclamo (interno)
    ============================================================ */

    /**
     * Muestra el detalle completo de un reclamo específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $reclamo = Reclamo::with(['categoria', 'abonado.sector', 'sector', 'barrio', 'operador.rol'])
            ->findOrFail($id);

        return view('reclamos.show', compact('reclamo'));
    }

    /* ============================================================
       🧾 Exportar PDF (informe individual)
    ============================================================ */

    /**
     * Genera un informe PDF del reclamo seleccionado.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPDF($id)
    {
        $reclamo = Reclamo::with(['categoria', 'abonado', 'sector', 'barrio', 'operador.rol'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('reclamos.reporte_pdf', compact('reclamo'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Reclamo_' . $reclamo->IdReclamo . '.pdf');
    }

    /* ============================================================
       🌐 Formulario público
    ============================================================ */

    /**
     * Muestra el formulario público para envío de reclamos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    /*
    public function publicCreate(Request $request)
    {
        $categorias = CategoriaReclamo::orderBy('Nombre')->get();
        $sectores   = Sector::orderBy('NombreSector')->get();
        $barrios    = Barrio::orderBy('NombreBarrio')->get();

        $abonado = null;

        if ($request->filled('clave_catastral')) {
            $abonado = Abonado::where('ClaveCatastral', $request->clave_catastral)->first();
        }

        return view('reclamos.publico_crear', compact('categorias', 'sectores', 'barrios', 'abonado'));
    }
        */

    public function publicCreate(Request $request)
    {
        $categorias = CategoriaReclamo::orderBy('Nombre')->get();
        $sectores   = Sector::orderBy('NombreSector')->get();
        $barrios    = Barrio::orderBy('NombreBarrio')->get();

        $abonado = null;
        //se manejara un solo mensaje de error
        $mensaje = null;

        // verifica si el usuario presionó buscar
        if ($request->has('clave_catastral')) {

            $clave = trim($request->clave_catastral);

            // caso 1: campo vacío o solo espacios
            if ($clave === '') {
                $mensaje = [
                    'tipo' => 'warning',
                    'texto' => 'Debes escribir algo para hacer la búsqueda.'
                ];
            }
            // caso 2: buscar abonado
            else {
                $abonado = Abonado::where('ClaveCatastral', $clave)->first();

            // caso 3: no se encontró el abonado antes entonces
                if (!$abonado) {
                    $mensaje = [
                        'tipo' => 'warning',
                        'texto' => 'No se encontró ningún abonado con la clave catastral ingresada.'
                    ];
                }
            }
        }

        return view('reclamos.publico_crear', compact('categorias', 'sectores', 'barrios', 'abonado', 'mensaje'));
    }


    /* ============================================================
       🌐 Guardar reclamo público
    ============================================================ */

    /**
     * Guarda un reclamo enviado desde el formulario público.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publicStore(Request $request)
    {
        return $this->store($request);
    }

    /* ============================================================
       🙌 Página de agradecimiento
    ============================================================ */

    /**
     * Muestra la página de agradecimiento tras enviar un reclamo público.
     *
     * @param  string  $codigo
     * @return \Illuminate\View\View
     */
    public function gracias($codigo)
    {
        return view('reclamos.publico_gracias', compact('codigo'));
    }

    /* ============================================================
       🔍 Consulta pública por código de seguimiento
    ============================================================ */

    /**
     * Muestra el formulario para consultar el estado de un reclamo.
     *
     * @return \Illuminate\View\View
     */
    public function consulta()
    {
        return view('reclamos.publico_consulta');
    }

    /**
     * Consulta el estado de un reclamo público por su código.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function consultar(Request $request)
    {
        $reclamo = Reclamo::with(['operador', 'categoria', 'abonado'])
            ->where('CodigoSeguimiento', $request->codigo)
            ->first();

        return view('reclamos.publico_consulta', compact('reclamo'));
    }

    /* ============================================================
       ✏️ Editar y actualizar reclamo
    ============================================================ */

    /**
     * Muestra el formulario para editar un reclamo.
     */
    public function edit($id)
    {
        $reclamo = Reclamo::findOrFail($id);
        $categorias = CategoriaReclamo::orderBy('Nombre')->get();
        $sectores = Sector::orderBy('NombreSector')->get();
        $barrios = Barrio::orderBy('NombreBarrio')->get();
        $usuarios = Usuario::where('Estado', 1)->orderBy('NombreUsuario')->get();

        return view('reclamos.editar', compact('reclamo', 'categorias', 'sectores', 'barrios', 'usuarios'));
    }

    /**
     * Actualiza los datos de un reclamo existente.
     */
    public function update(Request $request, $id)
    {
        $reclamo = Reclamo::findOrFail($id);

        $request->validate([
            'Descripcion' => 'required|string',
            'IdCategoria' => 'required|integer',
            'IdSector' => 'required|integer',
            'IdBarrio' => 'required|integer',
            'EstadoReclamo' => 'required|string',
            'IdUsuarioOperador' => 'nullable|integer'
        ]);

        $reclamo->update([
            'Descripcion' => $request->Descripcion,
            'Comentario' => $request->Comentario,
            'IdCategoria' => $request->IdCategoria,
            'IdSector' => $request->IdSector,
            'IdBarrio' => $request->IdBarrio,
            'IdUsuarioOperador' => $request->IdUsuarioOperador,
            'EstadoReclamo' => $request->EstadoReclamo
        ]);

        return redirect()->route('reclamos.leer')
                        ->with('success', '✅ Reclamo actualizado correctamente.');
    }

    /* ============================================================
       🗑️ Eliminar reclamo
    ============================================================ */

    /**
     * Elimina un reclamo del sistema.
     */
    public function destroy($id)
    {
        $reclamo = Reclamo::findOrFail($id);
        $reclamo->delete();

        return redirect()->route('reclamos.leer')->with('success', 'Reclamo eliminado correctamente.');
    }

    /* ============================================================
       📤 Exportar Reclamos a Excel
    ============================================================ */

    /**
     * Exporta todos los reclamos a un archivo Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel()
    {
        $fileName = 'Reclamos_' . date('Y-m-d_His') . '.xlsx';
        return Excel::download(new ReclamosExport, $fileName);
    }
}
