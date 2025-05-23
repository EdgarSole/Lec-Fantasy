<?php
namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\Equipo;
use App\Models\JugadoresEquipo;
use Illuminate\Http\Request;
use App\Models\Mercado;
use App\Models\Puja;
use App\Models\Jugador;
use App\Models\HistorialTransacciones;
use Carbon\Carbon;
use App\Jobs\ProcesarPujasFinalizadas;
use App\Models\User;
use App\Events\NuevoMensajeLiga;
use App\Models\MensajeLiga;
use Cloudinary\Cloudinary;  
use Illuminate\Support\Facades\DB;



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
        $query = HistorialTransacciones::with(['equipo.usuario', 'jugador'])
            ->where('liga_id', $liga->id);
            

        if ($tipo = request('tipo')) {
            if ($tipo == 'evento') {
                $query->whereNotIn('tipo', ['compra', 'venta']);
            } else {
                $query->where('tipo', $tipo);
            }
        }

        $actividades = $query->orderBy('created_at', 'desc')->paginate(7);

        $actividades->getCollection()->transform(function ($actividad) {
            $actividad->fecha_formateada = $actividad->created_at->addHours(2)->format('d/m/Y H:i');
            return $actividad;
        });

        return view('actividad', compact('liga', 'actividades'));
    }



    public function miEquipo(Liga $liga)
    {
        $user = auth()->user();

        // Buscar el equipo del usuario en esta liga específica, cargando estadisticas de jugadores
        $equipo = Equipo::with(['jugadores' => function ($query) {
            $query->withPivot('es_titular')->with('estadisticas'); 
        }])
        ->where('usuario_id', $user->id)
        ->where('liga_id', $liga->id)
        ->firstOrFail();

        $jugadoresEquipo = $equipo->jugadores;

        $titulares = $jugadoresEquipo->filter(function ($jugador) {
            return $jugador->pivot->es_titular;
        });

        $valorTotal = $jugadoresEquipo->sum('valor');

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

        return view('mi-equipo', compact(
            'liga',
            'equipo',
            'jugadoresEquipo',
            'titulares',
            'valorTotal',
            'logosEquipos'
        ));
    }

    
    public function venderJugador(Request $request, Liga $liga, Equipo $equipo)
{
    $request->validate([
        'jugador_id' => 'required|exists:jugadores,id',
        'valor_venta' => 'required|numeric'
    ]);
    
    // Verificar que el jugador pertenece al equipo
    if (!$equipo->jugadores()->where('jugador_id', $request->jugador_id)->exists()) {
        return response()->json([
            'success' => false, 
            'error' => 'El jugador no pertenece a este equipo'
        ]);
    }
    
    try {
        DB::transaction(function () use ($equipo, $request) {
            // Eliminar al jugador del equipo
            $equipo->jugadores()->detach($request->jugador_id);
            
            // Aumentar el presupuesto del equipo
            $equipo->increment('presupuesto', $request->valor_venta);
            
            // Registrar en historial de transacciones
            DB::table('historial_transacciones')->insert([
                'liga_id' => $equipo->liga_id,
                'equipo_id' => $equipo->id,
                'jugador_id' => $request->jugador_id,
                'tipo' => 'venta',
                'precio' => $request->valor_venta,
                'descripcion' => 'Venta de jugador',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
        
        return response()->json([
            'success' => true,
            'message' => "El jugador fue vendido con éxito!"
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Error al vender el jugador: ' . $e->getMessage()
        ]);
    }
}

    public function mercado(Liga $liga)
    {
        $user = auth()->user();
        $equipo = Equipo::where('usuario_id', $user->id)
                    ->where('liga_id', $liga->id)
                    ->firstOrFail();
        
        // Obtener mercado actual con pujas
        $mercadoActual = Mercado::with(['jugador', 'pujas.equipo'])
                        ->where('liga_id', $liga->id)
                        ->where('fecha_fin', '>', now())
                        ->where('fecha_inicio', '<=', now())
                        ->get();
        
        // Si no hay mercado activo, crear uno nuevo
        if ($mercadoActual->isEmpty()) {
            $mercadoActual = $this->crearNuevoMercado($liga);
        }
        
        // Obtener pujas del usuario actual
        $pujasUsuario = Puja::where('equipo_id', $equipo->id)
                        ->whereIn('mercado_id', $mercadoActual->pluck('id'))
                        ->get()
                        ->keyBy('mercado_id');
        
        // Calcular tiempo restante para la próxima actualización
        $tiempoRestante = $this->calcularTiempoRestante($mercadoActual->first()->fecha_fin);
        
        return view('mercado', compact(
            'liga',
            'equipo',
            'mercadoActual',
            'pujasUsuario',
            'tiempoRestante'
        ));
    }

    private function crearNuevoMercado(Liga $liga)
    {
        // 1. Procesar mercados finalizados no procesados
        $mercadosFinalizados = Mercado::with(['pujas.equipo', 'jugador'])
            ->where('liga_id', $liga->id)
            ->where('fecha_fin', '<=', now())
            ->where('procesado', false)
            ->get();
        
        foreach ($mercadosFinalizados as $mercado) {
            $this->procesarMercado($mercado);
        }
        
        // 2. Eliminar mercados procesados antiguos
        Mercado::where('liga_id', $liga->id)
            ->where('procesado', true)
            ->delete();
        
        // 3. Crear nuevo mercado
        $jugadoresEnEquipos = JugadoresEquipo::whereIn('equipo_id', 
            Equipo::where('liga_id', $liga->id)->pluck('id')
        )->pluck('jugador_id');
        
        $jugadoresDisponibles = Jugador::whereNotIn('id', $jugadoresEnEquipos)
            ->inRandomOrder()
            ->limit(5)
            ->get();
        
        if ($jugadoresDisponibles->isEmpty()) {
            throw new \Exception("No hay jugadores disponibles para crear mercado");
        }
        
        $fechaInicio = now();
        $fechaFin = $fechaInicio->copy()->addMinutes(5);
        
        $nuevosMercados = [];
        foreach ($jugadoresDisponibles as $jugador) {
            $nuevosMercados[] = Mercado::create([
                'liga_id' => $liga->id,
                'jugador_id' => $jugador->id,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'procesado' => false
            ]);
        }
        
        // Retornar con relaciones cargadas
        return Mercado::with(['jugador', 'pujas.equipo'])
                ->whereIn('id', collect($nuevosMercados)->pluck('id'))
                ->get();
    }

    private function calcularTiempoRestante($fechaFin)
    {
        $segundos = now()->diffInSeconds($fechaFin);
        
        return [
            'horas' => floor($segundos / 3600),
            'minutos' => floor(($segundos % 3600) / 60),
            'segundos' => $segundos % 60,
            'total_segundos' => $segundos
        ];
    }

  public function pujar(Request $request, Liga $liga)
{
    $request->validate([
        'mercado_id' => 'required|exists:mercado,id',
        'cantidad' => 'required|numeric|min:0',
    ]);
    
    $user = auth()->user();
    $mercado = Mercado::with('jugador')->findOrFail($request->mercado_id);

    $equipo = $user->equipos()->where('liga_id', $liga->id)->first();

    if (!$equipo) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró el equipo del usuario en esta liga.'
        ], 404);
    }

    // Crear o actualizar puja
    $puja = Puja::updateOrCreate(
        ['equipo_id' => $equipo->id, 'mercado_id' => $request->mercado_id],
        ['cantidad' => $request->cantidad]
    );

    // Obtener todas las pujas actualizadas para este mercado (ordenadas)
    $pujasMercado = Puja::with('equipo')
        ->where('mercado_id', $request->mercado_id)
        ->orderBy('cantidad', 'desc')
        ->get();

    // Calcular nuevo presupuesto disponible
    $pujasTotales = Puja::where('equipo_id', $equipo->id)
        ->whereHas('mercado', function($q) use ($liga) {
            $q->where('liga_id', $liga->id)
              ->where('fecha_fin', '>', now());
        })
        ->sum('cantidad');

    return response()->json([
    'success' => true, // Indica que la operación fue exitosa
    'presupuesto' => $equipo->presupuesto, // Presupuesto total del equipo
    'pujas_totales' => $pujasTotales, // Suma total de las pujas realizadas
    'pujas_mercado' => $pujasMercado->map(function($puja) {
        return [
            'equipo_nombre' => $puja->equipo->usuario->nombre, // Nombre del equipo que realizó la puja
            'cantidad' => $puja->cantidad, // Cantidad pujada
            'fecha' => $puja->created_at->format('H:i:s') // Hora en que se hizo la puja
        ];
    }),
    'mercado_id' => $request->mercado_id, // ID del mercado consultado
    'jugador_nombre' => $mercado->jugador->nombre, // Nombre del jugador subastado
    'jugador_valor' => $mercado->jugador->valor, // Valor base o actual del jugador
    'cantidad_pujada' => $request->cantidad, // Cantidad que se intenta pujar
    'presupuesto_restante' => $equipo->presupuesto - $pujasTotales // Presupuesto que queda después de las pujas
]);

}

   private function procesarMercado(Mercado $mercado)
{
    $mercado->load(['pujas.equipo', 'jugador']);

    \DB::transaction(function () use ($mercado) {
        if ($mercado->pujas->isEmpty()) {
            $mercado->update(['procesado' => true]);
            return;
        }

        $pujaGanadora = $mercado->pujas->sortByDesc('cantidad')->first();
        $equipoGanador = $pujaGanadora->equipo;

        if ($equipoGanador) {
            // Verificar y agregar jugador al equipo
            JugadoresEquipo::firstOrCreate([
                'jugador_id' => $mercado->jugador_id,
                'equipo_id' => $equipoGanador->id
            ], ['es_titular' => false]);

            // Registrar transacción
            DB::table('historial_transacciones')->insert([
                'liga_id' => $mercado->liga_id,
                'equipo_id' => $equipoGanador->id,
                'jugador_id' => $mercado->jugador_id,
                'tipo' => 'compra',
                'precio' => $pujaGanadora->cantidad,
                'descripcion' => 'Puja por ' . $mercado->jugador->nombre,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Actualizar presupuesto
            $equipoGanador->decrement('presupuesto', $pujaGanadora->cantidad);
            $equipoGanador->refresh();
        }

        $mercado->update(['procesado' => true]);
    });
}



public function eliminarPuja(Request $request, Liga $liga)
{
    $request->validate([
        'mercado_id' => 'required|exists:mercado,id',
    ]);
    
    $user = auth()->user();

    $equipo = Equipo::where('usuario_id', $user->id)
        ->where('liga_id', $liga->id)
        ->firstOrFail();

    $puja = Puja::where('equipo_id', $equipo->id)
        ->where('mercado_id', $request->mercado_id)
        ->firstOrFail();
    
    $puja->delete();
    
    return response()->json(['success' => true]);
}

    public function procesarPujas(Liga $liga)
{
    try {
        // Procesar inmediatamente en lugar de solo despachar el job
        $mercados = Mercado::where('liga_id', $liga->id)
            ->where('fecha_fin', '<=', now())
            ->where('procesado', false)
            ->get();
        
        foreach ($mercados as $mercado) {
            $this->procesarMercado($mercado);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Mercado procesado correctamente',
            'shouldReload' => true 
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function clasificacion(Liga $liga)
    {
        $equipos = $liga->equipos()
            ->with(['usuario'])
            ->orderByDesc('puntos')
            ->get()
            ->map(function ($equipo) {
                $jugadores = \App\Models\JugadoresEquipo::with('jugador')
                    ->where('equipo_id', $equipo->id)
                    ->get()
                    ->pluck('jugador');
                $equipo->valor_total = $jugadores->sum('valor');
                return $equipo;
            });

        // Todos los jugadores por equipo (para filtrar en frontend)
        $jugadoresEquipos = \App\Models\JugadoresEquipo::with('jugador')->get();

        $jugadoresEquiposArray = $jugadoresEquipos->map(function($je) {
            return [
                'equipo_id' => $je->equipo_id,
                'jugador_id' => $je->jugador_id,
                'nombre' => $je->jugador->nombre,
                'posicion' => $je->jugador->posicion,
                'valor' => $je->jugador->valor,
                'imagen_url' => $je->jugador->imagen_url,
                'equipo_real' => $je->jugador->equipo_real,
                'puntos' => $je->jugador->puntos,
            ];
        });
        return view('clasificacion', compact('liga', 'equipos', 'jugadoresEquiposArray'));

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
        // Seguridad
        if ($equipo->usuario_id !== auth()->id()) {
            return response()->json(['error' => 'ACCESO DENEGADO: No eres el dueño de este equipo'], 403);
        }
        if ($equipo->liga_id !== $liga->id) {
            return response()->json(['error' => 'CONFLICTO: El equipo no pertenece a esta liga'], 403);
        }

        // Obtener relación jugador-equipo
        $relacion = JugadoresEquipo::where('equipo_id', $equipo->id)
            ->where('jugador_id', $jugador->id)
            ->firstOrFail();

        // Si el jugador ya es titular, al desactivarlo simplemente lo pasa a banquillo
        if ($relacion->es_titular) {
            $relacion->es_titular = false;
            $relacion->save();
            
            return response()->json([
                'success' => true,
                'message' => "⚡ ¡JUGADOR MOVIDO AL BANQUILLO! {$jugador->nombre} ya no es titular",
                'es_titular' => false
            ]);
        }

        // Si queremos poner este jugador como titular, primero desactivamos el titular actual en esa posición
        JugadoresEquipo::where('equipo_id', $equipo->id)
            ->whereHas('jugador', function($query) use ($jugador) {
                $query->where('posicion', $jugador->posicion);
            })
            ->where('es_titular', true)
            ->update(['es_titular' => false]);

        // Ahora activamos al jugador que queremos titular
        $relacion->es_titular = true;
        $relacion->save();

        return response()->json([
            'success' => true,
            'message' => "🎮 ¡NUEVO TITULAR CONFIRMADO! {$jugador->nombre} es ahora tu {$jugador->posicion}",
            'es_titular' => true
        ]);
    }

    
    public function mostrarChat(Liga $liga)
    {
        // Agrupa los mensajes por fecha
        $mensajes = MensajeLiga::where('liga_id', $liga->id)
            ->with('usuario')
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });

        $imagenesChat = MensajeLiga::where('liga_id', $liga->id)
            ->where('tipo', 'imagen')
            ->with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        $participantes = User::whereHas('mensajes', function ($query) use ($liga) {
            $query->where('liga_id', $liga->id);
        })
        ->withCount([
            'mensajes' => function ($query) use ($liga) {
                $query->where('liga_id', $liga->id);
            }
        ])
        ->get();

        return view('chat', compact('liga', 'mensajes', 'participantes', 'imagenesChat'));
    }


    public function enviarChat(Request $request, Liga $liga)
    {
        $request->validate([
            'mensaje' => 'nullable|string|max:1000',
            'imagen' => 'nullable|image|max:2048', 
        ]);

        $tipo = 'texto';
        $imagen_url = null;
        $foto= 'imagen';
    if ($request->hasFile('imagen')) {
        $foto = $request->file('imagen'); // Aquí obtienes el archivo correctamente

        $cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key'    => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ]
        ]);
        $public_id = 'liga_' . $liga->id .
                '_user_' . auth()->id() .
                '_ts_' . now()->format('Ymd_His'); 

        $uploadResult = $cloudinary->uploadApi()->upload($foto->getRealPath(), [
            'folder' => 'Fotos_Chat',
            'public_id' => $public_id,
            'overwrite' => false, // no sobreescribe por si acaso
        ]);

        $imagen_url = $uploadResult['secure_url'];  
        $tipo = 'imagen';
    }


        $mensaje = MensajeLiga::create([
            'liga_id' => $liga->id,
            'usuario_id' => auth()->id(),
            'mensaje' => $request->mensaje ?? '', 
            'imagen_url' => $imagen_url,
            'tipo' => $tipo,
        ]);

        event(new NuevoMensajeLiga($mensaje));

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    public function borrarChat(Liga $liga)
    {
        // Elimina los mensajes asociados a la liga
        MensajeLiga::where('liga_id', $liga->id)->delete();

        // Devuelve respuesta JSON
        return response()->json(['success' => true]);
    }


}
