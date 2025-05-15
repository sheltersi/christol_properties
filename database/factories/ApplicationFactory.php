<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
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
            'phone'=> fake()->phoneNumber(),
            'dob' => fake()->date(),
            'id_number' => fake()->numberBetween(28774689,90857536),
            'current_address' => fake()->address(),
            'occupants' => fake()->numberBetween(1,5),
            'pets' => fake()->randomElement([0,1]),
            'employer' => fake()->firstName(),
            'job_title' => fake()->randomElement(['Nurse','Doctor','Lawyer','Caregiver','Software Developer','Accountant','Geologist','Teacher','Lecturer','Engineer']),
            'employment_start' => fake()->dateTimeThisYear(),
            'monthly_income' => fake()->numberBetween(7000,30000),
            'employer_contact' => fake()->phoneNumber(),
            'landlord_name' => fake()->userName(),
            'landlord_contact' => fake()->phoneNumber(),
            'rent_amount'=> fake()->numberBetween(7000,30000),
            'reason_leaving' => fake()->sentence(),
            'status' => fake()->randomElement(['pending','viewed','in-progress','accepted','declined']),
            'agree' => fake()->randomElement([0,1])
        ];
    }
}
