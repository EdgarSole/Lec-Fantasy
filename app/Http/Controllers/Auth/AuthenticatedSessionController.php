<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Obtener el campo 'login' (puede ser nombre o email)
        $login = $request->input('login');

        // Verificamos si el 'login' es un email o un nombre
        $user = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? \App\Models\User::where('email', $login)->first()
            : \App\Models\User::where('nombre', $login)->first();

        // Verificamos si el usuario existe y si la contraseña es correcta
        if ($user && \Hash::check($request->password, $user->password)) {
            // Iniciar sesión
            Auth::login($user);
            $request->session()->regenerate();

            // Redirigir al dashboard o la página prevista
            return redirect()->intended(route('dashboard'));
        }

        // Si no se encuentra el usuario o la contraseña es incorrecta
        throw ValidationException::withMessages([
            'login' => trans('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
