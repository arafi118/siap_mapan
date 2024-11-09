<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->company(),
            'alamat' => fake()->address(),
            'telpon' => '08' . fake()->numerify('#########'),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
