<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ScheduleStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case Open = 'open';
    case Full = 'full';
    case Departed = 'departed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Open => 'Open',
            self::Full => 'Penuh',
            self::Departed => 'Berangkat',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Open => 'success',
            self::Full => 'warning',
            self::Departed => 'info',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }
}
