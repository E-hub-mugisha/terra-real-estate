<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseImage extends Model
{
    protected $fillable = ['house_id', 'image_path'];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
