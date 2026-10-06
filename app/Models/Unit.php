<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_id',
        'unit_number',
        'unit_type',
        'size',
        'bedrooms',
        'bathrooms',
        'rent',
        'deposit',
        'availability',
        'occupancy_status',
        'utility_meter',
        'description',
    ];

    protected $casts = [
        'size' => 'decimal:2',
        'rent' => 'decimal:2',
        'deposit' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
    ];

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function building()
    {
        return $this->hasOneThrough(
            Building::class,
            Floor::class,
            'id',
            'id',
            'floor_id',
            'building_id'
        );
    }

    public function applications(): HasMany
    {
        return $this->hasMany(TenantApplication::class);
    }

    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class);
    }
}
