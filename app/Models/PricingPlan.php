<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price_per_day',
        'max_images',
        'featured',
        'priority_listing',
        'show_on_homepage',
        'active'
    ];
    
    public function orders()
    {
        return $this->hasMany(PropertyPlanOrder::class);
    }
}
