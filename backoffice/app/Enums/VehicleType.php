<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum VehicleType: string implements HasLabel
{
    case Shuttle = 'shuttle';
    case Elf = 'elf';
    case Hiace = 'hiace';
    case Bus = 'bus';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Shuttle => 'Shuttle',
            self::Elf => 'Elf',
            self::Hiace => 'Hiace',
            self::Bus => 'Bus',
        };
    }
}
