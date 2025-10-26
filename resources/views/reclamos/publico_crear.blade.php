@extends('layouts.public')

@section('title', 'Registrar Reclamo Ciudadano')

@section('content')
<div class="container py-5">
    <h3 class="text-center mb-4 text-primary fw-bold">📋 Formulario de Reclamos Ciudadanos</h3>

    {{-- 🔍 SECCIÓN DE BÚSQUEDA DEL ABONADO --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white fw-semibold">
            Buscar Abonado
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reclamos.publico.crear') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Clave Catastral</label>
                    <input type="text" name="clave_catastral" class="form-control" placeholder="Ej. 0101-0023-001" value="{{ request('clave_catastral') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </form>

            {{-- Resultado de búsqueda --}}
            @if(isset($abonado) && $abonado)
                <div class="alert alert-success mt-3 mb-0">
                    ✅ <strong>Abonado encontrado:</strong> {{ $abonado->NombreAbonado }} 
                    <span class="text-muted">({{ $abonado->ClaveCatastral }})</span>
                </div>
           @elseif(isset($mensaje))
            {{-- Se dejo un solo mensaje de error --}}
                <div class="alert alert-{{ $mensaje['tipo'] }} mt-3">
                ⚠️ {{ $mensaje['texto'] }}
                </div>
            @endif
        </div>
    </div>

    {{-- 🧾 FORMULARIO DE RECLAMO --}}
    @if(isset($abonado) && $abonado)
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white fw-semibold">
            Datos del Reclamo
        </div>
        <div class="card-body">
            <form action="{{ route('reclamos.publico.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="IdAbonado" value="{{ $abonado->IdAbonado }}">

                {{-- DATOS DEL ABONADO --}}
                <div class="mb-4">
                    <h5 class="fw-bold text-secondary mb-3">👤 Datos del Abonado</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre del Abonado</label>
                            <input type="text" class="form-control" value="{{ $abonado->NombreAbonado }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Celular</label>
                            <input type="text" class="form-control" value="{{ $abonado->Celular }}" readonly>
                        </div>
                    
                    </div>
                </div>

                {{-- DATOS DEL RECLAMO --}}
                <div class="mb-4">
                    <h5 class="fw-bold text-secondary mb-3">📝 Información del Reclamo</h5>
                    <div class="mb-3">
                        <label class="form-label">Descripción del Problema <span class="text-danger">*</span></label>
                        <textarea name="Descripcion" class="form-control" rows="3" required>{{ old('Descripcion') }}</textarea>
                    </div>

                

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select name="IdCategoria" class="form-select" required>
                                <option value="">Seleccione...</option>
                                @foreach($categorias as $c)
                                    <option value="{{ $c->IdCategoria }}">{{ $c->Nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sector <span class="text-danger">*</span></label>
                            <select name="IdSector" class="form-select" required>
                                @foreach($sectores as $s)
                                    <option value="{{ $s->IdSector }}" 
                                        @selected($abonado->IdSector == $s->IdSector)>
                                        {{ $s->NombreSector }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Barrio <span class="text-danger">*</span></label>
                            <select name="IdBarrio" class="form-select" required>
                                <option value="">Seleccione...</option>
                                @foreach($barrios as $b)
                                    <option value="{{ $b->IdBarrio }}">{{ $b->NombreBarrio }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- UBICACIÓN Y EVIDENCIA --}}
                <div class="mb-4">
                    <h5 class="fw-bold text-secondary mb-3">📍 Ubicación y Evidencia</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Coordenadas (Lat, Lon)</label>
                            <input type="text" name="CoordenadasUbicacion" class="form-control" placeholder="Ej. 13.3090, -87.1802" value="{{ old('CoordenadasUbicacion') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subir Evidencia (opcional)</label>
                            <input type="file" name="ImagenEvidencia" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="bi bi-send-fill"></i> Enviar Reclamo
                    </button>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="alert alert-info text-center mt-4 shadow-sm">
            🔍 Ingrese su <strong>clave catastral</strong> y presione <strong>Buscar</strong> para iniciar el reclamo.
        </div>
    @endif
</div>
@endsection
