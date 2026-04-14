<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement([
            PaymentStatus::Pending,
            PaymentStatus::Paid,
            PaymentStatus::Expired,
        ]);

        return [
            'booking_id' => Booking::factory(),
            'provider' => 'midtrans_snap',
            'method' => fake()->randomElement(['bank_transfer', 'qris', 'ewallet']),
            'transaction_id' => $status === PaymentStatus::Pending ? null : 'TRX-'.fake()->unique()->numerify('######'),
            'snap_token' => Str::random(32),
            'snap_redirect_url' => fake()->url(),
            'amount' => fake()->randomElement([85000, 90000, 95000, 100000]),
            'status' => $status,
            'paid_at' => $status === PaymentStatus::Paid ? now() : null,
            'expired_at' => $status === PaymentStatus::Pending ? now()->addHours(2) : now()->subHour(),
            'payload' => ['source' => 'factory'],
            'webhook_payload' => null,
        ];
    }
}
