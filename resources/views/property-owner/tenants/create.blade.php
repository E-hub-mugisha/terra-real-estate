@extends('layouts.propertyOwner.app')

@section('title', 'Register Tenant')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('property-owner.tenants.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left"></i> Back to Tenants
        </a>
        <h2 class="mt-3 mb-1">Register Tenant</h2>
        <p class="text-muted mb-0">Enter the tenant's details and select the unit they are applying for.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">Please correct the errors highlighted below.</div>
    @endif

    <form method="POST" action="{{ route('property-owner.tenants.store') }}">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Unit and Application Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="unit_id">Property Unit <span class="text-danger">*</span></label>
                    <select name="unit_id" id="unit_id"
                            class="form-select @error('unit_id') is-invalid @enderror" required>
                        <option value="">Select a unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                                {{ $unit->managedProperty->name ?? 'Property' }}
                                — {{ $unit->building->name ?? 'Building' }}
                                — {{ $unit->unit_number }}
                                ({{ $unit->currency ?? 'RWF' }} {{ number_format((float) $unit->monthly_rent) }}/month)
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="desired_move_in_date">Desired Move-in Date</label>
                        <input type="date" name="desired_move_in_date" id="desired_move_in_date"
                               min="{{ now()->toDateString() }}"
                               value="{{ old('desired_move_in_date') }}" class="form-control">
                        @error('desired_move_in_date') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="number_of_occupants">Number of Occupants <span class="text-danger">*</span></label>
                        <input type="number" min="1" max="100" name="number_of_occupants"
                               id="number_of_occupants" value="{{ old('number_of_occupants', 1) }}"
                               class="form-control @error('number_of_occupants') is-invalid @enderror" required>
                        @error('number_of_occupants') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="additional_information">Application Information</label>
                    <textarea name="additional_information" id="additional_information" rows="3"
                              class="form-control">{{ old('additional_information') }}</textarea>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name *</label>
                        <input name="first_name" value="{{ old('first_name') }}"
                               class="form-control @error('first_name') is-invalid @enderror" required>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name *</label>
                        <input name="last_name" value="{{ old('last_name') }}"
                               class="form-control @error('last_name') is-invalid @enderror" required>
                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone *</label>
                        <input name="phone" value="{{ old('phone') }}"
                               class="form-control @error('phone') is-invalid @enderror" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alternative Phone</label>
                        <input name="alternative_phone" value="{{ old('alternative_phone') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">National ID</label>
                        <input name="national_id" value="{{ old('national_id') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                               max="{{ now()->subDay()->toDateString() }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select gender</option>
                            @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('gender') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Occupation</label>
                        <input name="occupation" value="{{ old('occupation') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Employer</label>
                        <input name="employer" value="{{ old('employer') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Emergency Contact Name</label>
                        <input name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Emergency Contact Phone</label>
                        <input name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Internal Notes</label>
                        <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-terra">Register Tenant</button>
            <a href="{{ route('property-owner.tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection