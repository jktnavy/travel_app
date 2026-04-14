<?php

namespace App\Filament\Resources\PickupPoints\Pages;

use App\Filament\Resources\PickupPoints\PickupPointResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPickupPoint extends ViewRecord
{
    protected static string $resource = PickupPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
