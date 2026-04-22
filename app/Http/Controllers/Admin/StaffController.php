<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use App\Notifications\StaffCredentialsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function index()
    {
        $staff       = Staff::with(['user', 'department'])->latest()->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.staff.index', compact('staff', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'department_id' => 'nullable|exists:departments,id',
            'employee_id'   => 'nullable|string|max:50|unique:staff,employee_id',
            'position'      => 'nullable|string|max:100',
            'phone'         => 'nullable|string|max:30',
            'status'        => 'required|in:active,inactive',
            'joined_at'     => 'nullable|date',
            'notes'         => 'nullable|string',
            'role'          => 'required'
        ]);

        $password = Str::password(12);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($password),
            'role'     => $request->role
        ]);

        $staff = Staff::create([
            'user_id'       => $user->id,
            'department_id' => $request->department_id,
            'employee_id'   => $request->employee_id ?? $this->generateEmployeeId($request->name),
            'position'      => $request->position,
            'phone'         => $request->phone,
            'status'        => $request->status,
            'joined_at'     => $request->joined_at,
            'notes'         => $request->notes,
        ]);

        try {
            $user->notify(new StaffCredentialsNotification($password));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.roles.assign-view', $user)
                ->with('warning', "Staff member {$user->name} added, but the credentials email could not be sent. Please share login details manually.")
                ->with('new_staff', true);
        }

        return redirect()
            ->route('admin.roles.assign-view', $user)
            ->with('success', "Staff member {$user->name} added. Login credentials sent to {$user->email}.")
            ->with('new_staff', true);
    }

    public function show(Staff $staff)
    {
        $staff->load(['user', 'department']);

        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $staff->load(['user', 'department']);
        $departments = Department::orderBy('name')->get();

        return view('admin.staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $staff->user_id,
            'department_id' => 'nullable|exists:departments,id',
            'employee_id'   => 'nullable|string|max:50|unique:staff,employee_id,' . $staff->id,
            'position'      => 'nullable|string|max:100',
            'phone'         => 'nullable|string|max:30',
            'status'        => 'required|in:active,inactive',
            'joined_at'     => 'nullable|date',
            'notes'         => 'nullable|string',
        ]);

        // Update the linked user account
        $staff->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $staff->update([
            'department_id' => $request->department_id,
            'employee_id'   => $request->employee_id,
            'position'      => $request->position,
            'phone'         => $request->phone,
            'status'        => $request->status,
            'joined_at'     => $request->joined_at,
            'notes'         => $request->notes,
        ]);

        return back()->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $name = $staff->user?->name ?? 'Staff member';
        $user = $staff->user;

        $staff->delete();

        // Also delete the linked user account
        $user?->delete();

        return back()->with('success', "{$name} has been removed from the system.");
    }

    public function resetPassword(Staff $staff)
    {
        $password = Str::password(12);

        $staff->user->update([
            'password' => Hash::make($password),
        ]);

        try {
            $staff->user->notify(new StaffCredentialsNotification($password));
        } catch (\Exception $e) {
            return back()->with('error', 'Password reset but the email could not be sent.');
        }

        return back()->with('success', "Password reset and new credentials sent to {$staff->user->email}.");
    }

    public function updateStatus(Request $request, Staff $staff)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,on_leave,terminated',
        ]);

        $staff->update(['status' => $request->status]);

        return back()->with('success', "Status updated to " . ucfirst(str_replace('_', ' ', $request->status)) . ".");
    }

    // ── Private helpers ──────────────────────────────────────────────────

    private function generateEmployeeId(string $name): string
    {
        $initials = collect(explode(' ', trim($name)))
            ->map(fn($w) => strtoupper($w[0] ?? ''))
            ->take(3)
            ->implode('');

        $suffix = strtoupper(Str::random(4));

        return "EMP-{$initials}-{$suffix}";
    }
}
