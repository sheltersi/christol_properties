<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomNumber(1 ,20),
            'cottage_number' => fake()->numberBetween(1,18),
            'preferred_time' => fake()->time(),
            'preferred_date' => fake()->date(),
            'status' => fake()->randomElement(['pending','confirmed','declined']),
            'message'=> fake()->sentence()
                ];
    }
}
