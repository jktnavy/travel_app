<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Services\Payment\MidtransService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sync_status')
                ->label('Sync Status')
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => app(MidtransService::class)->syncPaymentStatus($this->record)),
            EditAction::make(),
        ];
    }
}
