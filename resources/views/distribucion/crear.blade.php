@extends('layouts.app')

@section('content')
<h3>Crear Distribución de Operador</h3>
<form method="POST" action="{{ route('distribucion.store') }}">
    @csrf
    <table class="table table-bordered">
        {{-- Hora Inicio --}}
        <tr>
            <th>Hora Inicio:</th>
            <td>
                <input type="datetime-local" name="HoraInicio" class="form-control" value="{{ old('HoraInicio') }}" required>
                @error('HoraInicio') <small class="text-danger">{{ $message }}</small> @enderror
            </td>
        </tr>
        {{-- Hora Final --}}
        <tr>
            <th>Hora Final:</th>
            <td>
                <input type="datetime-local" name="HoraFinal" class="form-control" value="{{ old('HoraFinal') }}" required>
                @error('HoraFinal') <small class="text-danger">{{ $message }}</small> @enderror
            </td>
        </tr>
        {{-- Operador Encargado --}}
        <tr>
            <th>Operador Encargado:</th>
            <td>
                {{-- ¡CORRECCIÓN CLAVE! El campo debe ser 'IdUsuarioOperador' --}}
                <select name="IdUsuarioOperador" class="form-control" required>
                    <option value="" selected disabled>Selecciona un operador</option>
                    @foreach($operadores as $operador)
                        <option value="{{ $operador->IdUsuario }}"> 
                            {{ $operador->NombreUsuario }} {{ $operador->ApellidoUsuario }}
                        </option>
                    @endforeach
                </select>
                @error('IdUsuarioOperador') <small class="text-danger">{{ $message }}</small> @enderror
            </td>
        </tr>
        {{-- Sector --}}
        <tr>
            <th>Sector:</th>
            <td>
                <select name="IdSector" class="form-control" required>
                    <option value="" selected disabled>Selecciona un sector</option>
                    @foreach($sectores as $sector)
                        <option value="{{ $sector->IdSector }}" {{ old('IdSector') == $sector->IdSector ? 'selected' : '' }}>
                            {{ $sector->NombreSector }}
                        </option>
                    @endforeach
                </select>
                @error('IdSector') <small class="text-danger">{{ $message }}</small> @enderror
            </td>
        </tr>
    </table>

    <button type="submit" class="btn btn-primary">Guardar Distribución</button>
</form>

{{-- Mensajes de Session y Errores Genéricos --}}
@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

{{-- Si deseas mantener el bloque de errores general --}}
@if ($errors->any() && !session('success'))
    <div class="alert alert-danger mt-3">
        <ul>
            <li>**Verifique los campos con errores.**</li>
        </ul>
    </div>
@endif

@endsection