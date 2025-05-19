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
    $mercadosFinalizados = Mercado::with(['pujas.usuario', 'liga', 'jugador'])
        ->where('fecha_fin', '<=', now())
        ->whereNull('procesado')
        ->get();

    foreach ($mercadosFinalizados as $mercado) {
        app(\App\Http\Controllers\MiLigaController::class)
            ->procesarMercado($mercado);
    }
}
}