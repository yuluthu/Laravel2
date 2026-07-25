<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[HasFactory]
#[Fillable(['tournament_id', 'team_id', 'active'])]
class TournamentTeam extends Model
{
    /** @use HasFactory<\Database\Factories\TournamentTeamFactory> */
    use HasFactory;

    protected $table = 'tournament_teams';

    public function tournament(): HasOne
    {
        return $this->hasOne(Tournament::class);
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class);
    }
}
