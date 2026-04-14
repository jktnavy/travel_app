<?php

namespace Database\Seeders;

use App\Models\TravelRoute;
use Illuminate\Database\Seeder;

class TravelRouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            [
                'code' => 'JKT-CJR-01',
                'origin_city' => 'Jakarta',
                'destination_city' => 'Cianjur',
                'origin_label' => 'Jakarta Selatan',
                'destination_label' => 'Cianjur Kota',
                'estimated_duration_minutes' => 180,
                'base_price' => 90000,
                'distance_km' => 95,
            ],
            [
                'code' => 'CJR-JKT-01',
                'origin_city' => 'Cianjur',
                'destination_city' => 'Jakarta',
                'origin_label' => 'Cianjur Kota',
                'destination_label' => 'Jakarta Selatan',
                'estimated_duration_minutes' => 180,
                'base_price' => 90000,
                'distance_km' => 95,
            ],
        ];

        foreach ($routes as $route) {
            TravelRoute::query()->updateOrCreate(
                ['code' => $route['code']],
                array_merge($route, ['is_active' => true]),
            );
        }
    }
}
