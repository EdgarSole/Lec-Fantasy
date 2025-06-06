<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puja extends Model
{
    use HasFactory;

    protected $table = 'pujas';

    protected $fillable = ['equipo_id', 'mercado_id', 'cantidad'];

    public function mercado()
    {
        return $this->belongsTo(Mercado::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

}
