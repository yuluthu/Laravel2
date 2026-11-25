<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class BoardController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json($this->payload());
    }

    /**
     * @return array{
     *     tournament: string,
     *     polled_at: string,
     *     source: string,
     *     teams: array<int, array{id: int, name: string}>,
     *     fixtures: array<int, array{
     *         group: string,
     *         team_a_id: int,
     *         team_b_id: int,
     *         team_a_score: int|null,
     *         team_b_score: int|null,
     *         when: string,
     *         live: bool
     *     }>
     * }
     */
    public function payload(): array
    {
        try {
            $teams = DB::table('teams')->select('id', 'name')->orderBy('name')->get();
            $games = DB::table('games')->orderBy('start_time')->limit(8)->get();

            if ($teams->isNotEmpty() && $games->isNotEmpty()) {
                return [
                    'tournament' => 'This weekend',
                    'polled_at' => now()->toIso8601String(),
                    'source' => 'database',
                    'teams' => $teams->map(fn ($team) => [
                        'id' => (int) $team->id,
                        'name' => $team->name,
                    ])->values()->all(),
                    'fixtures' => $games->map(function ($game) {
                        $kickoff = Carbon::parse($game->start_time);

                        return [
                            'group' => 'Fixture',
                            'team_a_id' => (int) $game->team_a_id,
                            'team_b_id' => (int) $game->team_b_id,
                            'team_a_score' => null,
                            'team_b_score' => null,
                            'when' => $kickoff->format('D · H:i'),
                            'live' => $kickoff->isPast() && $kickoff->greaterThan(now()->subHours(2)),
                        ];
                    })->values()->all(),
                ];
            }
        } catch (Throwable) {
            // The landing board still polls when the database is unreachable.
        }

        return $this->sample();
    }

    /**
     * @return array{
     *     tournament: string,
     *     polled_at: string,
     *     source: string,
     *     teams: array<int, array{id: int, name: string}>,
     *     fixtures: array<int, array{
     *         group: string,
     *         team_a_id: int,
     *         team_b_id: int,
     *         team_a_score: int|null,
     *         team_b_score: int|null,
     *         when: string,
     *         live: bool
     *     }>
     * }
     */
    private function sample(): array
    {
        return [
            'tournament' => 'Harbour Cup',
            'polled_at' => now()->toIso8601String(),
            'source' => 'sample',
            'teams' => [
                ['id' => 1, 'name' => 'Riverside'],
                ['id' => 2, 'name' => 'Harbour'],
                ['id' => 3, 'name' => 'North End'],
                ['id' => 4, 'name' => 'Kingsway'],
                ['id' => 5, 'name' => 'Milltown'],
                ['id' => 6, 'name' => 'Oakfield'],
                ['id' => 7, 'name' => 'Westgate'],
                ['id' => 8, 'name' => 'Priory'],
            ],
            'fixtures' => [
                [
                    'group' => 'Group A',
                    'team_a_id' => 1,
                    'team_b_id' => 2,
                    'team_a_score' => 2,
                    'team_b_score' => 1,
                    'when' => 'Full time',
                    'live' => false,
                ],
                [
                    'group' => 'Group A',
                    'team_a_id' => 3,
                    'team_b_id' => 4,
                    'team_a_score' => 0,
                    'team_b_score' => 0,
                    'when' => 'Sat · 14:00',
                    'live' => true,
                ],
                [
                    'group' => 'Group B',
                    'team_a_id' => 5,
                    'team_b_id' => 6,
                    'team_a_score' => null,
                    'team_b_score' => null,
                    'when' => 'Sat · 16:30',
                    'live' => false,
                ],
                [
                    'group' => 'Group B',
                    'team_a_id' => 7,
                    'team_b_id' => 8,
                    'team_a_score' => null,
                    'team_b_score' => null,
                    'when' => 'Sun · 11:00',
                    'live' => false,
                ],
            ],
        ];
    }
}
