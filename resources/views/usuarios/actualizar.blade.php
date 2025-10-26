@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h2>Actualizar Usuario</h2>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de actualización --}}
    <form action="{{ route('usuarios.update', $usuario->IdUsuario) }}" method="POST">
        @csrf
        @method('PUT')

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Campo</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><label for="IdUsuario">ID Usuario:</label></th>
                    <td>
                        <input type="text" id="IdUsuario" class="form-control" 
                               value="{{ $usuario->IdUsuario }}" disabled>
                    </td>
                </tr>

                <tr>
                    <th><label for="NombreUsuario">Nombre:</label></th>
                    <td>
                        <input type="text" id="NombreUsuario" name="NombreUsuario" class="form-control"
                               value="{{ old('NombreUsuario', $usuario->NombreUsuario) }}" required>
                    </td>
                </tr>

                <tr>
                    <th><label for="ApellidoUsuario">Apellido:</label></th>
                    <td>
                        <input type="text" id="ApellidoUsuario" name="ApellidoUsuario" class="form-control"
                               value="{{ old('ApellidoUsuario', $usuario->ApellidoUsuario) }}" required>
                    </td>
                </tr>

                <tr>
                    <th><label for="Email">Correo:</label></th>
                    <td>
                        <input type="email" id="Email" name="Email" class="form-control"
                               value="{{ old('Email', $usuario->Email) }}" required>
                    </td>
                </tr>

                <tr>
                    <th><label for="Celular">Celular:</label></th>
                    <td>
                        <input type="text" id="Celular" name="Celular" class="form-control"
                               value="{{ old('Celular', $usuario->Celular) }}" required>
                    </td>
                </tr>

                <tr>
                    <th><label for="IdRol">Rol:</label></th>
                    <td>
                        <select id="IdRol" name="IdRol" class="form-control" required>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->IdRol }}" 
                                        {{ $rol->IdRol == $usuario->IdRol ? 'selected' : '' }}>
                                    {{ $rol->NombreRol }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <th><label for="Estado">Estado:</label></th>
                    <td>
                        <select id="Estado" name="Estado" class="form-control" required>
                            <option value="1" {{ $usuario->Estado ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$usuario->Estado ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('usuarios.leer') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>

@endsection
