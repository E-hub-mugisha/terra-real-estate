<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        // List all staff members
        $staffMembers = Staff::with('role')->get();
        return view('admin.staff.index', compact('staffMembers'));
    }

    public function create()
    {
        // Show form to create a new staff member
    }

    public function store(Request $request)
    {
        // Validate and save new staff member
    }

    public function edit($id)
    {
        // Show form to edit existing staff member
    }

    public function update(Request $request, $id)
    {
        // Validate and update existing staff member
    }

    public function destroy($id)
    {
        // Delete a staff member
    }
}
