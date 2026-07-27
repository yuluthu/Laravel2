<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'club_type', 'active'])]
class Club extends Model
{
    /** @use HasFactory<\Database\Factories\ClubFactory> */
    use HasFactory;

    protected $table = 'clubs';

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function findWithRelated(int $id): ?Club
    {
        return self::with('teams')->find($id);
    }

    public static function listWithRelated() {
        return self::with('teams')->orderBy('name')->get();
    }
}
