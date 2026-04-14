<?php

namespace App\Filament\Resources\PickupPoints\Schemas;

use App\Models\PickupPoint;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PickupPointInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('travelRoute.id')
                    ->label('Travel route'),
                TextEntry::make('name'),
                TextEntry::make('city'),
                TextEntry::make('direction'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('contact_phone')
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (PickupPoint $record): bool => $record->trashed()),
            ]);
    }
}
