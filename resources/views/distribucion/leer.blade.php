@extends('layouts.app')

@section('content')
<h3>Listado de Distribuciones</h3>

<div class="mb-3">
    <a href="{{ route('distribucion.crear') }}" class="btn btn-primary">Crear Nueva Distribución</a>
</div>

{{-- Formulario de búsqueda (Correcto) --}}
<form action="{{ route('distribucion.index') }}" method="GET" class="mb-3">
    <div class="row g-2">
        <div class="col-md-4">
            {{-- Los filtros están bien, ya que el controlador les provee los datos --}}
            <select name="operador" class="form-control">
                <option value="">Todos los Operadores</option>
                @foreach($operadores as $operador)
                    {{-- Nota: Cuidado con el casing de la clave. Asumimos que es 'IdUsuario' --}}
                    <option value="{{ $operador->IdUsuario }}" {{ request('operador') == $operador->IdUsuario ? 'selected' : '' }}>
                        {{ $operador->NombreUsuario }} {{ $operador->ApellidoUsuario }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="sector" class="form-control">
                <option value="">Todos los Sectores</option>
                @foreach($sectores as $sector)
                    <option value="{{ $sector->IdSector }}" {{ request('sector') == $sector->IdSector ? 'selected' : '' }}>
                        {{ $sector->NombreSector }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-outline-secondary">Filtrar</button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Hora Inicio</th>
            <th>Hora Final</th>
            <th>Operador</th>
            <th>Sector</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($distribuciones as $dist)
        <tr>
            <td>{{ $dist->IdOperadorDistribucion }}</td>
            <td>{{ $dist->HoraInicio }}</td>
            <td>{{ $dist->HoraFinal }}</td>
            
            {{-- *** CORRECCIÓN CRÍTICA AQUÍ *** --}}
            {{-- Usamos 'usuarioOperador' que es el nombre correcto de la relación en el modelo. --}}
            <td>
                {{ $dist->usuarioOperador ? $dist->usuarioOperador->NombreUsuario.' '.$dist->usuarioOperador->ApellidoUsuario : 'Sin Operador' }}
            </td>
            
            <td>{{ $dist->sector ? $dist->sector->NombreSector : 'Sin Sector' }}</td>
            <td>
                <span class="badge {{ $dist->Estado ? 'bg-success' : 'bg-danger' }}">
                    {{ $dist->Estado ? 'Activo' : 'Inactivo' }}
                </span>
            </td>
            <td>
                <a href="{{ route('distribucion.edit', $dist->IdOperadorDistribucion) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('distribucion.toggleEstado', $dist->IdOperadorDistribucion) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-info btn-sm">
                        {{ $dist->Estado ? 'Desactivar' : 'Activar' }}
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

@endsection