<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentInvoice extends Model
{
    protected $fillable = [
        'lease_id',
        'tenant_id',
        'unit_id',
        'invoice_number',
        'invoice_type',
        'description',
        'billing_period_start',
        'billing_period_end',
        'issue_date',
        'due_date',
        'amount',
        'paid_amount',
        'balance',
        'currency',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'billing_period_start' => 'date',
            'billing_period_end' => 'date',
            'issue_date' => 'date',
            'due_date' => 'date',
            'amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'balance' => 'decimal:2',
        ];
    }

    public function lease(): BelongsTo
    {
        return $this->belongsTo(Lease::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Payments associated with this invoice through allocations.
     */
    public function payments()
    {
        return $this->belongsToMany(
            RentPayment::class,
            'rent_payment_allocations',
            'rent_invoice_id',
            'rent_payment_id'
        )->withPivot([
            'amount',
            'allocated_by',
            'allocated_at',
            'notes',
        ])->withTimestamps();
    }

    /**
     * Determine whether the invoice has an outstanding balance.
     */
    public function getIsOutstandingAttribute(): bool
    {
        return (float) $this->balance > 0
            && $this->status !== 'cancelled';
    }

    /**
     * Determine whether the invoice is overdue.
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->status !== 'cancelled'
            && (float) $this->balance > 0
            && $this->due_date
            && $this->due_date->lt(today());
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(
            RentPaymentAllocation::class,
            'rent_invoice_id'
        );
    }
}
