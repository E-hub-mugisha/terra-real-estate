@extends('layouts.tenant.app')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
           class="text-decoration-none small">
            <i class="bi bi-arrow-left me-1"></i>
            Back to maintenance requests
        </a>

        <h3 class="fw-bold mt-2 mb-1">Submit a Maintenance Request</h3>
        <p class="text-muted mb-0">
            Describe the problem so your property manager can review it.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h6 class="fw-bold">Please correct the following:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($units->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-house-exclamation fs-1 text-muted"></i>
                <h5 class="fw-bold mt-3">No eligible rental unit</h5>
                <p class="text-muted">
                    A maintenance request can be submitted for a unit
                    with an active lease linked to your tenant profile.
                    Please contact your property manager if this is incorrect.
                </p>
                <a href="{{ route('tenant-portal.dashboard') }}"
                   class="btn btn-outline-primary">
                    Return to dashboard
                </a>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">

                        <form method="POST"
                              action="{{ route('tenant-portal.maintenance-requests.store') }}">
                            @csrf

                            <h5 class="fw-bold mb-3">Rental information</h5>

                            <div class="mb-4">
                                <label for="unit_id" class="form-label">
                                    Rental unit <span class="text-danger">*</span>
                                </label>

                                <select name="unit_id"
                                        id="unit_id"
                                        class="form-select @error('unit_id') is-invalid @enderror"
                                        required>
                                    <option value="">Select your rental unit</option>

                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            @selected((string) old('unit_id') === (string) $unit->id)>
                                            {{ $unit->managedProperty?->name
                                                ?? $unit->managedProperty?->title
                                                ?? 'Managed property' }}
                                            — Unit {{ $unit->unit_number }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('unit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <h5 class="fw-bold mb-3">Describe the problem</h5>

                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    Request title <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="title"
                                       id="title"
                                       maxlength="255"
                                       value="{{ old('title') }}"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="e.g. Water leaking under the kitchen sink"
                                       required>

                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="category" class="form-label">
                                        Category <span class="text-danger">*</span>
                                    </label>

                                    <select name="category"
                                            id="category"
                                            class="form-select @error('category') is-invalid @enderror"
                                            required>
                                        <option value="">Select category</option>

                                        <option value="plumbing" @selected(old('category') === 'plumbing')>
                                            Plumbing
                                        </option>
                                        <option value="electrical" @selected(old('category') === 'electrical')>
                                            Electrical
                                        </option>
                                        <option value="structural" @selected(old('category') === 'structural')>
                                            Structural / building
                                        </option>
                                        <option value="appliance" @selected(old('category') === 'appliance')>
                                            Appliance
                                        </option>
                                        <option value="cleaning" @selected(old('category') === 'cleaning')>
                                            Cleaning
                                        </option>
                                        <option value="pest_control" @selected(old('category') === 'pest_control')>
                                            Pest control
                                        </option>
                                        <option value="security" @selected(old('category') === 'security')>
                                            Security
                                        </option>
                                        <option value="other" @selected(old('category') === 'other')>
                                            Other
                                        </option>
                                    </select>

                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="priority" class="form-label">
                                        Priority <span class="text-danger">*</span>
                                    </label>

                                    <select name="priority"
                                            id="priority"
                                            class="form-select @error('priority') is-invalid @enderror"
                                            required>
                                        <option value="low" @selected(old('priority') === 'low')>
                                            Low — minor issue
                                        </option>
                                        <option value="medium" @selected(old('priority', 'medium') === 'medium')>
                                            Medium — normal repair
                                        </option>
                                        <option value="high" @selected(old('priority') === 'high')>
                                            High — needs prompt attention
                                        </option>
                                        <option value="urgent" @selected(old('priority') === 'urgent')>
                                            Urgent — immediate attention
                                        </option>
                                    </select>

                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-3 mb-4">
                                <label for="description" class="form-label">
                                    Detailed description <span class="text-danger">*</span>
                                </label>

                                <textarea name="description"
                                          id="description"
                                          rows="6"
                                          maxlength="5000"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Explain the problem, where it occurs, when it started and any relevant details."
                                          required>{{ old('description') }}</textarea>

                                <div class="form-text">
                                    Do not include passwords or other sensitive account details.
                                </div>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Your request will be submitted for review.
                                The property manager will coordinate assignment
                                and scheduling.
                            </div>

                            <div class="d-flex flex-wrap justify-content-end gap-2">
                                <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
                                   class="btn btn-outline-secondary">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-1"></i>
                                    Submit request
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
