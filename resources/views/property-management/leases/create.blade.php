@extends('layouts.property-management')

@section('title', 'Create Lease - Property Management')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <a href="{{ route('property-management.leases.index') }}"
           class="text-muted text-decoration-none">
            ← Leases
        </a>

        <h1 class="h3 fw-bold mt-3"
            style="color:#19265d;">
            Create Lease
        </h1>

        <p class="text-muted">
            Create a tenancy agreement for an approved tenant application.
        </p>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    <form method="POST"
          action="{{ route('property-management.leases.store') }}">

        @csrf

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-bold">
                            Tenant & Unit
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Tenant *
                                </label>

                                <select name="tenant_id"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        Select Tenant
                                    </option>

                                    @foreach($tenants as $tenant)

                                        <option value="{{ $tenant->id }}"
                                            @selected(
                                                old(
                                                    'tenant_id',
                                                    $application?->tenant_id
                                                ) == $tenant->id
                                            )>

                                            {{ $tenant->full_name }}
                                            — {{ $tenant->phone }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Unit *
                                </label>

                                <select name="unit_id"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        Select Unit
                                    </option>

                                    @foreach($units as $unit)

                                        <option value="{{ $unit->id }}"
                                            @selected(
                                                old(
                                                    'unit_id',
                                                    $application?->unit_id
                                                ) == $unit->id
                                            )>

                                            {{ $unit->unit_number }}
                                            —
                                            {{ $unit->floor->building->property->title }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            @if($application)

                                <input type="hidden"
                                       name="tenant_application_id"
                                       value="{{ $application->id }}">

                                <div class="col-12">

                                    <div class="alert alert-success mb-0">

                                        Creating lease from approved application
                                        <strong>
                                            #{{ $application->id }}
                                        </strong>.

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Dates --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-bold">
                            Lease Period
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Start Date *
                                </label>

                                <input type="date"
                                       name="start_date"
                                       value="{{ old('start_date') }}"
                                       class="form-control"
                                       required>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    End Date *
                                </label>

                                <input type="date"
                                       name="end_date"
                                       value="{{ old('end_date') }}"
                                       class="form-control"
                                       required>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Financial terms --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-bold">
                            Financial Terms
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Monthly Rent *
                                </label>

                                <input type="number"
                                       name="monthly_rent"
                                       value="{{ old('monthly_rent', $application?->offered_rent ?? $application?->unit?->rent) }}"
                                       class="form-control"
                                       min="0"
                                       step="0.01"
                                       required>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Deposit *
                                </label>

                                <input type="number"
                                       name="deposit_amount"
                                       value="{{ old('deposit_amount', $application?->offered_deposit ?? $application?->unit?->deposit ?? 0) }}"
                                       class="form-control"
                                       min="0"
                                       step="0.01"
                                       required>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Payment Frequency *
                                </label>

                                <select name="payment_frequency"
                                        class="form-select"
                                        required>

                                    @foreach([
                                        'monthly' => 'Monthly',
                                        'quarterly' => 'Quarterly',
                                        'semi_annually' => 'Semi-annually',
                                        'annually' => 'Annually',
                                    ] as $value => $label)

                                        <option value="{{ $value }}"
                                            @selected(old('payment_frequency', 'monthly') === $value)>
                                            {{ $label }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Contract --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-bold">
                            Contract Terms
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Terms
                            </label>

                            <textarea name="terms"
                                      rows="6"
                                      class="form-control"
                                      placeholder="Enter the main lease terms...">{{ old('terms') }}</textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Special Conditions
                            </label>

                            <textarea name="special_conditions"
                                      rows="5"
                                      class="form-control"
                                      placeholder="Enter any special conditions...">{{ old('special_conditions') }}</textarea>

                        </div>

                        <div>

                            <label class="form-label fw-semibold">
                                Internal Notes
                            </label>

                            <textarea name="notes"
                                      rows="4"
                                      class="form-control">{{ old('notes') }}</textarea>

                        </div>

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('property-management.leases.index') }}"
                       class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn text-white px-4"
                            style="background:#D05208;">
                        Create Lease
                    </button>

                </div>

            </div>


            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-bold">
                            Lease Workflow
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <strong>Draft</strong>
                            <div class="small text-muted">
                                Lease is being prepared.
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Pending Signature</strong>
                            <div class="small text-muted">
                                Contract is ready for signing.
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Active</strong>
                            <div class="small text-muted">
                                Tenant occupies the unit.
                            </div>
                        </div>

                        <div>
                            <strong>Expired / Terminated</strong>
                            <div class="small text-muted">
                                Tenancy has ended.
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection