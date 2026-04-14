<?php

namespace App\Models;

use Database\Factories\PickupPointFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupPoint extends Model
{
    /** @use HasFactory<PickupPointFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'travel_route_id',
        'name',
        'city',
        'direction',
        'address',
        'contact_phone',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function travelRoute(): BelongsTo
    {
        return $this->belongsTo(TravelRoute::class);
    }
}
