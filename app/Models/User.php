<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'nombre',  
        'email',
        'password',
        'foto_url',  
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'usuario_id');
    }

    public function ligas()
    {
        return $this->belongsToMany(Liga::class, 'equipos', 'usuario_id', 'liga_id');
    }

    

}
