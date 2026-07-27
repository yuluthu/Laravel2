<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DateTimeInterface;

#[Fillable(['name', 'start_date', 'end_date'])]
class Tournament extends Model
{
    /** @use HasFactory<\Database\Factories\TournamentFactory> */
    use HasFactory;
    
    protected $table = 'tournaments';

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'tournament_teams');
    }

    public static function listWithRelated() {
        return self::with(['teams' => function ($query) {
            $query->orderBy('name');
        }])->orderBy('name')->get();
    }

    public function findWithRelated(int $id): ?Tournament
    {
        return self::with('teams')->find($id);
    }

    public function formatDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }
}
