<?php

namespace App\Models;

use Database\Factories\TravelRouteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelRoute extends Model
{
    /** @use HasFactory<TravelRouteFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $table = 'routes';

    protected $fillable = [
        'code',
        'origin_city',
        'destination_city',
        'origin_label',
        'destination_label',
        'estimated_duration_minutes',
        'base_price',
        'distance_km',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_duration_minutes' => 'integer',
            'base_price' => 'decimal:2',
            'distance_km' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pickupPoints(): HasMany
    {
        return $this->hasMany(PickupPoint::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
