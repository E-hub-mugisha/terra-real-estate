<?php

namespace App\Models;

use App\Models\Concerns\TracksViews;
use Illuminate\Database\Eloquent\Model;

class TerraJob extends Model
{
    use TracksViews;
    
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
