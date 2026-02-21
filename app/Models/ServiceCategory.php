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
        return $this->hasMany(ServiceSubcategory::class, 'category_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
