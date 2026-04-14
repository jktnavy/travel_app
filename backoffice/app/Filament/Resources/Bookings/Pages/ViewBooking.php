<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Services\Payment\MidtransService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_snap')
                ->label('Create Snap')
                ->icon('heroicon-o-link')
                ->visible(fn (): bool => $this->record->canBePaid())
                ->action(fn () => app(MidtransService::class)->createSnapTransaction($this->record)),
            EditAction::make(),
        ];
    }
}
