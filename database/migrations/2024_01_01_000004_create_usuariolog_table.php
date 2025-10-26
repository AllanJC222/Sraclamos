<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuariolog', function (Blueprint $table) {
            $table->id(); // Coincide con 'id INT NOT NULL AUTO_INCREMENT'
            $table->string('user_name', 50);
            $table->string('user_pass', 256);
            $table->string('user_tipo', 2)->nullable();
            // Esta tabla no usa timestamps en el SQL
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuariolog');
    }
};
