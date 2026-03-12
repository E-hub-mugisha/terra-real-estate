<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\{Staff, Department, User};
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function __construct(protected PermissionService $permissionService) {}

    // LIST
    public function index(Request $request)
    {

        $query = Staff::with(['user.roles', 'department'])
            ->when($request->search, fn($q) =>
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%"))
            )
            ->when($request->department, fn($q) => $q->where('department_id', $request->department))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->role, fn($q) =>
                $q->whereHas('user.roles', fn($r) => $r->where('name', $request->role))
            );

        $staff       = $query->paginate(10)->withQueryString();
        $departments = Department::where('is_active', true)->get();
        $roles       = Role::all();

        return view('admin.staff.index', compact('staff', 'departments', 'roles'));
    }

    // SHOW PROFILE
    public function show(Staff $staff)
    {

        $staff->load(['user.roles', 'user.permissions', 'department']);
        $effective = $this->permissionService->getUserEffectivePermissions($staff->user);

        return view('admin.staff.show', compact('staff', 'effective'));
    }

    // CREATE FORM
    public function create()
    {

        $departments = Department::where('is_active', true)->get();
        $roles       = Role::all();

        return view('admin.staff.create', compact('departments', 'roles'));
    }

    // STORE
    public function store(StoreStaffRequest $request)
    {
        // Create User account
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role
        $user->assignRole($request->role);

        // Create Staff profile
        Staff::create([
            'user_id'       => $user->id,
            'department_id' => $request->department_id,
            'employee_id'   => $request->employee_id,
            'position'      => $request->position,
            'phone'         => $request->phone,
            'joined_at'     => $request->joined_at,
            'status'        => 'active',
        ]);

        $this->permissionService->clearCache();

        return redirect()->route('staff.index')
                         ->with('success', "Staff member '{$user->name}' created successfully.");
    }

    // EDIT FORM
    public function edit(Staff $staff)
    {

        $staff->load(['user.roles', 'department']);
        $departments = Department::where('is_active', true)->get();
        $roles       = Role::all();

        return view('admin.staff.edit', compact('staff', 'departments', 'roles'));
    }

    // UPDATE
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        // Update user account
        $staff->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Reassign role if changed
        if (!$staff->user->hasRole($request->role)) {
            $staff->user->syncRoles([$request->role]);
            $staff->user->syncPermissions([]); // Reset direct permissions on role change
        }

        // Update staff profile
        $staff->update([
            'department_id' => $request->department_id,
            'employee_id'   => $request->employee_id,
            'position'      => $request->position,
            'phone'         => $request->phone,
            'status'        => $request->status,
            'joined_at'     => $request->joined_at,
        ]);

        $this->permissionService->clearCache();

        return redirect()->route('staff.show', $staff)
                         ->with('success', 'Staff profile updated successfully.');
    }

    // DELETE
    public function destroy(Staff $staff)
    {

        $name = $staff->user->name;
        $staff->user->delete(); // cascades to staff

        return redirect()->route('staff.index')
                         ->with('success', "{$name} has been removed.");
    }
}