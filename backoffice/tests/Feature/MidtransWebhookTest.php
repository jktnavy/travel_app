<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\TicketStatus;
use App\Models\Booking;
use App\Models\BookingPassenger;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\TravelRoute;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MidtransWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_webhook_is_idempotent_and_generates_ticket(): void
    {
        $route = TravelRoute::factory()->create();
        $vehicle = Vehicle::factory()->create();
        $driver = Driver::factory()->create();
        $customer = Customer::factory()->create();
        $schedule = Schedule::factory()->create([
            'travel_route_id' => $route->id,
            'vehicle_id' => $vehicle->id,
            'driver_id' => $driver->id,
            'booked_seats' => 0,
            'available_seats' => $vehicle->seat_capacity,
        ]);

        $booking = Booking::factory()->create([
            'customer_id' => $customer->id,
            'schedule_id' => $schedule->id,
            'booking_status' => BookingStatus::PendingPayment,
            'payment_status' => PaymentStatus::Pending,
            'passenger_count' => 1,
            'total_amount' => 90000,
            'paid_amount' => 0,
            'order_id' => 'ORD-WEBHOOK-001',
        ]);

        BookingPassenger::factory()->create([
            'booking_id' => $booking->id,
            'is_primary' => true,
        ]);

        Payment::factory()->create([
            'booking_id' => $booking->id,
            'amount' => 90000,
            'status' => PaymentStatus::Pending,
        ]);

        $payload = [
            'order_id' => $booking->order_id,
            'status_code' => '200',
            'gross_amount' => '90000.00',
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'transaction_id' => 'TRX-SETTLED-001',
        ];

        $payload['signature_key'] = hash(
            'sha512',
            $payload['order_id'].$payload['status_code'].$payload['gross_amount'].config('services.midtrans.server_key')
        );

        $this->postJson(route('webhooks.midtrans'), $payload)->assertOk();
        $this->postJson(route('webhooks.midtrans'), $payload)->assertOk();

        $booking->refresh();

        $this->assertEquals(PaymentStatus::Paid, $booking->payment_status);
        $this->assertEquals(BookingStatus::Paid, $booking->booking_status);
        $this->assertSame(1, $booking->tickets()->count());
        $this->assertEquals(TicketStatus::Issued, $booking->tickets()->first()->status);
    }
}
