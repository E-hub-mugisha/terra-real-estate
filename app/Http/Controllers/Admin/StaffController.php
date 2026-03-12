<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        // List all staff members
        $staffMembers = Staff::with('role')->get();
        $roles = Role::all();
        return view('admin.staff.index', compact('staffMembers', 'roles'));
    }

    public function create()
    {
        // Show form to create a new staff member
    }

    public function store(Request $request)
    {
        // Validate and save new staff member
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Create the staff member
        $staff = Staff::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'photo' => $request->photo,
        ]);
        return redirect()->route('admin.staff.index')->with('success', 'Staff member created successfully.');}

    public function edit($id)
    {
        // Show form to edit existing staff member
    }

    public function update(Request $request, $id)
    {
        // Validate and update existing staff member
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);
        $staff = Staff::findOrFail($id);
        $user = $staff->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy($id)
    {
        // Delete a staff member
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
