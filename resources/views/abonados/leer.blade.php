@extends('layouts.app')

@section('title', 'Lista de Abonados')

@section('content')
<div class="container">
    <h4 class="mb-4 fw-bold text-primary">
        📘 Lista de Abonados
    </h4>

    {{-- 🔍 Filtros de búsqueda --}}
    <form action="{{ route('abonados.leer') }}" method="GET" class="card shadow-sm border-0 p-3 mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-9">
                <input type="text" name="buscar" class="form-control form-control-lg"
                       placeholder="Buscar por Clave, Nombre o Código"
                       value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <a href="{{ route('abonados.leer') }}" class="btn btn-secondary btn-lg flex-fill">
                    <i class="bi bi-x-circle"></i> Limpiar
                </a>
            </div>
        </div>
    </form>

    {{-- ✅ Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success text-center fw-semibold" id="success-message">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('success-message');
                if (msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @endif

    {{-- 📋 Tabla de abonados --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered align-middle mb-0 text-center">
                <thead >
                    <tr>
                        <th>ID</th>
                        <th>Clave Catastral</th>
                        <th>No. Identidad</th>
                        <th>Código Abonado</th>
                        <th>Nombre</th>
                        <th>Sector</th>
                        <th>Dirección</th>
                        <th>Celular</th>
                        <th>Estado</th>
                        <th>Uso de Suelo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($abonados as $abonado)
                        {{-- 🎨 Colores alternos según estado --}}
                        <tr class="{{ $abonado->Estado ? 'table-info' : 'table-warning' }}">
                            <td>{{ $abonado->IdAbonado }}</td>
                            <td><span class="fw-semibold">{{ $abonado->ClaveCatastral }}</span></td>
                            <td>{{ $abonado->NoIdentidad }}</td>
                            <td><code>{{ $abonado->CodigoAbonado }}</code></td>
                            <td>{{ $abonado->NombreAbonado }}</td>
                            <td>{{ $abonado->sector->NombreSector ?? 'Sin sector' }}</td>
                            <td class="text-start">{{ $abonado->Direccion }}</td>
                            <td>{{ $abonado->Celular }}</td>
                            <td>
                                <span class="badge {{ $abonado->Estado ? 'bg-success' : 'bg-danger' }}">
                                    {{ $abonado->Estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>{{ $abonado->UsoDeSuelo }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('abonados.edit', ['IdAbonado' => $abonado->IdAbonado]) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi"></i> Editar
                                    </a>
                                   
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-muted py-3 text-center">
                                No se encontraron abonados registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📄 Paginación --}}
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="text-muted small mb-2">
            Mostrando <strong>{{ $abonados->firstItem() }}</strong> a
            <strong>{{ $abonados->lastItem() }}</strong>
            de <strong>{{ $abonados->total() }}</strong> abonados
        </div>
        <div>
            {{ $abonados->appends(['buscar' => request('buscar')])->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- 🎨 Estilos personalizados para igualar a Reclamos --}}
<style>
    .table th, .table td {
        padding: 0.8rem 1rem !important;
        vertical-align: middle !important;
    }

    .table-hover tbody tr:hover {
        background-color: #f6f9ff !important;
    }

    .table-info {
        background-color: #d9f2ff !important;
    }

    .table-warning {
        background-color: #fff3cd !important;
    }

    .btn-sm {
        font-size: 0.85rem;
        padding: 0.3rem 0.75rem;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.45em 0.6em;
    }

    .card {
        border-radius: 10px;
    }

    input.form-control-lg {
        height: calc(2.5rem + 2px);
        font-size: 1rem;
    }
</style>
@endsection
