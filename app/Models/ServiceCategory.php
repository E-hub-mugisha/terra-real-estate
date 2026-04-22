<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];
    public function subcategories()
    {
        return $this->hasMany(ServiceSubCategory::class, 'service_category_id'); // correct FK
    }

    // Only if you really want to access all services directly via category
    public function services()
    {
        return $this->hasMany(Service::class, 'service_category_id');
    }

    public function consultants()
    {
        return $this->belongsToMany(Consultant::class);
    }
}
