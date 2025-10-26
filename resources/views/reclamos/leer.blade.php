@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="mb-4 text-primary fw-bold">📋 Lista de Reclamos</h4>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="mb-3 text-end">
            <a href="{{ route('reclamos.exportExcel') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel-fill"></i> Exportar a Excel
            </a>
        </div>

        {{-- 🔍 FILTRO DE BÚSQUEDA --}}
        <form method="GET" action="{{ route('reclamos.leer') }}" class="card mb-4 shadow-sm p-3 border-0">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Categoría</label>
                    <select name="categoria" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->IdCategoria }}" @selected(request('categoria') == $cat->IdCategoria)>
                                {{ $cat->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Abonado</label>
                    <input type="text" name="abonado" class="form-control" placeholder="Nombre del abonado"
                        value="{{ request('abonado') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Operador</label>
                    <select name="operador" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($operadores as $op)
                            <option value="{{ $op->IdUsuario }}" @selected(request('operador') == $op->IdUsuario)>
                                {{ $op->NombreUsuario }} {{ $op->ApellidoUsuario }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Clave Catastral</label>
                    <input type="text" name="clave" class="form-control" placeholder="Ej. 0101-0023-001"
                        value="{{ request('clave') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Código Seguimiento</label>
                    <input type="text" name="codigo" class="form-control" placeholder="Ej. ABC123XYZ"
                        value="{{ request('codigo') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="Pendiente" @selected(request('estado') == 'Pendiente')>Pendiente</option>
                        <option value="En Proceso" @selected(request('estado') == 'En Proceso')>En Proceso</option>
                        <option value="Resuelto" @selected(request('estado') == 'Resuelto')>Resuelto</option>
                    </select>
                </div>

                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                    <a href="{{ route('reclamos.leer') }}" class="btn btn-secondary w-100 mt-2">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>

        {{-- 📊 TABLA DE RECLAMOS --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Código Seguimiento</th>
                            <th>Clave Catastral</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Abonado</th>
                            <th>Sector</th>
                            <th>Operador</th>
                            <th>Estado Reclamo</th>
                            <th style="width: 200px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reclamos as $reclamo)
                            <tr @class([
                                'table-warning' => $reclamo->EstadoReclamo === 'Pendiente',
                                'table-info' => $reclamo->EstadoReclamo === 'En Proceso',
                                'table-success' => $reclamo->EstadoReclamo === 'Resuelto',
                            ])>
                                <td class="text-center">{{ $reclamo->IdReclamo }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $reclamo->CodigoSeguimiento ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $reclamo->abonado->ClaveCatastral ?? 'N/A' }}</td>
                                <td>{{ $reclamo->Descripcion }}</td>
                                <td>{{ $reclamo->categoria->Nombre ?? 'N/A' }}</td>
                                <td>{{ $reclamo->abonado->NombreAbonado ?? 'N/A' }}</td>
                                <td>{{ $reclamo->sector->NombreSector ?? 'N/A' }}</td>
                                <td>{{ $reclamo->operador->NombreUsuario ?? 'No asignado' }}</td>
                                <td class="text-center">
                                    @if ($reclamo->EstadoReclamo === 'Pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($reclamo->EstadoReclamo === 'En Proceso')
                                        <span class="badge bg-info text-dark">En Proceso</span>
                                    @else
                                        <span class="badge bg-success">Resuelto</span>
                                    @endif
                                </td>

                                {{-- 🎯 Acciones --}}
                                <td class="text-center">
                                    @if (auth('usuariolog')->check())
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            @if (auth('usuariolog')->user()->user_tipo == '1')
                                                {{-- 👁️ Ver --}}
                                                <a href="{{ route('reclamos.show', $reclamo->IdReclamo) }}"
                                                    class="btn btn-info btn-sm d-flex align-items-center gap-1">
                                                    <i class="bi"></i> <span>Ver</span>
                                                </a>
                                            @endif

                                            {{-- ✏️ Editar --}}
                                            <a href="{{ route('reclamos.edit', $reclamo->IdReclamo) }}"
                                                class="btn btn-warning btn-sm d-flex align-items-center gap-1 text-white">
                                                <i class="bi"></i> <span>Editar</span>
                                            </a>

                                            {{-- 🗑️ Eliminar --}}
                                            @if (auth('usuariolog')->user()->user_tipo == '1')
                                                <form action="{{ route('reclamos.destroy', $reclamo->IdReclamo) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('¿Está seguro de eliminar el reclamo ID {{ $reclamo->IdReclamo }}?')"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                                                        <i class="bi"></i> <span>Eliminar</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        @if (auth('usuariolog')->user()->user_tipo != '1')
                                            <small class="text-muted d-block mt-1 fst-italic">Solo puedes editar</small>
                                        @endif
                                    @endif
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No hay reclamos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 📄 Paginación --}}
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
            <div class="text-muted small mb-2">
                Mostrando <strong>{{ $reclamos->firstItem() }}</strong> a
                <strong>{{ $reclamos->lastItem() }}</strong>
                de <strong>{{ $reclamos->total() }}</strong> reclamos
            </div>
            <div>
                {{ $reclamos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- 🎨 Estilos --}}
    <style>
        /* ==== Ajuste visual uniforme ==== */
        td.text-center {
            vertical-align: middle !important;
            white-space: nowrap;
        }

        .btn-sm {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Colores planos y consistentes */
        .btn-info {
            background-color: #0dcaf0;
            border: none;
        }

        .btn-info:hover {
            background-color: #0bb7d5;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #212529 !important;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            color: white !important;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
        }

        /* Íconos centrados y alineados */
        .btn i {
            font-size: 1rem;
        }

        /* Espaciado entre botones */
        .gap-2 {
            gap: 8px !important;
        }
    </style>


@endsection
