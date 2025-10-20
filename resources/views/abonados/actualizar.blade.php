@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4 text-primary fw-bold">✏️ Editar Abonado</h4>

    {{-- ⚠️ Mensaje de error general --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Se encontraron errores en el formulario:</strong>
        </div>
    @endif

    <form method="POST" action="{{ route('abonados.update', $abonado->IdAbonado) }}">
        @csrf
        @method('PUT')

        <table class="table table-bordered">
            <tbody>

                {{-- 🟦 Clave Catastral --}}
                <tr>
                    <th>Clave Catastral</th>
                    <td>
                        <input type="text" id="ClaveCatastral" name="ClaveCatastral"
                               class="form-control @error('ClaveCatastral') is-invalid @enderror"
                               value="{{ old('ClaveCatastral', $abonado->ClaveCatastral) }}" required>
                        @error('ClaveCatastral')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 No Identidad --}}
                <tr>
                    <th>No. Identidad</th>
                    <td>
                        <input type="text" id="NoIdentidad" name="NoIdentidad"
                               class="form-control @error('NoIdentidad') is-invalid @enderror"
                               value="{{ old('NoIdentidad', $abonado->NoIdentidad) }}"
                               placeholder="Ej. 0080-1234-56789"
                               maxlength="15"
                               pattern="\d{4}-\d{4}-\d{5}" required>
                        @error('NoIdentidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 Código Abonado --}}
                <tr>
                    <th>Código Abonado</th>
                    <td>
                        <input type="text" id="CodigoAbonado" name="CodigoAbonado"
                               class="form-control @error('CodigoAbonado') is-invalid @enderror"
                               value="{{ old('CodigoAbonado', $abonado->CodigoAbonado) }}" required>
                        @error('CodigoAbonado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 Nombre --}}
                <tr>
                    <th>Nombre Abonado</th>
                    <td>
                        <input type="text" id="NombreAbonado" name="NombreAbonado"
                               class="form-control @error('NombreAbonado') is-invalid @enderror"
                               value="{{ old('NombreAbonado', $abonado->NombreAbonado) }}" required>
                        @error('NombreAbonado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 Uso de Suelo --}}
                <tr>
                    <th>Uso de Suelo</th>
                    <td>
                        <input type="text" id="UsoDeSuelo" name="UsoDeSuelo"
                               class="form-control @error('UsoDeSuelo') is-invalid @enderror"
                               value="{{ old('UsoDeSuelo', $abonado->UsoDeSuelo) }}" required>
                        @error('UsoDeSuelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 Tipo Actividad --}}
                <tr>
                    <th>Tipo Actividad</th>
                    <td>
                        <input type="text" id="TipoActividad" name="TipoActividad"
                               class="form-control @error('TipoActividad') is-invalid @enderror"
                               value="{{ old('TipoActividad', $abonado->TipoActividad) }}" required>
                        @error('TipoActividad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 Sector --}}
                <tr>
                    <th>Sector</th>
                    <td>
                        <select id="IdSector" name="IdSector"
                                class="form-control @error('IdSector') is-invalid @enderror" required>
                            <option value="">Seleccione</option>
                            @foreach ($sectores as $sector)
                                <option value="{{ $sector->IdSector }}"
                                    {{ old('IdSector', $abonado->IdSector) == $sector->IdSector ? 'selected' : '' }}>
                                    {{ $sector->NombreSector }}
                                </option>
                            @endforeach
                        </select>
                        @error('IdSector')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 Dirección --}}
                <tr>
                    <th>Dirección</th>
                    <td>
                        <input type="text" id="Direccion" name="Direccion"
                               class="form-control @error('Direccion') is-invalid @enderror"
                               value="{{ old('Direccion', $abonado->Direccion) }}" required>
                        @error('Direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 Celular --}}
                <tr>
                    <th>Celular</th>
                    <td>
                        <input type="text" id="Celular" name="Celular"
                               class="form-control @error('Celular') is-invalid @enderror"
                               value="{{ old('Celular', $abonado->Celular) }}"
                               maxlength="8"
                               pattern="[0-9]{8}"
                               placeholder="Ej. 98765432"
                               required>
                        @error('Celular')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                {{-- 🟦 Estado --}}
                <tr>
                    <th>Estado</th>
                    <td>
                        <select id="Estado" name="Estado"
                                class="form-control @error('Estado') is-invalid @enderror" required>
                            <option value="1" {{ old('Estado', $abonado->Estado) == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('Estado', $abonado->Estado) == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('Estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <a href="{{ route('abonados.leer') }}" class="btn btn-secondary">⬅ Volver</a>
            <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
    </form>
</div>

{{-- Autoformato del número de identidad --}}
<script>
document.getElementById('NoIdentidad').addEventListener('input', function(e) {
    let valor = e.target.value.replace(/\D/g, '');
    if (valor.length > 4 && valor.length <= 8)
        valor = valor.slice(0,4) + '-' + valor.slice(4);
    else if (valor.length > 8)
        valor = valor.slice(0,4) + '-' + valor.slice(4,8) + '-' + valor.slice(8,13);
    e.target.value = valor;
});
</script>
@endsection
