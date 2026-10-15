@extends('layouts.tenant.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Apply for a Property</h3>
            <p class="text-muted mb-0">
                Submit your rental application for review.
            </p>
        </div>

        <a href="{{ route('tenant-portal.properties.show', $unit->id) }}"
           class="btn btn-outline-secondary">
            Back to Property
        </a>
    </div>

    @if ($errors->has('unit_id'))
        <div class="alert alert-danger">
            {{ $errors->first('unit_id') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="mb-3">
                {{ $unit->managedProperty->name
                    ?? $unit->managedProperty->title
                    ?? 'Rental Property' }}
            </h5>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <small class="text-muted d-block">Unit</small>
                    <strong>{{ $unit->unit_number }}</strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Monthly rent</small>
                    <strong>
                        {{ $unit->currency ?? 'RWF' }}
                        {{ number_format((float) $unit->monthly_rent, 0) }}
                    </strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Security deposit</small>
                    <strong>
                        {{ $unit->currency ?? 'RWF' }}
                        {{ number_format((float) ($unit->security_deposit ?? 0), 0) }}
                    </strong>
                </div>
            </div>

            <hr>

            <form method="POST"
                  action="{{ route('tenant-portal.properties.apply.store', $unit->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="preferred_move_in_date" class="form-label">
                        Preferred move-in date
                    </label>

                    <input type="date"
                           name="preferred_move_in_date"
                           id="preferred_move_in_date"
                           min="{{ now()->toDateString() }}"
                           value="{{ old('preferred_move_in_date') }}"
                           class="form-control @error('preferred_move_in_date') is-invalid @enderror">

                    @error('preferred_move_in_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="offered_rent" class="form-label">
                            Offered monthly rent
                        </label>

                        <input type="number"
                               name="offered_rent"
                               id="offered_rent"
                               min="0"
                               step="0.01"
                               required
                               value="{{ old('offered_rent', $unit->monthly_rent) }}"
                               class="form-control @error('offered_rent') is-invalid @enderror">

                        @error('offered_rent')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="offered_deposit" class="form-label">
                            Offered security deposit
                        </label>

                        <input type="number"
                               name="offered_deposit"
                               id="offered_deposit"
                               min="0"
                               step="0.01"
                               required
                               value="{{ old('offered_deposit', $unit->security_deposit ?? 0) }}"
                               class="form-control @error('offered_deposit') is-invalid @enderror">

                        @error('offered_deposit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label">
                        Message to the property manager
                    </label>

                    <textarea name="notes"
                              id="notes"
                              rows="4"
                              maxlength="3000"
                              class="form-control @error('notes') is-invalid @enderror"
                              placeholder="Tell the property manager about your application...">{{ old('notes') }}</textarea>

                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    Submitting this application does not automatically create a lease.
                    The property manager must review your application first.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Submit Application
                    </button>

                    <a href="{{ route('tenant-portal.applications.index') }}"
                       class="btn btn-outline-secondary">
                        My Applications
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection