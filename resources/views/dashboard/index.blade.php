@extends('layouts.app')

@section('content')
<main>
    <div class="container-fluid">
        <h1 class="mb-4 text-center text-md-start">📊 Dashboard de Gestión</h1>
        <hr>

        {{-- 🔹 Tarjetas de resumen --}}
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 border-warning border-3 text-center">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Reclamos Pendientes</h5>
                        <p class="card-text fs-2 fw-bold text-warning">{{ $pendientes }}</p>
                        <i class="bi bi-exclamation-triangle-fill fs-1 text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 border-info border-3 text-center">
                    <div class="card-body">
                        <h5 class="card-title text-muted">En Proceso</h5>
                        <p class="card-text fs-2 fw-bold text-info">{{ $enProceso }}</p>
                        <i class="bi bi-clock-fill fs-1 text-info"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 border-success border-3 text-center">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Reclamos Resueltos</h5>
                        <p class="card-text fs-2 fw-bold text-success">{{ $resueltos }}</p>
                        <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 border-primary border-3 text-center">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Total de Reclamos</h5>
                        <p class="card-text fs-2 fw-bold text-primary">{{ $total }}</p>
                        <i class="bi bi-clipboard-check-fill fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 📊 Gráfico + Últimos Reclamos --}}
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-secondary text-white">
                        Distribución de Reclamos por Categoría
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-secondary text-white">
                        Últimos Reclamos Registrados
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Codigo Seguimiento</th>
                                        <th>Abonado</th>
                                        <th>Categoría</th>
                                        <th>Estado</th>
                                        <th>Fecha Inicial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimosReclamos as $r)
                                        <tr>
                                            <td>{{ $r->CodigoSeguimiento }}</td>
                                            <td>{{ $r->abonado->NombreAbonado ?? 'No asignado' }}</td>
                                            <td>{{ $r->categoria->Nombre ?? 'Sin categoría' }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($r->EstadoReclamo == 'Pendiente') bg-warning
                                                    @elseif($r->EstadoReclamo == 'En Proceso') bg-info
                                                    @elseif($r->EstadoReclamo == 'Resuelto') bg-success
                                                    @else bg-secondary @endif">
                                                    {{ $r->EstadoReclamo ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ $r->FechaInicial ? date('d/m/Y', strtotime($r->FechaInicial)) : 'Sin fecha' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-muted">No hay reclamos recientes.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    data: @json($chartData),
                    backgroundColor: [
                        '#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6610f2'
                    ],
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
</main>
@endsection
