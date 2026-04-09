<?php

namespace App\Models;

use App\Models\Concerns\TracksViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory, TracksViews;

    protected $fillable = [
        'user_id',
        'name',
        'title',
        'email',
        'phone',
        'photo',
        'bio',
        'is_active',
        'registration_number',
        'cv',
        'province',
        'district',
        'availability',
        'is_verified',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_verified' => 'boolean',
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

    public function services()
    {
        return $this->belongsToMany(Service::class, 'consultant_service');
    }

    public function bookings()
    {
        return $this->hasMany(ConsultantBooking::class);
    }

    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', $this->name);
        return strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
    }

    public function scopeAvailable($query, string $district, int $serviceId): \Illuminate\Database\Eloquent\Builder
    {
        return $query
            ->where('district', $district)
            ->where('is_active', true)
            ->whereHas('services', fn($q) => $q->where('services.id', $serviceId));
    }
}
