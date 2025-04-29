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
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;



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
            'nombre' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);       
        
        // Manejo de la foto
        $foto_url = null;
        if ($request->hasFile('foto')) {
            // Obtener el archivo de la foto
            $foto = $request->file('foto');
            
            //Hace referencia a config/services.php 
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key'    => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ]
            ]);
            
            // Subir la foto a Cloudinary 
            $uploadResult = $cloudinary->uploadApi()->upload($foto->getRealPath(), [
                'folder' => 'Foto_Perfil',
                'public_id' => strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9_]/', '', $request->nombre))),
                'overwrite' => true,
            ]);

            // Obtener la URL de la imagen subida
            $foto_url = $uploadResult['secure_url'];
        } else {
            // Foto predeterminada en Cloudinary
            $foto_url ="https://res.cloudinary.com/dpsvxf3qg/image/upload/v1745910938/fotoperfil_predeterminada.png";
        }

        // Crear el usuario
        $user = User::create([
            'nombre' => $request->nombre,  
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_url' => $foto_url,  
        ]);

        // Iniciar sesión automáticamente
        auth()->login($user);

        // Redirigir a la ruta deseada (por ejemplo, el dashboard)
        return redirect('/dashboard');
    }

}
