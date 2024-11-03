<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidencia>
 */
class IncidenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'descripcion' => $this->faker->paragraph,
            'estado' => $this->faker->randomElement(['To Do', 'Doing', 'Done']),
            'creado' => User::factory(),
            'asignado' => User::factory(),

        ];
    }
}
