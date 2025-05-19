<?php

namespace App\Events;
use App\Http\Controllers\MiLigaController;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\MensajeLiga;

class NuevoMensajeLiga implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mensaje;

    public function __construct(MensajeLiga $mensaje)
    {
        // Asegúrate de cargar el usuario relacionado
        $mensaje->load('usuario');
        $this->mensaje = $mensaje;
    }

    public function broadcastOn()
    {
        return new Channel('liga.' . $this->mensaje->liga_id);
    }

    public function broadcastWith()
    {
        return [
            'mensaje' => [
                'id' => $this->mensaje->id,
                'usuario_id' => $this->mensaje->usuario_id,
                'liga_id' => $this->mensaje->liga_id,
                'mensaje' => $this->mensaje->mensaje,
                'created_at' => $this->mensaje->created_at->toDateTimeString(),
                'usuario' => [
                    'name' => $this->mensaje->usuario->name,
                    'foto_perfil' => $this->mensaje->usuario->foto_perfil ?? '/images/default-user.png',
                ]
            ]
        ];
    }

    // Opcional: nombre del evento (por si lo quieres específico en JS)
    public function broadcastAs()
    {
        return 'NuevoMensajeLiga';
    }
}
