<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migración para normalizar todos los nombres de usuario existentes a minúsculas.
 *
 * Esta migración actualiza todos los registros en la tabla `usuariolog`
 * para convertir los nombres de usuario (user_name) a minúsculas,
 * garantizando la estandarización del formato en toda la aplicación.
 *
 * IMPORTANTE: Esta migración debe ejecutarse después de implementar
 * el mutador setUserNameAttribute en el modelo usuariolog.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Obtener todos los usuarios de la tabla usuariolog
        $usuarios = DB::table('usuariolog')->get();

        // Actualizar cada usuario para convertir user_name a minúsculas
        foreach ($usuarios as $usuario) {
            DB::table('usuariolog')
                ->where('id', $usuario->id)
                ->update([
                    'user_name' => strtolower(trim($usuario->user_name))
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // No se puede revertir esta migración de forma automática
        // ya que no se conserva el formato original de mayúsculas/minúsculas.
        // Si es necesario revertir, debe hacerse manualmente con los datos originales.
    }
};
