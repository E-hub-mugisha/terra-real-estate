<?php

namespace App\Models;

use App\Models\Concerns\TracksViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes, TracksViews;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'start_date',
        'end_date',
        'created_by'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime'
        ];
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
