<?php

namespace Database\Factories;

use App\Models\TournamentTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TournamentTeam>
 */
class TournamentTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tournament_id' => $this->faker->numberBetween(1, 10),
            'team_id' => $this->faker->numberBetween(1, 20),
            'active' => $this->faker->boolean(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => true,
        ]);
    }
}
