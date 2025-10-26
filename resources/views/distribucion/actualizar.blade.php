@extends('layouts.app')

@section('content')
<h3>Editar Distribución de Operador</h3>

<form method="POST" action="{{ route('distribucion.update', $distribucion->IdOperadorDistribucion) }}">
    @csrf
    @method('PUT')
    <table class="table table-bordered">
        <tr>
            <th>Hora Inicio:</th>
            <td><input type="datetime-local" name="HoraInicio" value="{{ old('HoraInicio', $distribucion->HoraInicio) }}" class="form-control" required></td>
        </tr>
        <tr>
            <th>Hora Final:</th>
            <td><input type="datetime-local" name="HoraFinal" value="{{ old('HoraFinal', $distribucion->HoraFinal) }}" class="form-control" required></td>
        </tr>
        <tr>
            <th>Operador Encargado:</th>
         <td>
    <select name="IdUsuarioOperador" class="form-control" required>
        @foreach($operadores as $operador)
            <option value="{{ $operador->IdUsuario }}" 
                {{ $operador->IdUsuario == $distribucion->IdUsuarioOperador ? 'selected' : '' }}>
                {{ $operador->NombreUsuario }} {{ $operador->ApellidoUsuario }}
            </option>
        @endforeach
    </select>
</td>

        </tr>
        <tr>
            <th>Sector:</th>
            <td>
                <select name="IdSector" class="form-control" required>
                    @foreach($sectores as $sector)
                        <option value="{{ $sector->IdSector }}" {{ $sector->IdSector == $distribucion->IdSector ? 'selected' : '' }}>
                            {{ $sector->NombreSector }}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <th>Estado:</th>
            <td>
                <select name="Estado" class="form-control" required>
                    <option value="1" {{ $distribucion->Estado ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ !$distribucion->Estado ? 'selected' : '' }}>Inactivo</option>
                </select>
            </td>
        </tr>
    </table>

    <button type="submit" class="btn btn-primary">Actualizar Distribución</button>
</form>

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

@endsection