<?php

namespace App\Filament\Resources\TravelRoutes\Schemas;

use App\Models\TravelRoute;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TravelRouteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('origin_city'),
                TextEntry::make('destination_city'),
                TextEntry::make('origin_label'),
                TextEntry::make('destination_label'),
                TextEntry::make('estimated_duration_minutes')
                    ->numeric(),
                TextEntry::make('base_price')
                    ->money(),
                TextEntry::make('distance_km')
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
                    ->visible(fn (TravelRoute $record): bool => $record->trashed()),
            ]);
    }
}
