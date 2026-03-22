<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchitecturalDesign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'service_id',
        'category_id',
        'description',
        'design_file',
        'preview_image',
        'price',
        'is_free',
        'status',
        'featured',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(DesignCategory::class);
    }
    public function orders()
    {
        return $this->hasMany(DesignOrder::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
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
