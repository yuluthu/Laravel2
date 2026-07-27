<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'club_id'])]
class Team extends Model
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    protected $table = 'teams';

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function tournaments(): BelongsToMany
    {
        return $this->belongsToMany(Tournament::class, 'tournament_teams');
    }

    public function findWithRelated(int $id): ?Team
    {
        return self::with('club')->find($id);
    }

    public static function listWithRelated() {
        return self::with('club')->orderBy('name')->get();
    }
}
