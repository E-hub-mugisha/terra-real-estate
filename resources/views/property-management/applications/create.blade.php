@extends('layouts.property-management')

@section('title', 'New Tenant Application')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <a href="{{ route('property-management.applications.index') }}"
           class="text-muted text-decoration-none">
            ← Applications
        </a>

        <h1 class="h3 fw-bold mt-3"
            style="color:#19265d;">
            New Tenant Application
        </h1>

        <p class="text-muted">
            Submit a tenant application for an available unit.
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


    <form method="POST"
          action="{{ route('property-management.applications.store') }}">

        @csrf

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-bold">
                            Application Details
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
                                            @selected(old('tenant_id') == $tenant->id)>

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
                                        Select Available Unit
                                    </option>

                                    @foreach($units as $unit)

                                        <option value="{{ $unit->id }}"
                                            @selected(old('unit_id') == $unit->id)>

                                            {{ $unit->unit_number }}
                                            —
                                            {{ $unit->floor->building->property->title }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Application Date *
                                </label>

                                <input type="date"
                                       name="application_date"
                                       value="{{ old('application_date', now()->format('Y-m-d')) }}"
                                       class="form-control"
                                       required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Preferred Move-in Date
                                </label>

                                <input type="date"
                                       name="preferred_move_in_date"
                                       value="{{ old('preferred_move_in_date') }}"
                                       class="form-control">

                            </div>


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Offered Monthly Rent
                                </label>

                                <input type="number"
                                       name="offered_rent"
                                       value="{{ old('offered_rent') }}"
                                       class="form-control"
                                       min="0"
                                       step="0.01"
                                       placeholder="RWF">

                            </div>


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Offered Deposit
                                </label>

                                <input type="number"
                                       name="offered_deposit"
                                       value="{{ old('offered_deposit') }}"
                                       class="form-control"
                                       min="0"
                                       step="0.01"
                                       placeholder="RWF">

                            </div>


                            <div class="col-12">

                                <label class="form-label fw-semibold">
                                    Notes
                                </label>

                                <textarea name="notes"
                                          rows="5"
                                          class="form-control"
                                          placeholder="Additional application information">{{ old('notes') }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('property-management.applications.index') }}"
                       class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn text-white px-4"
                            style="background:#D05208;">
                        Submit Application
                    </button>

                </div>

            </div>


            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0 fw-bold">
                            Application Process
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <strong>1. Application</strong>
                            <div class="text-muted small">
                                Tenant submits an application for a unit.
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>2. Review</strong>
                            <div class="text-muted small">
                                Property manager reviews the application and KYC.
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>3. Approval</strong>
                            <div class="text-muted small">
                                Approved applications can proceed to lease creation.
                            </div>
                        </div>

                        <div>
                            <strong>4. Lease</strong>
                            <div class="text-muted small">
                                A lease is created after approval.
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection