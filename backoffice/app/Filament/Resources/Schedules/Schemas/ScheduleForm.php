<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Enums\ScheduleStatus;
use App\Models\Driver;
use App\Models\TravelRoute;
use App\Models\Vehicle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('travel_route_id')
                    ->label('Route')
                    ->options(TravelRoute::query()->pluck('code', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('vehicle_id')
                    ->options(Vehicle::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('driver_id')
                    ->options(Driver::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                DateTimePicker::make('departure_at')
                    ->required(),
                DateTimePicker::make('arrival_at')
                    ->required(),
                DateTimePicker::make('boarding_close_at')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('seat_capacity')
                    ->required()
                    ->numeric(),
                TextInput::make('booked_seats')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('available_seats')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->options(ScheduleStatus::class)
                    ->default(ScheduleStatus::Open)
                    ->required(),
                KeyValue::make('meta')
                    ->columnSpanFull()
                    ->addable()
                    ->deletable()
                    ->reorderable(),
            ]);
    }
}
