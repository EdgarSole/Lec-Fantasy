<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JugadoresEquipo extends Model
{
    use HasFactory;

    protected $fillable = ['jugador_id', 'equipo_id'];

    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
    

    
}
