@extends('public.layouts.app')

@section('title', 'Apply for Rental Unit | Terra Real Estate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <a href="{{ url()->previous() }}"
               class="text-decoration-none text-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Back to rentals
            </a>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header text-white p-4"
                     style="background:#19265d;">
                    <div class="small text-uppercase mb-2"
                         style="color:#ffad7d; letter-spacing:.12em;">
                        Terra Property Management
                    </div>

                    <h2 class="h4 fw-bold mb-2">Rental Application</h2>

                    <p class="mb-0 text-white-50">
                        Complete the form below to apply for this unit.
                    </p>
                </div>

                <div class="card-body p-4 p-lg-5">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Please check the following:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Selected unit --}}
                    <div class="p-3 mb-4 rounded"
                         style="background:#f7f8fa; border-left:4px solid #D05208;">
                        <div class="text-muted small">You are applying for</div>

                        <h5 class="fw-bold mt-1 mb-2"
                            style="color:#19265d;">
                            {{ $unit->managedProperty->name
                                ?? $unit->managedProperty->title
                                ?? 'Managed Property' }}
                            — Unit {{ $unit->unit_number }}
                        </h5>

                        <div class="fw-bold" style="color:#D05208;">
                            {{ number_format((float) $unit->monthly_rent) }}
                            {{ $unit->currency ?: 'RWF' }} / month
                        </div>

                        @if ((float) $unit->security_deposit > 0)
                            <div class="small text-muted mt-1">
                                Security deposit:
                                {{ number_format((float) $unit->security_deposit) }}
                                {{ $unit->currency ?: 'RWF' }}
                            </div>
                        @endif
                    </div>

                    <form method="POST"
                          action="{{ route('terra.rental-applications.store', $unit->id) }}">
                        @csrf

                        @if (!$tenant)
                            <h5 class="fw-bold mb-3">Applicant Information</h5>

                            @if ($user)
                                <div class="alert alert-info">
                                    Your application will use your existing
                                    Terra account.
                                </div>
                            @else
                                <p class="text-muted small">
                                    New to Terra? Submitting this form creates
                                    your tenant account automatically.
                                </p>
                            @endif

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name *</label>
                                    <input type="text"
                                           name="first_name"
                                           class="form-control"
                                           value="{{ old('first_name', $tenant?->first_name ?? '') }}"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text"
                                           name="last_name"
                                           class="form-control"
                                           value="{{ old('last_name', $tenant?->last_name ?? '') }}"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           value="{{ old('email', $user?->email ?? '') }}"
                                           {{ $user ? 'readonly' : '' }}
                                           required>

                                    @unless ($user)
                                        <small class="text-muted">
                                            If you already have an account,
                                            sign in before applying.
                                        </small>
                                    @endunless
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="text"
                                           name="phone"
                                           class="form-control"
                                           value="{{ old('phone', $tenant?->phone ?? '') }}"
                                           required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Residential Address</label>
                                    <input type="text"
                                           name="address"
                                           class="form-control"
                                           value="{{ old('address', $tenant?->address ?? '') }}">
                                </div>

                                @unless ($user)
                                    <div class="col-md-6">
                                        <label class="form-label">Create Password *</label>
                                        <input type="password"
                                               name="password"
                                               class="form-control"
                                               autocomplete="new-password"
                                               minlength="8"
                                               required>
                                        <small class="text-muted">
                                            Use at least 8 characters.
                                        </small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Confirm Password *</label>
                                        <input type="password"
                                               name="password_confirmation"
                                               class="form-control"
                                               autocomplete="new-password"
                                               required>
                                    </div>
                                @endunless
                            </div>
                        @else
                            <h5 class="fw-bold mb-3">Applicant</h5>

                            <div class="p-3 rounded mb-4"
                                 style="background:#f7f8fa;">
                                <strong>{{ $tenant->full_name }}</strong>
                                <div class="text-muted small">{{ $tenant->email }}</div>
                                <div class="text-muted small">{{ $tenant->phone }}</div>
                                <div class="small mt-2">
                                    Your existing tenant profile will be used.
                                </div>
                            </div>
                        @endif

                        <hr class="my-4">

                        <h5 class="fw-bold mb-3">Rental Requirements</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Desired Move-in Date
                                </label>
                                <input type="date"
                                       name="desired_move_in_date"
                                       class="form-control"
                                       min="{{ now()->toDateString() }}"
                                       value="{{ old('desired_move_in_date') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Number of Occupants *
                                </label>
                                <input type="number"
                                       name="number_of_occupants"
                                       class="form-control"
                                       min="1"
                                       max="50"
                                       value="{{ old('number_of_occupants', 1) }}"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Offered Monthly Rent
                                </label>
                                <input type="number"
                                       name="offered_monthly_rent"
                                       class="form-control"
                                       min="0"
                                       step="1000"
                                       value="{{ old('offered_monthly_rent', $unit->monthly_rent) }}">

                                <small class="text-muted">
                                    Listed rent:
                                    {{ number_format((float) $unit->monthly_rent) }}
                                    {{ $unit->currency ?: 'RWF' }}
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Employment Status</label>
                                <select name="employment_status"
                                        class="form-select">
                                    <option value="">Select status</option>
                                    @foreach ([
                                        'Employed',
                                        'Self-employed',
                                        'Business owner',
                                        'Student',
                                        'Unemployed',
                                        'Other'
                                    ] as $employmentStatus)
                                        <option value="{{ $employmentStatus }}"
                                            @selected(old('employment_status') === $employmentStatus)>
                                            {{ $employmentStatus }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    Additional Information
                                </label>
                                <textarea name="additional_information"
                                          rows="4"
                                          class="form-control"
                                          placeholder="Share any relevant information about your rental application">{{ old('additional_information') }}</textarea>
                            </div>
                        </div>

                        <div class="alert alert-light border mt-4 small">
                            By submitting, you confirm that the information
                            provided is accurate. Your application will be
                            reviewed by the property management team.
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                            <button type="submit"
                                    class="btn btn-lg text-white flex-grow-1"
                                    style="background:#D05208;">
                                <i class="bi bi-send me-2"></i>
                                Submit Rental Application
                            </button>

                            <a href="{{ url()->previous() }}"
                               class="btn btn-outline-secondary btn-lg">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection