<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'service_id',
        'assigned_consultant_id',
        'full_name',
        'phone',
        'email',
        'location',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class, 'assigned_consultant_id');
    }

    public function report()
    {
        return $this->hasOne(ConsultantServiceReport::class);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}