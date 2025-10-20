@extends('layouts.app')

@section('title', 'Crear Reclamo')

@section('content')
<div class="container">
    <h4 class="mb-4">Crear Nuevo Reclamo</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h6>Errores en el formulario:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 🔎 FILTRO DE BÚSQUEDA --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Buscar Abonado</div>
        <div class="card-body">
            <form method="GET" action="{{ route('reclamos.crear') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Clave Catastral</label>
                    <input type="text" name="clave_catastral" class="form-control" value="{{ request('clave_catastral') }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Nombre del Abonado</label>
                    <input type="text" name="nombre_abonado" class="form-control" value="{{ request('nombre_abonado') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </form>

            @if(isset($abonado) && $abonado)
                <div class="alert alert-success mt-3">
                    Abonado encontrado: <strong>{{ $abonado->NombreAbonado }}</strong> ({{ $abonado->ClaveCatastral }})
                </div>
            @elseif(request()->has('clave_catastral') || request()->has('nombre_abonado'))
                <div class="alert alert-warning mt-3">
                    No se encontró ningún abonado con esos datos.
                </div>
            @endif
        </div>
    </div>

    {{-- 🧾 FORMULARIO PRINCIPAL --}}
    <form action="{{ route('reclamos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">Datos del Reclamo</div>
            <div class="card-body">

                {{-- Campo oculto del abonado --}}
                <input type="hidden" name="IdAbonado" value="{{ $abonado->IdAbonado ?? '' }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre Abonado</label>
                        <input type="text" class="form-control" value="{{ $abonado->NombreAbonado ?? '' }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Celular</label>
                        <input type="text" class="form-control" value="{{ $abonado->Celular ?? '' }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción del Problema</label>
                    <textarea name="Descripcion" class="form-control" rows="3">{{ old('Descripcion') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comentario Adicional</label>
                    <textarea name="Comentario" class="form-control" rows="2">{{ old('Comentario') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Categoría</label>
                        <select name="IdCategoria" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach($categorias as $c)
                                <option value="{{ $c->IdCategoria }}" @selected(old('IdCategoria') == $c->IdCategoria)>{{ $c->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Sector</label>
                        <select name="IdSector" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach($sectores as $s)
                                <option value="{{ $s->IdSector }}" @selected((old('IdSector') ?? ($abonado->IdSector ?? '')) == $s->IdSector)>
                                    {{ $s->NombreSector }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Barrio</label>
                        <select name="IdBarrio" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach($barrios as $b)
                                <option value="{{ $b->IdBarrio }}" @selected(old('IdBarrio') == $b->IdBarrio)>{{ $b->NombreBarrio }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Operador Encargado</label>
                        <select name="IdUsuarioOperador" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach($usuarios as $u)
                                <option value="{{ $u->IdUsuario }}" @selected(old('IdUsuarioOperador') == $u->IdUsuario)>
                                    {{ $u->NombreUsuario }} {{ $u->ApellidoUsuario }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Coordenadas Ubicación (Lat, Lon)</label>
                    <input type="text" name="CoordenadasUbicacion" class="form-control" value="{{ old('CoordenadasUbicacion') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen Evidencia</label>
                    <input type="file" name="ImagenEvidencia" class="form-control">
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">Guardar Reclamo</button>
        <a href="{{ route('reclamos.leer') }}" class="btn btn-secondary btn-lg">Cancelar</a>
    </form>
</div>
@endsection
