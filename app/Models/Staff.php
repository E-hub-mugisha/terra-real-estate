<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id', 'department_id', 'employee_id',
        'phone', 'position', 'status', 'joined_at', 'notes',
    ];

    protected $casts = ['joined_at' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
