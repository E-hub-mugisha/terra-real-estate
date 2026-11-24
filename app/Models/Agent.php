<?php

namespace App\Models;

use App\Models\Concerns\TracksViews;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use TracksViews;
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'bio',
        'linkedin',
        'facebook',
        'instagram',
        'twitter',
        'profile_image',
        'whatsapp',
        'office_location',
        'languages',
        'is_verified',
        'province',
        'district',
        'sector',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleting(function ($agent) {
            if ($agent->user) {
                $agent->user->delete();
            }
        });
    }
}
