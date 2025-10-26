<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->id('IdRol');
            $table->string('NombreRol', 50);
            $table->tinyInteger('Estado')->default(1)->comment('0=Inactivo, 1=Activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rol');
    }
};