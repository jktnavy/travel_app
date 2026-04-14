<?php

namespace App\Filament\Resources\Schedules\Pages;

use App\Filament\Resources\Schedules\ScheduleResource;
use App\Models\Schedule;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $vehicleConflict = Schedule::query()
            ->whereKeyNot($this->record->getKey())
            ->where('vehicle_id', $data['vehicle_id'])
            ->where('departure_at', '<', $data['arrival_at'])
            ->where('arrival_at', '>', $data['departure_at'])
            ->exists();

        $driverConflict = Schedule::query()
            ->whereKeyNot($this->record->getKey())
            ->where('driver_id', $data['driver_id'])
            ->where('departure_at', '<', $data['arrival_at'])
            ->where('arrival_at', '>', $data['departure_at'])
            ->exists();

        if ($vehicleConflict || $driverConflict) {
            throw ValidationException::withMessages([
                'vehicle_id' => $vehicleConflict ? 'Vehicle already has another schedule in this time range.' : null,
                'driver_id' => $driverConflict ? 'Driver already has another schedule in this time range.' : null,
            ]);
        }

        return $data;
    }
}
