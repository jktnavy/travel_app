<?php

namespace App\Models;

use App\Enums\VehicleType;
use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    /** @use HasFactory<VehicleFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'unit_code',
        'plate_number',
        'name',
        'type',
        'seat_capacity',
        'baggage_capacity_kg',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'type' => VehicleType::class,
            'seat_capacity' => 'integer',
            'baggage_capacity_kg' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
