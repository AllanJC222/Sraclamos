@extends('layouts.app')

@section('content')

<h5>Añadir Operadores</h5>

<form method="POST" action="{{ route('usuarios.store') }}">
    @csrf
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Campo</th>
                <th scope="col">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th><label for="NombreUsuario">Nombre:</label></th>
                <td><input type="text" id="NombreUsuario" name="NombreUsuario" class="form-control" required></td>
            </tr>
            <tr>
                <th><label for="ApellidoUsuario">Apellido:</label></th>
                <td><input type="text" id="ApellidoUsuario" name="ApellidoUsuario" class="form-control" required></td>
            </tr>
            <tr>
                <th><label for="Email">Correo electrónico:</label></th>
                <td><input type="email" id="Email" name="Email" class="form-control" required></td>
            </tr>
            <tr>
                <th><label for="Celular">Celular:</label></th>
                <td><input type="text" id="Celular" name="Celular" class="form-control" required></td>
            </tr>
        
            <tr>
                <th><label for="IdRol">Rol:</label></th>
                <td>
                    <select id="IdRol" name="IdRol" class="form-control" required>
                        <option value="" selected disabled>Selecciona un rol</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->IdRol }}">{{ $rol->NombreRol }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@if(session('success'))
    <div class="alert alert-success mt-3" id="success-message">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => document.getElementById('success-message').style.display = 'none', 3000);
    </script>
@endif

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
