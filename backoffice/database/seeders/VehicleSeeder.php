<?php

namespace Database\Seeders;

use App\Enums\VehicleType;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            ['unit_code' => 'UNIT-101', 'plate_number' => 'B 1234 DTX', 'name' => 'Hiace Prima 1', 'type' => VehicleType::Hiace, 'seat_capacity' => 14],
            ['unit_code' => 'UNIT-102', 'plate_number' => 'B 2345 DTX', 'name' => 'Elf Prima 1', 'type' => VehicleType::Elf, 'seat_capacity' => 12],
            ['unit_code' => 'UNIT-103', 'plate_number' => 'B 3456 DTX', 'name' => 'Shuttle Reguler 1', 'type' => VehicleType::Shuttle, 'seat_capacity' => 6],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::query()->updateOrCreate(
                ['unit_code' => $vehicle['unit_code']],
                array_merge($vehicle, [
                    'baggage_capacity_kg' => 150,
                    'is_active' => true,
                ]),
            );
        }
    }
}
