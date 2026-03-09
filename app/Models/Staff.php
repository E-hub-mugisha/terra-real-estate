<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['user_id', 'role_id', 'phone', 'photo'];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permissionName)
    {
        if (!$this->role) return false;
        return $this->role->permissions->contains('name', $permissionName);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
