@extends('layouts.app')

@section('title', 'Edit – ' . $advertisement->title)

@section('content')
<style>
    :root {
        --navy:   #19265d;
        --gold:   #C8873A;
        --gold-lt:#e0a55e;
        --cream:  #f9f6f1;
        --ink:    #1a1a2e;
        --muted:  #6b7280;
        --border: rgba(200,135,58,.18);
        --card-bg:#ffffff;
        --shadow: 0 2px 16px rgba(25,38,93,.08);
        --error:  #dc2626;
    }

    /* ── Header ──────────────────────────────────────────────── */
    .form-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .form-header-left .breadcrumb-label {
        font-family: 'DM Sans', sans-serif;
        font-size: .7rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: .3rem;
    }

    .form-header-left h1 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.9rem;
        font-weight: 600;
        color: var(--navy);
        margin: 0;
    }

    /* ── Form layout ─────────────────────────────────────────── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 860px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    /* ── Section card ────────────────────────────────────────── */
    .section-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        margin-bottom: 1.25rem;
    }

    .section-card:last-child { margin-bottom: 0; }

    .section-title {
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--gold);
        font-weight: 600;
        margin-bottom: 1.1rem;
        padding-bottom: .6rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* ── Form fields ─────────────────────────────────────────── */
    .field-group {
        margin-bottom: 1.1rem;
    }

    .field-group:last-child { margin-bottom: 0; }

    .field-group label {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--navy);
        margin-bottom: .4rem;
    }

    .field-group label .req { color: var(--gold); margin-left: .15rem; }

    .field-group input[type="text"],
    .field-group input[type="email"],
    .field-group input[type="number"],
    .field-group input[type="tel"],
    .field-group select,
    .field-group textarea {
        width: 100%;
        font-family: 'DM Sans', sans-serif;
        font-size: .875rem;
        color: var(--ink);
        border: 1px solid rgba(25,38,93,.18);
        border-radius: 7px;
        padding: .6rem .85rem;
        background: var(--cream);
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
    }

    .field-group input:focus,
    .field-group select:focus,
    .field-group textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(200,135,58,.1);
    }

    .field-group textarea { resize: vertical; min-height: 100px; }

    .field-group .field-hint {
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        color: var(--muted);
        margin-top: .3rem;
    }

    .field-group .error-msg {
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        color: var(--error);
        margin-top: .3rem;
    }

    .field-group input.is-invalid,
    .field-group select.is-invalid,
    .field-group textarea.is-invalid {
        border-color: var(--error);
    }

    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 600px) { .two-col { grid-template-columns: 1fr; } }

    /* ── Existing images ─────────────────────────────────────── */
    .existing-images {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem;
        margin-bottom: .75rem;
    }

    .img-chip {
        position: relative;
        width: 80px; height: 80px;
        border-radius: 7px;
        overflow: hidden;
        border: 1px solid var(--border);
        flex-shrink: 0;
    }

    .img-chip img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }

    .img-chip .img-remove {
        position: absolute;
        top: 3px; right: 3px;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: rgba(220,38,38,.85);
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: .65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .15s;
    }

    .img-chip .img-remove:hover { background: #b91c1c; }
    .img-chip.removed { opacity: .35; }
    .img-chip.removed .img-remove { background: #6b7280; }

    /* ── Upload zone ─────────────────────────────────────────── */
    .upload-zone {
        border: 2px dashed rgba(200,135,58,.35);
        border-radius: 8px;
        padding: 1.2rem 1rem;
        text-align: center;
        background: rgba(200,135,58,.03);
        cursor: pointer;
        transition: border-color .2s, background .2s;
        position: relative;
    }

    .upload-zone:hover { border-color: var(--gold); background: rgba(200,135,58,.06); }

    .upload-zone input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer;
        width: 100%; height: 100%;
    }

    .upload-zone p {
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        color: var(--muted);
        margin: 0;
    }

    #new-preview {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        margin-top: .65rem;
    }

    #new-preview img {
        width: 72px; height: 72px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--border);
    }

    /* ── Buttons ─────────────────────────────────────────────── */
    .btn-terra {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 600;
        letter-spacing: .05em;
        padding: .65rem 1.5rem;
        border-radius: 8px;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: all .18s;
    }

    .btn-terra.primary { background: var(--gold); color: #fff; }
    .btn-terra.primary:hover { background: #b5752e; color: #fff; transform: translateY(-1px); }
    .btn-terra.outline { background: transparent; border-color: var(--navy); color: var(--navy); }
    .btn-terra.outline:hover { background: var(--navy); color: #fff; }
    .btn-terra.danger { background: transparent; border-color: var(--error); color: var(--error); }
    .btn-terra.danger:hover { background: var(--error); color: #fff; }

    /* ── Package cards ───────────────────────────────────────── */
    .pkg-cards { display: flex; flex-direction: column; gap: .6rem; }

    .pkg-card {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .8rem 1rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        cursor: pointer;
        transition: all .18s;
        background: var(--cream);
    }

    .pkg-card:hover { border-color: var(--gold); }

    .pkg-card input[type="radio"] {
        accent-color: var(--gold);
        width: 16px; height: 16px;
        flex-shrink: 0;
    }

    .pkg-card:has(input:checked) {
        border-color: var(--gold);
        background: rgba(200,135,58,.06);
    }

    .pkg-card .pkg-info .pkg-name {
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        font-weight: 600;
        color: var(--navy);
    }

    .pkg-card .pkg-info .pkg-price {
        font-family: 'DM Sans', sans-serif;
        font-size: .75rem;
        color: var(--gold);
    }

    /* ── Cost preview ────────────────────────────────────────── */
    .cost-preview {
        background: var(--navy);
        color: #fff;
        border-radius: 8px;
        padding: 1rem 1.1rem;
        margin-top: .75rem;
        font-family: 'DM Sans', sans-serif;
    }

    .cost-preview .cost-row {
        display: flex;
        justify-content: space-between;
        font-size: .82rem;
        padding: .2rem 0;
        color: rgba(255,255,255,.7);
    }

    .cost-preview .cost-total {
        display: flex;
        justify-content: space-between;
        font-size: 1rem;
        font-weight: 700;
        padding-top: .5rem;
        margin-top: .4rem;
        border-top: 1px solid rgba(255,255,255,.15);
        color: var(--gold-lt);
    }

    /* ── Change log strip ────────────────────────────────────── */
    .change-strip {
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: .75rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .78rem;
        color: var(--muted);
        margin-bottom: .75rem;
    }
</style>

<div class="container-fluid py-4 px-4">

    {{-- Header --}}
    <div class="form-header">
        <div class="form-header-left">
            <div class="breadcrumb-label">
                <a href="{{ route('admin.advertisements.index') }}"
                   style="color:var(--gold);text-decoration:none;">Advertisements</a>
                &rsaquo;
                <a href="{{ route('admin.advertisements.show', $advertisement) }}"
                   style="color:var(--gold);text-decoration:none;">{{ Str::limit($advertisement->title, 30) }}</a>
                &rsaquo; Edit
            </div>
            <h1>Edit Advertisement</h1>
        </div>
        <div style="display:flex;gap:.6rem;align-items:center;">
            <a href="{{ route('admin.advertisements.show', $advertisement) }}" class="btn-terra outline">
                <i class="bi bi-eye"></i> View
            </a>
            <form method="POST"
                  action="{{ route('admin.advertisements.destroy', $advertisement) }}"
                  onsubmit="return confirm('Delete this advertisement permanently?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-terra danger">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Change strip --}}
    <div class="change-strip">
        <strong style="color:var(--navy);">Last updated:</strong>
        {{ $advertisement->updated_at->format('d M Y, H:i') }}
        @if($advertisement->confirmedBy)
            &nbsp;·&nbsp; <strong style="color:var(--navy);">Confirmed by:</strong>
            {{ $advertisement->confirmedBy->name }}
        @endif
    </div>

    <form
        method="POST"
        action="{{ route('admin.advertisements.update', $advertisement) }}"
        enctype="multipart/form-data"
        id="ad-form"
    >
        @csrf @method('PUT')

        {{-- Pass removed images as hidden inputs (populated by JS) --}}
        <div id="removed-inputs-container"></div>

        <div class="form-grid">

            {{-- ── LEFT ─────────────────────────────────────────── --}}
            <div>

                {{-- Core info --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-file-text"></i> Core Information</div>

                    <div class="field-group">
                        <label>Title <span class="req">*</span></label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $advertisement->title) }}"
                            class="{{ $errors->has('title') ? 'is-invalid' : '' }}"
                            required
                        >
                        @error('title') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label>Description <span class="req">*</span></label>
                        <textarea
                            name="description"
                            class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                            required
                        >{{ old('description', $advertisement->description) }}</textarea>
                        @error('description') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label>Location</label>
                        <input
                            type="text"
                            name="location"
                            value="{{ old('location', $advertisement->location) }}"
                        >
                    </div>

                    <div class="two-col">
                        <div class="field-group">
                            <label>Price Amount</label>
                            <input
                                type="number"
                                name="price_amount"
                                value="{{ old('price_amount', $advertisement->price_amount) }}"
                                min="0"
                            >
                        </div>
                        <div class="field-group">
                            <label>Currency</label>
                            <select name="currency">
                                <option value="RWF" @selected(old('currency', $advertisement->currency) === 'RWF')>RWF</option>
                                <option value="USD" @selected(old('currency', $advertisement->currency) === 'USD')>USD</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Contact --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-telephone"></i> Contact Details</div>

                    <div class="two-col">
                        <div class="field-group">
                            <label>Phone <span class="req">*</span></label>
                            <input
                                type="tel"
                                name="contact_phone"
                                value="{{ old('contact_phone', $advertisement->contact_phone) }}"
                                class="{{ $errors->has('contact_phone') ? 'is-invalid' : '' }}"
                                required
                            >
                            @error('contact_phone') <p class="error-msg">{{ $message }}</p> @enderror
                        </div>
                        <div class="field-group">
                            <label>Email</label>
                            <input
                                type="email"
                                name="contact_email"
                                value="{{ old('contact_email', $advertisement->contact_email) }}"
                            >
                        </div>
                    </div>
                </div>

                {{-- Media --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-images"></i> Media</div>

                    {{-- Existing images --}}
                    @if(!empty($advertisement->images) && count($advertisement->images))
                    <div class="field-group">
                        <label>Existing Images</label>
                        <p class="field-hint" style="margin-bottom:.5rem;">
                            Click the &times; button to mark an image for removal.
                        </p>
                        <div class="existing-images" id="existing-images">
                            @foreach($advertisement->images as $i => $img)
                            <div class="img-chip" id="chip-{{ $i }}" data-index="{{ $i }}">
                                <img src="{{ asset($img) }}" alt="">
                                <button
                                    type="button"
                                    class="img-remove"
                                    onclick="removeImage({{ $i }}, '{{ $img }}')"
                                    title="Remove">
                                    &times;
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- New images --}}
                    <div class="field-group">
                        <label>Add New Images</label>
                        <div class="upload-zone">
                            <input
                                type="file"
                                name="images[]"
                                id="image-input"
                                accept="image/*"
                                multiple
                            >
                            <p><strong>Click to upload</strong> or drag &amp; drop</p>
                            <p style="margin-top:.2rem;">PNG, JPG, WEBP · Max 2 MB each</p>
                        </div>
                        <div id="new-preview"></div>
                        @error('images.*') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    {{-- Video --}}
                    <div class="field-group" style="margin-bottom:0;">
                        <label>Video</label>
                        @if($advertisement->video_path)
                            <div style="margin-bottom:.6rem;">
                                <video
                                    src="{{ asset($advertisement->video_path) }}"
                                    controls
                                    style="width:100%;border-radius:7px;max-height:200px;background:#000;"
                                ></video>
                                <p class="field-hint">
                                    Upload a new file below to replace the current video.
                                </p>
                            </div>
                        @endif
                        <input
                            type="file"
                            name="video"
                            accept="video/*"
                            style="background:var(--cream);border:1px solid rgba(25,38,93,.18);border-radius:7px;padding:.5rem .85rem;width:100%;"
                        >
                        @error('video') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Payment --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-phone"></i> MoMo Payment</div>

                    <div class="two-col">
                        <div class="field-group">
                            <label>MoMo Phone</label>
                            <input
                                type="tel"
                                name="momo_phone"
                                value="{{ old('momo_phone', $advertisement->momo_phone) }}"
                            >
                        </div>
                        <div class="field-group">
                            <label>Transaction ID</label>
                            <input
                                type="text"
                                name="momo_transaction_id"
                                value="{{ old('momo_transaction_id', $advertisement->momo_transaction_id) }}"
                            >
                        </div>
                    </div>

                    <div class="two-col">
                        <div class="field-group">
                            <label>Payment Status</label>
                            <select name="payment_status">
                                @foreach(['pending','confirmed','rejected'] as $ps)
                                    <option value="{{ $ps }}"
                                        @selected(old('payment_status', $advertisement->payment_status) === $ps)>
                                        {{ ucfirst($ps) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group">
                            <label>Ad Status</label>
                            <select name="status">
                                @foreach(['draft','pending_review','active','paused','expired','rejected'] as $s)
                                    <option value="{{ $s }}"
                                        @selected(old('status', $advertisement->status) === $s)>
                                        {{ ucfirst(str_replace('_',' ',$s)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Admin notes --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-sticky"></i> Admin Notes</div>
                    <div class="field-group" style="margin-bottom:0;">
                        <textarea
                            name="admin_notes"
                            style="min-height:70px;"
                        >{{ old('admin_notes', $advertisement->admin_notes) }}</textarea>
                    </div>
                </div>

            </div>

            {{-- ── RIGHT ────────────────────────────────────────── --}}
            <div>

                {{-- Owner --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-person"></i> Owner</div>
                    <div class="field-group" style="margin-bottom:0;">
                        <label>User <span class="req">*</span></label>
                        <select name="user_id"
                                class="{{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                required>
                            <option value="">— Select user —</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    @selected(old('user_id', $advertisement->user_id) == $user->id)>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Package --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-box"></i> Package</div>

                    <div class="pkg-cards">
                        @foreach($packages as $pkg)
                        <label class="pkg-card">
                            <input
                                type="radio"
                                name="listing_package_id"
                                value="{{ $pkg->id }}"
                                data-price="{{ $pkg->price_per_day }}"
                                @checked(old('listing_package_id', $advertisement->listing_package_id) == $pkg->id)
                            >
                            <div class="pkg-info">
                                <div class="pkg-name">{{ $pkg->name }}</div>
                                <div class="pkg-price">
                                    {{ number_format($pkg->price_per_day) }} RWF / day
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    @error('listing_package_id')
                        <p class="error-msg" style="margin-top:.5rem;">{{ $message }}</p>
                    @enderror

                    <div class="field-group" style="margin-top:1rem;">
                        <label>Duration (days) <span class="req">*</span></label>
                        <input
                            type="number"
                            name="listing_days"
                            id="listing-days"
                            value="{{ old('listing_days', $advertisement->listing_days) }}"
                            min="1"
                            max="365"
                            class="{{ $errors->has('listing_days') ? 'is-invalid' : '' }}"
                            required
                        >
                        @error('listing_days') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    {{-- Live cost preview --}}
                    <div class="cost-preview" id="cost-preview">
                        <div class="cost-row">
                            <span>Package rate</span>
                            <span id="cp-rate">—</span>
                        </div>
                        <div class="cost-row">
                            <span>Duration</span>
                            <span id="cp-days">—</span>
                        </div>
                        <div class="cost-total">
                            <span>Total</span>
                            <span id="cp-total">—</span>
                        </div>
                    </div>
                </div>

                {{-- Performance (read-only) --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-bar-chart-line"></i> Performance</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;text-align:center;">
                        @foreach([['Impressions', number_format($advertisement->impressions)], ['Clicks', number_format($advertisement->clicks)]] as [$label, $val])
                        <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.9rem;">
                            <div style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.5rem;font-weight:700;color:var(--navy);line-height:1;">
                                {{ $val }}
                            </div>
                            <div style="font-family:'DM Sans',sans-serif;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-top:.2rem;">
                                {{ $label }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Submit --}}
                <div class="section-card">
                    <div style="display:flex;gap:.75rem;flex-direction:column;">
                        <button type="submit" class="btn-terra primary" style="width:100%;justify-content:center;">
                            <i class="bi bi-floppy"></i> Save Changes
                        </button>
                        <a href="{{ route('admin.advertisements.show', $advertisement) }}"
                           class="btn-terra outline"
                           style="width:100%;justify-content:center;">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>

<script>
    // Image removal
    const removedImages = [];

    function removeImage(index, path) {
        const chip = document.getElementById('chip-' + index);
        if (!chip) return;

        const alreadyRemoved = removedImages.includes(path);

        if (alreadyRemoved) {
            // Undo removal
            removedImages.splice(removedImages.indexOf(path), 1);
            chip.classList.remove('removed');
            chip.querySelector('.img-remove').title = 'Remove';
        } else {
            // Mark for removal
            removedImages.push(path);
            chip.classList.add('removed');
            chip.querySelector('.img-remove').title = 'Undo removal';
        }

        // Sync hidden inputs
        const container = document.getElementById('removed-inputs-container');
        container.innerHTML = '';
        removedImages.forEach(p => {
            const input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = 'remove_images[]';
            input.value = p;
            container.appendChild(input);
        });
    }

    // New image preview
    document.getElementById('image-input')?.addEventListener('change', function () {
        const preview = document.getElementById('new-preview');
        preview.innerHTML = '';
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // Live cost calculator
    function recalc() {
        const radio = document.querySelector('input[name="listing_package_id"]:checked');
        const days  = parseInt(document.getElementById('listing-days')?.value) || 0;
        const preview = document.getElementById('cost-preview');
        if (!radio || !days) return;

        const rate  = parseInt(radio.dataset.price) || 0;
        const total = rate * days;

        document.getElementById('cp-rate').textContent  = rate.toLocaleString() + ' RWF/day';
        document.getElementById('cp-days').textContent  = days + ' day(s)';
        document.getElementById('cp-total').textContent = total.toLocaleString() + ' RWF';
    }

    document.querySelectorAll('input[name="listing_package_id"]')
        .forEach(r => r.addEventListener('change', recalc));
    document.getElementById('listing-days')?.addEventListener('input', recalc);
    recalc();
</script>
@endsection