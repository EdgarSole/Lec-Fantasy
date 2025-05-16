<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Mercado;
use App\Models\Puja;
use App\Models\JugadoresEquipo;
use App\Models\Equipo;
use Carbon\Carbon;
use App\Mail\PujaGanadoraNotification;
use Illuminate\Support\Facades\Mail;

class ProcesarPujasFinalizadas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $mercadosFinalizados = Mercado::with(['pujas' => function($query) {
                $query->orderByDesc('cantidad')->with('usuario');
            }, 'liga', 'jugador'])
            ->where('fecha_fin', '<=', Carbon::now())
            ->whereNull('procesado')
            ->get();

        foreach ($mercadosFinalizados as $mercado) {
            // Si no hay pujas, simplemente marcamos como procesado
            if ($mercado->pujas->isEmpty()) {
                $mercado->update(['procesado' => true]);
                continue;
            }

            // Obtener la puja ganadora (la de mayor cantidad)
            $pujaGanadora = $mercado->pujas->first();
            $usuarioGanador = $pujaGanadora->usuario;

            // Obtener equipo del ganador en esta liga
            $equipoGanador = $usuarioGanador->equipos()
                ->where('liga_id', $mercado->liga_id)
                ->first();

            if ($equipoGanador) {
                // Asignar jugador al equipo
                JugadoresEquipo::create([
                    'jugador_id' => $mercado->jugador_id,
                    'equipo_id' => $equipoGanador->id,
                    'es_titular' => false
                ]);

                // Restar el presupuesto
                $equipoGanador->decrement('presupuesto', $pujaGanadora->cantidad);

                // Enviar notificación al ganador
                Mail::to($usuarioGanador->email)->send(
                    new PujaGanadoraNotification($mercado->jugador, $pujaGanadora->cantidad)
                );
            }

            // Marcar como procesado
            $mercado->update(['procesado' => true]);
        }
    }
}