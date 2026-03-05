<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandImage extends Model
{
    //
    protected $fillable = ['land_id', 'image_path'];

    public function land()
    {
        return $this->belongsTo(Land::class);
    }
}
