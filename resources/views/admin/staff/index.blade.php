@extends('layouts.app')
@section('title', 'Staff Management')
@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Staff Management</h4>
            <a href="{{ route('staff.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Staff
            </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search name or email..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="department" class="form-select">
                        <option value="">All Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active"    {{ request('status') == 'active'    ? 'selected' : '' }}>Active</option>
                        <option value="inactive"  {{ request('status') == 'inactive'  ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-secondary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Staff Member</th>
                        <th>Employee ID</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staff as $member)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle bg-primary text-white">
                                    {{ strtoupper(substr($member->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $member->user->name }}</div>
                                    <small class="text-muted">{{ $member->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $member->employee_id }}</td>
                        <td>{{ $member->department?->name ?? '—' }}</td>
                        <td>{{ $member->position }}</td>
                        <td>
                            @foreach ($member->user->roles as $role)
                                <span class="badge {{ $role->name === 'admin' ? 'bg-purple' : 'bg-info' }}">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge
                                {{ $member->status === 'active'    ? 'bg-success' : '' }}
                                {{ $member->status === 'inactive'  ? 'bg-secondary' : '' }}
                                {{ $member->status === 'suspended' ? 'bg-danger' : '' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @can('staff.view')
                                    <a href="{{ route('staff.show', $member) }}"
                                       class="btn btn-sm btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                @endcan
                                @can('staff.edit')
                                    <a href="{{ route('staff.edit', $member) }}"
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endcan
                                @can('staff.assign_permissions')
                                    <a href="{{ route('staff.permissions.edit', $member) }}"
                                       class="btn btn-sm btn-outline-warning" title="Permissions">
                                        <i class="bi bi-shield-lock"></i>
                                    </a>
                                @endcan
                                @can('staff.manage')
                                    <form action="{{ route('staff.destroy', $member) }}" method="POST"
                                          onsubmit="return confirm('Remove this staff member?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No staff members found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $staff->links() }}
        </div>
    </div>
</div>
@endsection