<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = [
        'usuario_id',
        'liga_id',
        'presupuesto',
        'posicion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function liga()
    {
        return $this->belongsTo(Liga::class);
    }
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'liga_id');
    }

    
    public function jugadores()
    {
        return $this->belongsToMany(Jugador::class, 'jugadores_equipos');
    }


}
