<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'rent_payment_id',
        'tenant_id',
        'lease_id',
        'unit_id',
        'amount',
        'currency',
        'receipt_date',
        'payment_method',
        'transaction_id',
        'pdf_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'receipt_date' => 'date',
    ];

    public function payment()
    {
        return $this->belongsTo(RentPayment::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
