@extends('layouts.app')

@section('title', 'Reporte de Reclamo')

@section('content')
    <style>
        .report-container {
            background: #fff;
            border: 1px solid #ddd;
            padding: 40px 50px;
            border-radius: 8px;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .report-header {
            border-bottom: 3px solid #0d6efd;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }

        .report-header h2 {
            color: #0d6efd;
            font-weight: 700;
        }

        .section-title {
            background: #f8f9fa;
            color: #0d6efd;
            font-weight: 600;
            padding: 8px 12px;
            border-left: 4px solid #0d6efd;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .report-table th,
        .report-table td {
            padding: 8px 10px;
            vertical-align: top;
        }

        .report-table th {
            color: #6c757d;
            font-weight: 600;
            text-align: left;
            width: 25%;
        }

        .report-table td {
            font-weight: 500;
        }

        .badge-status {
            font-size: 0.9rem;
            padding: 4px 10px;
        }

        .signature-line {
            margin-top: 50px;
            text-align: center;
        }

        .signature-line hr {
            width: 250px;
            border-top: 2px solid #000;
            margin: 0 auto 5px;
        }
    </style>

    <div class="report-container">
        {{-- Encabezado --}}
        <div class="report-header text-center">
            <h2>Reporte de Reclamo</h2>
            <p class="text-muted mb-0">Generado el {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        {{-- Información principal --}}
        <table class="report-table mb-4">
            <tr>
                <th>Código de Seguimiento:</th>
                <td>
                    {{ $reclamo->CodigoSeguimiento ?? 'N/A' }}
                </td>

                <th>Fecha de Creación:</th>
                <td>{{ \Carbon\Carbon::parse($reclamo->FechaInicial)->format('d/m/Y H:i') ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Categoría:</th>
                <td>{{ $reclamo->categoria->Nombre ?? 'N/A' }}</td>
                <th>Estado del Reclamo:</th>
                <td>
                    @if($reclamo->EstadoReclamo === 'Pendiente')
                        <span class="badge bg-warning text-dark badge-status">Pendiente</span>
                    @elseif($reclamo->EstadoReclamo === 'En Proceso')
                        <span class="badge bg-info text-dark badge-status">En Proceso</span>
                    @elseif($reclamo->EstadoReclamo === 'Resuelto')
                        <span class="badge bg-success badge-status">Resuelto</span>
                    @else
                        <span class="badge bg-secondary badge-status">Desconocido</span>
                    @endif
                </td>

            </tr>
        </table>

        {{-- Descripción --}}
        <div class="section-title">Descripción del Problema</div>
        <p>{{ $reclamo->Descripcion }}</p>

        {{-- Comentarios --}}
        <div class="section-title">Comentarios u Observaciones</div>
        <p>{{ $reclamo->Comentario ?? 'Sin comentarios adicionales.' }}</p>

        {{-- Coordenadas --}}
        <div class="section-title">Ubicación</div>
        <table class="report-table">
            <tr>
                <th>Coordenadas:</th>
                <td>{{ $reclamo->CoordenadasUbicacion ?? 'N/A' }}</td>

                <th>Sector:</th>
                <td>{{ $reclamo->sector->NombreSector ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Barrio:</th>
                <td>{{ $reclamo->barrio->NombreBarrio ?? 'N/A' }}</td>
                <th></th>
                <td></td>
            </tr>
        </table>

        {{-- Imagen evidencia --}}
        @if($reclamo->ImagenEvidencia)
            <div class="section-title">Evidencia Fotográfica</div>
            <img src="data:image/jpeg;base64,{{ base64_encode($reclamo->ImagenEvidencia) }}" alt="Evidencia del Reclamo"
                class="img-fluid rounded shadow-sm" style="max-width:400px;">
        @endif

        {{-- Datos del Abonado --}}
        <div class="section-title">Datos del Abonado</div>
        <table class="report-table">
            <tr>
                <th>Clave Catastral:</th>
                <td>{{ $reclamo->abonado->ClaveCatastral ?? 'N/A' }}</td>
                <th>Nombre Completo:</th>
                <td>{{ $reclamo->abonado->NombreAbonado ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>No. Identidad:</th>
                <td>{{ $reclamo->abonado->NoIdentidad ?? 'N/A' }}</td>
                <th>Código Abonado:</th>
                <td>{{ $reclamo->abonado->CodigoAbonado ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Uso de Suelo:</th>
                <td>{{ $reclamo->abonado->UsoDeSuelo ?? 'N/A' }}</td>
                <th>Tipo de Actividad:</th>
                <td>{{ $reclamo->abonado->TipoActividad ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Celular:</th>
                <td>{{ $reclamo->abonado->Celular ?? 'N/A' }}</td>
                <th>Dirección:</th>
                <td>{{ $reclamo->abonado->Direccion ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha Creación:</th>
                <td>
                    {{ optional($reclamo->abonado->FechaCreacion ? \Carbon\Carbon::parse($reclamo->abonado->FechaCreacion) : null)->format('d/m/Y H:i') ?? 'N/A' }}
                </td>
                <td>
                    {{ optional($reclamo->abonado->FechaActualizacion ? \Carbon\Carbon::parse($reclamo->abonado->FechaActualizacion) : null)->format('d/m/Y H:i') ?? 'N/A' }}
                </td>

            </tr>
        </table>

        {{-- Datos del Operador --}}
        <div class="section-title">Datos del Operador</div>

        @if($reclamo->operador)
            <table class="report-table">
                <tr>
                    <th>Nombre Completo:</th>
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
                            <span class="badge bg-success badge-status">Activo</span>
                        @else
                            <span class="badge bg-danger badge-status">Inactivo</span>
                        @endif
                    </td>
                </tr>
            </table>
        @else
            <div class="alert alert-warning text-center mt-3 mb-0">
                ⚠️ No hay un operador asignado a este reclamo.
            </div>
        @endif



        {{-- Firma --}}
        <div class="signature-line">
            <hr>
            <p class="mb-0 fw-semibold">Firma del Operador</p>
            <small class="text-muted">{{ $reclamo->operador->NombreUsuario ?? '________________' }}</small>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('reclamos.leer') }}" class="btn btn-secondary">
                ← Volver a la lista
            </a>
        </div>

        {{-- Botones de Acción (Descargar PDF y Subir PDF Final) --}}
        <div class="text-end mt-4 d-flex justify-content-end gap-2">
            {{-- Botón 1: Descargar PDF (Generado) --}}
            <a href="{{ route('reclamos.pdf', $reclamo->IdReclamo) }}" class="btn btn-outline-danger">
                📄 Descargar PDF
            </a>

            {{-- Botón 2: Subir PDF Final (Solo si no está ya Resuelto/Terminado) --}}
            @if($reclamo->EstadoReclamo !== 'Resuelto')
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadPdfModal">
                    <i class="bi bi-upload"></i> Subir PDF y Terminar
                </button>
            @else
                <span class="badge bg-success p-2 align-self-center fs-6">Reclamo Terminado (Resuelto)</span>
            @endif
        </div>
        {{-- ... Sección de descarga (asumo que ya existe un botón o enlace de descarga) ... --}}

        @if ($reclamo->EstadoReclamo == 'Resuelto' && $reclamo->RutaFirma)
            <a href="{{ route('reclamos.downloadPdfFinal', $reclamo->IdReclamo) }}" class="btn btn-success" target="_blank">
                <i class="fa fa-download"></i> Descargar PDF Final (Resuelto)
            </a>
        @else
            {{-- Muestra el botón de descarga original para el PDF inicial --}}
            <a href="{{ route('reclamos.pdf', $reclamo->IdReclamo) }}" class="btn btn-secondary" target="_blank">
                <i class="fa fa-file-pdf"></i> Descargar PDF Original
            </a>
        @endif
    </div>

    {{-- Modal para Subir PDF (Formulario de Carga) --}}
    <div class="modal fade" id="uploadPdfModal" tabindex="-1" aria-labelledby="uploadPdfModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="uploadPdfModalLabel">Subir PDF de Reclamo Finalizado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- El formulario apunta a la nueva ruta y envía el archivo --}}
                <form action="{{ route('reclamos.uploadPdfFinal', $reclamo->IdReclamo) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>Suba aquí la versión firmada del reporte. Al confirmar, el estado del reclamo cambiará a
                            **Terminado/Resuelto**.</p>
                        <div class="mb-3">
                            <label for="pdf_final" class="form-label">Seleccionar Archivo PDF</label>
                            <input class="form-control" type="file" id="pdf_final" name="pdf_final" accept="application/pdf"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Confirmar y Marcar como Terminado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection