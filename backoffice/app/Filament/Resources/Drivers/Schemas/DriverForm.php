<?php

namespace App\Filament\Resources\Drivers\Schemas;

use App\Enums\DriverStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('license_number')
                    ->required(),
                DatePicker::make('license_expires_at'),
                Select::make('status')
                    ->options(DriverStatus::class)
                    ->default('active')
                    ->required(),
                DatePicker::make('hired_at'),
                Textarea::make('address')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
