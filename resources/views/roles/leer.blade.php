@extends('layouts.app')

@section('content')

<h5>Añadir Rol</h5>

<form method="POST" action="{{ route('roles.store') }}">
    @csrf
    <table class="table table-bordered">
        <thead>
            <tr>
            <th scope="col">Información</th>
            <th scope="col">Datos</th>
            </tr>
        </thead>
        <tbody>
        <tr>
        <th scope="row">
        <label for="NombreRol" class="mb-0">Nombre:</label>
        </th>
        <td>
        <input type="text" id="NombreRol" name="NombreRol" class="form-control" required>
        </td>
        </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

<hr> <h3>Listado de Roles</h3>

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

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $rol)
                <tr>
                    <td>{{ $rol->IdRol }}</td>
                    <td>{{ $rol->NombreRol }}</td>
                    <td>
                        <span class="badge {{ $rol->Estado ? 'bg-success' : 'bg-danger' }}">
                            {{ $rol->Estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('roles.edit', $rol->IdRol) }}" class="btn btn-warning btn-sm">
                            Actualizar
                        </a>
                        <form action="{{ route('roles.destroy', $rol->IdRol) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este rol?');">
                                Borrar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection