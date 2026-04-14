<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement([
            BookingStatus::PendingPayment,
            BookingStatus::Paid,
            BookingStatus::Confirmed,
        ]);

        $paymentStatus = match ($status) {
            BookingStatus::PendingPayment => PaymentStatus::Pending,
            BookingStatus::Paid, BookingStatus::Confirmed => PaymentStatus::Paid,
            default => PaymentStatus::Unpaid,
        };

        $passengerCount = fake()->numberBetween(1, 4);
        $amount = $passengerCount * fake()->randomElement([85000, 90000, 95000, 100000]);

        return [
            'customer_id' => Customer::factory(),
            'schedule_id' => Schedule::factory(),
            'booked_by_user_id' => User::factory(),
            'booking_code' => 'BOOK-'.fake()->unique()->numerify('######'),
            'order_id' => 'ORD-'.fake()->unique()->numerify('######'),
            'booking_status' => $status,
            'payment_status' => $paymentStatus,
            'passenger_count' => $passengerCount,
            'total_amount' => $amount,
            'paid_amount' => $paymentStatus === PaymentStatus::Paid ? $amount : 0,
            'expires_at' => now()->addHours(2),
            'paid_at' => $paymentStatus === PaymentStatus::Paid ? now() : null,
            'passenger_summary' => [
                'primary_name' => fake()->name(),
            ],
            'metadata' => [
                'source' => 'factory',
            ],
        ];
    }
}
