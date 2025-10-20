@foreach ($sectores as $sector)
<tr>
    <td>{{ $sector->IdSector }}</td>
    <td>{{ $sector->NombreSector }}</td>
    <td>
        <a href="{{ route('sectores.edit', $sector->IdSector) }}" class="btn btn-warning btn-sm">Actualizar</a>

        <form action="{{ route('sectores.destroy', $sector->IdSector) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" 
                    onclick="return confirm('¿Estás seguro de eliminar este sector?')">
                Eliminar
            </button>
        </form>
    </td>
</tr>
@endforeach
