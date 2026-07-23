<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

#[Fillable(['tenant_id', 'location_id', 'hardware_id', 'status'])]
class Device extends Model
{
    use HasFactory;

    protected $with = ['tenant', 'location', 'product', 'currentStatus', 'subscription', 'order'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function currentStatus(): HasOne
    {
        return $this->hasOne(DeviceLog::class)->ofMany([
            'id' => 'max',
        ], function (Builder $query) {
            $query->where('status', 1);
        });
    }

    public function deviceLogs(): HasMany
    {
        return $this->hasMany(DeviceLog::class);
    }

    // for subscriptions and orders there will be many records however we only care about the newest one (or with subscriptions, whatever one has the highest expiry date)
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->ofMany('expiry_date', 'max');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }

    protected static function booted()
    {
        if (env('APP_ENV') !== 'testing') {
            static::addGlobalScope('hasAccess', function (Builder $builder) {
                $builder->where('tenant_id', Auth::user()->tenant_id);
            });
        }
    }
}
