<?php

namespace Database\Factories;

use App\Enums\DriverStatus;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->unique()->phoneNumber(),
            'license_number' => 'SIM-'.fake()->unique()->numerify('########'),
            'license_expires_at' => now()->addMonths(fake()->numberBetween(3, 24))->toDateString(),
            'status' => fake()->randomElement([
                DriverStatus::Active,
                DriverStatus::Active,
                DriverStatus::OnLeave,
            ]),
            'hired_at' => fake()->date(),
            'address' => fake()->address(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
