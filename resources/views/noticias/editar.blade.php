{{-- Archivo: resources/views/noticias/editar.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Editar Noticia</h1>
        <ol class="breadcrumb mb-4">
            {{-- Corregido para que coincida con tu ruta 'dashboard' --}}
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('noticias.leer') }}">Noticias</a></li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Editando Noticia: {{ $noticia->Titulo }}
            </div>
            <div class="card-body">

                {{-- 1. El formulario apunta a la ruta 'update' y pasa el ID --}}
                <form action="{{ route('noticias.update', $noticia->IdNoticia) }}" method="POST">
                    @csrf {{-- Token de seguridad --}}
                    @method('PUT') {{-- !! IMPORTANTE: Le dice a Laravel que esto es una actualización (PUT) --}}

                    <div class="mb-3">
                        <label for="Titulo" class="form-label">Título</label>
                        {{-- 2. Rellenamos el 'value' con los datos actuales --}}
                        <input type="text" class="form-control" id="Titulo" name="Titulo"
                            value="{{ old('Titulo', $noticia->Titulo) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="Contenido" class="form-label">Contenido</label>
                        {{-- 2. Rellenamos el 'textarea' con los datos actuales --}}
                        <textarea class="form-control" id="Contenido" name="Contenido" rows="5"
                            required>{{ old('Contenido', $noticia->Contenido) }}</textarea>
                    </div>

                    <div class="mb-3 form-check">
                        {{-- 3. Marcamos el 'checked' si ya estaba publicado --}}
                        <input type="checkbox" class="form-check-input" id="Publicado" name="Publicado" value="1"
                            @if(old('Publicado', $noticia->Publicado)) checked @endif>
                        <label class="form-check-label" for="Publicado">Publicar inmediatamente</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Noticia</button>
                    <a href="{{ route('noticias.leer') }}" class="btn btn-secondary">Cancelar</a>
                </form>

            </div>
        </div>
    </div>
@endsection