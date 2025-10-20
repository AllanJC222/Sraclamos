@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Actualizar Sector</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sectores.update', $sector->IdSector) }}" method="POST">
        @csrf
        @method('PUT')

        <table class="table caption-top">
            <caption>Datos del sector</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Sector</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sector->IdSector }}</td>
                    <td>
                        <input type="text" name="NombreSector" value="{{ old('NombreSector', $sector->NombreSector) }}" 
                               class="form-control" required maxlength="50">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
@endsection
