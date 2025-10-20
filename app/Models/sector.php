<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sector extends Model
{
    use HasFactory;
    // Nombre exacto de la tabla en la BD
    protected $table = 'sector';

    // Nombre de la clave primaria
    protected $primaryKey = 'IdSector';

    // Si la clave primaria no es auto_increment o no es integer, ajusta aquí
    public $incrementing = true;
    protected $keyType = 'int';

    // Si tu tabla no usa timestamps (created_at / updated_at)
    public $timestamps = false;

    // Campos que se pueden llenar masivamente
    protected $fillable = ['NombreSector'];
}
