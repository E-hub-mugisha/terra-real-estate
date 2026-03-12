@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Staff Profile</h4>
            <small class="text-muted">Viewing details for {{ $staff->user->name }}</small>
        </div>
        <div class="d-flex gap-2">
            @can('staff.edit')
                <a href="{{ route('staff.edit', $staff) }}"
                   class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="bi bi-pencil"></i> Edit Profile
                </a>
            @endcan
            @can('staff.assign_permissions')
                <a href="{{ route('staff.permissions.edit', $staff) }}"
                   class="btn btn-outline-warning d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock"></i> Manage Permissions
                </a>
            @endcan
            <a href="{{ route('staff.index') }}"
               class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-4">

            {{-- Profile Card --}}
            <div class="card mb-4">
                <div class="card-body text-center py-4">

                    {{-- Avatar --}}
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold text-white"
                         style="width:80px;height:80px;border-radius:50%;background:#378ADD;font-size:28px;letter-spacing:1px">
                        {{ strtoupper(substr($staff->user->name, 0, 1)) }}{{ strtoupper(substr(strstr($staff->user->name, ' '), 1, 1)) }}
                    </div>

                    {{-- Name & Position --}}
                    <h5 class="fw-bold mb-1">{{ $staff->user->name }}</h5>
                    <p class="text-muted mb-2">{{ $staff->position }}</p>

                    {{-- Status Badge --}}
                    <span class="badge px-3 py-2 mb-3
                        {{ $staff->status === 'active'    ? 'bg-success-subtle text-success' : '' }}
                        {{ $staff->status === 'inactive'  ? 'bg-secondary-subtle text-secondary' : '' }}
                        {{ $staff->status === 'suspended' ? 'bg-danger-subtle text-danger' : '' }}">
                        <i class="bi bi-circle-fill me-1" style="font-size:8px"></i>
                        {{ ucfirst($staff->status) }}
                    </span>

                    {{-- Role Badge --}}
                    <div class="mb-3">
                        @foreach($staff->user->roles as $role)
                            <span class="badge px-3 py-2
                                {{ $role->name === 'admin' ? 'bg-purple-subtle text-purple' : 'bg-info-subtle text-info' }}"
                                  style="{{ $role->name === 'admin' ? 'background:#EEEDFE!important;color:#3C3489!important' : 'background:#E6F1FB!important;color:#0C447C!important' }}">
                                <i class="bi bi-shield-fill me-1"></i>
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    </div>

                    <hr class="my-3">

                    {{-- Contact Details --}}
                    <div class="text-start">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-envelope text-muted" style="width:16px"></i>
                            <small class="text-muted">{{ $staff->user->email }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone text-muted" style="width:16px"></i>
                            <small class="text-muted">{{ $staff->phone ?? 'Not provided' }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-building text-muted" style="width:16px"></i>
                            <small class="text-muted">{{ $staff->department?->name ?? 'No department' }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-person-badge text-muted" style="width:16px"></i>
                            <small class="text-muted">{{ $staff->employee_id }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar3 text-muted" style="width:16px"></i>
                            <small class="text-muted">
                                Joined {{ $staff->joined_at?->format('M d, Y') ?? 'N/A' }}
                            </small>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="row g-2 mb-4">
                <div class="col-6">
                    <div class="card text-center py-3">
                        <div class="card-body p-2">
                            <div class="fw-bold fs-4 text-primary">
                                {{ count($effective['all']) }}
                            </div>
                            <small class="text-muted">Total Permissions</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-center py-3">
                        <div class="card-body p-2">
                            <div class="fw-bold fs-4 text-success">
                                {{ count($effective['via_role']) }}
                            </div>
                            <small class="text-muted">Via Role</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-center py-3">
                        <div class="card-body p-2">
                            <div class="fw-bold fs-4 text-warning">
                                {{ count($effective['direct']) }}
                            </div>
                            <small class="text-muted">Direct Grants</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-center py-3">
                        <div class="card-body p-2">
                            <div class="fw-bold fs-4 text-secondary">
                                {{ $permissionsByModule->count() }}
                            </div>
                            <small class="text-muted">Modules</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if($staff->notes)
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-sticky me-2 text-warning"></i> Notes
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-0">{{ $staff->notes }}</p>
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-8">

            {{-- Permission Map by Module --}}
            <div class="card mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-key me-2 text-primary"></i>
                        Permission Map
                    </h6>
                    <div class="d-flex gap-2">
                        <span class="badge" style="background:#EAF3DE;color:#27500A;font-size:11px">
                            <i class="bi bi-circle-fill me-1" style="font-size:7px"></i>Via role
                        </span>
                        <span class="badge" style="background:#FAEEDA;color:#633806;font-size:11px">
                            <i class="bi bi-circle-fill me-1" style="font-size:7px"></i>Direct grant
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($permissionsByModule as $module => $perms)
                        <div class="mb-4">
                            {{-- Module Header --}}
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="text-uppercase fw-bold"
                                      style="font-size:11px;color:var(--bs-secondary-color);letter-spacing:.5px">
                                    {{ $module }}
                                </span>
                                <div class="flex-grow-1 border-bottom"></div>
                                <span class="badge bg-secondary-subtle text-secondary"
                                      style="font-size:10px">
                                    {{ $perms->count() }} actions
                                </span>
                            </div>

                            {{-- Permission Pills --}}
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($perms as $perm)
                                    <span class="badge d-flex align-items-center gap-1 px-2 py-2"
                                          style="font-size:11px;font-weight:400;
                                            {{ $perm['direct']   ? 'background:#FAEEDA;color:#633806;' : '' }}
                                            {{ $perm['via_role'] ? 'background:#EAF3DE;color:#27500A;' : '' }}">
                                        <i class="bi bi-check2" style="font-size:11px"></i>
                                        {{ $perm['action'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-shield-x fs-2 d-block mb-2"></i>
                            No permissions assigned yet.
                            @can('staff.assign_permissions')
                                <a href="{{ route('staff.permissions.edit', $staff) }}">Assign permissions</a>
                            @endcan
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Account Details --}}
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Account Details
                    </h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted ps-3" style="width:40%">Full name</td>
                                <td class="fw-semibold">{{ $staff->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Email</td>
                                <td>{{ $staff->user->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Employee ID</td>
                                <td>{{ $staff->employee_id }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Position</td>
                                <td>{{ $staff->position }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Department</td>
                                <td>{{ $staff->department?->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Phone</td>
                                <td>{{ $staff->phone ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Status</td>
                                <td>
                                    <span class="badge
                                        {{ $staff->status === 'active'    ? 'bg-success-subtle text-success' : '' }}
                                        {{ $staff->status === 'inactive'  ? 'bg-secondary-subtle text-secondary' : '' }}
                                        {{ $staff->status === 'suspended' ? 'bg-danger-subtle text-danger' : '' }}">
                                        {{ ucfirst($staff->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Role</td>
                                <td>
                                    @foreach($staff->user->roles as $role)
                                        <span class="badge"
                                              style="{{ $role->name === 'admin' ? 'background:#EEEDFE;color:#3C3489' : 'background:#E6F1FB;color:#0C447C' }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Date joined</td>
                                <td>{{ $staff->joined_at?->format('F d, Y') ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Account created</td>
                                <td>{{ $staff->created_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-3">Last updated</td>
                                <td>{{ $staff->updated_at->diffForHumans() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-lightning me-2 text-primary"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">

                        @can('staff.edit')
                        <div class="col-md-3 col-6">
                            <a href="{{ route('staff.edit', $staff) }}"
                               class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3 gap-1">
                                <i class="bi bi-pencil-square fs-5"></i>
                                <small>Edit Profile</small>
                            </a>
                        </div>
                        @endcan

                        @can('staff.assign_permissions')
                        <div class="col-md-3 col-6">
                            <a href="{{ route('staff.permissions.edit', $staff) }}"
                               class="btn btn-outline-warning w-100 d-flex flex-column align-items-center py-3 gap-1">
                                <i class="bi bi-shield-lock fs-5"></i>
                                <small>Permissions</small>
                            </a>
                        </div>
                        @endcan

                        @can('staff.manage')
                        <div class="col-md-3 col-6">
                            <form action="{{ route('staff.permissions.reset', $staff) }}"
                                  method="POST"
                                  onsubmit="return confirm('Reset permissions to role defaults?')">
                                @csrf
                                <button type="submit"
                                        class="btn btn-outline-secondary w-100 d-flex flex-column align-items-center py-3 gap-1">
                                    <i class="bi bi-arrow-counterclockwise fs-5"></i>
                                    <small>Reset Perms</small>
                                </button>
                            </form>
                        </div>

                        <div class="col-md-3 col-6">
                            <form action="{{ route('staff.destroy', $staff) }}"
                                  method="POST"
                                  onsubmit="return confirm('Permanently delete {{ $staff->user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-outline-danger w-100 d-flex flex-column align-items-center py-3 gap-1">
                                    <i class="bi bi-trash fs-5"></i>
                                    <small>Delete</small>
                                </button>
                            </form>
                        </div>
                        @endcan

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection