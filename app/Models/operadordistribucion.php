<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class operadordistribucion extends Model
{
    use HasFactory;
    
    protected $table = 'operadordistribucion';
    protected $primaryKey = 'IdOperadorDistribucion';
    public $timestamps = false; 
    // Nota: Si quieres que FechaCreacion y FechaActualizacion funcionen, 
    // asegúrate de que $timestamps sea true o de agregarlas a $fillable.
    
    protected $fillable = [
        'HoraInicio',
        'HoraFinal',
        // *** CORRECCIÓN CRÍTICA 1: Usar el nombre de columna final de la DB ***
        'IdUsuarioOperador', 
        'IdSector',
        'Estado', 
    ];

    // Relación con usuario (Operador Encargado)
    public function usuarioOperador() // Nombre de relación más claro (Opcional)
    {
        // *** CORRECCIÓN CRÍTICA 2: Usar la clave foránea final ***
        // 'IdUsuarioOperador' es el campo en esta tabla que apunta a 'IdUsuario' en la tabla 'usuario'.
        return $this->belongsTo(Usuario::class, 'IdUsuarioOperador', 'IdUsuario');
    }

    // Relación con sector
    public function sector()
    {
        // Correcto: 'IdSector' en esta tabla apunta a 'IdSector' en la tabla 'sector'.
        return $this->belongsTo(Sector::class, 'IdSector', 'IdSector');
    }
}