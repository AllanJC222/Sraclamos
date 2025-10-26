<?php
// Archivo: database/migrations/YYYY_MM_DD_HHMMSS_create_noticias_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id('IdNoticia'); // Llave primaria
            $table->string('Titulo');
            $table->text('Contenido');
            $table->boolean('Publicado')->default(false);
            $table->timestamps(); // Crea 'created_at' y 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};