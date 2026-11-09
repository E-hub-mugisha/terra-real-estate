<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentPaymentAllocation extends Model
{
    protected $fillable = [
        'rent_payment_id',
        'rent_invoice_id',
        'amount',
        'allocated_by',
        'allocated_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'allocated_at' => 'datetime',
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(
            RentPayment::class,
            'rent_payment_id'
        );
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(
            RentInvoice::class,
            'rent_invoice_id'
        );
    }

    public function allocator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'allocated_by'
        );
    }
}