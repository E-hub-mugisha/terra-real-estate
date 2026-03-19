<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerraJob extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'deadline',
        'is_active'
    ];

    public function applications()
    {
        return $this->hasMany(TerraJobApplication::class);
    }
}
