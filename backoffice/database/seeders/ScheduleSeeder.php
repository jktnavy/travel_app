<?php

namespace Database\Seeders;

use App\Enums\ScheduleStatus;
use App\Models\Driver;
use App\Models\Schedule;
use App\Models\TravelRoute;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $routes = TravelRoute::query()->get();
        $vehicles = Vehicle::query()->get();
        $drivers = Driver::query()->get();

        foreach ($routes as $index => $route) {
            $vehicle = $vehicles[$index % $vehicles->count()];
            $driver = $drivers[$index % $drivers->count()];

            for ($dayOffset = 1; $dayOffset <= 5; $dayOffset++) {
                $departureAt = now()->addDays($dayOffset)->setTime(7 + $index, 0);

                Schedule::query()->updateOrCreate(
                    [
                        'travel_route_id' => $route->id,
                        'vehicle_id' => $vehicle->id,
                        'driver_id' => $driver->id,
                        'departure_at' => $departureAt,
                    ],
                    [
                        'arrival_at' => (clone $departureAt)->addHours(3),
                        'boarding_close_at' => (clone $departureAt)->subMinutes(30),
                        'price' => $route->base_price,
                        'seat_capacity' => $vehicle->seat_capacity,
                        'booked_seats' => 0,
                        'available_seats' => $vehicle->seat_capacity,
                        'status' => ScheduleStatus::Open,
                        'meta' => [
                            'seeded' => true,
                        ],
                    ],
                );
            }
        }
    }
}
