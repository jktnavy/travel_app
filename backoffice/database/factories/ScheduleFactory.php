<?php

namespace Database\Factories;

use App\Enums\ScheduleStatus;
use App\Models\Driver;
use App\Models\Schedule;
use App\Models\TravelRoute;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departureAt = fake()->dateTimeBetween('+1 day', '+30 days');
        $seatCapacity = fake()->randomElement([6, 10, 12, 14]);
        $bookedSeats = fake()->numberBetween(0, max(0, $seatCapacity - 1));

        return [
            'travel_route_id' => TravelRoute::factory(),
            'vehicle_id' => Vehicle::factory(),
            'driver_id' => Driver::factory(),
            'departure_at' => $departureAt,
            'arrival_at' => (clone $departureAt)->modify('+3 hours'),
            'boarding_close_at' => (clone $departureAt)->modify('-30 minutes'),
            'price' => fake()->randomElement([85000, 90000, 95000, 100000]),
            'seat_capacity' => $seatCapacity,
            'booked_seats' => $bookedSeats,
            'available_seats' => $seatCapacity - $bookedSeats,
            'status' => $bookedSeats === $seatCapacity ? ScheduleStatus::Full : ScheduleStatus::Open,
            'meta' => [
                'source' => 'factory',
            ],
        ];
    }
}
