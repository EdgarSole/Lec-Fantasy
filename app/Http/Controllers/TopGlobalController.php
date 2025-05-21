<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Liga;
use App\Models\User;
use Illuminate\Http\Request;

class TopGlobalController extends Controller
{
    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda
        $searchUser = $request->input('search_user');
        $searchTeam = $request->input('search_team');
        
        // Consulta base ordenada por puntos descendente
        $query = Equipo::with(['usuario', 'liga'])
            ->orderBy('puntos', 'DESC');
            
        // Aplicar filtros si existen
        if ($searchUser) {
            $query->whereHas('usuario', function($q) use ($searchUser) {
                $q->where('name', 'LIKE', "%{$searchUser}%");
            });
        }
        
        if ($searchTeam) {
            $query->where('nombre_equipo', 'LIKE', "%{$searchTeam}%");
        }
        
        // Paginar resultados (20 por página)
        $equipos = $query->paginate(20);
        
        return view('top-global', [
            'equipos' => $equipos,
            'searchUser' => $searchUser,
            'searchTeam' => $searchTeam
        ]);
    }
}