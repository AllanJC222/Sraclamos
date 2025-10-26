<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoriareclamo', function (Blueprint $table) {
            $table->id('IdCategoria');
            $table->string('Nombre', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoriareclamo');
    }
};