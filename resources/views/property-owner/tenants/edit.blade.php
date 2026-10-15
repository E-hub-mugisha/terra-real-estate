@extends('layouts.propertyOwner.app')

@section('title', 'Edit Tenant')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('property-owner.tenants.show', $tenant) }}" class="text-decoration-none">
            <i class="bi bi-arrow-left"></i> Back to Tenant
        </a>
        <h2 class="mt-3 mb-1">Edit Tenant</h2>
        <p class="text-muted mb-0">{{ $tenant->full_name }} · {{ $tenant->tenant_code }}</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">Please correct the errors highlighted below.</div>
    @endif

    <form method="POST" action="{{ route('property-owner.tenants.update', $tenant) }}">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach([
                        'first_name' => 'First Name',
                        'last_name' => 'Last Name',
                        'email' => 'Email',
                        'phone' => 'Phone',
                        'alternative_phone' => 'Alternative Phone',
                        'national_id' => 'National ID',
                        'gender' => 'Gender',
                        'occupation' => 'Occupation',
                        'employer' => 'Employer',
                        'emergency_contact_name' => 'Emergency Contact Name',
                        'emergency_contact_phone' => 'Emergency Contact Phone',
                    ] as $field => $label)
                        <div class="col-md-6">
                            <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                            <input
                                id="{{ $field }}"
                                name="{{ $field }}"
                                value="{{ old($field, $tenant->{$field}) }}"
                                class="form-control @error($field) is-invalid @enderror"
                                @required(in_array($field, ['first_name', 'last_name', 'email', 'phone']))
                                @if($field === 'email') type="email" @endif
                            >
                            @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    @endforeach

                    <div class="col-md-6">
                        <label class="form-label" for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                               value="{{ old('date_of_birth', $tenant->date_of_birth?->format('Y-m-d')) }}"
                               max="{{ now()->subDay()->toDateString() }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="status">Tenant Status</label>
                        <select id="status" name="status" class="form-select" required>
                            @foreach(['pending' => 'Pending', 'active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $tenant->status) === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="address">Address</label>
                        <textarea id="address" name="address" rows="2" class="form-control">{{ old('address', $tenant->address) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="notes">Internal Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="form-control">{{ old('notes', $tenant->notes) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-terra">Save Changes</button>
            <a href="{{ route('property-owner.tenants.show', $tenant) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection