<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('customer.name')
                    ->label('Customer'),
                TextEntry::make('schedule.id')
                    ->label('Schedule'),
                TextEntry::make('booked_by_user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('booking_code'),
                TextEntry::make('order_id'),
                TextEntry::make('booking_status')
                    ->badge(),
                TextEntry::make('payment_status')
                    ->badge(),
                TextEntry::make('passenger_count')
                    ->numeric(),
                TextEntry::make('total_amount')
                    ->numeric(),
                TextEntry::make('paid_amount')
                    ->numeric(),
                TextEntry::make('expires_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('paid_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('cancelled_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('cancel_reason')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('passenger_summary')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
                    ->visible(fn (Booking $record): bool => $record->trashed()),
            ]);
    }
}
