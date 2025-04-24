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
        Schema::create('estadisticas_jugador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jugador_id')->constrained('jugadores')->onDelete('cascade');
            $table->foreignId('partida_id')->constrained('partidas')->onDelete('cascade');
            $table->integer('kills')->default(0);
            $table->integer('muertes')->default(0);
            $table->integer('asistencias')->default(0);
            $table->integer('cs')->default(0);
            $table->boolean('ganado')->default(false);
            $table->integer('torres_destruidas')->default(0);
            $table->decimal('puntos_fantasy', 8, 2)->default(0); // Este se calculará
            $table->timestamps();
        });
        
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estadisticas_jugadores');
    }
};
