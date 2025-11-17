<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\Equipo;
use App\Models\JugadoresEquipo;
use App\Models\Jugador;
use App\Models\HistorialTransacciones;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $ligas = Liga::with(['creador'])
            ->withCount('equipos as usuarios_count')
            ->when($search, function ($query, $search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.dashboard', compact('ligas', 'search'));
    }

    public function showLiga(Liga $liga)
    {
        $liga->load(['creador', 'equipos.usuario', 'equipos.jugadores']);

        $usuariosDisponibles = User::whereDoesntHave('equipos', function ($q) use ($liga) {
                $q->where('liga_id', $liga->id);
            })
            ->orderBy('nombre')
            ->get();

        return view('admin.ligas.show', compact('liga', 'usuariosDisponibles'));
    }

    public function createLiga()
    {
        $usuarios = User::orderBy('nombre')->get();

        return view('admin.ligas.create', compact('usuarios'));
    }

    public function storeLiga(Request $request)
    {
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
            'contrasena' => 'nullable|required_if:tipo,privada|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'usuario_id' => 'required|exists:users,id',
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

        $creador = User::findOrFail($request->usuario_id);

        $liga = Liga::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'logo_url' => $logo_url,
            'contrasena' => $request->tipo === 'privada' ? $request->contrasena : null,
            'tipo' => $request->tipo,
            'usuario_id' => $creador->id,
        ]);

        $equipo = Equipo::create([
            'usuario_id' => $creador->id,
            'liga_id' => $liga->id,
            'posicion' => 1,
        ]);

        $posiciones = ['Top', 'Jungla', 'Mid', 'Adc', 'Support'];

        foreach ($posiciones as $posicion) {
            $jugador = Jugador::where('posicion', $posicion)
                ->whereNotIn('id', function ($query) use ($liga) {
                    $query->select('jugador_id')
                        ->from('jugadores_equipos')
                        ->join('equipos', 'equipos.id', '=', 'jugadores_equipos.equipo_id')
                        ->where('equipos.liga_id', $liga->id);
                })
                ->inRandomOrder()
                ->first();

            if ($jugador) {
                JugadoresEquipo::create([
                    'jugador_id' => $jugador->id,
                    'equipo_id' => $equipo->id,
                    'es_titular' => false,
                ]);
            }
        }

        $puntosTotales = $equipo->jugadores()->sum('puntos');
        $equipo->update([
            'puntos' => $puntosTotales,
        ]);

        HistorialTransacciones::create([
            'liga_id' => $liga->id,
            'equipo_id' => $equipo->id,
            'tipo' => 'info',
            'descripcion' => 'Liga creada por admin ' . (Auth::guard('admin')->user()->email ?? ''),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Liga creada correctamente.');
    }

    public function editLiga(Liga $liga)
    {
        $usuarios = User::orderBy('nombre')->get();

        return view('admin.ligas.edit', compact('liga', 'usuarios'));
    }

    public function updateLiga(Request $request, Liga $liga)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'tipo' => 'required|in:publica,privada',
            'contrasena' => $request->tipo === 'privada' ? 'nullable|string|min:4' : 'nullable',
            'logo_url' => 'nullable|image|max:2048',
            'usuario_id' => 'required|exists:users,id',
        ]);

        $liga->nombre = $request->nombre;
        $liga->descripcion = $request->descripcion;
        $liga->tipo = $request->tipo;
        $liga->usuario_id = $request->usuario_id;

        if ($request->tipo === 'privada') {
            if ($request->filled('contrasena')) {
                $liga->contrasena = $request->contrasena;
            }
        } else {
            $liga->contrasena = null;
        }

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

        if ($liga->isDirty()) {
            $liga->save();
        }

        return redirect()->route('admin.ligas.show', $liga)->with('success', 'Liga actualizada correctamente.');
    }

    public function destroyLiga(Liga $liga)
    {
        JugadoresEquipo::whereHas('equipo', function ($query) use ($liga) {
            $query->where('liga_id', $liga->id);
        })->delete();

        $liga->equipos()->delete();

        $liga->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Liga eliminada correctamente por el administrador.');
    }

    public function addUserToLiga(Request $request, Liga $liga)
    {
        $data = $request->validate([
            'usuario_id' => 'required|exists:users,id',
        ]);

        $usuarioId = $data['usuario_id'];

        // Evitar duplicados: si ya tiene equipo en esta liga, no crear otro
        $yaTieneEquipo = $liga->equipos()->where('usuario_id', $usuarioId)->exists();
        if ($yaTieneEquipo) {
            return back()->with('success', 'Ese usuario ya pertenece a la liga.');
        }

        $equipo = Equipo::create([
            'usuario_id' => $usuarioId,
            'liga_id' => $liga->id,
        ]);

        // Opcional: podrías asignar jugadores aquí si lo deseas

        return back()->with('success', 'Usuario añadido a la liga correctamente.');
    }

    public function removeUserFromLiga(Liga $liga, Equipo $equipo)
    {
        if ($equipo->liga_id !== $liga->id) {
            abort(404);
        }

        JugadoresEquipo::where('equipo_id', $equipo->id)->delete();
        $equipo->delete();

        return back()->with('success', 'Usuario eliminado de la liga correctamente.');
    }
}
