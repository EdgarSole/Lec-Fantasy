<?php
namespace App\Http\Controllers;

use App\Models\Liga;
use Illuminate\Http\Request;


class MiLigaController extends Controller
{
    public function index(Liga $liga)
    {
        $liga->load('usuarios'); 
        return view('mi-liga', compact('liga'));
    }

    // Métodos para otras vistas
    public function actividad(Liga $liga)
    {
        return view('actividad', compact('liga'));
    }

    public function miEquipo(Liga $liga)
    {
        return view('mi-equipo', compact('liga'));
    }

    public function mercado(Liga $liga)
    {
        return view('mercado', compact('liga'));
    }

    public function clasificacion(Liga $liga)
    {
        return view('clasificacion', compact('liga'));
    }

    public function actualizarLiga(Request $request, Liga $liga)
{
    // Validaciones
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:1000',
        'tipo' => 'required|in:publica,privada',
        'contrasena' => $request->tipo === 'privada' ? 'nullable|string|min:4' : 'nullable',
        'logo_url' => 'nullable|image|max:2048', // máx 2MB
    ]);

    // Actualizar campos
    $liga->nombre = $request->nombre;
    $liga->descripcion = $request->descripcion;
    $liga->tipo = $request->tipo;

    // Contraseña (sin encriptar)
    if ($request->tipo === 'privada') {
        if ($request->filled('contrasena')) {
            $liga->contrasena = $request->contrasena; // GUARDAR PLANA
        }
        // Si no se envía, se mantiene la anterior
    } else {
        $liga->contrasena = null;
    }

    // Subir nuevo logo a Cloudinary si se proporciona
    if ($request->hasFile('logo_url')) {
        $logo = $request->file('logo_url');

        $cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key'    => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ]
        ]);

        $uploadResult = $cloudinary->uploadApi()->upload($logo->getRealPath(), [
            'folder' => 'Foto_Liga',
            'public_id' => strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9_]/', '', $request->nombre))),
            'overwrite' => true,
        ]);

        $liga->logo_url = $uploadResult['secure_url'];
    }

    // Guardar si hay cambios
    if ($liga->isDirty()) {
        $liga->save();
        return redirect()->route('mi-liga', ['liga' => $liga->id])
                         ->with('status', 'Liga actualizada con éxito');
    }

    return redirect()->route('mi-liga', ['liga' => $liga->id])
                     ->with('status', 'No se realizaron cambios');
}

    


public function destroy(Liga $liga)
{
    if (auth()->id() !== $liga->usuario_id) {
        abort(403);
    }

    // Eliminar equipos asociados
    $liga->equipos()->delete();

    // Eliminar la liga
    $liga->delete();

    return redirect()->route('inicio')
                     ->with('success', 'Liga y sus equipos eliminados con éxito');
}


}
