<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DriverStatus: string implements HasColor, HasLabel
{
    case Active = 'active';
    case OnLeave = 'on_leave';
    case Inactive = 'inactive';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Aktif',
            self::OnLeave => 'Cuti',
            self::Inactive => 'Nonaktif',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::OnLeave => 'warning',
            self::Inactive => 'danger',
        };
    }
}
