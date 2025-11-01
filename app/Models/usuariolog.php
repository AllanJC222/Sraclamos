<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class usuariolog extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuariolog';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_name',
        'user_pass',
        'user_tipo',
    ];

    protected $hidden = [
        'user_pass',
    ];

    public function getAuthPassword(){
        return $this -> user_pass;
    }

    /**
     * Mutador para estandarizar el nombre de usuario a minúsculas.
     *
     * Convierte automáticamente el user_name a minúsculas antes de guardarlo
     * en la base de datos, garantizando consistencia y evitando duplicados
     * por diferencias de mayúsculas/minúsculas.
     *
     * @param string $value
     * @return void
     */
    public function setUserNameAttribute($value)
    {
        $this->attributes['user_name'] = strtolower(trim($value));
    }

    //para que no se manejen los datos tipo fecha o hora
    public $timestamps = false;



}//final del modelo 
