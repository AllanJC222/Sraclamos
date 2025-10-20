@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h5> Editar Categoría de Reclamo</h5>

    {{--  Validación de errores --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Se encontraron errores:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('categoria.update', $categoria->IdCategoria) }}">
        @csrf
        @method('PUT') 

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th scope="col">Campo</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="Nombre" class="mb-0">Nombre:</label>
                    </th>
                    <td>
                        <input type="text" id="Nombre" name="Nombre"
                               class="form-control"
                               value="{{ old('Nombre', $categoria->Nombre) }}"
                               required>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('categoria.leer') }}" class="btn btn-secondary">Cancelar</a>
    </form>

    {{-- ✅ Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success mt-3" id="success-message">
            {{ session('success') }}
        </div>

        <script>
            // Oculta el mensaje de éxito después de 3 segundos
            setTimeout(() => {
                let msg = document.getElementById('success-message');
                if (msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @endif
</div>
@endsection
