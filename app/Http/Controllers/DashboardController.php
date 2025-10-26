<?php

namespace App\Http\Controllers;

use App\Models\Reclamo;
use App\Models\CategoriaReclamo;
use Illuminate\Support\Facades\DB;

/**
 * Controlador del Panel Principal (DashboardController)
 *
 * Este controlador se encarga de reunir y procesar la información estadística
 * para el panel principal del sistema de reclamos, incluyendo:
 * - Totales por estado de reclamo.
 * - Distribución de reclamos por categoría.
 * - Últimos reclamos registrados.
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Muestra la vista principal del panel de control (dashboard).
     *
     * Este método realiza varias consultas a la base de datos:
     * 1. Calcula los totales de reclamos por estado (Pendiente, En Proceso, Resuelto).
     * 2. Genera la distribución de reclamos por categoría para gráficos estadísticos.
     * 3. Obtiene los últimos 15 reclamos registrados con sus relaciones.
     *
     * Finalmente, envía toda la información a la vista `dashboard.index`.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1️⃣ Totales por estado de reclamo
        $pendientes = Reclamo::where('EstadoReclamo', 'Pendiente')->count();
        $enProceso  = Reclamo::where('EstadoReclamo', 'En Proceso')->count();
        $resueltos  = Reclamo::where('EstadoReclamo', 'Resuelto')->count();
        $total      = Reclamo::count();

        // 2️⃣ Distribución de reclamos por categoría
        // Se realiza un LEFT JOIN entre la tabla de categorías y reclamos
        // para contar cuántos reclamos pertenecen a cada categoría, incluso
        // si alguna categoría aún no tiene reclamos.
        $categorias = CategoriaReclamo::select(
                'categoriareclamo.Nombre',
                DB::raw('COUNT(reclamos.IdReclamo) as total')
            )
            ->leftJoin('reclamos', 'categoriareclamo.IdCategoria', '=', 'reclamos.IdCategoria')
            ->groupBy('categoriareclamo.Nombre')
            ->get();

        // Datos para gráficos (Chart.js o similar)
        $chartLabels = $categorias->pluck('Nombre');
        $chartData   = $categorias->pluck('total');

        // 3️⃣ Últimos 15 reclamos registrados
        // Se incluyen las relaciones con 'abonado' y 'categoria' para mostrar información contextual
        $ultimosReclamos = Reclamo::with(['abonado', 'categoria'])
            ->orderBy('IdReclamo', 'desc')
            ->take(15)
            ->get();

        // 4️⃣ Enviar datos a la vista del Dashboard
        return view('dashboard.index', compact(
            'pendientes',
            'enProceso',
            'resueltos',
            'total',
            'chartLabels',
            'chartData',
            'ultimosReclamos'
        ));
    }
}
