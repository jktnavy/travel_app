<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TicketStatus: string implements HasColor, HasLabel
{
    case Pending = 'pending';
    case Issued = 'issued';
    case Used = 'used';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Issued => 'Terbit',
            self::Used => 'Digunakan',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Issued => 'success',
            self::Used => 'info',
            self::Cancelled => 'danger',
        };
    }
}
