<?php

namespace App\Filament\Resources\Drivers\Schemas;

use App\Models\Driver;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DriverInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('phone'),
                TextEntry::make('license_number'),
                TextEntry::make('license_expires_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('hired_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('address')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
                    ->visible(fn (Driver $record): bool => $record->trashed()),
            ]);
    }
}
