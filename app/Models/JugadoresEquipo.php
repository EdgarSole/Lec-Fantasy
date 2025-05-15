<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JugadoresEquipo extends Model
{
    use HasFactory;

    protected $fillable = ['equipo_id', 'jugador_id', 'es_titular'];


    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
    

    
}
