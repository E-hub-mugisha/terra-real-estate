<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'lease_id',
        'tenant_id',
        'unit_id',
        'invoice_type',
        'description',
        'billing_period_start',
        'billing_period_end',
        'issue_date',
        'due_date',
        'amount',
        'paid_amount',
        'balance',
        'status',
        'notes',
    ];

    protected $casts = [
        'billing_period_start' => 'date',
        'billing_period_end' => 'date',
        'issue_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function allocations()
    {
        return $this->hasMany(
            RentPaymentAllocation::class,
            'rent_invoice_id'
        );
    }

    public function payments()
    {
        return $this->hasManyThrough(
            RentPayment::class,
            RentPaymentAllocation::class,
            'rent_invoice_id',
            'id',
            'id',
            'rent_payment_id'
        );
    }

    public function ledgerEntries()
    {
        return $this->hasMany(RentLedgerEntries::class);
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->status === 'paid';
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date &&
            $this->due_date->isPast() &&
            $this->balance > 0 &&
            !in_array($this->status, ['paid', 'cancelled']);
    }
}
