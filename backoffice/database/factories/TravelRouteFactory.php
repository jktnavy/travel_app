<?php

namespace Database\Factories;

use App\Models\TravelRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TravelRoute>
 */
class TravelRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $routes = [
            ['Jakarta', 'Cianjur', 'Jakarta Selatan', 'Cianjur Kota'],
            ['Cianjur', 'Jakarta', 'Cianjur Kota', 'Jakarta Selatan'],
        ];

        [$originCity, $destinationCity, $originLabel, $destinationLabel] = fake()->randomElement($routes);

        return [
            'code' => strtoupper(substr($originCity, 0, 3)).'-'.strtoupper(substr($destinationCity, 0, 3)).'-'.fake()->unique()->numerify('##'),
            'origin_city' => $originCity,
            'destination_city' => $destinationCity,
            'origin_label' => $originLabel,
            'destination_label' => $destinationLabel,
            'estimated_duration_minutes' => fake()->numberBetween(120, 240),
            'base_price' => fake()->randomElement([85000, 90000, 95000, 100000]),
            'distance_km' => fake()->randomFloat(2, 70, 130),
            'is_active' => true,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
