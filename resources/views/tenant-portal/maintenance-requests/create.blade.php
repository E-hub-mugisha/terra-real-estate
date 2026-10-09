@extends('layouts.property-management')

@section('title', 'New Maintenance Request')
@section('page-title', 'New Maintenance Request')
@section('page-subtitle', 'Tell us what needs to be repaired.')

@section('content')

<div class="container-fluid px-0">

    <div class="mb-4">
        <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Requests
        </a>
    </div>

    @if($leases->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-house-exclamation fs-1 text-muted"></i>
                <h5 class="fw-bold mt-3">No Active Lease Found</h5>
                <p class="text-muted mb-0">
                    You need an active lease linked to your tenant profile
                    before submitting a maintenance request.
                </p>
            </div>
        </div>
    @else

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">

                <div class="mb-4">
                    <h4 class="fw-bold">Describe the issue</h4>
                    <p class="text-muted mb-0">
                        Provide enough information for the property manager to understand the problem.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('tenant-portal.maintenance-requests.store') }}"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">
                        <label for="lease_id" class="form-label fw-semibold">
                            Property and Unit <span class="text-danger">*</span>
                        </label>

                        <select name="lease_id"
                                id="lease_id"
                                class="form-select @error('lease_id') is-invalid @enderror"
                                required>
                            <option value="">Select your rented unit</option>

                            @foreach($leases as $lease)
                                <option value="{{ $lease->id }}"
                                    @selected(old('lease_id') == $lease->id)>
                                    {{ $lease->unit->floor->building->property->title ?? 'Property' }}
                                    — Unit {{ $lease->unit->unit_number ?? $lease->unit_id }}
                                </option>
                            @endforeach
                        </select>

                        @error('lease_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-4">

                        <div class="col-md-8">
                            <label for="title" class="form-label fw-semibold">
                                Request Title <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="title"
                                   id="title"
                                   maxlength="150"
                                   value="{{ old('title') }}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="e.g. Water leaking under kitchen sink"
                                   required>

                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="category" class="form-label fw-semibold">
                                Category <span class="text-danger">*</span>
                            </label>

                            <select name="category"
                                    id="category"
                                    class="form-select @error('category') is-invalid @enderror"
                                    required>
                                <option value="">Select category</option>
                                @foreach([
                                    'plumbing' => 'Plumbing',
                                    'electrical' => 'Electrical',
                                    'appliance' => 'Appliance',
                                    'structural' => 'Structural',
                                    'cleaning' => 'Cleaning',
                                    'internet' => 'Internet',
                                    'security' => 'Security',
                                    'other' => 'Other',
                                ] as $value => $label)
                                    <option value="{{ $value }}"
                                        @selected(old('category') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="priority" class="form-label fw-semibold">
                                Priority <span class="text-danger">*</span>
                            </label>

                            <select name="priority"
                                    id="priority"
                                    class="form-select @error('priority') is-invalid @enderror"
                                    required>
                                <option value="low" @selected(old('priority') === 'low')>
                                    Low — Minor issue
                                </option>
                                <option value="normal" @selected(old('priority', 'normal') === 'normal')>
                                    Normal — Standard repair
                                </option>
                                <option value="high" @selected(old('priority') === 'high')>
                                    High — Needs prompt attention
                                </option>
                                <option value="urgent" @selected(old('priority') === 'urgent')>
                                    Urgent — Immediate attention needed
                                </option>
                            </select>

                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="preferred_access_at" class="form-label fw-semibold">
                                Preferred Access Date and Time
                            </label>

                            <input type="datetime-local"
                                   name="preferred_access_at"
                                   id="preferred_access_at"
                                   value="{{ old('preferred_access_at') }}"
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                   class="form-control @error('preferred_access_at') is-invalid @enderror">

                            @error('preferred_access_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">
                                Description <span class="text-danger">*</span>
                            </label>

                            <textarea name="description"
                                      id="description"
                                      rows="5"
                                      maxlength="5000"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Explain what happened, where the issue is located, and any relevant details..."
                                      required>{{ old('description') }}</textarea>

                            <div class="form-text">
                                Provide at least 10 characters. Maximum 5,000 characters.
                            </div>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="attachment" class="form-label fw-semibold">
                                Photo of the Issue
                            </label>

                            <input type="file"
                                   name="attachment"
                                   id="attachment"
                                   accept=".jpg,.jpeg,.png,.webp"
                                   class="form-control @error('attachment') is-invalid @enderror">

                            <div class="form-text">
                                Optional. JPG, PNG or WebP, maximum 5 MB.
                                Do not upload sensitive personal documents.
                            </div>

                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-5">
                        <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
                           class="btn btn-light border">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i>
                            Submit Request
                        </button>
                    </div>

                </form>

            </div>
        </div>

    @endif

</div>

@endsection