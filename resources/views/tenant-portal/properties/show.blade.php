@extends('layouts.property-management')

@section('title', 'Property Details')

@section('content')
@php
    $property = $unit->floor?->building?->property;
@endphp

<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('tenant-portal.properties.index') }}"
           class="text-decoration-none text-muted">
            &larr; Back to available properties
        </a>
    </div>

    @if($errors->has('unit'))
        <div class="alert alert-warning">
            {{ $errors->first('unit') }}
        </div>
    @endif

    <div class="row g-4">

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">

                    <span class="badge text-bg-success mb-3">
                        Available for application
                    </span>

                    <h1 class="h3 fw-bold mb-2">
                        {{ $property->title }}
                    </h1>

                    <p class="text-muted">
                        {{ $property->district ?? 'Location not specified' }}
                        @if($property->sector)
                            , {{ $property->sector }}
                        @endif
                    </p>

                    <hr>

                    <h2 class="h5 fw-bold mb-3">Unit information</h2>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="bg-light rounded p-3 h-100">
                                <small class="text-muted d-block">Unit number</small>
                                <strong>{{ $unit->unit_number }}</strong>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="bg-light rounded p-3 h-100">
                                <small class="text-muted d-block">Unit type</small>
                                <strong>
                                    {{ ucfirst(str_replace('_', ' ', $unit->unit_type)) }}
                                </strong>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="bg-light rounded p-3 h-100">
                                <small class="text-muted d-block">Bedrooms</small>
                                <strong>{{ $unit->bedrooms ?? 'Not specified' }}</strong>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="bg-light rounded p-3 h-100">
                                <small class="text-muted d-block">Bathrooms</small>
                                <strong>{{ $unit->bathrooms ?? 'Not specified' }}</strong>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="bg-light rounded p-3 h-100">
                                <small class="text-muted d-block">Monthly rent</small>
                                <strong class="text-success">
                                    {{ number_format((float) $unit->rent, 0) }} RWF
                                </strong>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="bg-light rounded p-3 h-100">
                                <small class="text-muted d-block">Required deposit</small>
                                <strong>
                                    {{ number_format((float) $unit->deposit, 0) }} RWF
                                </strong>
                            </div>
                        </div>
                    </div>

                    @if($unit->description)
                        <h2 class="h5 fw-bold">Description</h2>
                        <p class="text-muted mb-4">
                            {{ $unit->description }}
                        </p>
                    @endif

                    @if($property->description)
                        <h2 class="h5 fw-bold">Property overview</h2>
                        <p class="text-muted mb-0">
                            {{ $property->description }}
                        </p>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h2 class="h4 fw-bold mb-2">Apply for this unit</h2>

                    <p class="text-muted small mb-4">
                        Submit your application for review by the property manager.
                        An application does not guarantee approval or reserve the unit.
                    </p>

                    <form method="POST"
                          action="{{ route('tenant-portal.properties.apply', $unit) }}">
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

                        <div class="mb-3">
                            <label for="offered_rent" class="form-label">
                                Offered monthly rent (RWF)
                            </label>

                            <input type="number"
                                   name="offered_rent"
                                   id="offered_rent"
                                   min="0"
                                   step="0.01"
                                   value="{{ old('offered_rent', $unit->rent) }}"
                                   class="form-control @error('offered_rent') is-invalid @enderror">

                            @error('offered_rent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted">
                                The manager will review your offer.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="offered_deposit" class="form-label">
                                Offered deposit (RWF)
                            </label>

                            <input type="number"
                                   name="offered_deposit"
                                   id="offered_deposit"
                                   min="0"
                                   step="0.01"
                                   value="{{ old('offered_deposit', $unit->deposit) }}"
                                   class="form-control @error('offered_deposit') is-invalid @enderror">

                            @error('offered_deposit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">
                                Additional information
                            </label>

                            <textarea name="notes"
                                      id="notes"
                                      rows="4"
                                      maxlength="5000"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      placeholder="Tell the property manager anything relevant to your application.">{{ old('notes') }}</textarea>

                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-terra w-100">
                            Submit Application
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .btn-terra {
        background: #D05208;
        color: #fff;
        border: 1px solid #D05208;
    }

    .btn-terra:hover {
        background: #ad4306;
        color: #fff;
        border-color: #ad4306;
    }
</style>
@endsection