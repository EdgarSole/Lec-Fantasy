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
        Schema::create('historial_transacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_fantasy_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('jugador_id')->constrained('jugadores')->onDelete('cascade');
            $table->enum('tipo', ['compra', 'venta']);
            $table->decimal('precio', 10, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_transacciones');
    }
};
