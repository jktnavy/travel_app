<?php

namespace App\Services\Payment;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\Ticket\TicketService;
use Illuminate\Support\Facades\DB;

class MidtransWebhookService
{
    public function __construct(
        private readonly TicketService $ticketService,
    ) {}

    public function handleNotification(array $payload): Payment
    {
        $orderId = $payload['order_id'] ?? null;

        if (! $orderId) {
            throw new \InvalidArgumentException('Midtrans notification is missing order_id.');
        }

        $this->verifySignature($payload);

        return DB::transaction(function () use ($payload, $orderId): Payment {
            $booking = Booking::query()
                ->where('order_id', $orderId)
                ->with(['customer', 'schedule.travelRoute', 'passengers', 'tickets', 'latestPayment'])
                ->firstOrFail();

            $payment = $booking->latestPayment()->firstOrNew();
            $paymentStatus = $this->mapPaymentStatus(
                $payload['transaction_status'] ?? null,
                $payload['fraud_status'] ?? null,
            );

            $grossAmount = $payload['gross_amount'] ?? $booking->total_amount;

            $payment->fill([
                'provider' => 'midtrans_snap',
                'method' => $payload['payment_type'] ?? $payment->method,
                'transaction_id' => $payload['transaction_id'] ?? $payment->transaction_id,
                'amount' => is_numeric($grossAmount) ? (float) $grossAmount : (float) $booking->total_amount,
                'status' => $paymentStatus,
                'paid_at' => $paymentStatus === PaymentStatus::Paid ? ($payment->paid_at ?? now()) : $payment->paid_at,
                'expired_at' => in_array($paymentStatus, [PaymentStatus::Expired, PaymentStatus::Cancelled], true) ? now() : $payment->expired_at,
                'webhook_payload' => $payload,
            ]);
            $payment->save();

            $this->synchronizeBooking($booking, $payment);

            if ($payment->isSuccessful()) {
                $this->ticketService->generateForBooking($booking->fresh(['customer', 'schedule.travelRoute', 'passengers', 'tickets']));
            }

            return $payment->fresh();
        });
    }

    public function verifySignature(array $payload): void
    {
        $signatureKey = $payload['signature_key'] ?? null;

        if (! $signatureKey) {
            return;
        }

        $expectedSignature = hash(
            'sha512',
            ($payload['order_id'] ?? '')
            .($payload['status_code'] ?? '')
            .($payload['gross_amount'] ?? '')
            .config('services.midtrans.server_key')
        );

        if (! hash_equals($expectedSignature, $signatureKey)) {
            throw new \RuntimeException('Invalid Midtrans signature.');
        }
    }

    private function mapPaymentStatus(?string $transactionStatus, ?string $fraudStatus): PaymentStatus
    {
        return match ($transactionStatus) {
            'capture' => $fraudStatus === 'challenge' ? PaymentStatus::Pending : PaymentStatus::Paid,
            'settlement' => PaymentStatus::Paid,
            'pending' => PaymentStatus::Pending,
            'expire' => PaymentStatus::Expired,
            'cancel' => PaymentStatus::Cancelled,
            'deny', 'failure' => PaymentStatus::Failed,
            'refund', 'partial_refund' => PaymentStatus::Refunded,
            default => PaymentStatus::Pending,
        };
    }

    private function synchronizeBooking(Booking $booking, Payment $payment): void
    {
        if ($payment->isSuccessful()) {
            $booking->forceFill([
                'payment_status' => PaymentStatus::Paid,
                'booking_status' => BookingStatus::Paid,
                'paid_amount' => $payment->amount,
                'paid_at' => $payment->paid_at ?? now(),
            ])->save();

            return;
        }

        $isCancelledFlow = in_array($payment->status, [
            PaymentStatus::Cancelled,
            PaymentStatus::Expired,
            PaymentStatus::Failed,
        ], true);

        $booking->forceFill([
            'payment_status' => $payment->status,
            'booking_status' => $isCancelledFlow ? BookingStatus::Cancelled : $booking->booking_status,
            'cancelled_at' => $isCancelledFlow ? ($booking->cancelled_at ?? now()) : $booking->cancelled_at,
        ])->save();
    }
}
