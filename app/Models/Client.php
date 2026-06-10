<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// app/Models/Client.php
class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'national_id',
        'province',
        'district',
        'sector',
        'client_type',
        'company_name',
        'notes',
        'is_active',
        'created_by',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Nice label for select2 / dropdowns
    public function getSelectLabelAttribute()
    {
        return "{$this->full_name} — {$this->phone}" .
            ($this->email ? " ({$this->email})" : '');
    }

    // app/Models/Client.php
    public function houses()
    {
        return $this->hasMany(\App\Models\House::class);
    }

    public function lands()
    {
        return $this->hasMany(\App\Models\Land::class);
    }
}
