<?php

namespace App\Models;

use App\Models\Concerns\HasPayments;
use App\Models\Concerns\TracksViews;
use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    use HasPayments, TracksViews;

    protected $fillable = [
        'user_id',
        'service_id',
        'title',
        'description',
        'price',
        'size_sqm',
        'zoning',
        'land_use',
        'province',
        'district',
        'sector',
        'cell',
        'village',
        'upi',
        'title_doc',
        'is_title_verified',
        'latitude',
        'longitude',
        'status',
        'is_approved',
        'expires_at',
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
        'condition'
    ];

    protected string $viewableStatus = 'available';
    
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

    public function images()
    {
        return $this->hasMany(LandImage::class);
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
