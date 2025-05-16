<?php

// app/Console/Commands/ProcesarMercados.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcesarPujasFinalizadas;

class ProcesarMercados extends Command
{
    protected $signature = 'mercados:procesar';
    protected $description = 'Procesar pujas finalizadas de mercados';

    public function handle()
    {
        ProcesarPujasFinalizadas::dispatch();
        $this->info('Job ProcesarPujasFinalizadas despachado.');
    }
}
