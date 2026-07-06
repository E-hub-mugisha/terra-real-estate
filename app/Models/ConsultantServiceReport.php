<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantServiceReport extends Model
{
    protected $fillable = [
        'consultant_id',
        'service_id',
        'client_name',
        'client_phone',
        'service_date',
        'service_time',
        'location',
        'amount',
        'commission_type',
        'commission_value',
        'terra_commission_amount',
        'consultant_amount',
        'status',
        'notes',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'service_date'   => 'date',
        'amount'         => 'decimal:2',
        'commission_value' => 'decimal:2',
        'terra_commission_amount' => 'decimal:2',
        'consultant_amount' => 'decimal:2',
        'reviewed_at'    => 'datetime',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}