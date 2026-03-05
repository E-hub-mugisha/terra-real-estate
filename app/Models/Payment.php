<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'property_plan_order_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(PropertyPlanOrder::class, 'property_plan_order_id');
    }
}
