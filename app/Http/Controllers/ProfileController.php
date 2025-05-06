<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validación personalizada
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255', 'unique:users,nombre,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'foto_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Verificar si el email fue cambiado
        $emailCambiado = $request->email !== $user->email;

        // Actualizar datos
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->descripcion = $request->descripcion;

        if ($emailCambiado) {
            $user->email_verified_at = null;
        }

        // Actualizar contraseña si se proporcionó
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Subir nueva foto de perfil
        if ($request->hasFile('foto_url')) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key' => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ]
            ]);

            $uploadResult = $cloudinary->uploadApi()->upload(
                $request->file('foto_url')->getRealPath(), [
                    'folder' => 'Foto_Perfil',
                    'public_id' => strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-ZñÑáéíóúÁÉÍÓÚ_]/u', '', $request->nombre))),
                    'overwrite' => true,
                    'resource_type' => 'image'
                ]
            );

            $user->foto_url = $uploadResult['secure_url'];
        }

        $user->save();

        // Reautenticar al usuario si el email fue cambiado (opcional pero recomendable)
        if ($emailCambiado) {
            Auth::login($user);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Eliminar la foto de perfil de Cloudinary
        if ($user->foto_url) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key' => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ]
            ]);

            // Aquí asumimos que usaste 'user_NOMBRE' como public_id
            // Asegúrate de replicar la lógica de nombre exactamente como al subir
            $publicId = 'Foto_Perfil/' . strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-ZñÑáéíóúÁÉÍÓÚ_]/u', '', $user->nombre)));


            try {
                $cloudinary->uploadApi()->destroy($publicId, [
                    'invalidate' => true,
                ]);
            } catch (\Exception $e) {
                // Opcional: loguear o manejar error si falla la eliminación
            } 
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}