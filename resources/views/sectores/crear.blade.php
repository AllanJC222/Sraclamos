@extends('layouts.app')

@section('content')
<h5>Añadir Sectores</h5>

<form method="POST" action="{{ route('sectores.store') }}">
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
                    <label for="NombreSector" class="mb-0">Nombre:</label>
                </th>
                <td>
                    <input type="text" id="NombreSector" name="NombreSector" class="form-control" required>
                </td>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@if(session('success'))
    <div class="alert alert-success mt-3" role="alert">
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
