<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'profession',
        'license_number',
        'years_experience',
        'rating',
        'bio',
        'services',
        'portfolio_url',
        'credentials_doc',
        'linkedin',
        'website',
        'whatsapp',
        'office_location',
        'languages',
        'profile_image',
        'is_verified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
