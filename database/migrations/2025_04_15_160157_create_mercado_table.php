<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mercado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liga_id')->constrained('ligas')->onDelete('cascade');
            $table->foreignId('jugador_id')->constrained('jugadores')->onDelete('cascade');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mercado');
    }
};
