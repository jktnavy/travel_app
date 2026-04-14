<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_code' => 'CUST-'.fake()->unique()->numerify('####'),
            'name' => fake()->name(),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'identity_number' => fake()->optional()->numerify('################'),
            'date_of_birth' => fake()->optional()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'address' => fake()->address(),
            'notes' => fake()->optional()->sentence(),
            'preferences' => [
                'preferred_contact' => fake()->randomElement(['phone', 'email', 'whatsapp']),
            ],
            'is_active' => true,
        ];
    }
}
