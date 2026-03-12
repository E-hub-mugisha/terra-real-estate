@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Edit Staff Member</h4>
            <small class="text-muted">
                Editing profile for
                <strong>{{ $staff->user->name }}</strong>
                &mdash; {{ $staff->employee_id }}
            </small>
        </div>
        <div class="d-flex gap-2">
            @can('staff.assign_permissions')
                <a href="{{ route('staff.permissions.edit', $staff) }}"
                   class="btn btn-outline-warning d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock"></i> Manage Permissions
                </a>
            @endcan
            <a href="{{ route('staff.show', $staff) }}"
               class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Role changed warning --}}
    <div class="alert alert-warning d-none" id="role-change-warning">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Role change detected.</strong>
        Saving will reset all direct permission overrides for this user.
        Their new role's default permissions will apply.
    </div>

    <form action="{{ route('staff.update', $staff) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-lg-8">

                {{-- Account Information --}}
                <div class="card mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-person-circle me-2 text-primary"></i>
                            Account Information
                        </h6>
                        <span class="badge bg-secondary-subtle text-secondary">
                            Joined {{ $staff->joined_at?->format('M d, Y') ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            {{-- Full Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $staff->user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $staff->user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password (optional on edit) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    New Password
                                    <small class="text-muted fw-normal">(leave blank to keep current)</small>
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Enter new password">
                                    <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="form-control"
                                           placeholder="Repeat new password">
                                    <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('password_confirmation', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Staff Profile --}}
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-briefcase me-2 text-primary"></i>
                            Staff Profile
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            {{-- Employee ID --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    Employee ID <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="employee_id"
                                       class="form-control @error('employee_id') is-invalid @enderror"
                                       value="{{ old('employee_id', $staff->employee_id) }}">
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Position --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    Position / Job Title <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="position"
                                       class="form-control @error('position') is-invalid @enderror"
                                       value="{{ old('position', $staff->position) }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $staff->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Department --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    Department <span class="text-danger">*</span>
                                </label>
                                <select name="department_id"
                                        class="form-select @error('department_id') is-invalid @enderror">
                                    <option value="">— Select Department —</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('department_id', $staff->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Joined Date --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Date Joined</label>
                                <input type="date"
                                       name="joined_at"
                                       class="form-control @error('joined_at') is-invalid @enderror"
                                       value="{{ old('joined_at', $staff->joined_at?->format('Y-m-d')) }}">
                                @error('joined_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    Account Status <span class="text-danger">*</span>
                                </label>
                                <select name="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                    <option value="active"
                                        {{ old('status', $staff->status) === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $staff->status) === 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                    <option value="suspended"
                                        {{ old('status', $staff->status) === 'suspended' ? 'selected' : '' }}>
                                        Suspended
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Notes --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Notes</label>
                                <textarea name="notes"
                                          class="form-control"
                                          rows="2"
                                          placeholder="Optional internal notes...">{{ old('notes', $staff->notes) }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-lg-4">

                {{-- Current Role Info --}}
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-shield-lock me-2 text-primary"></i>
                            Role & Access
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">
                            Changing the role will reset any direct permission overrides.
                        </p>

                        @error('role')
                            <div class="alert alert-danger py-2 small">{{ $message }}</div>
                        @enderror

                        @php $currentRole = $staff->user->roles->first()?->name @endphp

                        @foreach ($roles as $role)
                            <div class="form-check border rounded p-3 mb-2 role-card
                                {{ old('role', $currentRole) === $role->name ? 'border-primary bg-primary bg-opacity-10' : '' }}"
                                 id="role_card_{{ $role->name }}">
                                <input class="form-check-input"
                                       type="radio"
                                       name="role"
                                       id="role_{{ $role->name }}"
                                       value="{{ $role->name }}"
                                       data-original="{{ $currentRole }}"
                                       {{ old('role', $currentRole) === $role->name ? 'checked' : '' }}
                                       onchange="handleRoleChange(this)">
                                <label class="form-check-label w-100"
                                       for="role_{{ $role->name }}">
                                    <div class="fw-semibold text-capitalize">{{ $role->name }}</div>
                                    <small class="text-muted">
                                        {{ $role->permissions->count() }} permissions
                                    </small>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Current Permissions Summary --}}
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-key me-2 text-primary"></i>
                            Current Permissions
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush" style="max-height: 220px; overflow-y: auto;">
                            @forelse ($staff->user->getAllPermissions()->take(10) as $perm)
                                <div class="list-group-item list-group-item-action py-2 px-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success" style="font-size:12px"></i>
                                    <small>{{ $perm->name }}</small>
                                </div>
                            @empty
                                <div class="list-group-item py-2 px-3">
                                    <small class="text-muted">No permissions assigned.</small>
                                </div>
                            @endforelse
                            @if($staff->user->getAllPermissions()->count() > 10)
                                <div class="list-group-item py-2 px-3 text-center">
                                    <small class="text-muted">
                                        +{{ $staff->user->getAllPermissions()->count() - 10 }} more &mdash;
                                        <a href="{{ route('staff.permissions.edit', $staff) }}">view all</a>
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Danger Zone --}}
                @can('staff.manage')
                <div class="card border-danger">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Danger Zone
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-3">
                            Permanently remove this staff member and their account.
                            This cannot be undone.
                        </p>
                        <form action="{{ route('staff.destroy', $staff) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to permanently delete {{ $staff->user->name }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="bi bi-trash me-1"></i> Remove Staff Member
                            </button>
                        </form>
                    </div>
                </div>
                @endcan

            </div>
        </div>

        {{-- Form Actions --}}
        <div class="d-flex justify-content-end gap-2 mt-2 mb-5">
            <a href="{{ route('staff.show', $staff) }}"
               class="btn btn-outline-secondary px-4">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary px-5 d-flex align-items-center gap-2">
                <i class="bi bi-check-lg"></i>
                Save Changes
            </button>
        </div>

    </form>
</div>

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon  = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function handleRoleChange(radio) {
    const originalRole = radio.dataset.original;
    const warning      = document.getElementById('role-change-warning');

    // Show warning only when role is different from original
    warning.classList.toggle('d-none', radio.value === originalRole);

    // Highlight selected role card
    document.querySelectorAll('.role-card').forEach(card => {
        card.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
    });
    document.getElementById('role_card_' + radio.value)
            .classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
}
</script>
@endsection