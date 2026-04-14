<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BookingStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case PendingPayment = 'pending_payment';
    case Paid = 'paid';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::PendingPayment => 'Menunggu Pembayaran',
            self::Paid => 'Sudah Dibayar',
            self::Confirmed => 'Terkonfirmasi',
            self::Cancelled => 'Dibatalkan',
            self::Completed => 'Selesai',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::PendingPayment => 'warning',
            self::Paid => 'info',
            self::Confirmed => 'success',
            self::Cancelled => 'danger',
            self::Completed => 'success',
        };
    }
}
