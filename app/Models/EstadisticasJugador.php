<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadisticasJugador extends Model
{
    protected $table = 'estadisticas_jugadores';

    protected $fillable = [
        'jugador_id',
        'kills',
        'asistencias',
        'muertes',
        'puntos_vision',
        'objetivo_robado',
        'danio_torres',
        'oro',
        'solo_kills',
        'double_kills',
        'triple_kills',
        'quadra_kills',
        'penta_kills',
        'danio_campeones',
        'danio_recibido',
        'tiempo_muerto',
        'botin_conseguido',
        'botin_perdido',
        'primera_sangre',
        'primera_torre',
    ];

    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }
}
