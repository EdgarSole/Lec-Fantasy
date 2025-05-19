<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeLiga extends Model
{   
    protected $table = 'mensajes_liga';
    protected $fillable = [
        'liga_id', 
        'usuario_id', 
        'mensaje', 

    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

}