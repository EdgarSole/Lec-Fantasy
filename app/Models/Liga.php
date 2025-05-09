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
        'contrasena', 
        'usuario_id'
    ];
    

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'equipos', 'liga_id', 'usuario_id')
                    ->withTimestamps();
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'liga_id');
    }
    

}