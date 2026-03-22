<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'title',
        'upi',
        'type',
        'price',
        'area_sqft',
        'status',
        'bedrooms',
        'bathrooms',
        'garages',
        'description',
        'province',
        'district',
        'sector',
        'cell',
        'village',
        'condition',
        'is_approved',
        'agent_id',
        'added_by',
        'listing_package_id',
        'listing_days',
        'listing_fee_total',
        'agent_listing_commission',
        'terra_listing_revenue',
        'owner_name',
        'owner_email',
        'owner_phone',
        'owner_id_number',
    ];

    public function images()
    {
        return $this->hasMany(HouseImage::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function advertisements()
    {
        return $this->morphMany(Advertisement::class, 'advertisable');
    }

    public function planOrders()
    {
        return $this->morphMany(PropertyPlanOrder::class, 'property');
    }
    public function latestPlan()
    {
        return $this->planOrders()->latest()->first();
    }
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function listingPackage()
    {
        return $this->belongsTo(ListingPackage::class);
    }
    public function commission()
    {
        return $this->morphOne(AgentCommission::class, 'commissionable');
    }
}
