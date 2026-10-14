<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lease extends Model
{
    protected $fillable = [
        'tenant_id',
        'unit_id',
        'created_by',
        'lease_number',
        'start_date',
        'end_date',
        'monthly_rent',
        'security_deposit',
        'rent_due_day',
        'currency',
        'payment_frequency',
        'status',
        'terminated_at',
        'termination_reason',
        'terms',
        'document_path',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'terminated_at' => 'date',
            'monthly_rent' => 'decimal:2',
            'security_deposit' => 'decimal:2',
            'rent_due_day' => 'integer',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function rentPayments(): HasMany
    {
        return $this->hasMany(RentPayment::class);
    }
}