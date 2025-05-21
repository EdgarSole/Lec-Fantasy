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
        Schema::create('estadisticas_jugadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jugador_id')->constrained('jugadores'); // Relación con la tabla jugadores
            $table->integer('kills')->default(0);
            $table->integer('asistencias')->default(0);
            $table->integer('muertes')->default(0);
            $table->integer('puntos_vision')->default(0);
            $table->integer('objetivo_robado')->default(0);
            $table->integer('danio_torres')->default(0);
            $table->integer('oro')->default(0);
            $table->integer('solo_kills')->default(0);
            $table->integer('double_kills')->default(0);
            $table->integer('triple_kills')->default(0);
            $table->integer('quadra_kills')->default(0);
            $table->integer('penta_kills')->default(0);
            $table->integer('danio_campeones')->default(0);
            $table->integer('danio_recibido')->default(0);
            $table->integer('tiempo_muerto')->default(0);
            $table->integer('botin_conseguido')->default(0);
            $table->integer('botin_perdido')->default(0);
            $table->boolean('primera_sangre')->default(false);
            $table->boolean('primera_torre')->default(false);
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
