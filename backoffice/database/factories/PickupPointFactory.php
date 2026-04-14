<?php

namespace Database\Factories;

use App\Models\PickupPoint;
use App\Models\TravelRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PickupPoint>
 */
class PickupPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'travel_route_id' => TravelRoute::factory(),
            'name' => fake()->company().' Point',
            'city' => fake()->randomElement(['Jakarta', 'Cianjur']),
            'direction' => fake()->randomElement(['departure', 'return']),
            'address' => fake()->address(),
            'contact_phone' => fake()->optional()->phoneNumber(),
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
