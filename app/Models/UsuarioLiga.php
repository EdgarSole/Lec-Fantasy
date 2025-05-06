<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioLiga extends Model
{
    protected $table = 'usuarios_ligas';

    protected $fillable = [
        'liga_id',
        'usuario_id'
    ];

    public function liga()
    {
        return $this->belongsTo(Liga::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
