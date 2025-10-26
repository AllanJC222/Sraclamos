<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// IMPORTANTE: El nombre de la clase debe ser 'Abonado' (mayúscula)
class Abonado extends Model
{
    use HasFactory;
    
    /**
     * El nombre exacto de la tabla en la base de datos.
     */
    protected $table = 'abonados';

    /**
     * ¡CORRECCIÓN CRÍTICA!
     * El nombre de la clave primaria de la tabla debe ser IdAbonado (singular).
     */
    protected $primaryKey = 'IdAbonado';

    /**
     * Indica si la clave primaria es auto-incrementable.
     */
    public $incrementing = true;

    /**
     * El tipo de dato de la clave primaria.
     */
    protected $keyType = 'int';

    /**
     * Indica que no se usan los timestamps (created_at y updated_at).
     */
    public $timestamps = false;

    /**
     * Los atributos que se pueden llenar de forma masiva (mass assignable).
     */
    protected $fillable = [
        'ClaveCatastral',
        'NoIdentidad',
        'CodigoAbonado',
        'NombreAbonado',
        'UsoDeSuelo',
        'TipoActividad',
        'IdSector',
        'Direccion',
        'Celular',
        'Estado',
    ];

    /**
     * Definir la relación con el modelo Sector.
     */
    public function sector()
    {
        // Se define usando las claves foráneas explícitas (IdSector)
        return $this->belongsTo(Sector::class, 'IdSector', 'IdSector');
    }
}
