@extends('layouts.app')

@section('content')
<h3>Listado de Operadores</h3>

{{-- Formulario de búsqueda --}}
<form action="{{ route('usuarios.leer') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input 
            type="text" 
            name="buscar" 
            class="form-control" 
            placeholder="Buscar por Nombre, Apellido, Email o Celular" 
            value="{{ request('buscar') }}">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </div>
</form>

{{-- Mensaje de éxito --}}
@if(session('success'))
    <div class="alert alert-success mt-3" role="alert" id="success-message">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            var msg = document.getElementById('success-message');
            if(msg){
                msg.style.display = 'none';
            }
        }, 3000);
    </script>
@endif

{{-- Tabla --}}
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">
                <a href="{{ route('usuarios.leer', ['sort_by' => 'NombreUsuario', 'sort_order' => request('sort_by') === 'NombreUsuario' && request('sort_order') === 'asc' ? 'desc' : 'asc', 'buscar' => request('buscar')]) }}">
                    Nombre
                    @if(request('sort_by') === 'NombreUsuario')
                        <i class="fas fa-sort-{{ request('sort_order') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th scope="col">
                <a href="{{ route('usuarios.leer', ['sort_by' => 'ApellidoUsuario', 'sort_order' => request('sort_by') === 'ApellidoUsuario' && request('sort_order') === 'asc' ? 'desc' : 'asc', 'buscar' => request('buscar')]) }}">
                    Apellido
                    @if(request('sort_by') === 'ApellidoUsuario')
                        <i class="fas fa-sort-{{ request('sort_order') === 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </th>
            <th scope="col">Correo</th>
            <th scope="col">Celular</th>
            <th scope="col">Rol</th>
            <th scope="col">Estado</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->IdUsuario }}</td>
                <td>{{ $usuario->NombreUsuario }}</td>
                <td>{{ $usuario->ApellidoUsuario }}</td>
                <td>{{ $usuario->Email }}</td>
                <td>{{ $usuario->Celular }}</td>
                <td>{{ $usuario->rol ? $usuario->rol->NombreRol : 'Sin Rol' }}</td>
                <td>
                    <span class="badge {{ $usuario->Estado ? 'bg-success' : 'bg-danger' }}">
                        {{ $usuario->Estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('usuarios.edit', $usuario->IdUsuario) }}" class="btn btn-warning btn-sm">
                        Actualizar
                    </a>
                   <form action="{{ route('usuarios.toggleEstado', $usuario->IdUsuario) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info btn-sm">
                            {{ $usuario->Estado ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No se encontraron usuarios.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Paginación --}}
<div class="d-flex justify-content-center">
    {{ $usuarios->appends([
        'buscar' => request('buscar'),
        'sort_by' => request('sort_by'),
        'sort_order' => request('sort_order')
    ])->links() }}
</div>

@endsection
