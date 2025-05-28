<?php

namespace Database\Factories;

use App\Models\Jugador;
use Illuminate\Database\Eloquent\Factories\Factory;

class JugadorFactory extends Factory
{
    protected $model = Jugador::class;

    public function definition()
    {
       return [
            'nombre' => $this->faker->name(),
            'imagen_url' => $this->faker->imageUrl(200, 200, 'sports'), // ejemplo imagen deportiva
            'posicion' => $this->faker->randomElement(['Top', 'Jungle', 'Mid', 'ADC', 'Support']),
            'equipo_real' => $this->faker->company(),
            'valor' => $this->faker->numberBetween(1000, 10000),
            'puntos' => 0,
        ];
    }
}
