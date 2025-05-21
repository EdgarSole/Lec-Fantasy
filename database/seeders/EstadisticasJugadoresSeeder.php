<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadisticasJugadoresSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            $stats = [
                'kills' => rand(0, 20),
                'asistencias' => rand(0, 30),
                'muertes' => rand(0, 15),
                'puntos_vision' => rand(0, 100),
                'objetivo_robado' => rand(0, 3),
                'danio_torres' => rand(0, 10000),
                'oro' => rand(5000, 20000),
                'solo_kills' => rand(0, 5),
                'double_kills' => rand(0, 3),
                'triple_kills' => rand(0, 2),
                'quadra_kills' => rand(0, 1),
                'penta_kills' => rand(0, 1),
                'danio_campeones' => rand(0, 25000),
                'danio_recibido' => rand(0, 25000),
                'tiempo_muerto' => rand(0, 300),
                'botin_conseguido' => rand(0, 5),
                'botin_perdido' => rand(0, 5),
                'primera_sangre' => rand(0, 1),
                'primera_torre' => rand(0, 1),
            ];

            // Cálculo de puntos
            $puntos = 
                ($stats['kills'] * 2) +
                ($stats['asistencias']) -
                ($stats['muertes']) +
                intdiv($stats['puntos_vision'], 10) +
                ($stats['objetivo_robado'] * 3) +
                intdiv($stats['danio_torres'], 1000) +
                intdiv($stats['oro'], 1000) +
                ($stats['double_kills'] * 3) +
                ($stats['triple_kills'] * 5) +
                ($stats['quadra_kills'] * 8) +
                ($stats['penta_kills'] * 12) +
                intdiv($stats['danio_campeones'], 2000) +
                intdiv($stats['danio_recibido'], 2000) -
                intdiv($stats['tiempo_muerto'], 10) +
                ($stats['botin_conseguido']) -
                ($stats['botin_perdido']) +
                ($stats['primera_sangre'] ? 5 : 0) +
                ($stats['primera_torre'] ? 5 : 0);

            // Guardar estadísticas
            DB::table('estadisticas_jugadores')->insert(array_merge(
                ['jugador_id' => $i, 'created_at' => now(), 'updated_at' => now()],
                $stats
            ));

            // Actualizar puntos en jugadores
            DB::table('jugadores')
                ->where('id', $i)
                ->update(['puntos' => $puntos]);
        }
    }
}
