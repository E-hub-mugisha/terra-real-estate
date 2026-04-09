<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConsultantBooking extends Model
{
    protected $fillable = [
        'reference',
        'consultant_id',
        'service_id',
        'user_id',
        'client_name',
        'client_email',
        'client_phone',
        'province',
        'district',
        'appointment_date',
        'notes',
        'fee',
        'payment_method',
        'payment_reference',
        'payment_status',
        'status',
        'confirmed_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'confirmed_at'     => 'datetime',
        'fee'              => 'decimal:2',
    ];

    // Auto-generate reference on create
    protected static function booted(): void
    {
        static::creating(function (self $booking) {
            $booking->reference ??= 'TRR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        });
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }
}
