<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    protected $fillable = [
        'managed_property_id',
        'name',
        'building_code',
        'number_of_floors',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'number_of_floors' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function managedProperty(): BelongsTo
    {
        return $this->belongsTo(ManagedProperty::class);
    }

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class);
    }
}
