<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentLedgerEntries extends Model
{
    use HasFactory;

    protected $table = 'rent_ledger_entries';

    protected $fillable = [
        'tenant_id',
        'lease_id',
        'unit_id',
        'rent_invoice_id',
        'rent_payment_id',
        'entry_type',
        'entry_date',
        'description',
        'debit',
        'credit',
        'balance',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

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

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(
            RentInvoice::class,
            'rent_invoice_id'
        );
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(
            RentPayment::class,
            'rent_payment_id'
        );
    }
}