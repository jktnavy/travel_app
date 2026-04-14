<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'schedule_id',
        'booked_by_user_id',
        'booking_code',
        'order_id',
        'booking_status',
        'payment_status',
        'passenger_count',
        'total_amount',
        'paid_amount',
        'expires_at',
        'paid_at',
        'cancelled_at',
        'cancel_reason',
        'passenger_summary',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'booking_status' => BookingStatus::class,
            'payment_status' => PaymentStatus::class,
            'passenger_count' => 'integer',
            'total_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'expires_at' => 'datetime',
            'paid_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'passenger_summary' => 'array',
            'metadata' => 'array',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function bookedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'booked_by_user_id');
    }

    public function passengers(): HasMany
    {
        return $this->hasMany(BookingPassenger::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function canBePaid(): bool
    {
        return in_array($this->booking_status, [BookingStatus::Draft, BookingStatus::PendingPayment], true)
            && in_array($this->payment_status, [PaymentStatus::Unpaid, PaymentStatus::Pending], true)
            && ! $this->cancelled_at;
    }

    public function canBeConfirmed(): bool
    {
        return $this->booking_status === BookingStatus::Paid
            && $this->payment_status === PaymentStatus::Paid;
    }

    public function markAsCancelled(?string $reason = null): void
    {
        $this->forceFill([
            'booking_status' => BookingStatus::Cancelled,
            'payment_status' => $this->payment_status === PaymentStatus::Paid
                ? PaymentStatus::Refunded
                : PaymentStatus::Cancelled,
            'cancelled_at' => now(),
            'cancel_reason' => $reason,
        ])->save();
    }
}
