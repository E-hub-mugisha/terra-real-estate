<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'title',
        'description',

        'type',
        'property_category',
        'listing_type',

        'price',

        'district',
        'sector',
        'cell',
        'village',
        'address',

        'latitude',
        'longitude',

        'upi_reference',
        'zoning',

        'status',
        'management_status',

        'is_approved',
        'is_managed',

        'expires_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_approved' => 'boolean',
        'is_managed' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Owner
    |--------------------------------------------------------------------------
    */

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Buildings
    |--------------------------------------------------------------------------
    */

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Management helpers
    |--------------------------------------------------------------------------
    */

    public function isManaged(): bool
    {
        return $this->is_managed === true;
    }

    public function isForRent(): bool
    {
        return $this->listing_type === 'rent';
    }

    public function propertyOwner(): BelongsTo
    {
        return $this->belongsTo(PropertyOwner::class, 'property_owner_id');
    }
}
