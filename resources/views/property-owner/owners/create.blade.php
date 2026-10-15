@extends('layouts.property-management.app')

@section('title', 'Create Property Owner')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-1">Create Property Owner</h1>
            <p class="text-muted mb-0">
                Assign a property-owner profile to an existing user account.
            </p>
        </div>

        <a href="{{ route('admin.property-management.owners.index') }}"
            class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to owners
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please correct the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h2 class="h5 mb-0">Owner information</h2>
        </div>

        <div class="card-body p-4">
            <form method="POST"
                action="{{ route('admin.property-management.owners.store') }}">
                @csrf

                @if ($owner->exists)
                @method('PUT')
                @endif

                <div class="row g-3">
                    @if (!$owner->exists)
                    <div class="col-12">
                        <label for="user_id" class="form-label">
                            User account <span class="text-danger">*</span>
                        </label>

                        <select name="user_id" id="user_id"
                            class="form-select @error('user_id') is-invalid @enderror"
                            required>
                            <option value="">Select an existing user</option>

                            @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                @selected(old('user_id')==$user->id)>
                                {{ $user->name }} — {{ $user->email }}
                            </option>
                            @endforeach
                        </select>

                        @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($users->isEmpty())
                        <div class="form-text text-warning">
                            All existing users already have property-owner profiles.
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="col-md-6">
                        <label class="form-label">Linked user</label>
                        <input type="text" class="form-control"
                            value="{{ $owner->user?->name }} ({{ $owner->user?->email }})"
                            disabled>
                        <div class="form-text">
                            The linked user account cannot be changed here.
                        </div>
                    </div>
                    @endif

                    <div class="col-md-6">
                        <label for="owner_type" class="form-label">
                            Owner type <span class="text-danger">*</span>
                        </label>

                        <select name="owner_type" id="owner_type"
                            class="form-select @error('owner_type') is-invalid @enderror"
                            required>
                            <option value="individual"
                                @selected(old('owner_type', $owner->owner_type ?: 'individual') === 'individual')>
                                Individual
                            </option>
                            <option value="company"
                                @selected(old('owner_type', $owner->owner_type) === 'company')>
                                Company
                            </option>
                        </select>

                        @error('owner_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone number</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $owner->phone) }}"
                            placeholder="+250...">

                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="national_id" class="form-label">National ID</label>
                        <input type="text" name="national_id" id="national_id"
                            class="form-control @error('national_id') is-invalid @enderror"
                            value="{{ old('national_id', $owner->national_id) }}">

                        @error('national_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6" id="company-field">
                        <label for="company_name" class="form-label">Company name</label>
                        <input type="text" name="company_name" id="company_name"
                            class="form-control @error('company_name') is-invalid @enderror"
                            value="{{ old('company_name', $owner->company_name) }}">

                        @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tin" class="form-label">Tax identification number (TIN)</label>
                        <input type="text" name="tin" id="tin"
                            class="form-control @error('tin') is-invalid @enderror"
                            value="{{ old('tin', $owner->tin) }}">

                        @error('tin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" rows="2"
                            class="form-control @error('address') is-invalid @enderror">{{ old('address', $owner->address) }}</textarea>

                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="verification_status" class="form-label">
                            Verification status <span class="text-danger">*</span>
                        </label>

                        <select name="verification_status" id="verification_status"
                            class="form-select @error('verification_status') is-invalid @enderror"
                            required>
                            @foreach ([
                            'pending' => 'Pending',
                            'verified' => 'Verified',
                            'rejected' => 'Rejected',
                            ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('verification_status', $owner->verification_status ?: 'pending') === $value)>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>

                        @error('verification_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="notes" class="form-label">Internal notes</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $owner->notes) }}</textarea>

                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ $owner->exists ? 'Save changes' : 'Create owner' }}
                    </button>

                    <a href="{{ route('admin.property-management.owners.index') }}"
                        class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

                @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ownerType = document.getElementById('owner_type');
                        const companyField = document.getElementById('company-field');

                        function toggleCompanyField() {
                            companyField.hidden = ownerType.value !== 'company';
                        }

                        ownerType.addEventListener('change', toggleCompanyField);
                        toggleCompanyField();
                    });
                </script>
                @endpush
            </form>
        </div>
    </div>
</div>
@endsection