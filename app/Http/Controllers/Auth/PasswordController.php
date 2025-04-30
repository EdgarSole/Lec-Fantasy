<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password without requiring the current one.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validar si se ha enviado una nueva contraseña
        if ($request->filled('password')) {
            $validated = $request->validate([
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            // Actualizar la contraseña del usuario autenticado
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return back()->with('status', 'password-updated');
    }
}
