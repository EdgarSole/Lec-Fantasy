<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadisticaJugador extends Model
{
    protected $table = 'estadisticas_jugadores'; 

    protected $fillable = [
        'jugador_id', 'fecha_jornada', 'kills', 'asistencias', 'muertes',
        'puntos_vision', 'danio_torres', 'oro', 'solo_kills', 'double_kills',
        'triple_kills', 'quadra_kills', 'penta_kills', 'danio_campeones',
        'danio_recibido', 'primera_sangre', 'primera_torre',
        'tiempo_muerto', 'botin_conseguido', 'botin_perdido'
    ];


    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }
}