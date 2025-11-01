@extends('layouts.app')

@section('content')

<!-- Asegúrate de que esta URL sea la ruta POST que procesa los datos -->
<!-- Usamos el nombre de ruta completo: 'registrarse.registrar.crearlogs' -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Card con estilos de Bootstrap y sombra profunda -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h1 class="card-title text-center mb-4 text-primary fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i> Crear Nuevo Usuario
                    </h1>
                    <hr class="mb-5">

                    <!-- Mostrar mensajes de éxito -->
                    @if (session('sucess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong class="me-1">¡Éxito!</strong>
                            {{ session('sucess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('registrar.storelogs') }}">
                        @csrf
                        <!-- Campo: user_name -->
                        <div class="mb-4">
                            <label for="user_name" class="form-label fw-semibold text-secondary">Nombre de Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input id="user_name" type="text" name="user_name" value="{{ old('user_name') }}" required autofocus
                                       placeholder="Ej: jdoe123"
                                       class="form-control @error('user_name') is-invalid @enderror">
                                @error('user_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Solo se permiten letras minúsculas, números, guiones (-), guiones bajos (_) y puntos (.)
                            </small>
                        </div>

                        <!-- Campo: user_pass (Contraseña) -->
                        <div class="mb-4">
                            <label for="user_pass" class="form-label fw-semibold text-secondary">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input id="user_pass" type="password" name="user_pass" required
                                       placeholder="••••••••"
                                       class="form-control @error('user_pass') is-invalid @enderror">
                                @error('user_pass')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo: user_tipo (Tipo de Usuario) -->
                        <div class="mb-5">
                            <label for="user_tipo" class="form-label fw-semibold text-secondary">Tipo de Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <select id="user_tipo" name="user_tipo" required
                                        class="form-select @error('user_tipo') is-invalid @enderror">
                                    <option value="" disabled {{ old('user_tipo') == null ? 'selected' : '' }}>-- Seleccione un rol --</option>
                                    <option value="1" {{ old('user_tipo') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                    <option value="2" {{ old('user_tipo') == 'empleado' ? 'selected' : '' }}>Empleado</option>
                                    
                                </select>
                                @error('user_tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botón de Registro -->
                        <div class="d-grid">
                            <button type="submit"
                                    class="btn btn-primary btn-lg shadow-sm rounded-pill py-2 fw-bold text-uppercase letter-spacing-1">
                                Completar Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Se requiere incluir Bootstrap Icons o Font Awesome para que los iconos (bi-person, bi-lock, etc.) se muestren. -->
<!-- Si no usas Bootstrap Icons, reemplaza las clases como "bi bi-person" por clases de Font Awesome o similar. -->
@endsection
