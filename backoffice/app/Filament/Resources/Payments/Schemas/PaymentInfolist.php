<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Payment;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('booking.order_id')
                    ->label('Order ID'),
                TextEntry::make('booking.booking_code')
                    ->label('Booking'),
                TextEntry::make('booking.customer.name')
                    ->label('Customer'),
                TextEntry::make('settled_by_user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('provider'),
                TextEntry::make('method')
                    ->placeholder('-'),
                TextEntry::make('transaction_id')
                    ->placeholder('-'),
                TextEntry::make('snap_redirect_url')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('amount')
                    ->money('IDR'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('paid_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('expired_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('payload')
                    ->formatStateUsing(fn ($state): string => $state ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '-')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('webhook_payload')
                    ->formatStateUsing(fn ($state): string => $state ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '-')
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
                    ->visible(fn (Payment $record): bool => $record->trashed()),
            ]);
    }
}
