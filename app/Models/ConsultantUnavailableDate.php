<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultantUnavailableDate extends Model
{
    protected $fillable = ['consultant_id', 'date', 'reason'];

    protected $casts = [
        'date' => 'date',
    ];

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(Consultant::class);
    }
}