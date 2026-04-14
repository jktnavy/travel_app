<?php

namespace App\Services\Ticket;

use App\Enums\TicketStatus;
use App\Models\Booking;
use App\Models\BookingPassenger;
use App\Models\Ticket;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketService
{
    public function generateForBooking(Booking $booking): void
    {
        DB::transaction(function () use ($booking): void {
            $booking->loadMissing(['customer', 'schedule.travelRoute', 'passengers', 'tickets']);

            $passengers = $booking->passengers->isNotEmpty()
                ? $booking->passengers
                : collect([null]);

            foreach ($passengers as $passenger) {
                $ticket = Ticket::query()->firstOrNew([
                    'booking_id' => $booking->id,
                    'booking_passenger_id' => $passenger?->id,
                ]);

                if (! $ticket->exists) {
                    $ticket->fill([
                        'schedule_id' => $booking->schedule_id,
                        'customer_id' => $booking->customer_id,
                        'ticket_code' => $this->generateTicketCode(),
                        'qr_token' => (string) Str::uuid(),
                    ]);
                }

                $ticket->fill([
                    'status' => TicketStatus::Issued,
                    'issued_at' => $ticket->issued_at ?? now(),
                ]);

                $metadata = $ticket->metadata ?? [];
                $metadata['qr_path'] = $metadata['qr_path'] ?? $this->storeQrCode($ticket->ticket_code, $booking, $passenger);
                $metadata['pdf_path'] = $metadata['pdf_path'] ?? null;
                $ticket->metadata = $metadata;

                $ticket->save();
            }
        });
    }

    public function generateTicketCode(): string
    {
        return 'TKT-'.now()->format('ymd').'-'.Str::upper(Str::random(8));
    }

    private function storeQrCode(string $ticketCode, Booking $booking, ?BookingPassenger $passenger): string
    {
        $payload = json_encode([
            'ticket_code' => $ticketCode,
            'booking_code' => $booking->booking_code,
            'customer' => $booking->customer->name,
            'passenger' => $passenger?->name,
            'route' => $booking->schedule->travelRoute?->code,
            'departure_at' => $booking->schedule->departure_at?->toIso8601String(),
        ], JSON_UNESCAPED_SLASHES);

        $svg = (new QRCode(new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        ])))->render($payload);

        $path = "tickets/qr/{$ticketCode}.svg";

        Storage::disk('local')->put($path, $svg);

        return $path;
    }
}
