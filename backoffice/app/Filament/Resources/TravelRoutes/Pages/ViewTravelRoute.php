<?php

namespace App\Filament\Resources\TravelRoutes\Pages;

use App\Filament\Resources\TravelRoutes\TravelRouteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTravelRoute extends ViewRecord
{
    protected static string $resource = TravelRouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
