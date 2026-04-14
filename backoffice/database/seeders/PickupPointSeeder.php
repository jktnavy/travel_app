<?php

namespace Database\Seeders;

use App\Models\PickupPoint;
use App\Models\TravelRoute;
use Illuminate\Database\Seeder;

class PickupPointSeeder extends Seeder
{
    public function run(): void
    {
        $routes = TravelRoute::query()->get()->keyBy('code');

        $points = [
            ['route' => 'JKT-CJR-01', 'name' => 'Pool Jakarta Selatan', 'city' => 'Jakarta', 'direction' => 'departure', 'address' => 'Jl. TB Simatupang, Jakarta Selatan', 'sort_order' => 1],
            ['route' => 'JKT-CJR-01', 'name' => 'Rest Area Cipanas', 'city' => 'Cianjur', 'direction' => 'departure', 'address' => 'Jl. Raya Puncak, Cipanas', 'sort_order' => 2],
            ['route' => 'CJR-JKT-01', 'name' => 'Pool Cianjur Kota', 'city' => 'Cianjur', 'direction' => 'departure', 'address' => 'Jl. KH Abdullah bin Nuh, Cianjur', 'sort_order' => 1],
            ['route' => 'CJR-JKT-01', 'name' => 'Drop Point Lebak Bulus', 'city' => 'Jakarta', 'direction' => 'departure', 'address' => 'Jl. Lebak Bulus Raya, Jakarta Selatan', 'sort_order' => 2],
        ];

        foreach ($points as $point) {
            $route = $routes->get($point['route']);

            if (! $route) {
                continue;
            }

            PickupPoint::query()->updateOrCreate(
                [
                    'travel_route_id' => $route->id,
                    'name' => $point['name'],
                ],
                [
                    'city' => $point['city'],
                    'direction' => $point['direction'],
                    'address' => $point['address'],
                    'sort_order' => $point['sort_order'],
                    'contact_phone' => '081234567890',
                    'is_active' => true,
                ],
            );
        }
    }
}
