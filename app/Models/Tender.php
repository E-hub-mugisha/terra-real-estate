<?php

namespace App\Models;

use App\Models\Concerns\TracksViews;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use TracksViews;
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'reference_no',
        'budget',
        'submission_deadline',
        'location',
        'document_path',
        'is_open'
    ];

    protected function casts(): array
    {
        return [
            'submission_deadline' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
