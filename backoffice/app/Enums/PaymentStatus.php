<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasColor, HasLabel
{
    case Unpaid = 'unpaid';
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
    case Expired = 'expired';
    case Refunded = 'refunded';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Unpaid => 'Belum Dibayar',
            self::Pending => 'Pending',
            self::Paid => 'Lunas',
            self::Failed => 'Gagal',
            self::Expired => 'Kedaluwarsa',
            self::Refunded => 'Refund',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Unpaid => 'gray',
            self::Pending => 'warning',
            self::Paid => 'success',
            self::Failed => 'danger',
            self::Expired => 'danger',
            self::Refunded => 'info',
            self::Cancelled => 'danger',
        };
    }
}
