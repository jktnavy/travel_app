<?php

namespace App\Models;

use App\Enums\DriverStatus;
use Database\Factories\DriverFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    /** @use HasFactory<DriverFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'license_number',
        'license_expires_at',
        'status',
        'hired_at',
        'address',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'license_expires_at' => 'date',
            'status' => DriverStatus::class,
            'hired_at' => 'date',
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
