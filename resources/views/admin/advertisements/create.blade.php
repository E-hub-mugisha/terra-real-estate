@extends('layouts.app')

@section('title', 'Create Advertisement')

@section('content')

<style>
    @@keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    .ad-card      { animation: fadeIn .3s ease; background: #fff; border-radius: 12px; border: 1px solid #e5e8f0; padding: 2rem; margin-bottom: 1.5rem; }
    .section-head { font-family: 'Cormorant Garamond', serif; color: #19265d; font-size: 1.25rem; font-weight: 700; border-bottom: 2px solid #f0f2f8; padding-bottom: .5rem; margin-bottom: 1.25rem; }
    .pkg-card     { border: 2px solid #e5e8f0; border-radius: 10px; padding: 1.25rem; cursor: pointer; transition: all .2s; }
    .pkg-card:hover, .pkg-card.selected { border-color: #D05208; background: #fff8f5; }
    .pkg-card input[type=radio] { display: none; }
    .pkg-price    { font-size: 1.4rem; font-weight: 700; color: #D05208; }
    .pkg-name     { font-weight: 600; color: #19265d; }
    .step-badge   { background: #19265d; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 700; margin-right: .5rem; }
    .cost-box     { background: #f8f9ff; border: 1px solid #d0d5e8; border-radius: 8px; padding: 1rem 1.25rem; }
</style>


<div class="container py-4" style="max-width:820px">

    <div class="d-flex align-items-center mb-4">
        <div>
            <h1 class="mb-0" style="font-family:'Cormorant Garamond',serif;color:#19265d;font-size:2rem;font-weight:700">
                Create Advertisement
            </h1>
            <p class="text-muted mb-0">Promote your property or service on Terra</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('advertisements.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- STEP 1: Package --}}
        <div class="ad-card">
            <div class="section-head"><span class="step-badge">1</span> Choose Package</div>
            <div class="row g-3">
                @forelse($packages as $pkg)
                <div class="col-md-4">
                    <label class="pkg-card d-block {{ old('listing_package_id') == $pkg->id ? 'selected' : '' }}">
                        <input type="radio" name="listing_package_id" value="{{ $pkg->id }}"
                            {{ old('listing_package_id') == $pkg->id ? 'checked' : '' }}
                            onchange="updateCost(); this.closest('.row').querySelectorAll('.pkg-card').forEach(c=>c.classList.remove('selected')); this.closest('.pkg-card').classList.add('selected')">
                        <div class="pkg-name">{{ $pkg->tier_label }}</div>
                        <div class="pkg-price mt-1">{{ $pkg->formatted_price }}</div>
                        @if($pkg->features)
                        <ul class="mt-2 mb-0 ps-3 small text-muted">
                            @foreach($pkg->features as $f)
                                <li>{{ $f }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </label>
                </div>
                @empty
                <p class="text-muted">No advertisement packages available. Please contact admin.</p>
                @endforelse
            </div>

            <div class="mt-3 row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Listing Duration (days)</label>
                    <input type="number" name="listing_days" class="form-control" min="1" max="365"
                        value="{{ old('listing_days', 30) }}" oninput="updateCost()">
                </div>
                <div class="col-md-8">
                    <div class="cost-box">
                        <span class="text-muted small">Estimated Total</span>
                        <div id="cost-display" style="font-size:1.3rem;font-weight:700;color:#D05208">— RWF</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 2: Link Property (optional) --}}
        <div class="ad-card">
            <div class="section-head"><span class="step-badge">2</span> Link a Property <span class="text-muted fw-normal" style="font-size:.9rem">(optional)</span></div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Property Type</label>
                    <select name="advertisable_type" class="form-select" onchange="filterLinkedItems(this.value)">
                        <option value="">— None —</option>
                        <option value="house"  {{ old('advertisable_type') == 'house'  ? 'selected' : '' }}>House</option>
                        <option value="land"   {{ old('advertisable_type') == 'land'   ? 'selected' : '' }}>Land</option>
                        <option value="design" {{ old('advertisable_type') == 'design' ? 'selected' : '' }}>Architectural Design</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Select Property</label>
                    <select name="advertisable_id" id="linked-item-select" class="form-select">
                        <option value="">— Select type first —</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- STEP 3: Ad Details --}}
        <div class="ad-card">
            <div class="section-head"><span class="step-badge">3</span> Ad Details</div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Ad Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Modern 3-Bedroom House in Kicukiro" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="5" required placeholder="Describe what you're advertising...">{{ old('description') }}</textarea>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}" placeholder="+250 7XX XXX XXX">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Email</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email') }}" placeholder="you@example.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="e.g. Kigali, Gasabo">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Asking Price (RWF)</label>
                    <input type="number" name="price_amount" class="form-control" value="{{ old('price_amount') }}" placeholder="Leave blank if not applicable">
                </div>
            </div>
        </div>

        {{-- STEP 4: Images --}}
        <div class="ad-card">
            <div class="section-head"><span class="step-badge">4</span> Images</div>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            <small class="text-muted">Upload up to 10 images. Max 5MB each.</small>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('advertisements.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-lg px-5" style="background:#D05208;color:#fff;border-radius:8px;font-weight:600">
                Save & Continue to Payment →
            </button>
        </div>
    </form>
</div>

<script>
const packages = @json($packages->map(fn($p) => ['id'=>$p->id,'price_per_day'=>$p->price_per_day]));
const properties = {
    house:  @json($houses->map(fn($h)  => ['id'=>$h->id,'title'=>$h->title])),
    land:   @json($lands->map(fn($l)   => ['id'=>$l->id,'title'=>$l->title])),
    design: @json($designs->map(fn($d) => ['id'=>$d->id,'title'=>$d->title])),
};

function updateCost() {
    const pkgId = document.querySelector('input[name=listing_package_id]:checked')?.value;
    const days  = parseInt(document.querySelector('input[name=listing_days]')?.value) || 0;
    const pkg   = packages.find(p => p.id == pkgId);
    const el    = document.getElementById('cost-display');
    if (pkg && days) {
        el.textContent = (pkg.price_per_day * days).toLocaleString() + ' RWF';
    } else {
        el.textContent = '— RWF';
    }
}

function filterLinkedItems(type) {
    const sel = document.getElementById('linked-item-select');
    sel.innerHTML = '<option value="">— Select —</option>';
    if (!type || !properties[type]) return;
    properties[type].forEach(item => {
        const o = document.createElement('option');
        o.value = item.id; o.textContent = item.title;
        sel.appendChild(o);
    });
}

// Restore on validation fail
filterLinkedItems('{{ old('advertisable_type') }}');
document.getElementById('linked-item-select').value = '{{ old('advertisable_id') }}';
updateCost();
</script>

@endsection