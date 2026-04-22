<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantPortfolio extends Model
{
    protected $fillable = [
        'consultant_id',
        'title',
        'location',
        'year',
        'image',
    ];
 
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
