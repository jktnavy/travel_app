<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Models\Ticket;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('booking.id')
                    ->label('Booking'),
                TextEntry::make('schedule.id')
                    ->label('Schedule'),
                TextEntry::make('customer.name')
                    ->label('Customer'),
                TextEntry::make('bookingPassenger.name')
                    ->label('Booking passenger')
                    ->placeholder('-'),
                TextEntry::make('ticket_code'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('issued_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('used_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('metadata')
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
                    ->visible(fn (Ticket $record): bool => $record->trashed()),
            ]);
    }
}
