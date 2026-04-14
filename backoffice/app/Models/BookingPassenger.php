<?php

namespace App\Models;

use Database\Factories\BookingPassengerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookingPassenger extends Model
{
    /** @use HasFactory<BookingPassengerFactory> */
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'name',
        'phone',
        'email',
        'identity_number',
        'gender',
        'seat_number',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }
}
