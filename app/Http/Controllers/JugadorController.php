<?php

namespace App\Http\Controllers;

use App\Models\Jugador;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    public function index()
    {
        $jugadores = Jugador::all();
        $equipos = Jugador::select('equipo_real')->distinct()->pluck('equipo_real');
        $logosEquipos = [
        'Team Heretics' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747036744/TeamHeretics.webp',
        'Fnatic' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747036743/Fnatic.webp',
        'Karmine Corp' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747036743/KarmineCorp.webp',
        'G2' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747037231/G2.png',
        'Movistar KOI' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747042004/MKOI_no9k5z.webp',
        'Team Vitality' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747042007/VIT_eevazm.webp',
        'SK' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747042071/SK_rty62c.png',
        'GiantX' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747042117/GiantX_dhbwww.png',
        'Rogue' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747042005/RGE_p1dwbo.webp',
        'BDS' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747042008/BDS_bbprhw.webp',
];

        return view('jugadores', [
            'jugadores' => $jugadores,
            'equipos' => $equipos,
            'logosEquipos' => $logosEquipos
        ]);
    }
}