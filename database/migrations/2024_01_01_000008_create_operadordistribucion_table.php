<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operadordistribucion', function (Blueprint $table) {
            $table->id('IdOperadorDistribucion');
            $table->dateTime('HoraInicio');
            $table->dateTime('HoraFinal');
            
            $table->unsignedBigInteger('IdUsuarioOperador');
            $table->unsignedBigInteger('IdSector');
            
            $table->tinyInteger('Estado')->default(1)->comment('0=Inactivo, 1=Activo');
            
            $table->timestamp('FechaCreacion')->useCurrent();
            $table->timestamp('FechaActualizacion')->useCurrent()->useCurrentOnUpdate();

            // Constraints
            $table->foreign('IdUsuarioOperador', 'OperadorUsuarioFk')
                  ->references('IdUsuario')->on('usuario');
            $table->foreign('IdSector', 'SectorAsignadoFk')
                  ->references('IdSector')->on('sector');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operadordistribucion');
    }
};