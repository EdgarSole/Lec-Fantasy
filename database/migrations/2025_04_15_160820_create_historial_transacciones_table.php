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
            $table->foreignId('liga_id')->nullable()->constrained('ligas')->onDelete('cascade');
            $table->unsignedBigInteger('equipo_id')->nullable(); // SIN ->constrained() 
            $table->foreignId('jugador_id')->nullable()->constrained('jugadores')->nullOnDelete();
            $table->enum('tipo', ['compra', 'venta', 'info'])->nullable();
            $table->decimal('precio', 12)->nullable();
            $table->text('descripcion')->nullable();
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
