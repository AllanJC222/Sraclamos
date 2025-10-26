<?php

namespace App\Exports;

use App\Models\Reclamo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReclamosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Reclamo::with(['categoria', 'abonado', 'sector', 'operador'])
            ->orderBy('IdReclamo', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código Seguimiento',
            'Descripción',
            'Categoría',
            'Abonado',
            'Clave Catastral',
            'Sector',
            'Operador',
            'Estado Reclamo',
            'Fecha Inicial',
        ];
    }

    public function map($r): array
    {
        return [
            $r->IdReclamo,
            $r->CodigoSeguimiento,
            $r->Descripcion,
            $r->categoria->Nombre ?? 'N/A',
            $r->abonado->NombreAbonado ?? 'N/A',
            $r->abonado->ClaveCatastral ?? 'N/A',
            $r->sector->NombreSector ?? 'N/A',
            $r->operador->NombreUsuario ?? 'N/A',
            $r->EstadoReclamo,
            $r->FechaInicial,
        ];
    }
}
