@extends('layouts.property-management')

@section('title', 'Edit Lease - Property Management')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <a href="{{ route('property-management.leases.show', $lease) }}"
           class="text-muted text-decoration-none">
            ← Back to Lease
        </a>

        <h1 class="h3 fw-bold mt-3"
            style="color:#19265d;">
            Edit Lease
        </h1>

        <p class="text-muted">
            {{ $lease->lease_number }}
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
          action="{{ route('property-management.leases.update', $lease) }}">

        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="mb-0 fw-bold">
                    Lease Terms
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
                               value="{{ old('start_date', $lease->start_date?->format('Y-m-d')) }}"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            End Date *
                        </label>

                        <input type="date"
                               name="end_date"
                               value="{{ old('end_date', $lease->end_date?->format('Y-m-d')) }}"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Monthly Rent *
                        </label>

                        <input type="number"
                               name="monthly_rent"
                               value="{{ old('monthly_rent', $lease->monthly_rent) }}"
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
                               value="{{ old('deposit_amount', $lease->deposit_amount) }}"
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
                                class="form-select">

                            @foreach([
                                'monthly' => 'Monthly',
                                'quarterly' => 'Quarterly',
                                'semi_annually' => 'Semi-annually',
                                'annually' => 'Annually',
                            ] as $value => $label)

                                <option value="{{ $value }}"
                                    @selected($lease->payment_frequency === $value)>
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-12">

                        <label class="form-label">
                            Terms
                        </label>

                        <textarea name="terms"
                                  rows="7"
                                  class="form-control">{{ old('terms', $lease->terms) }}</textarea>

                    </div>

                    <div class="col-12">

                        <label class="form-label">
                            Special Conditions
                        </label>

                        <textarea name="special_conditions"
                                  rows="5"
                                  class="form-control">{{ old('special_conditions', $lease->special_conditions) }}</textarea>

                    </div>

                    <div class="col-12">

                        <label class="form-label">
                            Notes
                        </label>

                        <textarea name="notes"
                                  rows="4"
                                  class="form-control">{{ old('notes', $lease->notes) }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        <div class="d-flex justify-content-end gap-2">

            <a href="{{ route('property-management.leases.show', $lease) }}"
               class="btn btn-light border">
                Cancel
            </a>

            <button type="submit"
                    class="btn text-white px-4"
                    style="background:#D05208;">
                Save Changes
            </button>

        </div>

    </form>

</div>

@endsection