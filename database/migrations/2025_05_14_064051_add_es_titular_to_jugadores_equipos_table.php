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
        Schema::table('jugadores_equipos', function (Blueprint $table) {
            $table->boolean('es_titular')->default(false);
        });
    }

    public function down()
    {
        Schema::table('jugadores_equipos', function (Blueprint $table) {
            $table->dropColumn('es_titular');
        });
    }

};
