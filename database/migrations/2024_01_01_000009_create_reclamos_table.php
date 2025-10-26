<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reclamos', function (Blueprint $table) {
            $table->id('IdReclamo');
            $table->string('Descripcion', 255);
            $table->unsignedBigInteger('IdCategoria');
            $table->timestamp('FechaInicial')->useCurrent();
            $table->timestamp('FechaFinal')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('IdAbonado');
            $table->string('CodigoSeguimiento', 50)->nullable();
            $table->unsignedBigInteger('IdSector');
            $table->unsignedBigInteger('IdBarrio');
            $table->tinyInteger('Estado')->default(1)->comment('0=Inactivo, 1=Activo');
            $table->string('CoordenadasUbicacion', 255)->nullable();
            $table->binary('ImagenEvidencia')->nullable();
            $table->unsignedBigInteger('IdUsuarioOperador');
            $table->string('Comentario', 500)->nullable();
            $table->enum('EstadoReclamo', ['Pendiente', 'En Proceso', 'Resuelto'])->default('Pendiente');

            // Constraints
            $table->foreign('IdCategoria')->references('IdCategoria')->on('categoriareclamo');
            $table->foreign('IdAbonado')->references('IdAbonado')->on('abonados');
            $table->foreign('IdSector')->references('IdSector')->on('sector');
            $table->foreign('IdBarrio')->references('IdBarrio')->on('barrio');
            $table->foreign('IdUsuarioOperador', 'ReclamoOperadorFk')
                  ->references('IdUsuario')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reclamos');
    }
};