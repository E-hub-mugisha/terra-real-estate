<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = [
        'service_category_id',
        'service_subcategory_id',
        'title',
        'slug',
        'description',
        'price',
        'commission_type',
        'commission_value',
        'is_active',
    ];

    public function serviceReports()
    {
        return $this->hasMany(ConsultantServiceReport::class);
    }

    /**
     * Calculate Terra's commission for a given charged amount.
     */
    public function calculateCommission(float $amount): float
    {
        if ($this->commission_type === 'fixed') {
            return min($this->commission_value, $amount);
        }

        return round($amount * ($this->commission_value / 100), 2);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ServiceSubCategory::class, 'service_subcategory_id');
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }

    public function lands()
    {
        return $this->hasMany(Land::class);
    }

    public function architecturalDesigns()
    {
        return $this->hasMany(ArchitecturalDesign::class);
    }
    public function advertisements()
    {
        return $this->morphMany(Advertisement::class, 'advertisable');
    }
    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_service');
    }
    public function professionals(): BelongsToMany
    {
        return $this->belongsToMany(Professional::class, 'professional_service')
            ->withTimestamps();
    }
}
