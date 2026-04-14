<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Booking;
use App\Models\BookingPassenger;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
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
            'schedule_id' => Schedule::factory(),
            'customer_id' => Customer::factory(),
            'booking_passenger_id' => BookingPassenger::factory(),
            'ticket_code' => 'TKT-'.fake()->unique()->numerify('######'),
            'status' => TicketStatus::Issued,
            'qr_token' => Str::uuid()->toString(),
            'issued_at' => now(),
            'used_at' => null,
            'metadata' => ['source' => 'factory'],
        ];
    }
}
