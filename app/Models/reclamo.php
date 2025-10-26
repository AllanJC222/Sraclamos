<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importación de modelos relacionados (en mayúscula inicial)
use App\Models\CategoriaReclamo;
use App\Models\Abonado;
use App\Models\Sector;
use App\Models\Barrio;
use App\Models\Usuario;
use App\Models\OperadorDistribucion;

class Reclamo extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'reclamos';

    /**
     * Clave primaria personalizada.
     */
    protected $primaryKey = 'IdReclamo';

    /**
     * La clave primaria es incremental y de tipo entero.
     */
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Desactiva timestamps automáticos (no existen created_at / updated_at).
     */
    public $timestamps = false;

    /**
     * Campos que pueden asignarse de forma masiva (mass assignment).
     */
    protected $fillable = [
        'Descripcion',
        'IdCategoria',
        'FechaInicial',
        'FechaFinal',
        'IdAbonado',
        'IdSector',
        'IdBarrio',
        'Estado',
        'CoordenadasUbicacion',
        'ImagenEvidencia',
        'IdUsuarioOperador',
        'Comentario',
        'EstadoReclamo',
        'RutaFirma',       //para guardar firma
        'CodigoSeguimiento',   
    ];


    /* ------------------------------------------------------------------
     | RELACIONES ENTRE TABLAS
     |-------------------------------------------------------------------*/

    /**
     * Relación con la tabla 'categoriareclamo'.
     * Un reclamo pertenece a una categoría.
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaReclamo::class, 'IdCategoria', 'IdCategoria');
    }

    /**
     * Relación con la tabla 'abonados'.
     * Un reclamo pertenece a un abonado.
     */
    public function abonado()
    {
        return $this->belongsTo(Abonado::class, 'IdAbonado', 'IdAbonado');
    }

    /**
     * Relación con la tabla 'sector'.
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'IdSector', 'IdSector');
    }

    /**
     * Relación con la tabla 'barrio'.
     */
    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'IdBarrio', 'IdBarrio');
    }

    /**
     * Relación con la tabla 'usuario'.
     * Representa el operador encargado del reclamo.
     */
    public function operador()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuarioOperador', 'IdUsuario');
    }

    /**
     * Relación con la tabla 'operadordistribucion' (opcional).
     * Solo si planeas usar el historial de distribución o asignaciones.
     */
    public function operadorDistribucion()
    {
        return $this->belongsTo(OperadorDistribucion::class, 'IdUsuarioOperador', 'IdUsuarioOperador');
    }

    /* ------------------------------------------------------------------
     | ⚙️ MÉTODOS ÚTILES ADICIONALES (opcionales)
     |-------------------------------------------------------------------*/

    /**
     * Devuelve el estado del reclamo en texto legible.
     */
    public function getEstadoTextoAttribute()
    {
        return $this->Estado == 1 ? 'Activo' : 'Inactivo';
    }

    /**
     * Accesor para formatear la fecha inicial.
     */
    public function getFechaInicialFormattedAttribute()
    {
        return $this->FechaInicial ? date('d/m/Y H:i', strtotime($this->FechaInicial)) : 'Sin fecha';
    }

    /**
     * Accesor para mostrar un resumen corto de la descripción.
     */
    public function getResumenDescripcionAttribute()
    {
        return strlen($this->Descripcion) > 50 
            ? substr($this->Descripcion, 0, 50) . '...' 
            : $this->Descripcion;
    }
}
