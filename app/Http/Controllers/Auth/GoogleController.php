<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $foto_url ="https://res.cloudinary.com/dpsvxf3qg/image/upload/v1745910938/fotoperfil_predeterminada.png";
        // Buscar o crear el usuario
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'nombre' => $googleUser->getName(),
                'password' => bcrypt(str()->random(16)), // contraseña aleatoria
                'foto_url' => $foto_url,
            ]
        );

        Auth::login($user);

        return redirect()->intended(route('dashboard'));
    }
}
