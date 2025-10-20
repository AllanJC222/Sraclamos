<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class usuariolog extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuariolog';

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


    //para que no se manejen los datos tipo fecha o hora
    public $timestamps = false;



}//final del modelo 
