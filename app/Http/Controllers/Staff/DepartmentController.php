<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use AuthorizesRequests;

    // List all departments
    public function index(Request $request)
    {

        $departments = Department::withCount('staff')
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%")
            )
            ->when($request->status === 'active',   fn($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn($q) => $q->where('is_active', false))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total'    => Department::count(),
            'active'   => Department::where('is_active', true)->count(),
            'inactive' => Department::where('is_active', false)->count(),
            'staff'    => \App\Models\Staff::count(),
        ];

        return view('admin.staff.departments.index', compact('departments', 'stats'));
    }

    // Store new department
    public function store(Request $request)
    {

        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:10|unique:departments,code|alpha_num|uppercase',
            'description' => 'nullable|string|max:500',
        ]);

        Department::create([
            'name'        => $request->name,
            'code'        => strtoupper($request->code),
            'description' => $request->description,
            'is_active'   => true,
        ]);

        return back()->with('success', "Department '{$request->name}' created successfully.");
    }

    // Update department
    public function update(Request $request, Department $department)
    {

        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => "required|string|max:10|unique:departments,code,{$department->id}|alpha_num",
            'description' => 'nullable|string|max:500',
            'is_active'   => 'boolean',
        ]);

        $department->update([
            'name'        => $request->name,
            'code'        => strtoupper($request->code),
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return back()->with('success', "Department '{$department->name}' updated successfully.");
    }

    // Delete department (soft delete)
    public function destroy(Department $department)
    {

        // Block delete if staff are assigned
        if ($department->staff()->count() > 0) {
            return back()->with('error', "Cannot delete '{$department->name}' — it has {$department->staff()->count()} staff assigned. Reassign them first.");
        }

        $department->delete();

        return back()->with('success', "Department '{$department->name}' deleted.");
    }

    // Toggle active/inactive status
    public function toggleStatus(Department $department)
    {
        $this->authorize('staff.manage');

        $department->update(['is_active' => !$department->is_active]);

        $status = $department->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Department '{$department->name}' {$status}.");
    }
}