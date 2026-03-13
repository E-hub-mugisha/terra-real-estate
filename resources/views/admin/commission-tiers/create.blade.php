@extends('layouts.app')

@section('title', 'Create Commission Tier')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:var(--terra-navy)">Create Commission Tier</h1>
            <p class="text-muted mb-0" style="font-size:.9rem">Define a new sliding scale commission range</p>
        </div>
        <a href="{{ route('admin.commission-tiers.index') }}" class="btn btn-outline-secondary btn-sm">
            ← Back to Tiers
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

    <form method="POST" action="{{ route('admin.commission-tiers.store') }}">
        @csrf

        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Tier Details</h6>
                    </div>
                    <div class="card-body p-4">

                        {{-- Label --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="font-size:.85rem">
                                Tier Label <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="label" class="form-control"
                                placeholder="e.g. 30,000 – 99,999 RWF"
                                value="{{ old('label') }}" required>
                            <div class="form-text">A human-readable name for this tier.</div>
                        </div>

                        {{-- Range --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Minimum Value (RWF) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="min_value" class="form-control"
                                        placeholder="e.g. 30000"
                                        value="{{ old('min_value') }}" min="0" required>
                                    <span class="input-group-text" style="font-size:.8rem">RWF</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Maximum Value (RWF)
                                    <small class="text-muted fw-normal">(leave empty for no upper limit)</small>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="max_value" class="form-control"
                                        placeholder="e.g. 99999"
                                        value="{{ old('max_value') }}" min="0">
                                    <span class="input-group-text" style="font-size:.8rem">RWF</span>
                                </div>
                            </div>
                        </div>

                        {{-- Commission rates --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Terra Commission % <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="terra_commission_pct" id="terraPct"
                                        class="form-control" placeholder="e.g. 29"
                                        value="{{ old('terra_commission_pct') }}"
                                        min="0" max="100" step="0.01" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Consultant Payout % <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="consultant_payout_pct" id="consultantPct"
                                        class="form-control" placeholder="e.g. 71"
                                        value="{{ old('consultant_payout_pct') }}"
                                        min="0" max="100" step="0.01" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-4">

                {{-- Live preview --}}
                <div class="card border-0 shadow-sm" style="background:var(--terra-navy)">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4" style="color:var(--terra-gold)">Live Preview</h6>

                        {{-- Split bar --}}
                        <div class="mb-3">
                            <div style="display:flex;justify-content:space-between;margin-bottom:6px">
                                <span style="font-size:.75rem;color:rgba(255,255,255,.5)">Terra</span>
                                <span style="font-size:.75rem;color:rgba(255,255,255,.5)">Consultant</span>
                            </div>
                            <div style="height:10px;border-radius:5px;overflow:hidden;background:rgba(255,255,255,.1);display:flex">
                                <div id="terraBar" style="height:100%;background:linear-gradient(90deg,var(--terra-orange),var(--terra-gold));transition:width .3s;width:0%"></div>
                                <div id="consultantBar" style="height:100%;background:linear-gradient(90deg,#2d7a4f,#5ddc8a);transition:width .3s;width:0%"></div>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-top:6px">
                                <span id="terraBarPct" style="font-size:.75rem;color:var(--terra-gold);font-weight:600">0%</span>
                                <span id="consultantBarPct" style="font-size:.75rem;color:#5ddc8a;font-weight:600">0%</span>
                            </div>
                        </div>

                        {{-- Example calculation --}}
                        <div style="border-top:1px solid rgba(255,255,255,.1);padding-top:16px;margin-top:4px">
                            <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px">
                                Example — 100,000 RWF service
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Service Value</span>
                                <span style="font-size:.82rem;color:#fff;font-weight:600">100,000 RWF</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Terra Gets</span>
                                <span id="terraAmt" style="font-size:.82rem;color:var(--terra-gold);font-weight:600">— RWF</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Consultant Gets</span>
                                <span id="consultantAmt" style="font-size:.82rem;color:#5ddc8a;font-weight:600">— RWF</span>
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
                Save Tier
            </button>
            <a href="{{ route('admin.commission-tiers.index') }}"
                class="btn btn-outline-secondary px-4 py-2">
                Cancel
            </a>
        </div>

    </form>
</div>


<script>
    const terraPctInput     = document.getElementById('terraPct');
    const consultantPctInput = document.getElementById('consultantPct');

    function updatePreview() {
        const terra      = parseFloat(terraPctInput.value) || 0;
        const consultant = parseFloat(consultantPctInput.value) || 0;
        const example    = 100000;

        document.getElementById('terraBar').style.width        = terra + '%';
        document.getElementById('consultantBar').style.width   = consultant + '%';
        document.getElementById('terraBarPct').textContent     = terra + '%';
        document.getElementById('consultantBarPct').textContent = consultant + '%';
        document.getElementById('terraAmt').textContent        = Math.round(example * terra / 100).toLocaleString() + ' RWF';
        document.getElementById('consultantAmt').textContent   = Math.round(example * consultant / 100).toLocaleString() + ' RWF';
    }

    // Auto fill consultant pct when terra pct changes
    terraPctInput.addEventListener('input', function () {
        consultantPctInput.value = (100 - parseFloat(this.value || 0)).toFixed(2);
        updatePreview();
    });

    consultantPctInput.addEventListener('input', updatePreview);

    updatePreview();
</script>
@endsection