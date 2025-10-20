@extends('layouts.app')

@section('title', 'Lista de Barrios')

@section('content')
<div class="container">
    <h4 class="mb-4 text-primary fw-bold">Lista de Barrios</h4>

    {{-- ✅ Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 🔍 FILTRO DE BÚSQUEDA --}}
    <form method="GET" action="{{ route('barrios.leer') }}" class="card mb-4 shadow-sm p-3 border-0">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="nombre" class="form-label fw-semibold">Buscar por nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                       placeholder="Ej. Barrio San José"
                       value="{{ request('nombre') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('barrios.leer') }}" class="btn btn-secondary w-100">Limpiar</a>
            </div>
        </div>
    </form>

    {{-- 🔘 Botón para crear nuevo barrio --}}
    <div class="mb-3 text-end">
        <a href="{{ route('barrios.crear') }}" class="btn btn-primary">
            Nuevo Barrio
        </a>
    </div>

    {{-- 📋 Tabla de barrios --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Barrio</th>
                        <th>Sector</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barrios as $barrio)
                        <tr>
                            <td class="text-center">{{ $barrio->IdBarrio }}</td>
                            <td>{{ $barrio->NombreBarrio }}</td>
                            <td>{{ $barrio->sector->NombreSector ?? 'Sin sector' }}</td>
                            <td class="text-center">

                                {{-- Solo usuarios autenticados --}}
                                @if(auth('usuariolog')->check())
                                    {{-- Solo tipo 1 (Administrador) puede eliminar --}}
                                    @if(auth('usuariolog')->user()->user_tipo == '1')
                                        <a href="{{ route('barrios.edit', $barrio->IdBarrio) }}" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>
                                        <form action="{{ route('barrios.destroy', $barrio->IdBarrio) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Desea eliminar el barrio {{ $barrio->NombreBarrio }}?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('barrios.edit', $barrio->IdBarrio) }}" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>
                                        <span class="text-muted small d-block mt-1">Sin permiso para eliminar</span>
                                    @endif
                                @else
                                    <span class="text-muted small">Debe iniciar sesión</span>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay barrios registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📄 Paginación --}}
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="text-muted small mb-2">
            Mostrando <strong>{{ $barrios->firstItem() }}</strong> a 
            <strong>{{ $barrios->lastItem() }}</strong> 
            de <strong>{{ $barrios->total() }}</strong> barrios
        </div>
        <div>
            {{ $barrios->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
