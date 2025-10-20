<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la BD.
     */
    protected $table = 'usuario';

    /**
     * Llave primaria.
     */
    protected $primaryKey = 'IdUsuario'; // ✅ corregido

    /**
     * La llave es autoincremental.
     */
    public $incrementing = true;

    /**
     * Tipo de la llave primaria.
     */
    protected $keyType = 'int';

    /**
     * La tabla tiene timestamps manejados por Laravel.
     */
    public $timestamps = false;

    /**
     * Campos asignables en masa.
     */
    protected $fillable = [
        'NombreUsuario',
        'ApellidoUsuario',
        'Email',   // ✅ incluir Email
        'Celular',
        'IdRol',
        'Estado',
    ];

    /**
     * Relación con el modelo Rol.
     */
    public function rol()
    {
        return $this->belongsTo(rol::class, 'IdRol', 'IdRol');
    }
}
