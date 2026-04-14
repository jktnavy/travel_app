<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    /** @use HasFactory<TicketFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'booking_id',
        'schedule_id',
        'customer_id',
        'booking_passenger_id',
        'ticket_code',
        'status',
        'qr_token',
        'issued_at',
        'used_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'status' => TicketStatus::class,
            'issued_at' => 'datetime',
            'used_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function bookingPassenger(): BelongsTo
    {
        return $this->belongsTo(BookingPassenger::class);
    }
}
