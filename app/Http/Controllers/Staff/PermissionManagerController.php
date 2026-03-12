<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignPermissionRequest;
use App\Models\Staff;
use App\Services\PermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionManagerController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected PermissionService $permissionService) {}

    // Show the permission editor
    public function edit(Staff $staff)
    {

        $staff->load(['user.roles', 'user.permissions', 'department']);

        $roles       = Role::with('permissions')->get();
        $permissions = $this->permissionService->getAllGrouped();
        $effective   = $this->permissionService->getUserEffectivePermissions($staff->user);

        // Build role permission map for JS (so UI can preview role defaults)
        $rolePermissionMap = $roles->mapWithKeys(fn($role) => [
            $role->name => $role->permissions->pluck('name')->toArray(),
        ]);

        return view('admin.staff.permissions', compact(
            'staff', 'roles', 'permissions', 'effective', 'rolePermissionMap'
        ));
    }

    // Save role + direct permissions
    public function save(AssignPermissionRequest $request, Staff $staff)
    {
        $user = $staff->user;

        // Reassign role — resets direct permissions only if role changed
        if (!$user->hasRole($request->role)) {
            $user->syncRoles([$request->role]);
            $user->syncPermissions([]); // clear overrides on role change
        }

        // Sync direct permissions (on top of role)
        $user->syncPermissions($request->permissions ?? []);

        $this->permissionService->clearCache();

        return redirect()
            ->route('staff.permissions.edit', $staff)
            ->with('success', 'Role and permissions updated. Changes are live immediately.');
    }

    // Reset to role defaults — clears all direct overrides
    public function reset(Staff $staff)
    {
        $this->authorize('staff.manage');

        $this->permissionService->resetToRoleDefaults($staff->user);

        return back()->with('success', 'Permissions reset to role defaults.');
    }
}