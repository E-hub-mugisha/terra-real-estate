<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchitecturalDesign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'category_id',
        'description',
        'design_file',
        'preview_image',
        'price',
        'is_free',
        'status',
        'featured'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(DesignCategory::class);
    }
    public function orders()
    {
        return $this->hasMany(DesignOrder::class);
    }
}
