<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'label', 'department', 'color', 'description', 'is_active',
    ];
 
    protected $casts = [
        'is_active' => 'boolean',
    ];
 
    // ── Relationships ────────────────────────────────
 
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
 
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')->withTimestamps();
    }
 
    // ── Helpers ──────────────────────────────────────
 
    /** Check if this role carries a given permission name */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions->pluck('name')->contains($permission);
    }
 
    /** Sync permissions by array of permission names */
    public function syncPermissionsByName(array $names): void
    {
        $ids = Permission::whereIn('name', $names)->pluck('id');
        $this->permissions()->sync($ids);
    }
}
