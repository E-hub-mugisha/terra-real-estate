<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'content', 'image', 'price', 'status', 'start_date', 'end_date', 'created_by'];
}
