<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_category_id',
        'service_subcategory_id',
        'title',
        'slug',
        'description',
        'price',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ServiceSubcategory::class, 'service_subcategory_id');
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
}
