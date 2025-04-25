<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validación de los campos
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:users'],  // Validación para asegurar que el nombre sea único
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Manejo de la foto
        $foto_url = null;
        if ($request->hasFile('foto')) {
            // Obtener la extensión del archivo
            $extension = $request->file('foto')->getClientOriginalExtension();
            
            // Generar el nombre de la foto como el nombre del usuario
            $nombre_imagen = strtolower(str_replace(' ', '_', $request->nombre)) . '.' . $extension;

            // Definir la ruta donde se guardará la foto (directamente en public/Foto_Perfil)
            $path = public_path('Foto_Perfil/' . $nombre_imagen);
            
            // Mover el archivo a la carpeta public/Foto_Perfil
            $request->file('foto')->move(public_path('Foto_Perfil'), $nombre_imagen);
            
            // Guardar la URL de la foto (relativa a la carpeta public)
            $foto_url = 'Foto_Perfil/' . $nombre_imagen;
        } else {
            // Si no se sube foto, usar la foto predeterminada
            $foto_url = 'Foto_Perfil/fotoperfil_predeterminada.png';
        }

        // Crear el usuario
        $user = User::create([
            'nombre' => $request->nombre,  // Guardar el nombre
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_url' => $foto_url,  // Guardar la URL de la foto
        ]);

        // Iniciar sesión automáticamente
        auth()->login($user);

        // Redirigir a la ruta deseada (por ejemplo, el dashboard)
        return redirect('/dashboard'); // Asegúrate de que la ruta "/dashboard" exista en tus rutas
    }

}
