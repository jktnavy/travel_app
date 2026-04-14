<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class TicketPrintController extends Controller
{
    public function __invoke(Booking $booking): View
    {
        $booking->loadMissing(['customer', 'schedule.travelRoute', 'tickets.bookingPassenger']);

        abort_if($booking->tickets->isEmpty(), 404);

        $ticket = $booking->tickets->first();

        return view('tickets.print', [
            'booking' => $booking,
            'ticket' => $ticket,
            'qrCodeSvg' => $this->resolveQrCodeSvg($ticket),
        ]);
    }

    private function resolveQrCodeSvg(Ticket $ticket): ?string
    {
        $path = $ticket->metadata['qr_path'] ?? null;

        if (! $path || ! Storage::disk('local')->exists($path)) {
            return null;
        }

        return Storage::disk('local')->get($path);
    }
}
