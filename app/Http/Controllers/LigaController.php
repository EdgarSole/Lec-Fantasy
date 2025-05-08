<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary;

class LigaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Obtener ligas del usuario con conteo de equipos
        $ligas = $user->ligas()
            ->withCount(['equipos as miembros_count'])
            ->latest()
            ->get();

        // Obtener todas las ligas con conteo de miembros
        $todasLasLigas = Liga::withCount('equipos')
            ->select('id', 'nombre', 'tipo', 'logo_url')
            ->get();

        return view('inicio', [
            'ligas' => $ligas,
            'todasLasLigas' => $todasLasLigas,
        ]);
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        if (Liga::whereRaw('LOWER(nombre) = ?', [strtolower($value)])->exists()) {
                            $fail('Ya existe una liga con ese nombre.');
                        }
                    },
                ],
                'descripcion' => 'nullable|string',
                'tipo' => 'required|in:publica,privada',
                'codigo_unico' => 'nullable|required_if:tipo,privada|string',
                'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $logo_url = 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1746528986/fotoliga_predeterminada.webp';

            if ($request->hasFile('logo_url')) {
                $logo = $request->file('logo_url');

                $cloudinary = new \Cloudinary\Cloudinary([
                    'cloud' => [
                        'cloud_name' => config('services.cloudinary.cloud_name'),
                        'api_key'    => config('services.cloudinary.api_key'),
                        'api_secret' => config('services.cloudinary.api_secret'),
                    ]
                ]);

                $uploadResult = $cloudinary->uploadApi()->upload($logo->getRealPath(), [
                    'folder' => 'Foto_Liga',
                    'public_id' => strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9_]/', '', $request->nombre))),
                    'overwrite' => true,
                ]);

                $logo_url = $uploadResult['secure_url'];
            }

            // Crear la liga
            $liga = Liga::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'logo_url' => $logo_url,
                'codigo_unico' => $request->tipo === 'privada' ? $request->codigo_unico : null,
                'tipo' => $request->tipo,               
                'usuario_id' => auth()->id(),
            ]);

            // Crear el equipo del usuario en la liga (posición 1)
            Equipo::create([
                'usuario_id' => Auth::id(), 
                'liga_id' => $liga->id,
                'posicion' => 1 // Primer miembro
            ]);

            return redirect()->back()->with('success', 'Liga creada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la liga: ' . $e->getMessage()]);
        }
    }

    public function salir($ligaId)
    {
        
        $user = Auth::user();
        $liga = Liga::findOrFail($ligaId);
    
        // Verifica si el usuario es el líder
       
    
        // Eliminar el equipo del usuario
        $deleted = Equipo::where('usuario_id', $user->id)
              ->where('liga_id', $ligaId)
              ->delete();
    
        if (!$deleted) {
            return redirect()->back()->with('error', 'No se encontró tu equipo en esta liga');
        }
    
        // Verificar si quedan miembros
        $miembrosRestantes = Equipo::where('liga_id', $ligaId)->count();
    
        if ($miembrosRestantes === 0) {
            $liga->delete();
            return redirect()->route('inicio')->with('success', 'La liga se ha eliminado al quedarse sin miembros.');
        }
    
        // Reordenar posiciones
        $equipos = Equipo::where('liga_id', $ligaId)
                         ->orderBy('posicion')
                         ->get();
    
        foreach ($equipos as $index => $equipo) {
            $equipo->update(['posicion' => $index + 1]);
        }
    
        return redirect()->route('inicio')->with('success', 'Has salido de la liga correctamente.');
    }
    

    public function buscarLigas(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $ligas = Liga::withCount('equipos as usuarios_count')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                return $query->where('nombre', 'like', '%'.$searchTerm.'%');
            })
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'logo_url', 'tipo']);

        return response()->json($ligas);
    }

    public function unirse(Request $request)
    {
        $request->validate([
            'liga_id' => 'required|exists:ligas,id',
            'password' => 'nullable|string'
        ]);

        $user = Auth::user();
        $liga = Liga::findOrFail($request->liga_id);

        // Verificar si ya tiene un equipo en esta liga
        if (Equipo::where('usuario_id', $user->id)
                 ->where('liga_id', $liga->id)
                 ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tienes un equipo en esta liga.'
            ], 422);
        }

        // Verificar contraseña si es privada
        if ($liga->tipo === 'privada' && $liga->codigo_unico !== $request->password) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta.'
            ], 422);
        }

        // Crear el equipo del usuario en la liga
        $posicion = Equipo::where('liga_id', $liga->id)->count() + 1;
        
        Equipo::create([
            'usuario_id' => $user->id,
            'liga_id' => $liga->id,
            'posicion' => $posicion
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Te has unido a la liga correctamente.'
        ]);
    }
}