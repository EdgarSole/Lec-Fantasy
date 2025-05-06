<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('usuarios_ligas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('liga_id')->constrained('ligas')->onDelete('cascade');
        $table->timestamps();
    });
}

    
    public function down()
    {
        Schema::dropIfExists('usuarios_ligas');
    }
    
};
