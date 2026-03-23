<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantAppointment extends Model
{
    protected $table = 'consultant_appointments';

    protected $fillable = [
        'consultant_id',
        'name',
        'email',
        'date',
        'time',
        'message',
    ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}