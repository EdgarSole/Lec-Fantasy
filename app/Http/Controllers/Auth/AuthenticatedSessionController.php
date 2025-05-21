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
        $login = $request->input('login');

        $user = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? \App\Models\User::where('email', $login)->first()
            : \App\Models\User::where('nombre', $login)->first();

        if ($user && \Hash::check($request->password, $user->password)) {
            // Guardar el idioma actual antes de loguear
            $locale = session('locale', 'es');

            Auth::login($user);
            $request->session()->regenerate();

            // Restaurar el idioma después del login
            session(['locale' => $locale]);

            return redirect()->route('inicio');
        }

        throw ValidationException::withMessages([
            'login' => trans('auth.failed'),
        ]);
    }

    


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $locale = session('locale', 'es'); // Guardar idioma actual

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Restaurar idioma después de logout
        session(['locale' => $locale]);

        return redirect('/');
    }

}
