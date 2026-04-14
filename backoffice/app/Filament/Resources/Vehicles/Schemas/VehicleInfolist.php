<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use App\Models\Vehicle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VehicleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('unit_code'),
                TextEntry::make('plate_number'),
                TextEntry::make('name')
                    ->placeholder('-'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('seat_capacity')
                    ->numeric(),
                TextEntry::make('baggage_capacity_kg')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Vehicle $record): bool => $record->trashed()),
            ]);
    }
}
