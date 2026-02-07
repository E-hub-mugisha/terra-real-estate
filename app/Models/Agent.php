<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'years_experience',
        'bio',
        'linkedin',
        'facebook',
        'instagram',
        'twitter',
        'profile_image',
        'whatsapp',
        'office_location',
        'languages',
        'is_verified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
