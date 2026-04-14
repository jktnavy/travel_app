<?php

namespace App\Models;

use App\Enums\ScheduleStatus;
use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    /** @use HasFactory<ScheduleFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'travel_route_id',
        'vehicle_id',
        'driver_id',
        'departure_at',
        'arrival_at',
        'boarding_close_at',
        'price',
        'seat_capacity',
        'booked_seats',
        'available_seats',
        'status',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'departure_at' => 'datetime',
            'arrival_at' => 'datetime',
            'boarding_close_at' => 'datetime',
            'price' => 'decimal:2',
            'seat_capacity' => 'integer',
            'booked_seats' => 'integer',
            'available_seats' => 'integer',
            'status' => ScheduleStatus::class,
            'meta' => 'array',
        ];
    }

    public function travelRoute(): BelongsTo
    {
        return $this->belongsTo(TravelRoute::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function hasAvailableSeats(int $requestedSeats = 1): bool
    {
        return $this->available_seats >= $requestedSeats
            && $this->status === ScheduleStatus::Open;
    }

    public function recalculateSeatStats(): void
    {
        $bookedSeats = (int) $this->bookings()
            ->whereIn('booking_status', ['paid', 'confirmed'])
            ->sum('passenger_count');

        $availableSeats = max(0, $this->seat_capacity - $bookedSeats);

        $this->forceFill([
            'booked_seats' => $bookedSeats,
            'available_seats' => $availableSeats,
            'status' => $availableSeats === 0 && $this->status === ScheduleStatus::Open
                ? ScheduleStatus::Full
                : $this->status,
        ])->save();
    }
}
