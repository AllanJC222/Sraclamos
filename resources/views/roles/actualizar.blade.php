@extends('layouts.app')

@section('content')

<div class="container mt-4">
<h2>Actualizar Rol</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('roles.update', $rol->IdRol) }}" method="POST">
    @csrf
    @method('PUT')

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Campo</th>
                <th scope="col">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">
                    <label for="IdRol" class="mb-0">ID Rol:</label>
                </th>
                <td>
                    <input type="text" id="IdRol" name="IdRol" class="form-control" value="{{ $rol->IdRol }}" disabled>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="NombreRol" class="mb-0">Nombre de Rol:</label>
                </th>
                <td>
                    <input type="text" id="NombreRol" name="NombreRol" class="form-control" value="{{ old('NombreRol', $rol->NombreRol) }}" required>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="Estado" class="mb-0">Estado:</label>
                </th>
                <td>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Estado" id="estadoActivo" value="1" {{ $rol->Estado == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="estadoActivo">Activo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="Estado" id="estadoInactivo" value="0" {{ $rol->Estado == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="estadoInactivo">Inactivo</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>

</div>
@endsection