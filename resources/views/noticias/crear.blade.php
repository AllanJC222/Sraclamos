{{-- Archivo: resources/views/noticias/crear.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Crear Noticia</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('noticias.leers') }}">Noticias</a></li>
            <li class="breadcrumb-item active">Crear</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus me-1"></i>
                Formulario de Nueva Noticia
            </div>
            <div class="card-body">

                {{-- 1. Formulario que envía los datos al Controlador (ruta 'store') --}}
                <form action="{{ route('noticias.store') }}" method="POST">
                    @csrf {{-- Token de seguridad OBLIGATORIO en Laravel --}}

                    <div class="mb-3">
                        <label for="Titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="Titulo" name="Titulo" value="{{ old('Titulo') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="Contenido" class="form-label">Contenido</label>
                        <textarea class="form-control" id="Contenido" name="Contenido" rows="5"
                            required>{{ old('Contenido') }}</textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="Publicado" name="Publicado" value="1">
                        <label class="form-check-label" for="Publicado">Publicar inmediatamente</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Noticia</button>
                    <a href="{{ route('noticias.leers') }}" class="btn btn-secondary">Cancelar</a>
                </form>

            </div>
        </div>
    </div>
@endsection