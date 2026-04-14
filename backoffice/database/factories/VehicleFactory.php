<?php

namespace Database\Factories;

use App\Enums\VehicleType;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement([
            VehicleType::Shuttle,
            VehicleType::Elf,
            VehicleType::Hiace,
        ]);

        return [
            'unit_code' => 'UNIT-'.fake()->unique()->numerify('###'),
            'plate_number' => strtoupper(fake()->bothify('B #### ???')),
            'name' => ucfirst($type->value).' '.fake()->numerify('##'),
            'type' => $type,
            'seat_capacity' => match ($type) {
                VehicleType::Shuttle => 6,
                VehicleType::Elf => 12,
                VehicleType::Hiace => 14,
                VehicleType::Bus => 30,
            },
            'baggage_capacity_kg' => fake()->numberBetween(100, 250),
            'is_active' => true,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
