<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.order_id')
                    ->label('Order ID')
                    ->searchable(),
                TextColumn::make('booking.booking_code')
                    ->label('Booking')
                    ->searchable(),
                TextColumn::make('booking.customer.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Gross Amount')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('method')
                    ->label('Payment Type')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Transaction Status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('paid_at')
                    ->label('Settlement Time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('provider')
                    ->searchable(),
                TextColumn::make('transaction_id')
                    ->searchable(),
                TextColumn::make('expired_at')
                    ->dateTime()
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('inspect_payload')
                    ->label('Raw Payload')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->url(fn ($record): string => PaymentResource::getUrl('view', ['record' => $record])),
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
