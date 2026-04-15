<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    // ── ROLES ────────────────────────────────────────

    public function index()
    {
        $roles       = Role::with('permissions')->withCount('users')->get();
        $permissions = Permission::all()->groupBy('group');

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:60|unique:roles,name|regex:/^[a-z_]+$/',
            'label'       => 'required|string|max:100',
            'department'  => 'required|string|max:100',
            'color'       => 'required|string|max:20',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissions = $validated['permissions'] ?? [];
        unset($validated['permissions']);

        $role = Role::create($validated);
        $role->permissions()->sync($permissions);

        return back()->with('success', "Role \"{$role->label}\" created successfully.");
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'label'       => 'required|string|max:100',
            'department'  => 'required|string|max:100',
            'color'       => 'required|string|max:20',
            'description' => 'nullable|string|max:500',
            'is_active'   => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissions = $validated['permissions'] ?? [];
        unset($validated['permissions']);

        $validated['is_active'] = (bool) $request->boolean('is_active');

        $role->update($validated);
        $role->permissions()->sync($permissions);

        return back()->with('success', "Role \"{$role->label}\" updated.");
    }

    public function destroy(Role $role)
    {
        // Prevent deleting administrator role
        if ($role->name === 'administrator') {
            return back()->with('error', 'The Administrator role cannot be deleted.');
        }

        $role->delete();
        return back()->with('success', "Role \"{$role->label}\" deleted.");
    }

    // ── USER ROLE ASSIGNMENT ─────────────────────────

    public function users()
    {
        $users = User::with('roles', 'staff')
            ->whereHas('staff')
            ->paginate(20);

        $roles = Role::where('is_active', true)->get();

        return view('admin.roles.users', compact('users', 'roles'));
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->roles()->sync([$request->role_id]);

        $role = Role::find($request->role_id);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', "Role \"{$role->label}\" assigned to {$user->name}.");
    }


    public function removeRole(User $user)
    {
        $user->roles()->detach();
        return back()->with('success', "Role removed from {$user->name}.");
    }

    public function assignView(User $user)
    {
        $user->load('roles.permissions');
        $roles       = Role::where('is_active', true)->with('permissions')->get();
        $currentRole = $user->roles->first();

        return view('admin.roles.assign', compact('user', 'roles', 'currentRole'));
    }
}
