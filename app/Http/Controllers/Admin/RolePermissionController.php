<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    use AuthorizesRequests;

    // ── Main page — list roles and permissions ─────────────────────
    public function index()
    {

        $roles = Role::with('permissions')
                     ->withCount('permissions', 'users')
                     ->get();

        $permissions = Permission::all()
                        ->groupBy(fn($p) => explode('.', $p->name)[0]);

        $modules = $permissions->keys();

        $stats = [
            'roles'       => Role::count(),
            'permissions' => Permission::count(),
            'modules'     => $permissions->count(),
            'assigned'    => \App\Models\User::has('roles')->count(),
        ];

        return view('admin.roles.index',
            compact('roles', 'permissions', 'modules', 'stats'));
    }

    // ── Create Role ────────────────────────────────────────────────
    public function storeRole(Request $request)
    {

        $request->validate([
            'name'        => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => strtolower($request->name)]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', "Role '{$role->name}' created with " . count($request->permissions ?? []) . " permissions.");
    }

    // ── Update Role permissions ────────────────────────────────────
    public function updateRole(Request $request, Role $role)
    {

        $request->validate([
            'name'          => "required|string|max:255|unique:roles,name,{$role->id}",
            'permissions'   => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => strtolower($request->name)]);
        $role->syncPermissions($request->permissions ?? []);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', "Role '{$role->name}' updated.");
    }

    // ── Delete Role ────────────────────────────────────────────────
    public function destroyRole(Role $role)
    {

        // Block if users are assigned this role
        if ($role->users()->count() > 0) {
            return back()->with('error',
                "Cannot delete '{$role->name}' — {$role->users()->count()} users have this role.");
        }

        $role->delete();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', "Role '{$role->name}' deleted.");
    }

    // ── Create Permission ──────────────────────────────────────────
    public function storePermission(Request $request)
    {

        $request->validate([
            'module' => 'required|string|alpha_dash|max:50',
            'action' => 'required|string|alpha_dash|max:50',
        ]);

        $name = strtolower($request->module) . '.' . strtolower($request->action);

        if (Permission::where('name', $name)->exists()) {
            return back()->with('error', "Permission '{$name}' already exists.");
        }

        Permission::create(['name' => $name]);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', "Permission '{$name}' created.");
    }

    // ── Delete Permission ──────────────────────────────────────────
    public function destroyPermission(Permission $permission)
    {

        $permission->delete();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', "Permission '{$permission->name}' deleted.");
    }
}