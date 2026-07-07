{{-- resources/views/consultant/service-reports/create.blade.php --}}
@extends('layouts.users')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

@section('content')
<div class="sr-page py-4">
<div class="container-fluid" style="max-width:1180px;">

    {{-- Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="sr-header-icon">
            <i class="ti ti-file-invoice"></i>
        </div>
        <div>
            <div class="sr-eyebrow">Terra &middot; Consultant</div>
            <h4 class="sr-title mb-0">Report Service Provided</h4>
            <div class="sr-subtitle">Log a completed client service to track commission and earnings</div>
        </div>
    </div>

    @if (session('success'))
        <div class="sr-alert-success d-flex align-items-center gap-2 mb-4">
            <i class="ti ti-circle-check fs-5"></i>
            <span class="fw-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if ($serviceRequest ?? null)
        <div class="sr-alert-linked d-flex align-items-center gap-2 mb-4">
            <i class="ti ti-link fs-5"></i>
            <span class="fw-medium">
                This report is linked to a client request submitted {{ $serviceRequest->created_at->diffForHumans() }}.
                Client details below are locked to match that request.
            </span>
        </div>
    @endif

    <form method="POST" action="{{ route('consultant.service-reports.store') }}" id="reportForm">
        @csrf
        @if ($serviceRequest ?? null)
            <input type="hidden" name="service_request_id" value="{{ $serviceRequest->id }}">
        @endif

        <div class="row g-4">
            {{-- Main form column --}}
            <div class="col-lg-8">
                <div class="sr-card mb-4">
                    <div class="card-body p-4 p-md-5">

                        <div class="sr-section-title">
                            <span class="sr-step">1</span> Service Details
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-6">
                                <label class="sr-label">Service</label>
                                <div class="sr-input-wrap">
                                    <i class="ti ti-briefcase sr-input-icon"></i>
                                    <select name="service_id" id="service_id" class="form-select sr-control ps-5"
                                        {{ ($serviceRequest ?? null) ? 'disabled' : '' }} required>
                                        <option value="">Select service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                data-price="{{ $service->price }}"
                                                data-commission-type="{{ $service->commission_type }}"
                                                data-commission-value="{{ $service->commission_value }}"
                                                {{ (old('service_id') ?? ($serviceRequest->service_id ?? null)) == $service->id ? 'selected' : '' }}>
                                                {{ $service->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($serviceRequest ?? null)
                                        <input type="hidden" name="service_id" value="{{ $serviceRequest->service_id }}">
                                    @endif
                                </div>
                                @error('service_id') <div class="sr-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="sr-label">Amount Charged</label>
                                <div class="sr-input-wrap">
                                    <span class="sr-prefix">RWF</span>
                                    <input type="number" step="0.01" name="amount" id="amount"
                                           class="form-control sr-control sr-control-prefixed"
                                           value="{{ old('amount') }}" required>
                                </div>
                                @error('amount') <div class="sr-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="sr-divider">

                        <div class="sr-section-title">
                            <span class="sr-step">2</span> Client Information
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-6">
                                <label class="sr-label">Client Name</label>
                                <div class="sr-input-wrap">
                                    <i class="ti ti-user sr-input-icon"></i>
                                    <input type="text" name="client_name" class="form-control sr-control ps-5"
                                           value="{{ old('client_name', $serviceRequest->full_name ?? '') }}"
                                           {{ ($serviceRequest ?? null) ? 'readonly' : '' }} required>
                                </div>
                                @error('client_name') <div class="sr-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="sr-label">Client Phone</label>
                                <div class="sr-input-wrap">
                                    <i class="ti ti-phone sr-input-icon"></i>
                                    <input type="text" name="client_phone" class="form-control sr-control ps-5"
                                           placeholder="0788123456" value="{{ old('client_phone', $serviceRequest->phone ?? '') }}"
                                           {{ ($serviceRequest ?? null) ? 'readonly' : '' }} required>
                                </div>
                                @error('client_phone') <div class="sr-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="sr-divider">

                        <div class="sr-section-title">
                            <span class="sr-step">3</span> When &amp; Where
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-4">
                                <label class="sr-label">Date</label>
                                <div class="sr-input-wrap">
                                    <i class="ti ti-calendar sr-input-icon"></i>
                                    <input type="date" name="service_date" class="form-control sr-control ps-5"
                                           value="{{ old('service_date', optional($serviceRequest->preferred_date ?? null)->format('Y-m-d')) }}" required>
                                </div>
                                @error('service_date') <div class="sr-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="sr-label">Time</label>
                                <div class="sr-input-wrap">
                                    <i class="ti ti-clock sr-input-icon"></i>
                                    <input type="time" name="service_time" class="form-control sr-control ps-5"
                                           value="{{ old('service_time', $serviceRequest->preferred_time ?? '') }}" required>
                                </div>
                                @error('service_time') <div class="sr-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="sr-label">Location</label>
                                <div class="sr-input-wrap">
                                    <i class="ti ti-map-pin sr-input-icon"></i>
                                    <input type="text" name="location" class="form-control sr-control ps-5"
                                           value="{{ old('location', $serviceRequest->location ?? '') }}"
                                           {{ ($serviceRequest ?? null) ? 'readonly' : '' }} required>
                                </div>
                                @error('location') <div class="sr-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-2">
                            <label class="sr-label">Notes <span class="sr-optional">(optional)</span></label>
                            <textarea name="notes" class="form-control sr-control sr-textarea" rows="3" placeholder="Any additional details about this service...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Submit (mobile inline, hidden on lg where sidebar has it) --}}
                <div class="d-lg-none">
                    <button type="submit" class="sr-submit-btn w-100">
                        <i class="ti ti-send"></i> Submit Report
                    </button>
                </div>
            </div>

            {{-- Sticky summary sidebar --}}
            <div class="col-lg-4">
                <div class="sr-sticky">
                    <div class="sr-summary-card">
                        <div class="sr-summary-top">
                            <div class="sr-summary-label">
                                <i class="ti ti-building-skyscraper"></i> Terra Commission
                            </div>
                            <div class="sr-summary-figure" id="terraAmount">0 RWF</div>
                        </div>

                        <div class="sr-summary-bottom">
                            <div class="sr-summary-label sr-summary-label-dark">
                                <i class="ti ti-wallet"></i> You Receive
                            </div>
                            <div class="sr-summary-figure sr-summary-figure-dark" id="consultantAmount">0 RWF</div>

                            <div class="sr-summary-note d-flex align-items-start gap-2">
                                <i class="ti ti-info-circle mt-1"></i>
                                <span>Commission is calculated automatically based on the selected service and amount charged.</span>
                            </div>

                            <button type="submit" class="sr-submit-btn w-100 d-none d-lg-inline-flex">
                                <i class="ti ti-send"></i> Submit Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

<style>
    .sr-page {
        --navy: #19265d;
        --navy-dark: #111a45;
        --navy-tint: #eef0f8;
        --gold: #D05208;
        --gold-light: #fdf1e8;
        --ink: #16203f;
        --muted: #6b7280;
        --line: #e7e9f2;
        background: #f7f7fb;
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        min-height: 100%;
    }

    .sr-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--navy), var(--navy-dark));
        color: var(--gold);
        font-size: 1.4rem;
        box-shadow: 0 8px 20px -8px rgba(25, 38, 93, 0.5);
        flex-shrink: 0;
    }

    .sr-eyebrow {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 2px;
    }

    .sr-title {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
        font-size: 1.9rem;
        color: var(--navy);
        line-height: 1.15;
    }

    .sr-subtitle {
        font-size: 0.88rem;
        color: var(--muted);
        margin-top: 2px;
    }

    .sr-alert-success {
        background: #eafaf1;
        border: 1px solid #b9e9cd;
        color: #146c43;
        border-radius: 14px;
        padding: 0.9rem 1.1rem;
    }

    .sr-alert-linked {
        background: var(--gold-light);
        border: 1px solid #f0d3b8;
        color: #8a4306;
        border-radius: 14px;
        padding: 0.9rem 1.1rem;
        font-size: 0.88rem;
    }

    .sr-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: 0 10px 30px -18px rgba(25, 38, 93, 0.25);
        position: relative;
        overflow: hidden;
    }

    .sr-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--navy), var(--gold));
    }

    .sr-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 1.25rem;
    }

    .sr-step {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: var(--gold-light);
        color: var(--gold);
        font-size: 0.78rem;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
    }

    .sr-divider {
        margin: 1.85rem 0;
        opacity: 1;
        border-top: 1px dashed var(--line);
    }

    .sr-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--muted);
        margin-bottom: 0.4rem;
    }

    .sr-optional {
        font-weight: 400;
        color: #9ca3af;
    }

    .sr-input-wrap {
        position: relative;
    }

    .sr-input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa0b4;
        pointer-events: none;
        font-size: 1.05rem;
        z-index: 3;
    }

    .sr-prefix {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--navy);
        font-weight: 700;
        font-size: 0.85rem;
        z-index: 3;
    }

    .sr-control {
        border: 1.5px solid var(--line);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        background: #fbfbfd;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }

    .sr-control-prefixed {
        padding-left: 3.1rem;
    }

    .sr-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 4px rgba(208, 82, 8, 0.1);
        background: #fff;
        outline: none;
    }

    .sr-textarea {
        resize: vertical;
        min-height: 90px;
    }

    .sr-error {
        color: #dc3545;
        font-size: 0.78rem;
        margin-top: 0.35rem;
    }

    .sr-sticky {
        position: sticky;
        top: 1.5rem;
    }

    .sr-summary-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 16px 40px -20px rgba(25, 38, 93, 0.45);
        border: 1px solid var(--line);
    }

    .sr-summary-top {
        background: linear-gradient(135deg, var(--navy), var(--navy-dark));
        padding: 1.6rem 1.5rem;
        position: relative;
    }

    .sr-summary-top::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(208, 82, 8, 0.25), transparent 60%);
    }

    .sr-summary-bottom {
        background: #fff;
        padding: 1.6rem 1.5rem 1.75rem;
    }

    .sr-summary-label {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: rgba(255,255,255,0.65);
        margin-bottom: 0.35rem;
        position: relative;
    }

    .sr-summary-label-dark {
        color: var(--muted);
    }

    .sr-summary-figure {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
        font-size: 2.1rem;
        color: #fff;
        position: relative;
        transition: opacity .15s ease;
    }

    .sr-summary-figure-dark {
        color: var(--gold);
        margin-bottom: 1.1rem;
    }

    .sr-summary-note {
        background: var(--navy-tint);
        border: 1px solid var(--line);
        color: var(--muted);
        font-size: 0.82rem;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.4rem;
        line-height: 1.4;
    }

    .sr-submit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: var(--gold);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.9rem 1.5rem;
        transition: background .15s ease, transform .1s ease, box-shadow .15s ease;
        box-shadow: 0 10px 24px -10px rgba(208, 82, 8, 0.55);
    }

    .sr-submit-btn:hover {
        background: #b84706;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 28px -10px rgba(208, 82, 8, 0.6);
    }

    .sr-submit-btn:active {
        transform: translateY(0);
    }

    @media (max-width: 991.98px) {
        .sr-sticky { position: static; }
    }
</style>

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

    // If the service is pre-selected (linked request) or amount pre-filled, calculate immediately
    if (serviceSelect.value || amountInput.value) {
        recalculate();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection