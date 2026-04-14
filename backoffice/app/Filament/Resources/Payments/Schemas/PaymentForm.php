<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('booking_id')
                    ->options(Booking::query()->pluck('order_id', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('settled_by_user_id')
                    ->label('Settled By')
                    ->options(User::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
                TextInput::make('provider')
                    ->required()
                    ->default('midtrans_snap'),
                TextInput::make('method'),
                TextInput::make('transaction_id'),
                TextInput::make('snap_token')
                    ->maxLength(255),
                Textarea::make('snap_redirect_url')
                    ->columnSpanFull(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Select::make('status')
                    ->options(PaymentStatus::class)
                    ->default(PaymentStatus::Pending)
                    ->required(),
                DateTimePicker::make('paid_at'),
                DateTimePicker::make('expired_at'),
                KeyValue::make('payload')
                    ->columnSpanFull(),
                KeyValue::make('webhook_payload')
                    ->columnSpanFull(),
            ]);
    }
}
