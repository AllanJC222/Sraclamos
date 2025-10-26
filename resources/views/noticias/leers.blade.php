{{-- Archivo: resources/views/noticias/leer.blade.php --}}

@extends('layouts.app') {{-- 1. Usamos la plantilla principal --}}

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Noticias</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Noticias</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-table me-1"></i>
                    Lista de Noticias
                </span>
                {{-- 2. Enlace a la ruta de 'crear' --}}
                <a href="{{ route('noticias.crear') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Crear Noticia
                </a>
            </div>
            <div class="card-body">

                {{-- Mensaje de éxito (si venimos de 'store') --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th> {{-- <-- 1. Nueva columna --}} </tr>
                    </thead>
                    <tbody>
                        @forelse ($noticias as $noticia)
                            <tr>
                                <td>{{ $noticia->Titulo }}</td>
                                <td>
                                    @if($noticia->Publicado)
                                        <span class="badge bg-success">Publicado</span>
                                    @else
                                        <span class="badge bg-secondary">Borrador</span>
                                    @endif
                                </td>
                                <td>{{ $noticia->created_at->format('d/m/Y') }}</td>

                                {{-- 2. Nuevos botones de acción --}}
                                <td>
                                    <a href="{{ route('noticias.edit', $noticia->IdNoticia) }}" class="btn btn-warning btn-sm">
                                        Editar
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('noticias.destroy', $noticia->IdNoticia) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta noticia?');">
                                        @csrf
                                        @method('DELETE') {{-- !! IMPORTANTE: Le dice a Laravel que es DELETE --}}
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- 3. Actualizamos el colspan --}}
                                <td colspan="4" class="text-center">No hay noticias registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection