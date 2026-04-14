<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Models\Schedule;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('travelRoute.id')
                    ->label('Travel route'),
                TextEntry::make('vehicle.name')
                    ->label('Vehicle'),
                TextEntry::make('driver.name')
                    ->label('Driver'),
                TextEntry::make('departure_at')
                    ->dateTime(),
                TextEntry::make('arrival_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('boarding_close_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('seat_capacity')
                    ->numeric(),
                TextEntry::make('booked_seats')
                    ->numeric(),
                TextEntry::make('available_seats')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('meta')
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
                    ->visible(fn (Schedule $record): bool => $record->trashed()),
            ]);
    }
}
