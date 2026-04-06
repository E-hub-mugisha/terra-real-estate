@extends('layouts.app')
@section('title', 'Add Staff Member')
@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Add Staff Member</h4>
            <small class="text-muted">Create a new staff account and assign their role</small>
        </div>
        <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back to Staff
        </a>
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

    <form action="{{ route('staff.store') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-lg-8">

                {{-- Account Information --}}
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-person-circle me-2 text-primary"></i>
                            Account Information
                        </h6>
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
                                    value="{{ old('name') }}"
                                    placeholder="e.g. John Smith">
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
                                    value="{{ old('email') }}"
                                    placeholder="e.g. john@realty.com">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                        name="password"
                                        id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Min 8 characters">
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
                                <label class="form-label fw-semibold">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control"
                                        placeholder="Repeat password">
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
                                    value="{{ old('employee_id', 'EMP-' . str_pad(rand(1,999), 3, '0', STR_PAD_LEFT)) }}"
                                    placeholder="e.g. EMP-001">
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
                                    value="{{ old('position') }}"
                                    placeholder="e.g. Sales Agent">
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
                                    value="{{ old('phone') }}"
                                    placeholder="e.g. +1 555 000 0000">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Department --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Department <span class="text-danger">*</span>
                                </label>
                                <select name="department_id"
                                    class="form-select @error('department_id') is-invalid @enderror">
                                    <option value="">— Select Department —</option>
                                    @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Joined Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date Joined</label>
                                <input type="date"
                                    name="joined_at"
                                    class="form-control @error('joined_at') is-invalid @enderror"
                                    value="{{ old('joined_at', now()->format('Y-m-d')) }}">
                                @error('joined_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Notes --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Notes</label>
                                <textarea name="notes"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Optional internal notes about this staff member...">{{ old('notes') }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-lg-4">

                {{-- Role Assignment --}}
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-shield-lock me-2 text-primary"></i>
                            Role & Access
                        </h6>
                    </div>
                    <div class="card-body">
                        <label class="form-label fw-semibold">
                            Assign Role <span class="text-danger">*</span>
                        </label>
                        <p class="text-muted small mb-3">
                            The role defines what this staff member can do in the system.
                            You can fine-tune permissions after creating the account.
                        </p>

                        @error('role')
                        <div class="alert alert-danger py-2 small">{{ $message }}</div>
                        @enderror

                        @foreach ($roles as $role)
                        <div class="form-check border rounded p-3 mb-2
                                {{ old('role') === $role->name ? 'border-primary bg-primary bg-opacity-10' : 'border-light' }}"
                            id="role_card_{{ $role->name }}">
                            <input class="form-check-input"
                                type="radio"
                                name="role"
                                id="role_{{ $role->name }}"
                                value="{{ $role->name }}"
                                {{ old('role') === $role->name ? 'checked' : '' }}
                                onchange="highlightRole('{{ $role->name }}')">
                            <label class="form-check-label w-100 cursor-pointer"
                                for="role_{{ $role->name }}">
                                <div class="fw-semibold text-capitalize">{{ $role->name }}</div>
                                <small class="text-muted">
                                    {{ $role->permissions->count() }} permissions included
                                </small>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Summary Card --}}
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-info-circle me-2 text-primary"></i>
                            What happens next?
                        </h6>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check2 text-success me-2"></i>
                                A user account is created with login access
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check2 text-success me-2"></i>
                                The selected role is assigned immediately
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check2 text-success me-2"></i>
                                Staff profile is linked to the account
                            </li>
                            <li>
                                <i class="bi bi-check2 text-success me-2"></i>
                                You can adjust permissions anytime
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        {{-- Form Actions --}}
        <div class="d-flex justify-content-end gap-2 mt-2 mb-5">
            <a href="{{ route('staff.index') }}" class="btn btn-outline-secondary px-4">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary px-5 d-flex align-items-center gap-2">
                <i class="bi bi-person-check-fill"></i>
                Create Staff Member
            </button>
        </div>

    </form>
</div>

<script>
    function togglePassword(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    function highlightRole(roleName) {
        document.querySelectorAll('[id^="role_card_"]').forEach(card => {
            card.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
            card.classList.add('border-light');
        });
        const selected = document.getElementById('role_card_' + roleName);
        if (selected) {
            selected.classList.remove('border-light');
            selected.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
        }
    }
</script>
@endsection