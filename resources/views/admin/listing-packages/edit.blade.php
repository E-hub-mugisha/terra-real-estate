@extends('layouts.app')

@section('title', 'Edit Listing Package')

@section('content')

<style>
    .form-check.form-switch .form-check-input {
        width: 2.5rem !important;
        height: 1.25rem !important;
        visibility: visible !important;
        opacity: 1 !important;
        cursor: pointer;
    }
</style>

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Edit Listing Package</h1>
            <p class="text-muted mb-0" style="font-size:.9rem">
                {{ $listingPackage->type_label }} — {{ $listingPackage->tier_label }}
            </p>
        </div>
        <a href="{{ route('admin.listing-packages.index') }}" class="btn btn-outline-secondary btn-sm">
            ← Back to Packages
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

    <form method="POST" action="{{ route('admin.listing-packages.update', $listingPackage) }}">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-lg-8">

                {{-- Basic Info --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Package Details</h6>
                    </div>
                    <div class="card-body p-4">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Listing Type <span class="text-danger">*</span>
                                </label>
                                <select name="listing_type" class="form-select" required>
                                    <option value="">— Select type —</option>
                                    @foreach($listingTypes as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('listing_type', $listingPackage->listing_type) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Package Tier <span class="text-danger">*</span>
                                </label>
                                <select name="package_tier" class="form-select" required>
                                    <option value="">— Select tier —</option>
                                    @foreach($packageTiers as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('package_tier', $listingPackage->package_tier) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Price Per Day (RWF) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="price_per_day" class="form-control"
                                        value="{{ old('price_per_day', $listingPackage->price_per_day) }}"
                                        min="1" required>
                                    <span class="input-group-text" style="font-size:.8rem">RWF/day</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Agent Commission % <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="agent_commission_pct" class="form-control"
                                        value="{{ old('agent_commission_pct', $listingPackage->agent_commission_pct) }}"
                                        min="0" max="100" step="0.01" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Terra Share % <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="terra_share_pct" class="form-control"
                                        value="{{ old('terra_share_pct', $listingPackage->terra_share_pct) }}"
                                        min="0" max="100" step="0.01" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Features --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Features</h6>
                    </div>
                    <div class="card-body p-4">
                        <label class="form-label fw-semibold" style="font-size:.85rem">
                            Feature List
                            <small class="text-muted fw-normal">(one feature per line)</small>
                        </label>
                        @php
                        $existingFeatures = is_array($listingPackage->features)
                        ? $listingPackage->features
                        : (json_decode($listingPackage->features, true) ?? []);
                        @endphp
                        <textarea name="features" class="form-control" rows="5">{{ old('features', implode("\n", $existingFeatures)) }}</textarea>
                        <div class="form-text">Each line will be saved as a separate feature item.</div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-lg-4">

                {{-- Status --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Status</h6>
                    </div>
                    <div class="card-body p-4">
                        {{-- Hidden fallback so unchecked submits 0 --}}
                        <input type="hidden" name="is_active" value="0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="is_active" {{ old('is_active', $listingPackage->is_active) ? 'checked' : '' }}
                                style="width:2.5rem;height:1.25rem;cursor:pointer">
                            <label class="form-check-label fw-semibold" for="is_active">
                                Active
                            </label>
                        </div>
                        <div class="form-text mt-2">Inactive packages won't appear in the listing registration form.</div>
                    </div>
                </div>

                {{-- Commission Preview --}}
                <div class="card border-0 shadow-sm" style="background:var(--terra-navy)">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color:var(--terra-gold)">Commission Preview</h6>
                        <div id="previewBox">
                            <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid rgba(255,255,255,.1)">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Daily Rate</span>
                                <span style="font-size:.82rem;color:#fff;font-weight:600" id="prev-rate">—</span>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid rgba(255,255,255,.1)">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Agent Gets</span>
                                <span style="font-size:.82rem;color:#5ddc8a;font-weight:600" id="prev-agent">—</span>
                            </div>
                            <div class="d-flex justify-content-between py-2">
                                <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Terra Gets</span>
                                <span style="font-size:.82rem;color:var(--terra-gold);font-weight:600" id="prev-terra">—</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex gap-2 mt-2">
            <button type="submit" class="btn px-4 py-2 btn btn-outline-secondary">
                Update Package
            </button>
            <a href="{{ route('admin.listing-packages.index') }}"
                class="btn btn-outline-secondary px-4 py-2">
                Cancel
            </a>
        </div>

    </form>
</div>

<script>
    const priceInput = document.querySelector('[name="price_per_day"]');
    const agentInput = document.querySelector('[name="agent_commission_pct"]');
    const terraInput = document.querySelector('[name="terra_share_pct"]');

    function updatePreview() {
        const price = parseFloat(priceInput.value);
        const agent = parseFloat(agentInput.value);
        const terra = parseFloat(terraInput.value);

        if (price > 0 && agent >= 0 && terra >= 0) {
            const agentAmt = Math.round(price * agent / 100);
            const terraAmt = Math.round(price * terra / 100);
            document.getElementById('prev-rate').textContent = price.toLocaleString() + ' RWF';
            document.getElementById('prev-agent').textContent = agentAmt.toLocaleString() + ' RWF';
            document.getElementById('prev-terra').textContent = terraAmt.toLocaleString() + ' RWF';
        }
    }

    agentInput.addEventListener('input', function() {
        if (this.value !== '') {
            terraInput.value = (100 - parseFloat(this.value)).toFixed(2);
        }
        updatePreview();
    });

    priceInput.addEventListener('input', updatePreview);
    terraInput.addEventListener('input', updatePreview);

    // Run on page load with existing values
    updatePreview();
</script>
@endsection