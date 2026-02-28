<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    protected $fillable = [
        'agent_id',
        'advertisable_type',
        'advertisable_id',
        'ad_type',
        'title',
        'description',
        'banner_image',
        'price',
        'start_date',
        'end_date',
        'status'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function advertisable()
    {
        return $this->morphTo();
    }
}
