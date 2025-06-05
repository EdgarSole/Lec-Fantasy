<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact'); 
    }

    public function submit(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:2000',
    ]);

    // Procesar el formulario
   // Mail::to('contacto@lecfantasy.com')->send(new ContactFormSubmitted($validated));

    return back()->with('success', __('messages.contact-success'));
}

}