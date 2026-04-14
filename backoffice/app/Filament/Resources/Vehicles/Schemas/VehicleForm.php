<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use App\Enums\VehicleType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('unit_code')
                    ->required(),
                TextInput::make('plate_number')
                    ->required(),
                TextInput::make('name'),
                Select::make('type')
                    ->options(VehicleType::class)
                    ->required(),
                TextInput::make('seat_capacity')
                    ->required()
                    ->numeric(),
                TextInput::make('baggage_capacity_kg')
                    ->numeric(),
                Toggle::make('is_active')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
