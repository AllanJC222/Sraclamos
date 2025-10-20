<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barrio', function (Blueprint $table) {
            $table->id('IdBarrio');
            $table->string('NombreBarrio', 100);
            
            // Llave foránea para sector
            $table->unsignedBigInteger('IdSector');
            $table->foreign('IdSector', 'fk_barrio_sector')
                  ->references('IdSector')->on('sector')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barrio');
    }
};
