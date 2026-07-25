<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[HasFactory]
#[Fillable(['player_id', 'game_id', 'reverted', 'type_id'])]
class MatchEvent extends Model
{
    /** @use HasFactory<\Database\Factories\MatchEventFactory> */
    use HasFactory;

    protected $table = 'match_events';

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
