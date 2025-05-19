<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcesarPujasFinalizadas;
use App\Models\Liga;

class ProcesarPujasCommand extends Command
{
    protected $signature = 'pujas:procesar {--liga= : ID de la liga específica}';
    protected $description = 'Procesa las pujas finalizadas del mercado';

    public function handle()
    {
        $ligaId = $this->option('liga');

        $this->info('Iniciando procesamiento de pujas...');
        
        if ($ligaId) {
            $liga = Liga::find($ligaId);
            if (!$liga) {
                $this->error('No se encontró la liga con ID: '.$ligaId);
                return;
            }
            $this->info("Procesando solo para la liga: {$liga->nombre}");
        }

        // Ejecutar el job directamente (sin cola)
        $job = new ProcesarPujasFinalizadas();
        $job->handle();

        $this->info('Procesamiento de pujas completado!');
    }
}