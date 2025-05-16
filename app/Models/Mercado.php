<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    use HasFactory;

    protected $table = 'mercado';

    protected $fillable = ['liga_id', 'jugador_id', 'fecha_inicio', 'fecha_fin'];

    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }

    public function liga()
    {
        return $this->belongsTo(Liga::class);
    }

    public function pujas()
    {
        return $this->hasMany(Puja::class);
    }   

}

