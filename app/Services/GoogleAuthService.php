<?php

namespace App\Services;

use Laravel\Socialite\Facades\Socialite;

class GoogleAuthService
{
    public function getUserData(string $token): array
    {
        $googleUser = Socialite::driver('google')->stateless()->userFromToken($token);

        return [
            'email' => $googleUser->getEmail(),
            'nombre' => $googleUser->getName(),
            'foto_url' => $googleUser->getAvatar(),
        ];
    }
}
