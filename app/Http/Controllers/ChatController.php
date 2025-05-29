<?php

namespace App\Http\Controllers;

use App\Events\NuevoMensajeLiga;
use App\Models\MensajeLiga;
use Illuminate\Http\Request;


class ChatController extends Controller
{

    public function mostrarChat(Liga $liga)
    {
        $mensajes = MensajeLiga::where('liga_id', $liga->id)
            ->with('usuario')
            ->orderBy('created_at')
            ->get();

        dd($liga, $mensajes); // para probar

        return view('chat', compact('liga', 'mensajes'));
    }

    public function enviar(Request $request, Liga $liga)
    {
        $request->validate([
            'mensaje' => 'required|string|max:1000'
        ]);

        $mensaje = MensajeLiga::create([
            'liga_id' => $liga->id,
            'usuario_id' => auth()->id(),
            'mensaje' => $request->mensaje,
        ]);

        event(new NuevoMensajeLiga($mensaje));

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }
}