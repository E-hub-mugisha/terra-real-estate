<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentPayment extends Model
{
    use HasFactory;

    protected $table = 'rent_payments';

    protected $fillable = [
        'payment_number',
        'tenant_id',
        'lease_id',
        'unit_id',
        'payment_method',
        'provider',
        'transaction_id',
        'amount',
        'currency',
        'payment_date',
        'status',
        'description',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(
            Tenant::class,
            'tenant_id'
        );
    }

    public function lease(): BelongsTo
    {
        return $this->belongsTo(
            Lease::class,
            'lease_id'
        );
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(
            Unit::class,
            'unit_id'
        );
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'recorded_by'
        );
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(
            RentPaymentAllocation::class,
            'rent_payment_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAllocatedAmountAttribute(): float
    {
        return (float) $this->allocations()->sum('amount');
    }

    public function getUnallocatedAmountAttribute(): float
    {
        return max(
            0,
            (float) $this->amount - $this->allocated_amount
        );
    }
}