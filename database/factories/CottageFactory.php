<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cottage>
 */
class CottageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomNumber(1,20),
            'number' => fake()->randomNumber(1,20),
            'location' => fake()->randomElement(['4 heelra road, raumaraispark, Johannesburg 2090','66 1st avenue, Bramley, Johannesburg 2090']),
            'price_per_month' => fake()->numberBetween(3000,7000),
            'status' => fake()->randomElement(['available','taken'])
        ];
    }
}
