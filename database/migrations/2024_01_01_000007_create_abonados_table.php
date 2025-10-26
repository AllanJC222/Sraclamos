<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abonados', function (Blueprint $table) {
            $table->id('IdAbonado');
            $table->string('ClaveCatastral', 20);
            $table->string('NoIdentidad', 20)->unique();
            $table->string('CodigoAbonado', 20)->unique();
            $table->string('NombreAbonado', 45);
            $table->string('UsoDeSuelo', 45);
            $table->string('TipoActividad', 45);
            
            // Llave foránea para sector
            $table->unsignedBigInteger('IdSector');
            $table->foreign('IdSector', 'ZonaAbonadoFk')
                  ->references('IdSector')->on('sector'); // Sin cascade
                  
            $table->string('Direccion', 150);
            $table->string('Celular', 15);
            $table->tinyInteger('Estado')->default(1)->comment('0=Inactivo, 1=Activo');
            
            // Timestamps personalizados del SQL
            $table->timestamp('FechaCreacion')->useCurrent();
            $table->timestamp('FechaActualizacion')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abonados');
    }
};