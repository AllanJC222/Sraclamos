<?php
// Archivo: app/Models/Noticia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    // Especificamos cómo se llama la tabla en la BD
    protected $table = 'noticias';

    // Especificamos la llave primaria
    protected $primaryKey = 'IdNoticia';

    // Definimos los campos que SÍ se pueden llenar masivamente
    protected $fillable = [
        'Titulo',
        'Contenido',
        'Publicado',
    ];
}