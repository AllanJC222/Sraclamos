@extends('layouts.app')

@section('content')
<h5>Añadir Abonado</h5>

<form method="POST" action="{{ route('abonados.store') }}">
    @csrf
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Campo</th>
                <th scope="col">Valor</th>
            </tr>
        </thead>
        <tbody>

            {{-- 🟦 Clave Catastral --}}
            <tr>
                <th><label for="ClaveCatastral">Clave Catastral:</label></th>
                <td>
                    <input type="text" id="ClaveCatastral" name="ClaveCatastral"
                           class="form-control @error('ClaveCatastral') is-invalid @enderror"
                           value="{{ old('ClaveCatastral') }}" required>
                    @error('ClaveCatastral')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            {{-- 🟦 No Identidad --}}
            <tr>
                <th><label for="NoIdentidad">No. Identidad:</label></th>
                <td>
                    <input type="text" id="NoIdentidad" name="NoIdentidad"
                           class="form-control @error('NoIdentidad') is-invalid @enderror"
                           placeholder="Ej. 0080-1234-56789"
                           maxlength="15"
                           pattern="\d{4}-\d{4}-\d{5}"
                           value="{{ old('NoIdentidad') }}" required>
                    @error('NoIdentidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            {{-- 🟦 Código de Abonado --}}
            <tr>
                <th><label for="CodigoAbonado">Código de Abonado:</label></th>
                <td>
                    <input type="text" id="CodigoAbonado" name="CodigoAbonado"
                           class="form-control @error('CodigoAbonado') is-invalid @enderror"
                           value="{{ old('CodigoAbonado') }}" required>
                    @error('CodigoAbonado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            {{-- 🟦 Nombre --}}
            <tr>
                <th><label for="NombreAbonado">Nombre de Abonado:</label></th>
                <td>
                    <input type="text" id="NombreAbonado" name="NombreAbonado"
                           class="form-control @error('NombreAbonado') is-invalid @enderror"
                           value="{{ old('NombreAbonado') }}" required>
                    @error('NombreAbonado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            {{-- 🟦 Uso de Suelo --}}
            <tr>
                <th><label for="UsoDeSuelo">Uso de Suelo:</label></th>
                <td>
                    <input type="text" id="UsoDeSuelo" name="UsoDeSuelo"
                           class="form-control @error('UsoDeSuelo') is-invalid @enderror"
                           value="{{ old('UsoDeSuelo') }}" required>
                    @error('UsoDeSuelo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            {{-- 🟦 Tipo de Actividad --}}
            <tr>
                <th><label for="TipoActividad">Tipo de Actividad:</label></th>
                <td>
                    <input type="text" id="TipoActividad" name="TipoActividad"
                           class="form-control @error('TipoActividad') is-invalid @enderror"
                           value="{{ old('TipoActividad') }}" required>
                    @error('TipoActividad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            {{-- 🟦 Sector --}}
            <tr>
                <th><label for="IdSector">Sector:</label></th>
                <td>
                    <select id="IdSector" name="IdSector"
                            class="form-control @error('IdSector') is-invalid @enderror" required>
                        <option value="">Seleccione</option>
                        @foreach ($sectores as $sector)
                            <option value="{{ $sector->IdSector }}"
                                {{ old('IdSector') == $sector->IdSector ? 'selected' : '' }}>
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
                <th><label for="Direccion">Dirección:</label></th>
                <td>
                    <input type="text" id="Direccion" name="Direccion"
                           class="form-control @error('Direccion') is-invalid @enderror"
                           value="{{ old('Direccion') }}" required>
                    @error('Direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            {{-- 🟦 Celular --}}
            <tr>
                <th><label for="Celular">Celular:</label></th>
                <td>
                    <input type="text" id="Celular" name="Celular"
                           class="form-control @error('Celular') is-invalid @enderror"
                           value="{{ old('Celular') }}" required>
                    @error('Celular')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

            {{-- 🟦 Estado --}}
            <tr>
                <th><label for="Estado">Estado:</label></th>
                <td>
                    <select id="Estado" name="Estado"
                            class="form-control @error('Estado') is-invalid @enderror" required>
                        <option value="1" {{ old('Estado') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('Estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('Estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>

        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>



{{-- ✅ Mensaje de éxito --}}
@if(session('success'))
    <div class="alert alert-success mt-3" role="alert" id="success-message">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('success-message')?.remove();
        }, 3000);
    </script>
@endif

{{-- 🧩 Script para formatear NoIdentidad --}}
<script>
    document.getElementById('NoIdentidad').addEventListener('input', function (e) {
        let valor = e.target.value.replace(/\D/g, '');
        if (valor.length > 4 && valor.length <= 8)
            valor = valor.slice(0, 4) + '-' + valor.slice(4);
        else if (valor.length > 8)
            valor = valor.slice(0, 4) + '-' + valor.slice(4, 8) + '-' + valor.slice(8, 13);
        e.target.value = valor;
    });
</script>
@endsection
