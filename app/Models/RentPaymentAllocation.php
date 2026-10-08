<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentPaymentAllocation extends Model
{
    use HasFactory;

    protected $table = 'rent_payment_allocations';

    protected $fillable = [
        'rent_payment_id',
        'rent_invoice_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

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
}