<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jugadores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'imagen_url',
        'posicion',
        'equipo_real',
        'valor',
        // Agrega aquí cualquier otro campo que necesites
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'valor' => 'integer',
        // Agrega otras conversiones de tipos si es necesario
    ];

    /**
     * Obtener la URL de la imagen del jugador.
     * Si no tiene imagen, devuelve una por defecto.
     *
     * @return string
     */
    public function getImagenUrlAttribute($value)
    {
        return $value ?? 'https://via.placeholder.com/150'; // Imagen por defecto
    }

    // app/Models/Jugador.php

    public function estadisticas()
    {
        return $this->hasOne(EstadisticasJugador::class, 'jugador_id');
    }

    
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class)->withPivot('es_titular');
    }

}