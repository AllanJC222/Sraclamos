@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Editar Reclamo: #{{ $reclamo->IdReclamo }}</h4>

    {{-- Mostrar errores de validación generales --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reclamos.update', $reclamo->IdReclamo) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- 1. Descripción --}}
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="Descripcion" class="form-control" required>{{ old('Descripcion', $reclamo->Descripcion) }}</textarea>
            @error('Descripcion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- 2. Categoría --}}
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="IdCategoria" class="form-control" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->IdCategoria }}" 
                        {{ old('IdCategoria', $reclamo->IdCategoria) == $categoria->IdCategoria ? 'selected' : '' }}>
                        {{ $categoria->NombreCategoria }}
                    </option>
                @endforeach
            </select>
            @error('IdCategoria') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        
        {{-- NUEVO CAMPO: Operador de Distribución --}}
        <div class="mb-3">
            <label class="form-label">Operador de Distribución</label>
            <select name="IdOperadorDistribucion" class="form-control" required>
                {{-- Asumo que la variable se llama $operadoresDistribucion --}}
                @foreach($operadoresDistribucion as $operador)
                    <option value="{{ $operador->IdOperadorDistribucion }}" 
                        {{ old('IdOperadorDistribucion', $reclamo->IdOperadorDistribucion) == $operador->IdOperadorDistribucion ? 'selected' : '' }}>
                        {{ $operador->Nombre }}
                    </option>
                @endforeach
            </select>
            @error('IdOperadorDistribucion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- 3. Abonado --}}
        <div class="mb-3">
            <label class="form-label">Abonado</label>
            <select name="IdAbonados" class="form-control" required>
                @foreach($abonados as $abonado)
                    <option value="{{ $abonado->IdAbonados }}" 
                        {{ old('IdAbonados', $reclamo->IdAbonados) == $abonado->IdAbonados ? 'selected' : '' }}>
                        {{ $abonado->Nombre }}
                    </option>
                @endforeach
            </select>
            @error('IdAbonados') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- 4. Sector --}}
        <div class="mb-3">
            <label class="form-label">Sector</label>
            <select name="IdSector" class="form-control" required>
                @foreach($sectores as $sector)
                    <option value="{{ $sector->IdSector }}" 
                        {{ old('IdSector', $reclamo->IdSector) == $sector->IdSector ? 'selected' : '' }}>
                        {{ $sector->NombreSector }}
                    </option>
                @endforeach
            </select>
            @error('IdSector') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- CAMPO CORREGIDO: Estado del Reclamo (usa IdEstado y la colección $estados) --}}
        <div class="mb-3">
            <label class="form-label">Estado Reclamo</label>
            <select name="IdEstado" class="form-control" required>
                @foreach($estados as $estado)
                    <option value="{{ $estado->IdEstado }}" 
                        {{ old('IdEstado', $reclamo->IdEstado) == $estado->IdEstado ? 'selected' : '' }}>
                        {{ $estado->NombreEstado }}
                    </option>
                @endforeach
            </select>
            @error('IdEstado') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- 5. Coordenadas Ubicación --}}
        <div class="mb-3">
            <label class="form-label">Coordenadas Ubicación</label>
            <input type="text" name="CoordenadasUbicacion" 
                   value="{{ old('CoordenadasUbicacion', $reclamo->CoordenadasUbicacion) }}" 
                   class="form-control">
            @error('CoordenadasUbicacion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- 6. Imagen Evidencia --}}
        <div class="mb-3">
            <label class="form-label">Imagen Evidencia</label>
            <input type="file" name="ImagenEvidencia" class="form-control">
            @error('ImagenEvidencia') <div class="text-danger">{{ $message }}</div> @enderror
            
            {{-- Muestra la imagen actual si existe --}}
            @if($reclamo->ImagenEvidencia)
                <p class="mt-2">Evidencia Actual:</p>
                {{-- Nota: Como estás guardando la imagen como LONGBLOB en el controlador, 
                     aquí necesitarías una ruta que decodifique y sirva esa imagen. 
                     La línea `asset('storage/'.$reclamo->ImagenEvidencia)` SOLO funciona si la imagen se guarda en disco.
                     Si se guarda como BLOB, necesitarías una ruta como: 
                     <img src="{{ route('reclamos.imagen', $reclamo->IdReclamo) }}" alt="Evidencia" width="100">
                     Mantengo tu línea original asumiendo que el almacenamiento es mixto o tienes una configuración de acceso especial.
                --}}
                <p>Actual: <img src="{{ asset('storage/'.$reclamo->ImagenEvidencia) }}" alt="Evidencia" width="100"></p>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Actualizar Reclamo</button>
    </form>
</div>
@endsection
