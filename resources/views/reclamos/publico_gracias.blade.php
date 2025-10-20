@extends('layouts.public')

@section('title', 'Reclamo Enviado')

@section('content')
<div class="container text-center py-5">
    <h3 class="text-success">✅ Reclamo registrado exitosamente</h3>
    <p class="lead">Tu código de seguimiento es:</p>
    <h2 class="text-primary">{{ $codigo }}</h2>
    <p>Guarda este código para consultar el estado de tu reclamo más adelante.</p>
    <p>Tomar una captura para asegurar de guardar el codigo.</p>

    <a href="{{ route('reclamos.publico.consulta') }}" class="btn btn-outline-primary mt-3">Consultar Estado</a>
</div>
@endsection
