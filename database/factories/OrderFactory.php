<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => 1,
            'device_id' => 1,
            'delivery_date' => random_int(1, 5) == 1 ? fake()->dateTimeBetween('-15 week', '-1 weeks') : null,
            'status' => 1,
        ];
    }
}
