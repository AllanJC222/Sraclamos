@extends('layouts.public')

@section('title', 'Consulta de Reclamo')

@section('content')
<div class="container py-5">

    {{-- 🔍 Encabezado --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Consulta de Reclamo</h2>
        <p class="text-muted">Ingresa tu <strong>código de seguimiento</strong> para conocer el estado actual de tu reclamo.</p>
    </div>

    {{-- 🧾 Formulario de búsqueda --}}
    <form method="GET" action="{{ route('reclamos.publico.consultar') }}" class="row justify-content-center mb-4">
        <div class="col-md-5">
            <input type="text" name="codigo" class="form-control form-control-lg text-center"
                   placeholder="Ej. ABCD123456" required value="{{ request('codigo') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-lg w-100">
                <i class="bi bi-search me-1"></i> Consultar
            </button>
        </div>
    </form>

    {{-- 🧩 Resultado de la búsqueda --}}
    @if(isset($reclamo))
        <div class="card shadow-lg border-0 mx-auto" style="max-width: 800px;">
            <div class="card-header bg-primary text-white text-center py-3">
                <h5 class="mb-0">
                    Código de Seguimiento: 
                    <span class="fw-bold">{{ $reclamo->CodigoSeguimiento }}</span>
                </h5>
            </div>

            <div class="card-body p-4">
                {{-- Estado --}}
                <div class="mb-4 text-center">
                    <h5 class="fw-semibold">Estado del Reclamo</h5>
                    <span class="badge fs-5 px-4 py-2 
                        @if($reclamo->EstadoReclamo == 'Pendiente') bg-warning text-dark
                        @elseif($reclamo->EstadoReclamo == 'En Proceso') bg-info text-dark
                        @else bg-success @endif">
                        {{ $reclamo->EstadoReclamo }}
                    </span>
                </div>

                {{-- 📋 Detalles generales --}}
                <h5 class="text-primary mt-4 mb-3"><i class="bi bi-info-circle"></i> Detalles del Reclamo</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Descripción:</strong> {{ $reclamo->Descripcion }}</li>
                    <li class="list-group-item"><strong>Comentarios:</strong> {{ $reclamo->Comentario ?? 'Sin comentarios registrados.' }}</li>
                    <li class="list-group-item"><strong>Fecha de Registro:</strong> 
                        {{ $reclamo->FechaInicial ? date('d/m/Y h:i A', strtotime($reclamo->FechaInicial)) : 'No disponible' }}
                    </li>
                    <li class="list-group-item"><strong>Categoría:</strong> {{ $reclamo->categoria->Nombre ?? 'No especificada' }}</li>
                </ul>

                {{-- 👤 Información del abonado --}}
                <h5 class="text-success mt-4 mb-3"><i class="bi bi-person-lines-fill"></i> Datos del Abonado</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Nombre:</strong> {{ $reclamo->abonado->NombreAbonado ?? 'No asignado' }}</li>
                    <li class="list-group-item"><strong>Clave Catastral:</strong> {{ $reclamo->abonado->ClaveCatastral ?? 'No disponible' }}</li>
                    <li class="list-group-item"><strong>Celular:</strong> {{ $reclamo->abonado->Celular ?? 'No disponible' }}</li>
                </ul>

                {{-- 🧑‍🔧 Información del operador --}}
                <h5 class="text-info mt-4 mb-3"><i class="bi bi-headset"></i> Operador Asignado</h5>
                @if($reclamo->operador)
                    <ul class="list-group mb-3">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $reclamo->operador->NombreUsuario }}</li>
                        <li class="list-group-item"><strong>Celular:</strong> {{ $reclamo->operador->Celular ?? 'No disponible' }}</li>
                    </ul>
                @else
                    <p class="text-muted fst-italic">Este reclamo aún no tiene un operador asignado.</p>
                @endif
            </div>
        </div>
    @elseif(request()->has('codigo'))
        <div class="alert alert-danger text-center mt-4" role="alert">
            No se encontró ningún reclamo con el código ingresado.
        </div>
    @endif
</div>

{{-- 🧭 Estilos visuales extra --}}
<style>
    body {
        background-color: #f8fafc;
    }
    .list-group-item {
        border: none;
        border-bottom: 1px solid #e9ecef;
    }
    .card {
        border-radius: 15px;
    }
</style>
@endsection
