@extends('layouts.app')

@section('title', 'Edit Advertisement')

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

    /* Image preview grid */
    .img-grid     { display: flex; flex-wrap: wrap; gap: .75rem; margin-top: .75rem; }
    .img-thumb    { position: relative; width: 110px; height: 90px; border-radius: 8px; overflow: hidden; border: 1px solid #e5e8f0; }
    .img-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .img-thumb .remove-img {
        position: absolute; top: 4px; right: 4px;
        background: rgba(0,0,0,.55); color: #fff;
        border: none; border-radius: 50%; width: 22px; height: 22px;
        font-size: .75rem; line-height: 1; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .img-thumb .remove-img:hover { background: #D05208; }
    .img-thumb .img-label {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: rgba(0,0,0,.45); color: #fff;
        font-size: .65rem; text-align: center; padding: 2px 4px;
    }
</style>

<div class="container py-4" style="max-width:820px">

    <div class="d-flex align-items-center mb-4">
        <div>
            <h1 class="mb-0" style="font-family:'Cormorant Garamond',serif;color:#19265d;font-size:2rem;font-weight:700">
                Edit Advertisement
            </h1>
            <p class="text-muted mb-0">Update your listing details on Terra</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.advertisements.update', $advertisement) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- STEP 1: Package --}}
        <div class="ad-card">
            <div class="section-head"><span class="step-badge">1</span> Choose Package</div>
            <div class="row g-3">
                @forelse($packages as $pkg)
                <div class="col-md-4">
                    <label class="pkg-card d-block {{ (old('listing_package_id', $advertisement->listing_package_id) == $pkg->id) ? 'selected' : '' }}">
                        <input type="radio" name="listing_package_id" value="{{ $pkg->id }}"
                            {{ (old('listing_package_id', $advertisement->listing_package_id) == $pkg->id) ? 'checked' : '' }}
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
                        value="{{ old('listing_days', $advertisement->listing_days) }}" oninput="updateCost()">
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
                        <option value="house"  {{ old('advertisable_type', $currentAdvertisableType) == 'house'  ? 'selected' : '' }}>House</option>
                        <option value="land"   {{ old('advertisable_type', $currentAdvertisableType) == 'land'   ? 'selected' : '' }}>Land</option>
                        <option value="design" {{ old('advertisable_type', $currentAdvertisableType) == 'design' ? 'selected' : '' }}>Architectural Design</option>
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
                <input type="text" name="title" class="form-control"
                    value="{{ old('title', $advertisement->title) }}"
                    placeholder="e.g. Modern 3-Bedroom House in Kicukiro" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="5" required
                    placeholder="Describe what you're advertising...">{{ old('description', $advertisement->description) }}</textarea>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-control"
                        value="{{ old('contact_phone', $advertisement->contact_phone) }}"
                        placeholder="+250 7XX XXX XXX">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Email</label>
                    <input type="email" name="contact_email" class="form-control"
                        value="{{ old('contact_email', $advertisement->contact_email) }}"
                        placeholder="you@example.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Location</label>
                    <input type="text" name="location" class="form-control"
                        value="{{ old('location', $advertisement->location) }}"
                        placeholder="e.g. Kigali, Gasabo">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Asking Price (RWF)</label>
                    <input type="number" name="price_amount" class="form-control"
                        value="{{ old('price_amount', $advertisement->price_amount) }}"
                        placeholder="Leave blank if not applicable">
                </div>
            </div>
        </div>

        {{-- STEP 4: Images --}}
        <div class="ad-card">
            <div class="section-head"><span class="step-badge">4</span> Images</div>

            {{-- Existing images --}}
            @php $existingImages = $advertisement->images ?? []; @endphp
            @if(count($existingImages) > 0)
                <p class="fw-semibold text-muted small mb-1">Current Images — click <strong>×</strong> to remove</p>
                <div class="img-grid" id="existing-images-grid">
                    @foreach($existingImages as $index => $imgPath)
                    <div class="img-thumb" id="thumb-{{ $index }}">
                        <img src="{{ asset($imgPath) }}" alt="Ad image {{ $index + 1 }}">
                        <button type="button" class="remove-img" onclick="removeExistingImage({{ $index }}, '{{ $imgPath }}')" title="Remove image">×</button>
                        <span class="img-label">Image {{ $index + 1 }}</span>
                    </div>
                    @endforeach
                </div>
                {{-- Hidden inputs track which existing images to keep --}}
                <div id="keep-images-inputs">
                    @foreach($existingImages as $imgPath)
                        <input type="hidden" name="existing_images[]" value="{{ $imgPath }}" class="keep-img-input">
                    @endforeach
                </div>
            @endif

            {{-- New image upload --}}
            <div class="mt-3">
                <label class="form-label fw-semibold">Upload New Images</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*" onchange="previewNewImages(this)">
                <small class="text-muted">Upload up to 10 images total. Max 5MB each.</small>
                <div class="img-grid mt-2" id="new-images-preview"></div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('advertisements.show', $advertisement) }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-lg px-5" style="background:#D05208;color:#fff;border-radius:8px;font-weight:600">
                Save Changes →
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

// ── Cost calculator ──────────────────────────────────────────────────────────
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

// ── Property type filter ─────────────────────────────────────────────────────
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

// ── Remove existing image ────────────────────────────────────────────────────
function removeExistingImage(index, path) {
    // Hide the thumbnail
    const thumb = document.getElementById('thumb-' + index);
    if (thumb) thumb.style.display = 'none';

    // Remove the corresponding hidden keep input
    const inputs = document.querySelectorAll('.keep-img-input');
    inputs.forEach(input => {
        if (input.value === path) input.remove();
    });
}

// ── Preview newly selected images ────────────────────────────────────────────
function previewNewImages(input) {
    const preview = document.getElementById('new-images-preview');
    preview.innerHTML = '';
    Array.from(input.files).forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'img-thumb';
            div.innerHTML = `
                <img src="${e.target.result}" alt="New image ${i + 1}">
                <span class="img-label">New ${i + 1}</span>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

// ── Init on load ─────────────────────────────────────────────────────────────
const oldType = '{{ old('advertisable_type', $currentAdvertisableType) }}';
const oldId   = '{{ old('advertisable_id', $advertisement->advertisable_id) }}';

filterLinkedItems(oldType);
if (oldId) {
    document.getElementById('linked-item-select').value = oldId;
}
updateCost();
</script>

@endsection
