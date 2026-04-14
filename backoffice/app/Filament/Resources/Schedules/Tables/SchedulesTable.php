<?php

namespace App\Filament\Resources\Schedules\Tables;

use App\Enums\ScheduleStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('travelRoute.code')
                    ->label('Route')
                    ->badge()
                    ->searchable(),
                TextColumn::make('vehicle.name')
                    ->searchable(),
                TextColumn::make('driver.name')
                    ->searchable(),
                TextColumn::make('departure_at')
                    ->date('d M Y')
                    ->label('Departure Date')
                    ->sortable(),
                TextColumn::make('departure_at')
                    ->time('H:i')
                    ->label('Departure Time')
                    ->sortable(),
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('seat_capacity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('booked_seats')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('available_seats')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(collect(ScheduleStatus::cases())->mapWithKeys(fn (ScheduleStatus $status) => [
                        $status->value => $status->getLabel(),
                    ])),
                SelectFilter::make('travel_route_id')
                    ->relationship('travelRoute', 'code')
                    ->label('Route'),
                Filter::make('departure_range')
                    ->schema([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, $date): Builder => $query->whereDate('departure_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $query, $date): Builder => $query->whereDate('departure_at', '<=', $date));
                    }),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
