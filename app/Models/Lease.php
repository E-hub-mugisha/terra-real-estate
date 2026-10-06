<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'lease_number',
        'tenant_id',
        'unit_id',
        'tenant_application_id',

        'start_date',
        'end_date',

        'monthly_rent',
        'deposit_amount',
        'payment_frequency',

        'terms',
        'special_conditions',

        'signed_at',
        'signed_by',

        'status',

        'terminated_at',
        'termination_reason',

        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'signed_at' => 'datetime',
        'terminated_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(
            TenantApplication::class,
            'tenant_application_id'
        );
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'signed_by'
        );
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }
}