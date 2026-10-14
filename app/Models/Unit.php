<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = [
        'managed_property_id',
        'building_id',
        'floor_id',
        'unit_number',
        'unit_type',
        'bedrooms',
        'bathrooms',
        'area_sqm',
        'monthly_rent',
        'security_deposit',
        'currency',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'area_sqm' => 'decimal:2',
            'monthly_rent' => 'decimal:2',
            'security_deposit' => 'decimal:2',
        ];
    }

    public function managedProperty(): BelongsTo
    {
        return $this->belongsTo(ManagedProperty::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(TenantApplication::class);
    }

    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(PropertyExpense::class);
    }
}