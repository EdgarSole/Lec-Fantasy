<?php

namespace Tests\Unit\Seeders;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Jugador;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;

class EstadisticasJugadoresSeederTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
#[Group('pruebasUnitarias')]
public function test_estadisticas_jugadores_seeder_inserts_data_and_calculates_points()
{
    // Crear 50 jugadores dummy para cumplir la FK
    \App\Models\Jugador::factory()->count(50)->create();

    // Ejecutar el seeder
    $this->seed(\Database\Seeders\EstadisticasJugadoresSeeder::class);

    // Verificar inserciones y puntos
    $count = DB::table('estadisticas_jugadores')->count();
    $this->assertEquals(50, $count);

    for ($i = 1; $i <= 50; $i++) {
        $jugador = \App\Models\Jugador::find($i);
        $this->assertNotNull($jugador);
        $this->assertNotNull($jugador->puntos);
        $this->assertIsInt($jugador->puntos);
        $this->assertGreaterThanOrEqual(0, $jugador->puntos);
    }
}

}
