<?php

namespace App\Filament\Resources\TravelRoutes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TravelRouteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('origin_city')
                    ->required(),
                TextInput::make('destination_city')
                    ->required(),
                TextInput::make('origin_label')
                    ->required(),
                TextInput::make('destination_label')
                    ->required(),
                TextInput::make('estimated_duration_minutes')
                    ->required()
                    ->numeric(),
                TextInput::make('base_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('distance_km')
                    ->numeric(),
                Toggle::make('is_active')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
