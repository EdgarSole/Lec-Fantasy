<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\UsuarioLiga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary;

class LigaController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login'); // Asegúrate que el usuario está autenticado
        }

        // Obtener las ligas del usuario con conteo de miembros
        $ligas = $user->ligas()
                    ->withCount('usuarios')
                    ->latest()
                    ->get();

        // Pasar las ligas a la vista
        return view('inicio', [
            'ligas' => \App\Models\Liga::limit(3)->get()
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
                        if (\App\Models\Liga::whereRaw('LOWER(nombre) = ?', [strtolower($value)])->exists()) {
                            $fail('Ya existe una liga con ese nombre.');
                        }
                    },
                ],
                'descripcion' => 'nullable|string',
                'tipo' => 'required|in:publica,privada',
                'codigo_unico' => 'nullable|required_if:tipo,privada|string',
                'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $logo_url = 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1745910938/fotoperfil_predeterminada.png';

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

            $liga = Liga::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'logo_url' => $logo_url,
                'codigo_unico' => $request->tipo === 'privada' ? $request->codigo_unico : null,
                'tipo' => $request->tipo,               
                'usuario_id' => auth()->id(),
            ]);

            UsuarioLiga::create([
                'liga_id' => $liga->id,
           'usuario_id' => auth()->id(),           
            ]);

            return redirect()->back()->with('success', 'Liga creada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la liga: ' . $e->getMessage()]);
        }
    }

}