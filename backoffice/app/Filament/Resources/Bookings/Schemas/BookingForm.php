<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->label('Customer')
                    ->options(Customer::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('schedule_id')
                    ->label('Schedule')
                    ->options(
                        Schedule::query()
                            ->with('travelRoute')
                            ->get()
                            ->mapWithKeys(fn (Schedule $schedule): array => [
                                $schedule->id => sprintf(
                                    '%s | %s | %s',
                                    $schedule->travelRoute?->code ?? '-',
                                    $schedule->departure_at?->format('d M Y H:i') ?? '-',
                                    $schedule->vehicle?->name ?? 'Unit'
                                ),
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('booked_by_user_id')
                    ->label('Booked By')
                    ->options(User::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
                TextInput::make('booking_code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('order_id')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('booking_status')
                    ->options(BookingStatus::class)
                    ->default(BookingStatus::Draft)
                    ->required(),
                Select::make('payment_status')
                    ->options(PaymentStatus::class)
                    ->default(PaymentStatus::Unpaid)
                    ->required(),
                TextInput::make('passenger_count')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                DateTimePicker::make('expires_at'),
                DateTimePicker::make('paid_at'),
                DateTimePicker::make('cancelled_at'),
                Textarea::make('cancel_reason')
                    ->columnSpanFull(),
                KeyValue::make('passenger_summary')
                    ->columnSpanFull(),
                KeyValue::make('metadata')
                    ->columnSpanFull()
                    ->addable()
                    ->deletable()
                    ->reorderable(),
                Toggle::make('deleted_at')
                    ->visible(false),
            ]);
    }
}
