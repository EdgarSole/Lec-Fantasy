<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;  
use Illuminate\Support\Facades\Session;  
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function setLocale($lang, Request $request)
    {
        if(in_array($lang, ['en', 'es'])) {
            App::setLocale($lang);
            Session::put('locale', $lang);
        }

        // Si viene de una ruta con liga, redirigir a esa liga
        if ($request->has('liga')) {
            return redirect()->route('mi-liga', ['liga' => $request->liga]);
        }

        return back();
    }
}
