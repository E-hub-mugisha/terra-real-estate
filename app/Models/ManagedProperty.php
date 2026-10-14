<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManagedProperty extends Model
{
    protected $fillable = [
        'property_owner_id',
        'name',
        'property_code',
        'property_type',
        'description',
        'province',
        'district',
        'sector',
        'cell',
        'village',
        'address',
        'upi_reference',
        'latitude',
        'longitude',
        'management_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            PropertyOwner::class,
            'property_owner_id'
        );
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(PropertyExpense::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}
