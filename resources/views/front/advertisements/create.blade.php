@extends('layouts.app')

@section('title', 'Create Advertisement — Terra')

@section('content')

<style>
.ad-create-hero { background: #051321; padding: 40px 0 30px; }
.ad-steps { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 28px; }
.ad-step { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 500; color: rgba(255,255,255,.4); }
.ad-step span { width: 28px; height: 28px; border-radius: 50%; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; }
.ad-step.active { color: #fff; }
.ad-step.active span { background: #00a667; color: #fff; }
.ad-step.done { color: rgba(255,255,255,.7); }
.ad-step.done span { background: #00a667; color: #fff; }
.ad-step-line { width: 40px; height: 2px; background: rgba(255,255,255,.15); }
.ad-step-line.done { background: #00a667; }

.ad-pkg-banner {
    display: flex; justify-content: space-between; align-items: center;
    background: rgba(0,166,103,.12); border: 1px solid rgba(0,166,103,.3);
    border-radius: 10px; padding: 14px 20px;
}
.ad-pkg-banner__name { font-weight: 700; color: #00a667; font-size: 16px; display: block; }
.ad-pkg-banner__details { font-size: 13px; color: rgba(255,255,255,.6); }
.ad-pkg-banner__price { font-size: 20px; font-weight: 800; color: #fff; }

.section-pad { padding: 60px 0; }
.container--narrow { max-width: 720px; }

.form-card {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
    padding: 28px 28px 20px; margin-bottom: 24px;
}
.form-card__title { font-size: 17px; font-weight: 700; color: #051321; margin-bottom: 6px; }
.form-card__hint { font-size: 13px; color: #9ca3af; margin-bottom: 20px; }
.optional { font-weight: 400; color: #9ca3af; font-size: 13px; }
.req { color: #ef4444; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
.form-control { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: border .2s; box-sizing: border-box; }
.form-control:focus { outline: none; border-color: #00a667; box-shadow: 0 0 0 3px rgba(0,166,103,.1); }
.is-invalid { border-color: #ef4444; }
.invalid-feedback { font-size: 12px; color: #ef4444; margin-top: 4px; display: block; }

.media-dropzone {
    border: 2px dashed #d1d5db; border-radius: 12px; padding: 28px;
    text-align: center; cursor: pointer; transition: border-color .2s, background .2s;
}
.media-dropzone:hover, .media-dropzone.dragover {
    border-color: #00a667; background: rgba(0,166,103,.03);
}
.media-dropzone__icon svg { width: 40px; height: 40px; color: #9ca3af; margin: 0 auto 12px; display: block; }
.media-dropzone__icon--video svg { color: #6366f1; }
.media-dropzone__prompt p { font-size: 15px; color: #374151; margin-bottom: 4px; }
.media-dropzone__prompt p button { background: none; border: none; color: #00a667; cursor: pointer; font-weight: 600; font-size: 15px; }
.media-dropzone__prompt span { font-size: 12px; color: #9ca3af; }

.media-preview { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 16px; justify-content: center; }
.media-preview__item { position: relative; width: 90px; height: 90px; border-radius: 8px; overflow: hidden; }
.media-preview__item img { width: 100%; height: 100%; object-fit: cover; }
.media-preview__remove {
    position: absolute; top: 4px; right: 4px; width: 20px; height: 20px;
    background: rgba(0,0,0,.6); color: #fff; border: none; border-radius: 50%;
    cursor: pointer; font-size: 11px; display: flex; align-items: center; justify-content: center;
}

.form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; }
.btn-ghost { background: none; border: none; color: #6b7280; font-size: 14px; cursor: pointer; text-decoration: none; }
.btn-ghost:hover { color: #051321; }
.btn-lg { padding: 14px 36px; font-size: 16px; border-radius: 10px; border: none; cursor: pointer; font-weight: 700; }
.btn-primary { background: #00a667; color: #fff; text-decoration: none; display: inline-block; }
.btn-primary:hover { background: #008f57; }

@media (max-width: 600px) {
    .form-row { grid-template-columns: 1fr; }
    .form-card { padding: 20px 16px; }
}
</style>

<section class="ad-create-hero">
    <div class="container">
        {{-- Progress --}}
        <div class="ad-steps">
            <div class="ad-step done"><span>1</span> Choose Package</div>
            <div class="ad-step-line done"></div>
            <div class="ad-step active"><span>2</span> Ad Details</div>
            <div class="ad-step-line"></div>
            <div class="ad-step"><span>3</span> Payment</div>
        </div>

        <div class="ad-pkg-banner">
            <div class="ad-pkg-banner__info">
                <span class="ad-pkg-banner__name">{{ $package->name }} Package</span>
                <span class="ad-pkg-banner__details">
                    {{ $package->duration_days }} days ·
                    Up to {{ $package->max_images }} images
                    @if($package->allows_video) · Video supported @endif
                </span>
            </div>
            <span class="ad-pkg-banner__price">{{ number_format($package->price) }} RWF</span>
        </div>
    </div>
</section>

<section class="ad-create section-pad">
    <div class="container container--narrow">
        <form action="{{ route('advertisements.store') }}" method="POST" enctype="multipart/form-data" id="adForm">
            @csrf
            <input type="hidden" name="advertisement_package_id" value="{{ $package->id }}">

            {{-- ── Link to existing listing (optional) ────────────────────── --}}
            <div class="form-card">
                <h3 class="form-card__title">Link an Existing Listing <span class="optional">(optional)</span></h3>
                <p class="form-card__hint">Connect this ad to one of your properties to auto-fill details. Or skip to create a standalone ad.</p>

                <div class="form-row">
                    <div class="form-group">
                        <label>Listing Type</label>
                        <select name="listing_type" id="listingType" class="form-control">
                            <option value="custom">No listing — standalone ad</option>
                            @if($houses->count())
                            <option value="house" {{ old('listing_type') === 'house' ? 'selected' : '' }}>House</option>
                            @endif
                            @if($lands->count())
                            <option value="land" {{ old('listing_type') === 'land' ? 'selected' : '' }}>Land</option>
                            @endif
                            @if($designs->count())
                            <option value="design" {{ old('listing_type') === 'design' ? 'selected' : '' }}>Architectural Design</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group" id="listingSelectWrap" style="display:none;">
                        <label>Select Your Listing</label>
                        <select name="listing_id" id="listingSelect" class="form-control">
                            <option value="">— choose —</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ── Ad Content ──────────────────────────────────────────────── --}}
            <div class="form-card">
                <h3 class="form-card__title">Ad Content</h3>

                <div class="form-group">
                    <label>Ad Title <span class="req">*</span></label>
                    <input type="text" name="title" id="adTitle" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" placeholder="e.g. Prime Plot for Sale in Kicukiro" maxlength="150">
                    @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Description <span class="req">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="5" placeholder="Describe the property — size, features, why it stands out..." maxlength="2000">{{ old('description') }}</textarea>
                    @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}"
                               placeholder="e.g. Kicukiro, Kigali">
                    </div>
                    <div class="form-group">
                        <label>Asking Price (RWF)</label>
                        <input type="number" name="price_amount" class="form-control" value="{{ old('price_amount') }}"
                               placeholder="e.g. 35000000" min="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', auth()->user()->phone ?? '') }}"
                               placeholder="07XXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', auth()->user()->email ?? '') }}"
                               placeholder="you@example.com">
                    </div>
                </div>
            </div>

            {{-- ── Media Upload ─────────────────────────────────────────────── --}}
            <div class="form-card">
                <h3 class="form-card__title">Media</h3>

                {{-- Images --}}
                <div class="form-group">
                    <label>Images <span class="req">*</span> <span class="optional">(up to {{ $package->max_images }}, max 5MB each)</span></label>
                    <div class="media-dropzone" id="imageDropzone">
                        <input type="file" name="images[]" id="imageInput" multiple accept="image/jpeg,image/png,image/webp"
                               style="display:none;">
                        <div class="media-dropzone__prompt" id="imagePrompt">
                            <div class="media-dropzone__icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p>Drop images here or <button type="button" onclick="document.getElementById('imageInput').click()">browse</button></p>
                            <span>JPG, PNG, WEBP — up to {{ $package->max_images }} files</span>
                        </div>
                        <div class="media-preview" id="imagePreviews"></div>
                    </div>
                    @error('images.*')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>

                {{-- Video (only if package allows) --}}
                @if($package->allows_video)
                <div class="form-group">
                    <label>Video <span class="optional">(optional — MP4, max 100MB)</span></label>
                    <div class="media-dropzone media-dropzone--video" id="videoDropzone">
                        <input type="file" name="video" id="videoInput" accept="video/mp4,video/quicktime"
                               style="display:none;">
                        <div class="media-dropzone__prompt" id="videoPrompt">
                            <div class="media-dropzone__icon media-dropzone__icon--video">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M15 10l4.553-2.276A1 1 0 0121 8.68v6.641a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p>Drop video here or <button type="button" onclick="document.getElementById('videoInput').click()">browse</button></p>
                            <span>MP4 — max 100MB · A walkthrough or aerial video gets more attention</span>
                        </div>
                        <div id="videoPreview"></div>
                    </div>
                    @error('video')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('advertisements.packages') }}" class="btn btn-ghost">← Back</a>
                <button type="submit" class="btn btn-primary btn-lg">
                    Continue to Payment →
                </button>
            </div>
        </form>
    </div>
</section>

<script>
// ── Listing type → populate listing select ────────────────────────────────
const listings = {
    house:  @json($houses->map(fn($h) => ['id' => $h->id, 'label' => $h->title . ' — ' . $h->location])),
    land:   @json($lands->map(fn($l)  => ['id' => $l->id, 'label' => $l->title . ' — ' . $l->location])),
    design: @json($designs->map(fn($d) => ['id' => $d->id, 'label' => $d->title . ' (' . $d->style . ')'])),
};

document.getElementById('listingType').addEventListener('change', function () {
    const wrap  = document.getElementById('listingSelectWrap');
    const sel   = document.getElementById('listingSelect');
    const items = listings[this.value] || [];

    if (! items.length) { wrap.style.display = 'none'; return; }

    sel.innerHTML = '<option value="">— choose —</option>';
    items.forEach(i => {
        const opt = document.createElement('option');
        opt.value = i.id;
        opt.textContent = i.label;
        sel.appendChild(opt);
    });
    wrap.style.display = 'block';
});

// Auto-fill title if listing selected
document.getElementById('listingSelect').addEventListener('change', function () {
    if (! this.value) return;
    const type = document.getElementById('listingType').value;
    const item = (listings[type] || []).find(i => String(i.id) === this.value);
    if (item) {
        const titleInput = document.getElementById('adTitle');
        if (! titleInput.value) titleInput.value = item.label.split(' — ')[0];
    }
});

// ── Image dropzone ────────────────────────────────────────────────────────
const maxImages = {{ $package->max_images }};
let selectedImages = [];

const imageInput    = document.getElementById('imageInput');
const imagePreviews = document.getElementById('imagePreviews');
const imagePrompt   = document.getElementById('imagePrompt');
const imageDropzone = document.getElementById('imageDropzone');

imageDropzone.addEventListener('click', (e) => {
    if (e.target.tagName !== 'BUTTON') return;
});
imageDropzone.addEventListener('dragover', (e) => { e.preventDefault(); imageDropzone.classList.add('dragover'); });
imageDropzone.addEventListener('dragleave', () => imageDropzone.classList.remove('dragover'));
imageDropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    imageDropzone.classList.remove('dragover');
    handleImageFiles(Array.from(e.dataTransfer.files));
});

imageInput.addEventListener('change', () => handleImageFiles(Array.from(imageInput.files)));

function handleImageFiles(files) {
    const toAdd = files.filter(f => f.type.startsWith('image/')).slice(0, maxImages - selectedImages.length);
    toAdd.forEach(file => {
        selectedImages.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            const item = document.createElement('div');
            item.className = 'media-preview__item';
            item.innerHTML = `<img src="${e.target.result}"><button type="button" class="media-preview__remove" data-name="${file.name}">✕</button>`;
            imagePreviews.appendChild(item);
        };
        reader.readAsDataURL(file);
    });
    syncImageInput();
    if (selectedImages.length > 0) imagePrompt.style.opacity = '.5';
}

imagePreviews.addEventListener('click', (e) => {
    if (! e.target.classList.contains('media-preview__remove')) return;
    const name = e.target.dataset.name;
    selectedImages = selectedImages.filter(f => f.name !== name);
    e.target.closest('.media-preview__item').remove();
    syncImageInput();
    if (selectedImages.length === 0) imagePrompt.style.opacity = '1';
});

function syncImageInput() {
    const dt = new DataTransfer();
    selectedImages.forEach(f => dt.items.add(f));
    imageInput.files = dt.files;
}

@if($package->allows_video)
// ── Video dropzone ────────────────────────────────────────────────────────
const videoInput   = document.getElementById('videoInput');
const videoPreview = document.getElementById('videoPreview');
const videoPrompt  = document.getElementById('videoPrompt');
const videoDropzone = document.getElementById('videoDropzone');

videoDropzone.addEventListener('dragover', (e) => { e.preventDefault(); videoDropzone.classList.add('dragover'); });
videoDropzone.addEventListener('dragleave', () => videoDropzone.classList.remove('dragover'));
videoDropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    videoDropzone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('video/')) handleVideo(file);
});

videoInput.addEventListener('change', () => {
    if (videoInput.files[0]) handleVideo(videoInput.files[0]);
});

function handleVideo(file) {
    videoPrompt.style.display = 'none';
    const url = URL.createObjectURL(file);
    videoPreview.innerHTML = `
        <video controls style="width:100%;border-radius:8px;margin-top:8px;" src="${url}"></video>
        <button type="button" onclick="clearVideo()" style="margin-top:8px;font-size:13px;color:#ef4444;background:none;border:none;cursor:pointer;">Remove video</button>`;
}

function clearVideo() {
    videoInput.value = '';
    videoPreview.innerHTML = '';
    videoPrompt.style.display = 'block';
}
@endif
</script>

@endsection
