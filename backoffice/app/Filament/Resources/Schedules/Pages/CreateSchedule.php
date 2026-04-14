<?php

namespace App\Filament\Resources\Schedules\Pages;

use App\Filament\Resources\Schedules\ScheduleResource;
use App\Models\Schedule;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validateConflicts($data);

        return $data;
    }

    private function validateConflicts(array $data): void
    {
        $vehicleConflict = Schedule::query()
            ->where('vehicle_id', $data['vehicle_id'])
            ->where('departure_at', '<', $data['arrival_at'])
            ->where('arrival_at', '>', $data['departure_at'])
            ->exists();

        $driverConflict = Schedule::query()
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
    }
}
