<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('IdUsuario');
            $table->string('NombreUsuario', 50);
            $table->string('ApellidoUsuario', 50);
            $table->string('Email', 100)->unique();
            $table->string('Celular', 15);
            
            // Llave foránea para rol
            $table->unsignedBigInteger('IdRol');
            $table->foreign('IdRol', 'RolUsuarioFk')
                  ->references('IdRol')->on('rol'); // Sin cascade
            
            $table->tinyInteger('Estado')->default(1)->comment('0=Inactivo, 1=Activo');
            
            // Timestamps personalizados del SQL
            $table->timestamp('FechaCreacion')->useCurrent();
            $table->timestamp('FechaActualizacion')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};