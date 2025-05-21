<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;  
use Illuminate\Support\Facades\Session;  
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function setLocale($lang)
    {
        if(in_array($lang, ['en', 'es'])) {
            App::setLocale($lang);
            Session::put('locale', $lang);
        }

        return back();
    }
}
