<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barrio extends Model
{
    use HasFactory;
    /**
     * Nombre de la tabla en la BD.
     * @var string
     */
    protected $table = 'barrio';

    /**
     * Llave primaria.
     * @var string
     */
    protected $primaryKey = 'IdBarrio';

    /**
     * Si la llave primaria es autoincremental.
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipo de la llave primaria.
     * @var string
     */
    protected $keyType = 'int';

    /**
     * La tabla no tiene timestamps (created_at / updated_at).
     * @var bool
     */
    public $timestamps = false;

    /**
     * Campos asignables en masa.
     * @var array
     */
    protected $fillable = [
        'NombreBarrio',
        'IdSector',
    ];

    /**
     * Relación con el modelo Sector.
     * Un Barrio pertenece a un Sector.
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'IdSector', 'IdSector');
    }
}