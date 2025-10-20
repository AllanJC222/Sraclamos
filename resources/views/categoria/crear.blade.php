@extends('layouts.app')

@section('content')
<h5>Añadir Categoría de Reclamo</h5>

{{-- Asegúrate de que tu controlador de CategoriaReclamo maneje la ruta 'categoria.store' --}}
<form method="POST" action="{{ route('categoria.store') }}">
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
                    <label for="Nombre" class="mb-0">Nombre:</label>
                </th>
                <td>
                    <input type="text" id="Nombre" name="Nombre" class="form-control" required>
                </td>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@if(session('success'))
    <div class="alert alert-success mt-3" role="alert" id="success-message">
        {{ session('success') }}
    </div>
    <script>
        // Oculta el mensaje de éxito después de 3 segundos
        setTimeout(function() {
            var msg = document.getElementById('success-message');
            if(msg){
                msg.style.display = 'none';
            }
        }, 3000);
    </script>
@endif
@endsection
