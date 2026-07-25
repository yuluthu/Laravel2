<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\GameFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[HasFactory]
#[Fillable(['tournament_id', 'team_a_id', 'team_b_id', 'start_time'])]
class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function teamA(): HasOne
    {
        return $this->hasOne(Team::class);
    }
    
    public function teamB(): HasOne
    {
        return $this->hasOne(Team::class);
    }

}
