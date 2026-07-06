{{-- resources/views/consultant/service-reports/create.blade.php --}}
@extends('layouts.consultant')

@section('content')
<div class="container-fluid" style="--green:#00a667;">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-semibold">Report Service Provided</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('consultant.service-reports.store') }}" id="reportForm">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Service</label>
                        <select name="service_id" id="service_id" class="form-select" required>
                            <option value="">Select service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    data-price="{{ $service->price }}"
                                    data-commission-type="{{ $service->commission_type }}"
                                    data-commission-value="{{ $service->commission_value }}"
                                    {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Client Name</label>
                        <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" required>
                        @error('client_name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Client Phone</label>
                        <input type="text" name="client_phone" class="form-control" placeholder="0788123456" value="{{ old('client_phone') }}" required>
                        @error('client_phone') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="service_date" class="form-control" value="{{ old('service_date') }}" required>
                        @error('service_date') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Time</label>
                        <input type="time" name="service_time" class="form-control" value="{{ old('service_time') }}" required>
                        @error('service_time') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                        @error('location') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Amount Charged (RWF)</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
                        @error('amount') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background:#f5fbf8;border:1px solid var(--green);">
                            <div class="small text-muted">Terra Commission</div>
                            <div class="fs-5 fw-bold" style="color:var(--green);" id="terraAmount">0 RWF</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded bg-light border">
                            <div class="small text-muted">You Receive</div>
                            <div class="fs-5 fw-bold" id="consultantAmount">0 RWF</div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn text-white mt-4" style="background:var(--green);">
                    <i class="ti ti-send"></i> Submit Report
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const serviceSelect = document.getElementById('service_id');
    const amountInput = document.getElementById('amount');
    const terraEl = document.getElementById('terraAmount');
    const consultantEl = document.getElementById('consultantAmount');

    function formatRWF(n) {
        return new Intl.NumberFormat('en-RW').format(Math.round(n)) + ' RWF';
    }

    function recalculate() {
        const opt = serviceSelect.selectedOptions[0];
        const amount = parseFloat(amountInput.value) || 0;

        if (!opt || !opt.value) {
            terraEl.textContent = '0 RWF';
            consultantEl.textContent = '0 RWF';
            return;
        }

        const type = opt.dataset.commissionType;
        const value = parseFloat(opt.dataset.commissionValue);

        let terra = type === 'fixed' ? Math.min(value, amount) : (amount * value / 100);
        let consultant = amount - terra;

        terraEl.textContent = formatRWF(terra);
        consultantEl.textContent = formatRWF(consultant);
    }

    serviceSelect.addEventListener('change', function () {
        const opt = this.selectedOptions[0];
        if (opt && opt.dataset.price && !amountInput.value) {
            amountInput.value = opt.dataset.price;
        }
        recalculate();
    });
    amountInput.addEventListener('input', recalculate);
</script>
@endpush