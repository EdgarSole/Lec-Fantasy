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
            $table->string('nombre');
            $table->string('logo_url')->nullable();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('liga_id')->constrained('ligas')->onDelete('cascade');
            $table->decimal('presupuesto', 12, 2)->default(100000000);
            $table->timestamps();
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
