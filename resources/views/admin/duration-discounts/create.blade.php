@extends('layouts.app')

@section('title', 'Create Duration Discount')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:var(--terra-navy)">Create Duration Discount</h1>
            <p class="text-muted mb-0" style="font-size:.9rem">Define a new discount rule based on listing duration</p>
        </div>
        <a href="{{ route('admin.duration-discounts.index') }}" class="btn btn-outline-secondary btn-sm">
            ← Back to Discounts
        </a>
    </div>

    {{-- Errors --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.duration-discounts.store') }}">
        @csrf

        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Discount Details</h6>
                    </div>
                    <div class="card-body p-4">

                        {{-- Label --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="font-size:.85rem">
                                Label <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="label" class="form-control"
                                placeholder="e.g. 31 – 59 Days Discount"
                                value="{{ old('label') }}" required>
                            <div class="form-text">A human-readable name for this discount rule.</div>
                        </div>

                        {{-- Range --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Minimum Days <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="min_days" id="minDays"
                                        class="form-control" placeholder="e.g. 31"
                                        value="{{ old('min_days') }}" min="1" required>
                                    <span class="input-group-text" style="font-size:.8rem">days</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Maximum Days
                                    <small class="text-muted fw-normal">(leave empty for no upper limit)</small>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="max_days" id="maxDays"
                                        class="form-control" placeholder="e.g. 59"
                                        value="{{ old('max_days') }}" min="1">
                                    <span class="input-group-text" style="font-size:.8rem">days</span>
                                </div>
                            </div>
                        </div>

                        {{-- Discount % --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:.85rem">
                                Discount Rate % <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" name="discount_pct" id="discountPct"
                                    class="form-control" placeholder="e.g. 10"
                                    value="{{ old('discount_pct') }}"
                                    min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm" style="background:var(--terra-navy)">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4" style="color:var(--terra-gold)">Live Preview</h6>

                        {{-- Duration range --}}
                        <div style="background:rgba(255,255,255,.06);border-radius:10px;padding:14px 16px;margin-bottom:16px">
                            <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px">Duration Range</div>
                            <div id="rangePreview" style="font-size:1rem;color:#fff;font-weight:600">— days</div>
                        </div>

                        {{-- Discount bar --}}
                        <div class="mb-3">
                            <div style="display:flex;justify-content:space-between;margin-bottom:6px">
                                <span style="font-size:.75rem;color:rgba(255,255,255,.5)">Discount Applied</span>
                                <span id="discPct" style="font-size:.75rem;color:var(--terra-gold);font-weight:600">0%</span>
                            </div>
                            <div style="height:8px;border-radius:4px;overflow:hidden;background:rgba(255,255,255,.1)">
                                <div id="discBar" style="height:100%;border-radius:4px;
                                    background:linear-gradient(90deg,var(--terra-orange),var(--terra-gold));
                                    transition:width .3s;width:0%"></div>
                            </div>
                        </div>

                        {{-- Example --}}
                        <div style="border-top:1px solid rgba(255,255,255,.1);padding-top:16px">
                            <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px">
                                Example — 100,000 RWF gross
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Gross Amount</span>
                                <span style="font-size:.82rem;color:#fff;font-weight:600">100,000 RWF</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Discount</span>
                                <span id="discAmt" style="font-size:.82rem;color:var(--terra-gold);font-weight:600">— RWF</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Net Amount</span>
                                <span id="netAmt" style="font-size:.82rem;color:#5ddc8a;font-weight:600">— RWF</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn px-4 py-2 fw-semibold text-white"
                style="background:var(--terra-orange);border:none">
                Save Discount
            </button>
            <a href="{{ route('admin.duration-discounts.index') }}"
                class="btn btn-outline-secondary px-4 py-2">
                Cancel
            </a>
        </div>

    </form>
</div>

<script>
    const minDaysInput   = document.getElementById('minDays');
    const maxDaysInput   = document.getElementById('maxDays');
    const discPctInput   = document.getElementById('discountPct');

    function updatePreview() {
        const min  = parseInt(minDaysInput.value) || 0;
        const max  = parseInt(maxDaysInput.value) || 0;
        const pct  = parseFloat(discPctInput.value) || 0;
        const gross = 100000;

        // Range text
        let rangeText = '— days';
        if (min > 0 && max > 0)  rangeText = min + ' – ' + max + ' days';
        else if (min > 0)        rangeText = min + '+ days';
        document.getElementById('rangePreview').textContent = rangeText;

        // Bar — scale to 20% max discount = 100% bar width
        document.getElementById('discBar').style.width = Math.min(pct * 5, 100) + '%';
        document.getElementById('discPct').textContent = pct + '%';

        // Amounts
        const discAmt = Math.round(gross * pct / 100);
        const netAmt  = gross - discAmt;
        document.getElementById('discAmt').textContent = discAmt.toLocaleString() + ' RWF';
        document.getElementById('netAmt').textContent  = netAmt.toLocaleString() + ' RWF';
    }

    minDaysInput.addEventListener('input', updatePreview);
    maxDaysInput.addEventListener('input', updatePreview);
    discPctInput.addEventListener('input', updatePreview);

    updatePreview();
</script>
@endsection