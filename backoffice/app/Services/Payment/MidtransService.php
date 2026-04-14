<?php

namespace App\Services\Payment;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct(
        private readonly MidtransWebhookService $webhookService,
    ) {
        $this->configure();
    }

    public function createSnapTransaction(Booking $booking): Payment
    {
        return DB::transaction(function () use ($booking): Payment {
            $booking->loadMissing(['customer', 'schedule.travelRoute']);

            if (! $booking->canBePaid()) {
                throw new \RuntimeException('Booking is not eligible for payment.');
            }

            if (! filled($booking->order_id)) {
                $booking->forceFill([
                    'order_id' => $this->generateOrderId(),
                ])->save();
            }

            $payload = [
                'transaction_details' => [
                    'order_id' => $booking->order_id,
                    'gross_amount' => (int) round((float) $booking->total_amount),
                ],
                'customer_details' => [
                    'first_name' => $booking->customer->name,
                    'email' => $booking->customer->email,
                    'phone' => $booking->customer->phone,
                ],
                'item_details' => [
                    [
                        'id' => $booking->booking_code,
                        'price' => (int) round((float) $booking->schedule->price),
                        'quantity' => $booking->passenger_count,
                        'name' => sprintf(
                            'Shuttle %s %s',
                            $booking->schedule->travelRoute?->code ?? 'Route',
                            $booking->schedule->departure_at?->format('d-m-Y H:i') ?? ''
                        ),
                    ],
                ],
                'callbacks' => [
                    'finish' => route('tickets.print', $booking),
                ],
                'expiry' => [
                    'unit' => 'hours',
                    'duration' => 2,
                ],
            ];

            $response = Snap::createTransaction($payload);
            $responseArray = json_decode(json_encode($response), true);

            $payment = $booking->latestPayment()->firstOrNew();
            $payment->fill([
                'provider' => 'midtrans_snap',
                'amount' => $booking->total_amount,
                'status' => $payment->status?->value ?? 'pending',
                'snap_token' => $responseArray['token'] ?? null,
                'snap_redirect_url' => $responseArray['redirect_url'] ?? null,
                'payload' => $responseArray,
                'expired_at' => now()->addHours(2),
            ]);
            $payment->save();

            return $payment->fresh();
        });
    }

    public function syncPaymentStatus(Booking|Payment $subject): Payment
    {
        $payment = $subject instanceof Payment ? $subject : $subject->latestPayment;

        if (! $payment) {
            throw new \RuntimeException('No payment record available to sync.');
        }

        $response = Transaction::status($payment->booking->order_id);
        $responseArray = json_decode(json_encode($response), true);

        return $this->webhookService->handleNotification($responseArray);
    }

    public function generateOrderId(): string
    {
        return 'ORD-'.now()->format('YmdHis').'-'.Str::upper(Str::random(6));
    }

    private function configure(): void
    {
        Config::$serverKey = (string) config('services.midtrans.server_key');
        Config::$clientKey = (string) config('services.midtrans.client_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');
    }
}
