<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'label', 'group', 'description'];
 
    // All roles that carry this permission
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
 
    // Convenience: all permission names grouped
    public static function allGrouped(): array
    {
        return static::all()
            ->groupBy('group')
            ->map(fn ($group) => $group->pluck('label', 'name'))
            ->toArray();
    }
}
