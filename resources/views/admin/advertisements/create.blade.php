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

        <div class="ad-card">
    <div class="section-head">
        <span class="step-badge">5</span> Video
    </div>

    <div class="video-url-wrap">
        <span class="video-url-icon">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
            </svg>
        </span>
        <input
            type="url"
            name="video_path"
            id="videoUrlInput"
            class="form-control video-url-input @error('video_path') is-invalid @enderror"
            placeholder="https://youtube.com/watch?v=… or direct .mp4 URL"
            value="{{ old('video_path') }}"
            autocomplete="off"
        >
        <span class="video-url-status" id="videoUrlStatus"></span>
    </div>

    {{-- Live preview strip --}}
    <div class="video-preview" id="videoPreview" style="display:none;">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.172 13.828a4 4 0 015.656 0l4 4a4 4 0 01-5.656 5.656l-1.101-1.102"/>
        </svg>
        <span id="videoPreviewText"></span>
        <button type="button" class="video-clear-btn" id="videoClearBtn" title="Clear">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    @error('video_path')
        <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror

    <small class="text-muted d-block mt-1">
        Accepts YouTube, Vimeo, or a direct <code>.mp4</code> / <code>.webm</code> link.
    </small>
</div>

<style>
.video-url-wrap {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: .5rem;
}

.video-url-icon {
    position: absolute;
    left: .85rem;
    color: #7b849a;
    display: flex;
    pointer-events: none;
}

.video-url-input {
    padding-left: 2.6rem !important;
    padding-right: 2.4rem !important;
    transition: border-color .2s, box-shadow .2s;
}

.video-url-input.url-valid {
    border-color: #059669 !important;
    box-shadow: 0 0 0 3px rgba(5,150,105,.08) !important;
}

.video-url-input.url-invalid {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220,38,38,.08) !important;
}

.video-url-status {
    position: absolute;
    right: .85rem;
    font-size: .8rem;
    display: flex;
}

.video-preview {
    display: flex;
    align-items: center;
    gap: .45rem;
    padding: .45rem .75rem;
    background: rgba(200,135,58,.07);
    border: 1px solid rgba(200,135,58,.2);
    border-radius: 7px;
    font-size: .8rem;
    color: #C8873A;
    margin-bottom: .4rem;
    overflow: hidden;
}

#videoPreviewText {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 320px;
}

.video-clear-btn {
    background: none;
    border: none;
    color: #C8873A;
    cursor: pointer;
    padding: 0;
    opacity: .65;
    display: flex;
    transition: opacity .15s;
}

.video-clear-btn:hover { opacity: 1; }
</style>

<script>
(function () {
    var input   = document.getElementById('videoUrlInput');
    var status  = document.getElementById('videoUrlStatus');
    var preview = document.getElementById('videoPreview');
    var previewText = document.getElementById('videoPreviewText');
    var clearBtn    = document.getElementById('videoClearBtn');

    function isValidUrl(val) {
        try { new URL(val); return true; } catch { return false; }
    }

    function trimUrl(url) {
        try {
            var u = new URL(url);
            return u.hostname.replace('www.', '') + u.pathname.slice(0, 30) + (u.pathname.length > 30 ? '…' : '');
        } catch { return url.slice(0, 40); }
    }

    function evaluate() {
        var val = input.value.trim();
        input.classList.remove('url-valid', 'url-invalid');
        status.textContent = '';
        preview.style.display = 'none';

        if (!val) return;

        if (isValidUrl(val)) {
            input.classList.add('url-valid');
            status.textContent = '✓';
            status.style.color = '#059669';
            previewText.textContent = trimUrl(val);
            preview.style.display = 'flex';
        } else {
            input.classList.add('url-invalid');
            status.textContent = '✗';
            status.style.color = '#dc2626';
        }
    }

    input.addEventListener('input', evaluate);
    input.addEventListener('paste', function () { setTimeout(evaluate, 0); });

    clearBtn.addEventListener('click', function () {
        input.value = '';
        evaluate();
        input.focus();
    });

    // Evaluate on page load if old() value present
    if (input.value) evaluate();
})();
</script>

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

</script>

@endsection