<?php

namespace Database\Factories;

use App\Models\DeviceLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeviceLog>
 */
class DeviceLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => 1,
            'battery_charge' => fake()->numberBetween(1, 100),
            'sensor_life' => fake()->numberBetween(1, 100),
            'status' => 1,
        ];
    }
}
