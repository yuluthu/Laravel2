<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Game;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Game>
 */
class GameFactory extends Factory
{
    protected $model = Game::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tournament_id' => $this->faker->numberBetween(1, 10),
            'team_a_id' => $this->faker->numberBetween(1, 20),
            'team_b_id' => $this->faker->numberBetween(1, 20),
            'start_time' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
        ];
    }
}
