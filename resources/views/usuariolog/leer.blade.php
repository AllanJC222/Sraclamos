@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Listado de Usuarios de Login</h3>

    {{-- Búsqueda --}}
    <form action="{{ route('usuariolog.leer') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o tipo"
                   value="{{ request('buscar') }}">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success" id="success-message">{{ session('success') }}</div>
        <script>
            setTimeout(() => document.getElementById('success-message').style.display = 'none', 3000);
        </script>
    @endif

    {{-- Tabla --}}
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->user_name }}</td>
                    <td>
                        @if($usuario->user_tipo == '1')
                            <span class="badge bg-primary">Administrador</span>
                        @elseif($usuario->user_tipo == '2')
                            <span class="badge bg-success">Empleado</span>
                        @else
                            <span class="badge bg-secondary">Desconocido</span>
                        @endif
                    </td>
                    <td>
                        {{-- Botón Editar --}}
                        <a href="{{ route('usuariolog.edit', $usuario->id) }}" 
                        class="btn btn-warning btn-sm">Editar</a>

                        {{-- Botón Eliminar --}}
                        <form action="{{ route('usuariolog.destroy', $usuario->id) }}" 
                            method="POST" 
                            class="d-inline"
                            onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No se encontraron usuarios.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $usuarios->appends(['buscar' => request('buscar')])->links() }}
    </div>
</div>
@endsection
