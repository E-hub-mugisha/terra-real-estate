<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * A category has many architectural designs
     */
    public function designs()
    {
        return $this->hasMany(ArchitecturalDesign::class, 'category_id');
    }
}
