<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'price',
        'area_sqft',
        'status',
        'bedrooms',
        'bathrooms',
        'garages',
        'description',
        'city',
        'state',
        'zip_code',
        'country',
        'address',
        'condition'
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
}
