<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Enums\TicketStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('booking_id')
                    ->relationship('booking', 'id')
                    ->required(),
                Select::make('schedule_id')
                    ->relationship('schedule', 'id')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
                Select::make('booking_passenger_id')
                    ->relationship('bookingPassenger', 'name'),
                TextInput::make('ticket_code')
                    ->required(),
                Select::make('status')
                    ->options(TicketStatus::class)
                    ->default('pending')
                    ->required(),
                DateTimePicker::make('issued_at'),
                DateTimePicker::make('used_at'),
                Textarea::make('metadata')
                    ->columnSpanFull(),
            ]);
    }
}
