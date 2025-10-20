@extends('layouts.app')

@section('content')
    <h3>Listado de Sectores</h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Sector</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sectores as $sector)
                <tr>
                    <td>{{ $sector->IdSector }}</td>
                    <td>{{ $sector->NombreSector }}</td>
                    <td>
                        <a href="{{ route('sectores.edit', $sector->IdSector) }}" class="btn btn-warning btn-sm">
                            Actualizar
                        </a>

                        <form action="{{ route('sectores.destroy', $sector->IdSector) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro de eliminar este sector?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(session('success'))
        <div class="alert alert-success mt-3" role="alert" id="success-message">
            {{ session('success') }}
        </div>
        <script>
            // Espera 3 segundos (3000 ms) y luego oculta el mensaje
            setTimeout(function() {
                var msg = document.getElementById('success-message');
                if(msg){
                    msg.style.display = 'none';
                }
            }, 3000);
        </script>
    @endif
@endsection