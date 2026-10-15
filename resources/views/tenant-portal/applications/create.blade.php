@extends('layouts.tenant.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('tenant-portal.applications.index') }}"
           class="text-decoration-none">
            &larr; My Applications
        </a>

        <h3 class="fw-bold mt-3">Rental Application</h3>
        <p class="text-muted">
            Complete the form to apply for a rental unit.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tenant-portal.applications.store') }}"
          method="POST">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Unit Information</h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="unit_id" class="form-label">
                        Rental Unit <span class="text-danger">*</span>
                    </label>

                    <select name="unit_id" id="unit_id"
                            class="form-select @error('unit_id') is-invalid @enderror"
                            required>
                        <option value="">Select a unit</option>

                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}"
                                @selected(old('unit_id', $selectedUnit?->id) == $unit->id)>
                                {{ $unit->name ?? 'Unit #' . $unit->id }}
                                @if(isset($unit->monthly_rent))
                                    — {{ number_format((float) $unit->monthly_rent) }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @error('unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($units->isEmpty())
                        <div class="text-muted small mt-2">
                            No eligible units are available for application.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Application Details</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="desired_move_in_date" class="form-label">
                            Desired Move-in Date *
                        </label>
                        <input type="date"
                               name="desired_move_in_date"
                               id="desired_move_in_date"
                               min="{{ today()->format('Y-m-d') }}"
                               class="form-control"
                               value="{{ old('desired_move_in_date') }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="number_of_occupants" class="form-label">
                            Number of Occupants *
                        </label>
                        <input type="number"
                               name="number_of_occupants"
                               id="number_of_occupants"
                               min="1" max="50"
                               class="form-control"
                               value="{{ old('number_of_occupants', 1) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="offered_monthly_rent" class="form-label">
                            Offered Monthly Rent *
                        </label>
                        <input type="number"
                               name="offered_monthly_rent"
                               id="offered_monthly_rent"
                               min="0" step="0.01"
                               class="form-control"
                               value="{{ old('offered_monthly_rent') }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="currency" class="form-label">
                            Currency *
                        </label>
                        <select name="currency" id="currency"
                                class="form-select" required>
                            <option value="RWF"
                                @selected(old('currency', 'RWF') === 'RWF')>
                                RWF — Rwandan Franc
                            </option>
                            <option value="USD"
                                @selected(old('currency') === 'USD')>
                                USD — US Dollar
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="employment_status" class="form-label">
                            Employment Status
                        </label>
                        <select name="employment_status"
                                id="employment_status"
                                class="form-select">
                            <option value="">Select employment status</option>
                            @foreach([
                                'Employed',
                                'Self-employed',
                                'Business owner',
                                'Student',
                                'Unemployed',
                                'Other'
                            ] as $employment)
                                <option value="{{ $employment }}"
                                    @selected(old('employment_status') === $employment)>
                                    {{ $employment }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="additional_information" class="form-label">
                            Additional Information
                        </label>
                        <textarea name="additional_information"
                                  id="additional_information"
                                  rows="4"
                                  maxlength="5000"
                                  class="form-control"
                                  placeholder="Tell the property manager anything else relevant to your application.">{{ old('additional_information') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('tenant-portal.applications.index') }}"
               class="btn btn-light border">
                Cancel
            </a>

            <button type="submit"
                    class="btn btn-primary"
                    @disabled($units->isEmpty())>
                Submit Application
            </button>
        </div>
    </form>
</div>
@endsection