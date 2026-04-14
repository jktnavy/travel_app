<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket {{ $ticket->ticket_code }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 24px; }
        .ticket { max-width: 760px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; }
        .header { background: #111827; color: #fff; padding: 24px; }
        .content { display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px; padding: 24px; }
        .block { margin-bottom: 16px; }
        .label { font-size: 12px; color: #6b7280; text-transform: uppercase; margin-bottom: 4px; }
        .value { font-size: 16px; color: #111827; font-weight: 600; }
        .qr { display: flex; align-items: center; justify-content: center; min-height: 220px; border: 1px dashed #d1d5db; border-radius: 12px; background: #fafafa; }
        @media print { body { background: #fff; padding: 0; } }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1 style="margin:0;">Deny Trans Ticket</h1>
            <p style="margin:8px 0 0;">{{ $ticket->ticket_code }}</p>
        </div>

        <div class="content">
            <div>
                <div class="block">
                    <div class="label">Booking Code</div>
                    <div class="value">{{ $booking->booking_code }}</div>
                </div>
                <div class="block">
                    <div class="label">Customer</div>
                    <div class="value">{{ $booking->customer->name }}</div>
                </div>
                <div class="block">
                    <div class="label">Passenger</div>
                    <div class="value">{{ $ticket->bookingPassenger?->name ?? $booking->customer->name }}</div>
                </div>
                <div class="block">
                    <div class="label">Route</div>
                    <div class="value">{{ $booking->schedule->travelRoute?->origin_city }} - {{ $booking->schedule->travelRoute?->destination_city }}</div>
                </div>
                <div class="block">
                    <div class="label">Departure</div>
                    <div class="value">{{ $booking->schedule->departure_at?->format('d M Y H:i') }}</div>
                </div>
                <div class="block">
                    <div class="label">Status</div>
                    <div class="value">{{ $ticket->status->getLabel() }}</div>
                </div>
            </div>

            <div>
                <div class="qr">
                    @if ($qrCodeSvg)
                        {!! $qrCodeSvg !!}
                    @else
                        <span>QR code not available yet.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
