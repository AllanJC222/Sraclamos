<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Reclamo #{{ $reclamo->IdReclamo }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .report-container {
            border: 1px solid #ccc;
            padding: 30px 40px;
            border-radius: 8px;
        }
        .report-header {
            border-bottom: 2px solid #0d6efd;
            margin-bottom: 20px;
            text-align: center;
        }
        .report-header h2 {
            color: #0d6efd;
            margin: 0;
            font-size: 22px;
        }
        .section-title {
            background: #f0f4ff;
            color: #0d6efd;
            font-weight: bold;
            padding: 6px 10px;
            border-left: 4px solid #0d6efd;
            margin-top: 20px;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            padding: 6px 8px;
            vertical-align: top;
        }
        th {
            color: #666;
            text-align: left;
            width: 30%;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            color: #fff;
        }
        .bg-warning { background: #ffc107; color: #000; }
        .bg-info { background: #17a2b8; color: #000; }
        .bg-success { background: #28a745; }
        .bg-secondary { background: #6c757d; }
        .bg-danger { background: #dc3545; }
        img {
            margin-top: 10px;
            max-width: 300px;
            border-radius: 4px;
        }
        .signature-line {
            margin-top: 40px;
            text-align: center;
        }
        .signature-line hr {
            width: 200px;
            border-top: 1px solid #000;
            margin: 0 auto 5px;
        }
        .alert {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="report-container">
    <div class="report-header">
        <h2>Reporte de Reclamo</h2>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    {{-- Datos principales --}}
    <table>
        <tr>
            <th>Número Reclamo:</th>
            <td>{{ $reclamo->IdReclamo }}</td>
            <th>Fecha de Creación:</th>
            <td>{{ \Carbon\Carbon::parse($reclamo->FechaInicial)->format('d/m/Y H:i') ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Categoría:</th>
            <td>{{ $reclamo->categoria->Nombre ?? 'N/A' }}</td>
            <th>Estado del Reclamo:</th>
            <td>
                @if($reclamo->EstadoReclamo === 'Pendiente')
                    <span class="badge bg-warning">Pendiente</span>
                @elseif($reclamo->EstadoReclamo === 'En Proceso')
                    <span class="badge bg-info">En Proceso</span>
                @elseif($reclamo->EstadoReclamo === 'Resuelto')
                    <span class="badge bg-success">Resuelto</span>
                @else
                    <span class="badge bg-secondary">Desconocido</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">Descripción del Problema</div>
    <p>{{ $reclamo->Descripcion }}</p>

    <div class="section-title">Comentarios</div>
    <p>{{ $reclamo->Comentario ?? 'Sin comentarios.' }}</p>

    <div class="section-title">Ubicación</div>
    <table>
        <tr>
            <th>Coordenadas:</th>
            <td>{{ $reclamo->CoordenadasUbicacion ?? 'N/A' }}</td>
            <th>Sector:</th>
            <td>{{ $reclamo->sector->NombreSector ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Barrio:</th>
            <td>{{ $reclamo->barrio->NombreBarrio ?? 'N/A' }}</td>
        </tr>
    </table>

    @if($reclamo->ImagenEvidencia)
        <div class="section-title">Evidencia Fotográfica</div>
        <img src="data:image/jpeg;base64,{{ base64_encode($reclamo->ImagenEvidencia) }}" alt="Evidencia">
    @endif

    <div class="section-title">Datos del Abonado</div>
    <table>
        <tr>
            <th>Clave Catastral:</th>
            <td>{{ $reclamo->abonado->ClaveCatastral ?? 'N/A' }}</td>
            <th>Nombre:</th>
            <td>{{ $reclamo->abonado->NombreAbonado ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>No Identidad:</th>
            <td>{{ $reclamo->abonado->NoIdentidad ?? 'N/A' }}</td>
            <th>Código Abonado:</th>
            <td>{{ $reclamo->abonado->CodigoAbonado ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Uso de Suelo:</th>
            <td>{{ $reclamo->abonado->UsoDeSuelo ?? 'N/A' }}</td>
            <th>Tipo Actividad:</th>
            <td>{{ $reclamo->abonado->TipoActividad ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Dirección:</th>
            <td>{{ $reclamo->abonado->Direccion ?? 'N/A' }}</td>
            <th>Celular:</th>
            <td>{{ $reclamo->abonado->Celular ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">Datos del Operador</div>
    @if($reclamo->operador)
        <table>
            <tr>
                <th>Nombre:</th>
                <td>{{ $reclamo->operador->NombreUsuario ?? 'N/A' }} {{ $reclamo->operador->ApellidoUsuario ?? '' }}</td>
                <th>Email:</th>
                <td>{{ $reclamo->operador->Email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Celular:</th>
                <td>{{ $reclamo->operador->Celular ?? 'N/A' }}</td>
                <th>Rol:</th>
                <td>{{ $reclamo->operador->rol->NombreRol ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Estado:</th>
                <td colspan="3">
                    @if(($reclamo->operador->Estado ?? 0) == 1)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
            </tr>
        </table>
    @else
        <div class="alert">
            ⚠️ No hay un operador asignado a este reclamo.
        </div>
    @endif

    <div class="signature-line">
        <hr>
        <p><strong>Firma del Operador</strong></p>
        <small>{{ $reclamo->operador->NombreUsuario ?? '________________' }}</small>
    </div>
</div>
</body>
</html>
