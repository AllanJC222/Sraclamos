@extends('layouts.app')

@section('title', 'Editar Barrio')

@section('content')
<div class="container">
    <h4 class="mb-4 text-primary fw-bold">✏️ Editar Barrio</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('barrios.update', $barrio->IdBarrio) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="NombreBarrio" class="form-label fw-semibold">Nombre del Barrio</label>
                    <input type="text" name="NombreBarrio" id="NombreBarrio"
                           class="form-control" value="{{ old('NombreBarrio', $barrio->NombreBarrio) }}" required>
                </div>

                <div class="mb-3">
                    <label for="IdSector" class="form-label fw-semibold">Sector</label>
                    <select name="IdSector" id="IdSector" class="form-select" required>
                        @foreach ($sectores as $sector)
                            <option value="{{ $sector->IdSector }}" @selected($barrio->IdSector == $sector->IdSector)>
                                {{ $sector->NombreSector }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('barrios.leer') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
