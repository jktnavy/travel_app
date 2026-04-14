<?php

namespace Database\Seeders;

use App\Enums\DriverStatus;
use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = [
            ['name' => 'Budi Santoso', 'phone' => '081310000001', 'license_number' => 'SIM-100001'],
            ['name' => 'Agus Hidayat', 'phone' => '081310000002', 'license_number' => 'SIM-100002'],
            ['name' => 'Rizal Maulana', 'phone' => '081310000003', 'license_number' => 'SIM-100003'],
        ];

        foreach ($drivers as $driver) {
            Driver::query()->updateOrCreate(
                ['license_number' => $driver['license_number']],
                array_merge($driver, [
                    'license_expires_at' => now()->addYear()->toDateString(),
                    'status' => DriverStatus::Active,
                    'hired_at' => now()->subYear()->toDateString(),
                    'address' => 'Jakarta',
                ]),
            );
        }
    }
}
