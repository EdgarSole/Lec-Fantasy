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
        $mercadosFinalizados = Mercado::with(['pujas.equipo.usuario', 'liga', 'jugador'])
            ->where('fecha_fin', '<=', now())
            ->where('procesado', false)
            ->get();

        foreach ($mercadosFinalizados as $mercado) {
            // Procesar el mercado
            $this->procesarMercado($mercado);
            
            // Enviar notificaciones si hay pujas
            if ($mercado->pujas->isNotEmpty()) {
                $pujaGanadora = $mercado->pujas->sortByDesc('cantidad')->first();
                
                // Notificar al ganador
                if ($pujaGanadora && $pujaGanadora->equipo && $pujaGanadora->equipo->usuario) {
                    try {
                        Mail::to($pujaGanadora->equipo->usuario->email)
                            ->send(new PujaGanadoraNotification($mercado, $pujaGanadora));
                    } catch (\Exception $e) {
                        \Log::error('Error enviando notificación de puja ganadora: ' . $e->getMessage());
                    }
                }
            }
        }
    }

    private function procesarMercado(Mercado $mercado)
    {
        $mercado->load(['pujas.equipo', 'jugador']);

        \DB::transaction(function () use ($mercado) {
            if ($mercado->pujas->isEmpty()) {
                $mercado->update(['procesado' => true]);
                return;
            }

            $pujaGanadora = $mercado->pujas->sortByDesc('cantidad')->first();
            $equipoGanador = $pujaGanadora->equipo;

            if ($equipoGanador) {
                // 1. Verificar y agregar jugador al equipo
                \App\Models\JugadoresEquipo::firstOrCreate([
                    'jugador_id' => $mercado->jugador_id,
                    'equipo_id' => $equipoGanador->id
                ], ['es_titular' => false]);

                // 2. Sumar los puntos del jugador al TOTAL DEL EQUIPO
                $puntosJugador = $mercado->jugador->puntos;
                $equipoGanador->puntos += $puntosJugador;
                $equipoGanador->save();

                // 3. Registrar transacción
                \DB::table('historial_transacciones')->insert([
                    'liga_id' => $mercado->liga_id,
                    'equipo_id' => $equipoGanador->id,
                    'jugador_id' => $mercado->jugador_id,
                    'tipo' => 'compra',
                    'precio' => $pujaGanadora->cantidad,
                    'descripcion' => 'Compra de ' . $mercado->jugador->nombre,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Marcar como procesado
            $mercado->update(['procesado' => true]);
        });
    }
}