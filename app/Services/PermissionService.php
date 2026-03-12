<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    // Get all permissions grouped by module name
    public function getAllGrouped(): array
    {
        return Permission::all()
            ->groupBy(fn($p) => explode('.', $p->name)[0])
            ->map(fn($group) => $group->map(fn($p) => [
                'id'     => $p->id,
                'name'   => $p->name,
                'action' => explode('.', $p->name)[1],
            ]))
            ->toArray();
    }

    // Get user's effective permissions broken down by source
    public function getUserEffectivePermissions(User $user): array
    {
        return [
            'via_role' => $user->getPermissionsViaRoles()->pluck('name')->toArray(),
            'direct'   => $user->getDirectPermissions()->pluck('name')->toArray(),
            'all'      => $user->getAllPermissions()->pluck('name')->toArray(),
        ];
    }

    // Assign role and optional extra direct permissions
    public function assignRoleWithPermissions(User $user, string $role, array $extraPermissions = []): void
    {
        $user->syncRoles([$role]);
        $user->syncPermissions($extraPermissions);
        $this->clearCache();
    }

    // Update only direct permissions, keep role unchanged
    public function updateDirectPermissions(User $user, array $permissions): void
    {
        $user->syncPermissions($permissions);
        $this->clearCache();
    }

    // Revoke a single permission
    public function revokeOne(User $user, string $permission): void
    {
        $user->revokePermissionTo($permission);
        $this->clearCache();
    }

    // Clear all direct permissions, fall back to role defaults
    public function resetToRoleDefaults(User $user): void
    {
        $user->syncPermissions([]);
        $this->clearCache();
    }

    // Check if user can do a specific action on a module
    public function userCan(User $user, string $module, string $action): bool
    {
        return $user->hasPermissionTo("{$module}.{$action}");
    }

    // Clear Spatie permission cache
    public function clearCache(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}