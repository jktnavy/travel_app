<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Filament\Resources\Payments\PaymentResource;
use App\Filament\Resources\Tickets\TicketResource;
use App\Models\Booking;
use Filament\Actions\Action;
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

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('schedule.travelRoute.code')
                    ->label('Route')
                    ->badge()
                    ->searchable(),
                TextColumn::make('schedule.departure_at')
                    ->label('Schedule')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('order_id')
                    ->searchable(),
                TextColumn::make('booking_status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('passenger_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('paid_amount')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('booking_status')
                    ->options(collect(BookingStatus::cases())->mapWithKeys(fn (BookingStatus $status) => [
                        $status->value => $status->getLabel(),
                    ])),
                SelectFilter::make('payment_status')
                    ->options(collect(PaymentStatus::cases())->mapWithKeys(fn (PaymentStatus $status) => [
                        $status->value => $status->getLabel(),
                    ])),
                SelectFilter::make('route')
                    ->relationship('schedule.travelRoute', 'code')
                    ->label('Route'),
                Filter::make('booking_date')
                    ->schema([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                    }),
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record): bool => $record->canBeConfirmed())
                    ->action(function (Booking $record): void {
                        $record->update([
                            'booking_status' => BookingStatus::Confirmed,
                        ]);
                    }),
                Action::make('cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record): bool => $record->booking_status !== BookingStatus::Cancelled)
                    ->action(fn (Booking $record) => $record->markAsCancelled('Cancelled from Filament action')),
                Action::make('payment')
                    ->icon('heroicon-o-credit-card')
                    ->label('Payment')
                    ->url(fn (Booking $record): ?string => $record->latestPayment ? PaymentResource::getUrl('view', ['record' => $record->latestPayment]) : null)
                    ->visible(fn (Booking $record): bool => $record->latestPayment()->exists()),
                Action::make('ticket')
                    ->icon('heroicon-o-qr-code')
                    ->label('Ticket')
                    ->url(fn (Booking $record): ?string => $record->tickets()->first() ? TicketResource::getUrl('view', ['record' => $record->tickets()->first()]) : null)
                    ->visible(fn (Booking $record): bool => $record->tickets()->exists()),
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
