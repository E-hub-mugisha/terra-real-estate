<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerraJobApplication extends Model
{
    protected $fillable = [
        'job_id', 'user_id', 'cv', 'cover_letter', 'status'
    ];

    public function job()
    {
        return $this->belongsTo(TerraJob::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
