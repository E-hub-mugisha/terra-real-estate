<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignImage extends Model
{
    protected $fillable = ['architectural_design_id', 'image_path'];

    public function design()
    {
        return $this->belongsTo(ArchitecturalDesign::class);
    }
}
