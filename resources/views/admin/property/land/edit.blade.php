@extends('layouts.app')
@section('title', 'Edit Land — '.$land->title)
@section('content')

<style>
.le-topbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
.le-back-btn { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border:1.5px solid #e2e8f0; border-radius:8px; background:#fff; font-size:.81rem; font-weight:500; color:#475569; transition:all .18s; text-decoration:none; }
.le-back-btn:hover { border-color:#3b82f6; color:#2563eb; background:#eff6ff; }
.le-back-btn svg { width:14px; height:14px; }

.le-card { background:#fff; border:1px solid #e5e7eb; border-radius:12px; margin-bottom:16px; overflow:hidden; }
.le-card-head { padding:14px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
.le-card-icon { width:30px; height:30px; border-radius:7px; background:#eff6ff; border:1px solid #bfdbfe; display:grid; place-items:center; flex-shrink:0; }
.le-card-icon svg { width:14px; height:14px; color:#2563eb; }
.le-card-title { font-size:.88rem; font-weight:700; color:#1e293b; margin:0; }
.le-card-body { padding:20px; }

.le-label { font-size:.72rem; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:5px; display:block; }
.le-input { width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:.83rem; color:#1e293b; font-family:inherit; transition:border-color .18s, box-shadow .18s; background:#fafbfc; }
.le-input:focus { outline:none; border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); background:#fff; }
.le-input.is-invalid { border-color:#f87171; }
.le-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:32px; }
.le-textarea { resize:vertical; min-height:100px; }
.le-hint { font-size:.72rem; color:#94a3b8; margin-top:4px; }
.le-error { font-size:.72rem; color:#dc2626; margin-top:4px; }

.le-section-divider { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; padding:12px 0 8px; border-bottom:1px solid #f1f5f9; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
.le-section-divider::before { content:''; flex:1; height:1px; background:#f1f5f9; display:none; }

/* Image manager */
.le-img-grid { display:flex; flex-wrap:wrap; gap:10px; }
.le-img-item { position:relative; width:90px; height:72px; border-radius:8px; overflow:hidden; border:1px solid #e2e8f0; }
.le-img-item img { width:100%; height:100%; object-fit:cover; display:block; }
.le-img-del { position:absolute; top:3px; right:3px; width:20px; height:20px; border-radius:50%; background:rgba(220,38,38,.85); border:none; cursor:pointer; display:grid; place-items:center; }
.le-img-del svg { width:10px; height:10px; color:#fff; }
.le-img-dl { position:absolute; bottom:3px; right:3px; width:20px; height:20px; border-radius:50%; background:rgba(0,0,0,.55); display:grid; place-items:center; text-decoration:none; }
.le-img-dl svg { width:10px; height:10px; color:#fff; }

/* Upload drop zone */
.le-drop { border:2px dashed #e2e8f0; border-radius:10px; padding:20px; text-align:center; background:#fafbfc; cursor:pointer; transition:all .18s; }
.le-drop:hover, .le-drop.dragover { border-color:#3b82f6; background:#eff6ff; }
.le-drop svg { width:26px; height:26px; color:#94a3b8; margin-bottom:6px; }
.le-drop p { font-size:.8rem; color:#64748b; margin:0; }
.le-drop span { font-size:.72rem; color:#94a3b8; }
.le-upload-previews { display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }
.le-prev-thumb { position:relative; width:72px; height:58px; border-radius:7px; overflow:hidden; border:1px solid #e2e8f0; }
.le-prev-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.le-prev-rm { position:absolute; top:2px; right:2px; width:16px; height:16px; border-radius:50%; background:rgba(220,38,38,.85); border:none; cursor:pointer; display:grid; place-items:center; }
.le-prev-rm svg { width:9px; height:9px; color:#fff; }

.location-cascade select:disabled { background:#f8fafc; color:#94a3b8; }
</style>

{{-- Top bar --}}
<div class="le-topbar">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.properties.lands.show', $land->id) }}" class="le-back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to Details
        </a>
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="#">Property</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.properties.lands.index') }}">Lands</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.properties.lands.show', $land->id) }}">{{ Str::limit($land->title, 28) }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.properties.lands.show', $land->id) }}"
           class="btn btn-sm btn-outline-secondary">Discard</a>
        <button type="submit" form="land-edit-form" class="btn btn-sm btn-primary d-flex align-items-center gap-1">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
        </button>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show small mb-3" role="alert">
    <strong>Please fix the following errors:</strong>
    <ul class="mb-0 mt-1 ps-3">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show small mb-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form id="land-edit-form" method="POST" action="{{ route('admin.properties.lands.update', $land->id) }}">
@csrf
@method('PUT')

<div class="row g-3">

    {{-- ══ LEFT: Main fields ══ --}}
    <div class="col-xl-8">

        {{-- Basic info ── --}}
        <div class="le-card">
            <div class="le-card-head">
                <div class="le-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/></svg></div>
                <h6 class="le-card-title">Basic Information</h6>
            </div>
            <div class="le-card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="le-label">Property Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="le-input @error('title') is-invalid @enderror"
                               value="{{ old('title', $land->title) }}" placeholder="e.g. Prime Residential Plot in Kigali" required>
                        @error('title')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="le-label">UPI Number</label>
                        <input type="text" name="upi" class="le-input @error('upi') is-invalid @enderror"
                               value="{{ old('upi', $land->upi) }}" placeholder="e.g. 1/01/01/01/1234">
                        <p class="le-hint">Rwanda Land Authority parcel identifier</p>
                        @error('upi')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="le-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="le-input le-select @error('status') is-invalid @enderror" required>
                            @foreach(['active','pending','sold','inactive'] as $s)
                            <option value="{{ $s }}" {{ old('status', $land->status) === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="le-label">Description</label>
                        <textarea name="description" class="le-input le-textarea @error('description') is-invalid @enderror"
                                  placeholder="Describe the land — surroundings, access, features…">{{ old('description', $land->description) }}</textarea>
                        @error('description')<div class="le-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Location ── --}}
        <div class="le-card">
            <div class="le-card-head">
                <div class="le-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg></div>
                <h6 class="le-card-title">Location Details</h6>
            </div>
            <div class="le-card-body location-cascade">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="le-label">Province <span class="text-danger">*</span></label>
                        <select name="province" id="sel-province"
                                class="le-input le-select @error('province') is-invalid @enderror" required>
                            <option value="">Select Province</option>
                            @foreach(['Kigali City','Eastern Province','Western Province','Northern Province','Southern Province'] as $p)
                            <option value="{{ $p }}" {{ old('province', $land->province) === $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        @error('province')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="le-label">District <span class="text-danger">*</span></label>
                        <input type="text" name="district"
                               class="le-input @error('district') is-invalid @enderror"
                               value="{{ old('district', $land->district) }}"
                               placeholder="e.g. Gasabo" required>
                        @error('district')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="le-label">Sector <span class="text-danger">*</span></label>
                        <input type="text" name="sector"
                               class="le-input @error('sector') is-invalid @enderror"
                               value="{{ old('sector', $land->sector) }}"
                               placeholder="e.g. Remera" required>
                        @error('sector')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="le-label">Cell</label>
                        <input type="text" name="cell"
                               class="le-input @error('cell') is-invalid @enderror"
                               value="{{ old('cell', $land->cell) }}"
                               placeholder="e.g. Rukiri I">
                        @error('cell')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="le-label">Village</label>
                        <input type="text" name="village"
                               class="le-input @error('village') is-invalid @enderror"
                               value="{{ old('village', $land->village) }}"
                               placeholder="e.g. Nyabisindu">
                        @error('village')<div class="le-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Land specifications ── --}}
        <div class="le-card">
            <div class="le-card-head">
                <div class="le-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9V20.5l.16-.03L9 18.9l6 2.1 5.64-1.9V3.5z"/></svg></div>
                <h6 class="le-card-title">Land Specifications</h6>
            </div>
            <div class="le-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="le-label">Size (sqm) <span class="text-danger">*</span></label>
                        <input type="number" name="size_sqm" step="0.01" min="0"
                               class="le-input @error('size_sqm') is-invalid @enderror"
                               value="{{ old('size_sqm', $land->size_sqm) }}"
                               placeholder="e.g. 450" required>
                        @error('size_sqm')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="le-label">Zoning <span class="text-danger">*</span></label>
                        <select name="zoning" class="le-input le-select @error('zoning') is-invalid @enderror" required>
                            <option value="">Select Zoning</option>
                            @foreach(['R1','R2','R3','Commercial','Industrial','Agricultural'] as $z)
                            <option value="{{ $z }}" {{ old('zoning', $land->zoning) === $z ? 'selected' : '' }}>{{ $z }}</option>
                            @endforeach
                        </select>
                        @error('zoning')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="le-label">Land Use</label>
                        <select name="land_use" class="le-input le-select @error('land_use') is-invalid @enderror">
                            <option value="">Select Land Use</option>
                            @foreach(['Residential','Commercial','Agricultural','Industrial','Mixed Use','Recreational'] as $u)
                            <option value="{{ $u }}" {{ old('land_use', $land->land_use) === $u ? 'selected' : '' }}>{{ $u }}</option>
                            @endforeach
                        </select>
                        @error('land_use')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="le-label">Price (RWF) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.8rem;border-radius:9px 0 0 9px;border:1.5px solid #e2e8f0;background:#f8fafc">RWF</span>
                            <input type="number" name="price" step="0.01" min="0"
                                   class="le-input @error('price') is-invalid @enderror"
                                   style="border-radius:0 9px 9px 0;border-left:none"
                                   value="{{ old('price', $land->price) }}"
                                   placeholder="e.g. 5000000" required>
                        </div>
                        @error('price')<div class="le-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="le-label">Title Document</label>
                        <select name="title_document" class="le-input le-select @error('title_document') is-invalid @enderror">
                            <option value="">Select Document Type</option>
                            @foreach(['Freehold Title','Leasehold','Land Certificate','Occupation Permit'] as $d)
                            <option value="{{ $d }}" {{ old('title_document', $land->title_document ?? '') === $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                        @error('title_document')<div class="le-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /col-xl-8 --}}

    {{-- ══ RIGHT: Sidebar ══ --}}
    <div class="col-xl-4">
        <div class="position-sticky" style="top:24px">

            {{-- Current images ── --}}
            <div class="le-card">
                <div class="le-card-head">
                    <div class="le-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg></div>
                    <h6 class="le-card-title">Current Photos</h6>
                    <span class="badge bg-secondary ms-auto">{{ $land->images->count() }}</span>
                </div>
                <div class="le-card-body">
                    @if($land->images->count())
                    <div class="le-img-grid mb-3">
                        @foreach($land->images as $img)
                        <div class="le-img-item" id="img-{{ $img->id }}">
                            <img src="{{ asset('storage/'.$img->image_path) }}" alt="Land photo">
                            <a href="{{ asset('storage/'.$img->image_path) }}" download class="le-img-dl" title="Download">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
                            </a>
                            <button type="button" class="le-img-del" title="Delete"
                                    onclick="deleteImage({{ $img->id }}, this)">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted small text-center py-2 mb-3">No photos uploaded yet.</p>
                    @endif

                    {{-- Upload new photos ── --}}
                    <p class="le-label mb-2">Add More Photos</p>
                    <div class="le-drop" id="le-drop" onclick="document.getElementById('new-photos').click()">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.35 10.04A7.49 7.49 0 0012 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 000 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                        <p><b>Click to upload</b> or drag & drop</p>
                        <span>JPEG, PNG, WEBP · Max 5MB each</span>
                        <input type="file" id="new-photos" name="new_images[]" multiple accept="image/*" style="display:none">
                    </div>
                    <div class="le-upload-previews" id="le-previews"></div>
                </div>
            </div>

            {{-- Summary ── --}}
            <div class="le-card">
                <div class="le-card-head">
                    <div class="le-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg></div>
                    <h6 class="le-card-title">Current Values</h6>
                </div>
                <div class="le-card-body">
                    <div style="font-size:.8rem;display:flex;flex-direction:column;gap:8px">
                        <div class="d-flex justify-content-between"><span class="text-muted">UPI</span><span class="fw-600">{{ $land->upi ?? '—' }}</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">District</span><span class="fw-600">{{ $land->district }}</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Size</span><span class="fw-600">{{ number_format($land->size_sqm) }} sqm</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Zoning</span><span class="fw-600">{{ $land->zoning }}</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Price</span><span class="fw-600 text-primary">{{ number_format($land->price) }} RWF</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Status</span>
                            <span class="badge {{ match($land->status) { 'active'=>'bg-success','pending'=>'bg-warning text-dark','sold'=>'bg-primary',default=>'bg-danger' } }}">
                                {{ ucfirst($land->status) }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Last updated</span><span class="fw-600">{{ $land->updated_at->format('d M Y') }}</span></div>
                    </div>
                </div>
            </div>

            {{-- Save ── --}}
            <div class="d-flex flex-column gap-2">
                <button type="submit" form="land-edit-form" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.properties.lands.show', $land->id) }}"
                   class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    Discard &amp; Go Back
                </a>
            </div>

        </div>
    </div>

</div>{{-- /row --}}
</form>

{{-- Upload new photos (separate form, fires immediately) --}}
<form id="upload-form" method="POST"
      action="{{ route('admin.properties.lands.images.upload', $land->id) }}"
      enctype="multipart/form-data" style="display:none">
    @csrf
    <input type="file" name="images[]" id="upload-proxy" multiple accept="image/*">
</form>

<script>
/* ── Image delete (AJAX) ── */
window.deleteImage = function (id, btn) {
    if (!confirm('Remove this photo?')) return;
    btn.disabled = true;

    fetch('{{ url("admin/properties/lands") }}/' + {{ $land->id }} + '/images/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            const el = document.getElementById('img-' + id);
            if (el) el.remove();
        } else {
            alert('Could not delete image.'); btn.disabled = false;
        }
    })
    .catch(() => { alert('Error deleting image.'); btn.disabled = false; });
};

/* ── New photo previews ── */
const photoInput = document.getElementById('new-photos');
const previewsEl = document.getElementById('le-previews');
let newFiles = [];

function renderPreviews() {
    previewsEl.innerHTML = '';
    newFiles.forEach((f, i) => {
        const url  = URL.createObjectURL(f);
        const wrap = document.createElement('div');
        wrap.className = 'le-prev-thumb';
        wrap.innerHTML = `<img src="${url}"><button type="button" class="le-prev-rm" data-i="${i}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>`;
        previewsEl.appendChild(wrap);
    });
}

if (photoInput) {
    photoInput.addEventListener('change', e => {
        newFiles = [...newFiles, ...Array.from(e.target.files)];
        renderPreviews();
        /* Auto-upload on select */
        if (newFiles.length) uploadNewPhotos();
    });
}

previewsEl.addEventListener('click', e => {
    const btn = e.target.closest('[data-i]');
    if (btn) { newFiles.splice(+btn.dataset.i, 1); renderPreviews(); }
});

/* Drag & drop */
const dropEl = document.getElementById('le-drop');
if (dropEl) {
    dropEl.addEventListener('dragover',  e => { e.preventDefault(); dropEl.classList.add('dragover'); });
    dropEl.addEventListener('dragleave', ()=> dropEl.classList.remove('dragover'));
    dropEl.addEventListener('drop', e => {
        e.preventDefault(); dropEl.classList.remove('dragover');
        newFiles = [...newFiles, ...Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'))];
        renderPreviews();
        if (newFiles.length) uploadNewPhotos();
    });
}

function uploadNewPhotos() {
    const fd = new FormData();
    fd.append('_token', '{{ csrf_token() }}');
    newFiles.forEach(f => fd.append('images[]', f));

    fetch('{{ route("admin.properties.lands.images.upload", $land->id) }}', {
        method: 'POST', body: fd
    }).then(r => {
        if (r.ok) {
            /* Reload gallery section without full page refresh */
            window.location.reload();
        }
    }).catch(() => alert('Upload failed. Please try again.'));
}
</script>

@endsection