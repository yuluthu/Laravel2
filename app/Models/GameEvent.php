<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['player_id', 'game_id', 'reverted', 'type_id'])]
class GameEvent extends Model
{
    /** @use HasFactory<\Database\Factories\GameEventFactory> */
    use HasFactory;

    protected $table = 'game_events';

}
