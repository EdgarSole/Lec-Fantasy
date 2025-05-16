<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialTransacciones extends Model
{
    protected $table = 'historial_transacciones';

    protected $fillable = [
        'liga_id',
        'equipo_id',
        'jugador_id',
        'tipo',
        'precio',
        'descripcion',
    ];

    // Relación con Liga
    public function liga()
    {
        return $this->belongsTo(Liga::class);
    }

    // Relación con Equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    // Relación con Jugador
    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }
}
