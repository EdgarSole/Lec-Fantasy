<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    protected $fillable = [
        'nombre', 
        'descripcion', 
        'logo_url', 
        'tipo', 
        'codigo_unico', 
        'usuario_id'
    ];
    

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuarios_ligas', 'liga_id', 'usuario_id')
                    ->withTimestamps();
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}