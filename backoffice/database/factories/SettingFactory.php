<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group' => fake()->randomElement(['general', 'booking', 'payment']),
            'key' => fake()->unique()->slug(2, '_'),
            'label' => fake()->words(2, true),
            'value' => ['value' => fake()->sentence()],
            'is_public' => false,
        ];
    }
}
