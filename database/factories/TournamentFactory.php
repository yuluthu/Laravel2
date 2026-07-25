<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Tournament;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Tournament>
 */
class TournamentFactory extends Factory
{
    protected $model = Tournament::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => '',
            'tournamentType' => 1,
            'dateStart' => null,
            'dateEnd' => null,
        ];
    }
}
