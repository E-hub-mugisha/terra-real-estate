<?php

namespace App\Models;

use App\Models\Concerns\TracksViews;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use TracksViews;
    
    protected $fillable = [
        'user_id',
        'blog_category_id',
        'title',
        'slug',
        'featured_image',
        'content',
        'is_published',
        'published_at'
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }
    public function category()
    {
        return $this->belongsTo(BlogCategory::class,'blog_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function images()
    {
        return $this->hasMany(BlogImage::class)->orderBy('sort_order');
    }
}
