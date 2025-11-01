@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Editar Usuario de Login</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('usuariolog.update', $usuario->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre de Usuario</label>
            <input type="text" name="user_name" class="form-control"
                   value="{{ old('user_name', $usuario->user_name) }}" required>
            <small class="form-text text-muted">
                Solo se permiten letras minúsculas, números, guiones (-), guiones bajos (_) y puntos (.)
            </small>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de Usuario</label>
            <select name="user_tipo" class="form-control" required>
                <option value="1" {{ $usuario->user_tipo == '1' ? 'selected' : '' }}>Administrador</option>
                <option value="2" {{ $usuario->user_tipo == '2' ? 'selected' : '' }}>Empleado</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña (opcional)</label>
            <input type="password" name="user_pass" class="form-control" placeholder="Dejar vacío para no cambiarla">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('usuariolog.leer') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
