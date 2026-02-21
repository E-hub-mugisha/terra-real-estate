<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    protected $fillable = [
        'user_id',
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
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
