@extends('layouts.app')

@section('title', 'Editar Reclamo')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-primary fw-bold">✏️ Editar Reclamo #{{ $reclamo->IdReclamo }}</h4>

    {{-- Mensajes de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Errores detectados:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de edición --}}
    <form action="{{ route('reclamos.update', $reclamo->IdReclamo) }}" method="POST" class="card shadow-sm border-0 p-4">
        @csrf
        @method('PUT')

        {{-- DATOS GENERALES --}}
        <div class="mb-4">
            <h5 class="text-secondary fw-bold mb-3">📋 Información del Reclamo</h5>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Descripción del Problema</label>
                    <textarea name="Descripcion" class="form-control" rows="3" required>{{ old('Descripcion', $reclamo->Descripcion) }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Comentario Adicional</label>
                    <textarea name="Comentario" class="form-control" rows="2">{{ old('Comentario', $reclamo->Comentario) }}</textarea>
                </div>
            </div>
        </div>

        {{-- CATEGORÍA, SECTOR Y BARRIO --}}
        <div class="mb-4">
            <h5 class="text-secondary fw-bold mb-3">🏷️ Ubicación y Clasificación</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Categoría</label>
                    <select name="IdCategoria" class="form-select" required>
                        @foreach($categorias as $c)
                            <option value="{{ $c->IdCategoria }}" @selected($reclamo->IdCategoria == $c->IdCategoria)>
                                {{ $c->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sector</label>
                    <select name="IdSector" class="form-select" required>
                        @foreach($sectores as $s)
                            <option value="{{ $s->IdSector }}" @selected($reclamo->IdSector == $s->IdSector)>
                                {{ $s->NombreSector }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Barrio</label>
                    <select name="IdBarrio" class="form-select" required>
                        @foreach($barrios as $b)
                            <option value="{{ $b->IdBarrio }}" @selected($reclamo->IdBarrio == $b->IdBarrio)>
                                {{ $b->NombreBarrio }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- OPERADOR Y ESTADO --}}
        <div class="mb-4">
            <h5 class="text-secondary fw-bold mb-3">👷‍♂️ Gestión del Reclamo</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Operador Encargado</label>
                    <select name="IdUsuarioOperador" class="form-select">
                        <option value="">Sin asignar</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->IdUsuario }}" @selected($reclamo->IdUsuarioOperador == $u->IdUsuario)>
                                {{ $u->NombreUsuario }} {{ $u->ApellidoUsuario }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estado del Reclamo</label>
                    <select name="EstadoReclamo" class="form-select" required>
                        <option value="Pendiente" @selected($reclamo->EstadoReclamo === 'Pendiente')>Pendiente</option>
                        <option value="En Proceso" @selected($reclamo->EstadoReclamo === 'En Proceso')>En Proceso</option>
                        <option value="Resuelto" @selected($reclamo->EstadoReclamo === 'Resuelto')>Resuelto</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- INFORMACIÓN DEL ABONADO --}}
        <div class="mb-4">
            <h5 class="text-secondary fw-bold mb-3">👤 Datos del Abonado</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nombre del Abonado</label>
                    <input type="text" class="form-control" value="{{ $reclamo->abonado->NombreAbonado ?? 'N/A' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Clave Catastral</label>
                    <input type="text" class="form-control" value="{{ $reclamo->abonado->ClaveCatastral ?? 'N/A' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Celular</label>
                    <input type="text" class="form-control" value="{{ $reclamo->abonado->Celular ?? 'N/A' }}" readonly>
                </div>
            </div>
        </div>

        {{-- BOTONES --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('reclamos.leer') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="bi bi-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
