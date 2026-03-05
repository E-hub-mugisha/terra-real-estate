<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyPlanOrder extends Model
{
    protected $fillable = [
        'user_id',
        'pricing_plan_id',
        'property_id',
        'property_type',
        'days',
        'price_per_day',
        'total_price',
        'payment_status'
    ];

    public function property()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(PricingPlan::class, 'pricing_plan_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'property_plan_order_id');
    }
}
