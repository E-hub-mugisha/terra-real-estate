<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
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

    public function category()
    {
        return $this->belongsTo(BlogCategory::class,'blog_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
