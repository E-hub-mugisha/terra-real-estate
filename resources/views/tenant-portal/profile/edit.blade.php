@extends('layouts.property-management')

@section('title', 'My Tenant Profile')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('tenant-portal.dashboard') }}"
           class="text-decoration-none text-muted">
            &larr; Back to Dashboard
        </a>

        <h1 class="h3 fw-bold mt-3 mb-1">My Profile</h1>
        <p class="text-muted mb-0">
            Keep your personal and emergency contact information up to date.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <div class="d-flex flex-wrap justify-content-between
                        align-items-center gap-3 mb-4">
                <div>
                    <h2 class="h5 fw-bold mb-1">Personal Information</h2>
                    <p class="text-muted small mb-0">
                        Tenant ID: {{ $tenant->id }}
                    </p>
                </div>

                <span class="badge
                    {{ $tenant->kyc_status === 'verified'
                        ? 'text-bg-success'
                        : ($tenant->kyc_status === 'rejected'
                            ? 'text-bg-danger'
                            : 'text-bg-warning') }}">
                    KYC: {{ ucfirst($tenant->kyc_status) }}
                </span>
            </div>

            <form method="POST"
                  action="{{ route('tenant-portal.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="first_name" class="form-label">
                            First Name <span class="text-danger">*</span>
                        </label>
                        <input id="first_name"
                               name="first_name"
                               class="form-control"
                               value="{{ old('first_name', $tenant->first_name) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">
                            Last Name <span class="text-danger">*</span>
                        </label>
                        <input id="last_name"
                               name="last_name"
                               class="form-control"
                               value="{{ old('last_name', $tenant->last_name) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input id="email"
                               type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $tenant->email) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">
                            Phone <span class="text-danger">*</span>
                        </label>
                        <input id="phone"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone', $tenant->phone) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="national_id" class="form-label">
                            National ID
                        </label>
                        <input id="national_id"
                               name="national_id"
                               class="form-control"
                               value="{{ old('national_id', $tenant->national_id) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">
                            Date of Birth
                        </label>
                        <input id="date_of_birth"
                               type="date"
                               name="date_of_birth"
                               class="form-control"
                               max="{{ now()->toDateString() }}"
                               value="{{ old(
                                   'date_of_birth',
                                   $tenant->date_of_birth?->format('Y-m-d')
                               ) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="">Select gender</option>
                            @foreach(['Male', 'Female', 'Other'] as $gender)
                                <option value="{{ $gender }}"
                                    @selected(old('gender', $tenant->gender) === $gender)>
                                    {{ $gender }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <hr>
                        <h2 class="h5 fw-bold">Address</h2>
                    </div>

                    @foreach([
                        'district' => 'District',
                        'sector' => 'Sector',
                        'cell' => 'Cell',
                        'village' => 'Village',
                    ] as $field => $labelText)
                        <div class="col-md-6">
                            <label for="{{ $field }}" class="form-label">
                                {{ $labelText }}
                            </label>
                            <input id="{{ $field }}"
                                   name="{{ $field }}"
                                   class="form-control"
                                   value="{{ old($field, $tenant->$field) }}">
                        </div>
                    @endforeach

                    <div class="col-12">
                        <label for="address" class="form-label">
                            Detailed Address
                        </label>
                        <textarea id="address"
                                  name="address"
                                  rows="3"
                                  class="form-control">{{ old('address', $tenant->address) }}</textarea>
                    </div>

                    <div class="col-12">
                        <hr>
                        <h2 class="h5 fw-bold">Emergency Contact</h2>
                    </div>

                    <div class="col-md-6">
                        <label for="emergency_contact_name"
                               class="form-label">
                            Contact Name
                        </label>
                        <input id="emergency_contact_name"
                               name="emergency_contact_name"
                               class="form-control"
                               value="{{ old(
                                   'emergency_contact_name',
                                   $tenant->emergency_contact_name
                               ) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="emergency_contact_phone"
                               class="form-label">
                            Contact Phone
                        </label>
                        <input id="emergency_contact_phone"
                               name="emergency_contact_phone"
                               class="form-control"
                               value="{{ old(
                                   'emergency_contact_phone',
                                   $tenant->emergency_contact_phone
                               ) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="emergency_contact_relationship"
                               class="form-label">
                            Relationship
                        </label>
                        <input id="emergency_contact_relationship"
                               name="emergency_contact_relationship"
                               class="form-control"
                               value="{{ old(
                                   'emergency_contact_relationship',
                                   $tenant->emergency_contact_relationship
                               ) }}">
                    </div>

                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-terra">
                        Save Changes
                    </button>

                    <a href="{{ route('tenant-portal.dashboard') }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .btn-terra {
        color: #fff;
        background: #D05208;
        border-color: #D05208;
    }

    .btn-terra:hover {
        color: #fff;
        background: #ad4407;
        border-color: #ad4407;
    }
</style>
@endpush