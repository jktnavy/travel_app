<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\BookingPassenger;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookingPassenger>
 */
class BookingPassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->optional()->safeEmail(),
            'identity_number' => fake()->optional()->numerify('################'),
            'gender' => fake()->randomElement(['male', 'female']),
            'seat_number' => 'S-'.fake()->numberBetween(1, 14),
            'is_primary' => false,
        ];
    }
}
