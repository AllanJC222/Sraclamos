@extends('layouts.app')

@section('content')
    <h3>Listado de Categorías de Reclamo</h3>

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

    <a href="{{ route('categoria.crear') }}" class="btn btn-primary mb-3">Añadir Categoría</a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre de Categoría</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->IdCategoria }}</td>
                    <td>{{ $categoria->Nombre }}</td>
                    <td>
                        <a href="{{ route('categoria.edit', $categoria->IdCategoria) }}" class="btn btn-warning btn-sm">
                            Actualizar
                        </a>
                        <form action="{{ route('categoria.destroy', $categoria->IdCategoria) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta categoría?');">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
