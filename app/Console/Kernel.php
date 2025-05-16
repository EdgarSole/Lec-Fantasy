<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ProcesarPujasFinalizadas;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define los comandos Artisan disponibles para tu aplicación.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define el programador de tareas.
     */
  protected function schedule(Schedule $schedule)
{
    $schedule->command('mercados:procesar')->everyMinute();
}

}
