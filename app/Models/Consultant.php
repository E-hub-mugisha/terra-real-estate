<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'title',
        'email',
        'phone',
        'photo',
        'bio',
        'is_active',
    ];

    public function serviceCategories()
    {
        return $this->belongsToMany(ServiceCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(ConsultantReview::class);
    }
}
