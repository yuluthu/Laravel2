<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['device_id', 'expiry_date', 'status'])]
class Subscription extends Model
{
    use HasFactory;

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('notExpired', function (Builder $builder) {
            $builder->whereTodayOrAfter('expiry_date');
        });
    }
}
