<?php
namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\Equipo;
use App\Models\JugadoresEquipo;
use Illuminate\Http\Request;


class MiLigaController extends Controller
{
    public function index(Liga $liga)
    {
        $liga->load('usuarios'); 
        return view('mi-liga', compact('liga'));
    }

    // Métodos para otras vistas
    public function actividad(Liga $liga)
    {
        return view('actividad', compact('liga'));
    }

    public function miEquipo(Liga $liga)
    {
        $user = auth()->user();

        // Buscar el equipo del usuario en esta liga específica
        $equipo = Equipo::where('usuario_id', $user->id)
                        ->where('liga_id', $liga->id)
                        ->firstOrFail();

        $jugadores = JugadoresEquipo::with('jugador')
            ->where('equipo_id', $equipo->id)
            ->get()
            ->pluck('jugador');

        $valorTotal = $jugadores->sum('valor');

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

        return view('mi-equipo', compact('liga', 'jugadores', 'valorTotal', 'equipo', 'logosEquipos'));
    }



    public function mercado(Liga $liga)
    {
        return view('mercado', compact('liga'));
    }

    public function clasificacion(Liga $liga)
    {
        $equipos = $liga->equipos()
            ->with(['usuario']) // cargamos el usuario para cada equipo
            ->orderByDesc('puntos')
            ->get()
            ->map(function ($equipo) {
                // Cargamos los jugadores reales del equipo desde la tabla intermedia
                $jugadores = \App\Models\JugadoresEquipo::with('jugador')
                    ->where('equipo_id', $equipo->id)
                    ->get()
                    ->pluck('jugador');

                // Sumamos el valor de todos los jugadores
                $equipo->valor_total = $jugadores->sum('valor');

                return $equipo;
            });

        return view('clasificacion', [
            'liga' => $liga,
            'equipos' => $equipos,
        ]);
    }


    public function actualizarLiga(Request $request, Liga $liga)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'tipo' => 'required|in:publica,privada',
            'contrasena' => $request->tipo === 'privada' ? 'nullable|string|min:4' : 'nullable',
            'logo_url' => 'nullable|image|max:2048', // máx 2MB
        ]);

        // Actualizar campos
        $liga->nombre = $request->nombre;
        $liga->descripcion = $request->descripcion;
        $liga->tipo = $request->tipo;

        // Contraseña (sin encriptar)
        if ($request->tipo === 'privada') {
            if ($request->filled('contrasena')) {
                $liga->contrasena = $request->contrasena; // GUARDAR PLANA
            }
            // Si no se envía, se mantiene la anterior
        } else {
            $liga->contrasena = null;
        }

        // Subir nuevo logo a Cloudinary si se proporciona
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

            $liga->logo_url = $uploadResult['secure_url'];
        }

        // Guardar si hay cambios
        if ($liga->isDirty()) {
            $liga->save();
            return redirect()->route('mi-liga', ['liga' => $liga->id])
                            ->with('status', 'Liga actualizada con éxito');
        }

        return redirect()->route('mi-liga', ['liga' => $liga->id])
                        ->with('status', 'No se realizaron cambios');
    }

    


    public function destroy(Liga $liga)
    {
        // Verifica que el usuario autenticado sea el creador de la liga
        if (auth()->id() !== $liga->usuario_id) {
            abort(403);
        }

        // Eliminar las relaciones entre jugadores y equipos en la tabla jugadores_equipos
        \App\Models\JugadoresEquipo::whereHas('equipo', function ($query) use ($liga) {
            $query->where('liga_id', $liga->id);
        })->delete();

        // Eliminar los equipos asociados a la liga
        $liga->equipos()->delete();

        // Eliminar la liga
        $liga->delete();

        // Redirigir al inicio con un mensaje de éxito
        return redirect()->route('inicio')
                        ->with('success', 'Liga y sus equipos eliminados con éxito');
    }

    public function asignarJugador(Request $request, Liga $liga, Equipo $equipo, Jugador $jugador)
    {
        // Verifica que el usuario sea dueño del equipo
        if ($equipo->usuario_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        // Verifica que el equipo pertenezca a esta liga
        if ($equipo->liga_id !== $liga->id) {
            return response()->json(['error' => 'El equipo no pertenece a esta liga'], 403);
        }

        // Recibe la posición del jugador (que está en la tabla jugadores)
        $posicion = $jugador->posicion;
        if (!$posicion) {
            return response()->json(['error' => 'El jugador no tiene posición definida'], 422);
        }

        // Primero, quitar cualquier jugador existente en esta posición
        \App\Models\JugadoresEquipo::where('equipo_id', $equipo->id)
            ->whereHas('jugador', function($query) use ($posicion) {
                $query->where('posicion', $posicion);
            })
            ->update(['es_titular' => false]);

        // Buscar o crear la relación entre el jugador y el equipo
        $jugadorEquipo = \App\Models\JugadoresEquipo::updateOrCreate(
            [
                'equipo_id' => $equipo->id,
                'jugador_id' => $jugador->id
            ],
            [
                'es_titular' => true
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Jugador asignado correctamente como titular en posición ' . $posicion
        ]);
    }



}
