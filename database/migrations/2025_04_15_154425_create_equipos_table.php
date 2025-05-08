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
    Schema::create('equipos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('liga_id')->constrained('ligas')->onDelete('cascade');
        $table->decimal('presupuesto', 12)->default(100000000);
        $table->unsignedInteger('posicion')->nullable();
        $table->integer('puntos')->default(0);
        $table->timestamps();

        // Evitar duplicados: un usuario solo puede tener un equipo por liga
        $table->unique(['usuario_id', 'liga_id']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
