{{-- Basic information --}}
<div class="form-section">
    <div class="section-eyebrow">
        <div class="section-icon"><i class="bi bi-box-seam"></i></div>
        <div>
            <p class="section-title">Basic Information</p>
            <p class="section-desc">What buyers see first — make the title and category count.</p>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $product->title ?? '') }}" placeholder="e.g. Portland Cement 50kg Bag">
        @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="material_category_id" id="category-select"
                    class="form-select @error('material_category_id') is-invalid @enderror">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('material_category_id', $product->material_category_id ?? null) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('material_category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Subcategory <span class="optional-tag">(optional)</span></label>
            <select name="material_subcategory_id" id="subcategory-select" class="form-select">
                <option value="">Select subcategory</option>
                @foreach ($subcategories ?? [] as $sub)
                    <option value="{{ $sub->id }}"
                        {{ old('material_subcategory_id', $product->material_subcategory_id ?? null) == $sub->id ? 'selected' : '' }}>
                        {{ $sub->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-0 mt-3">
        <label class="form-label">Description <span class="optional-tag">(optional)</span></label>
        <textarea name="description" rows="4" class="form-control" placeholder="Describe quality, specifications, delivery details...">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>

{{-- Pricing & availability --}}
<div class="form-section">
    <div class="section-eyebrow">
        <div class="section-icon"><i class="bi bi-tag"></i></div>
        <div>
            <p class="section-title">Pricing &amp; Availability</p>
            <p class="section-desc">How much it costs and how buyers can order it.</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Price <span class="optional-tag">(optional)</span></label>
            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price', $product->price ?? '') }}" placeholder="0.00">
            @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <div class="form-text-hint">Leave blank to show "On request".</div>
        </div>
        <div class="col-md-4">
            <label class="form-label">Currency</label>
            <select name="currency" class="form-select">
                <option value="RWF" {{ old('currency', $product->currency ?? 'RWF') === 'RWF' ? 'selected' : '' }}>RWF</option>
                <option value="USD" {{ old('currency', $product->currency ?? '') === 'USD' ? 'selected' : '' }}>USD</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Unit <span class="optional-tag">(optional)</span></label>
            <input type="text" name="unit" placeholder="e.g. per bag, per m2" class="form-control"
                   value="{{ old('unit', $product->unit ?? '') }}">
        </div>
    </div>

    <div class="row g-3 mt-0">
        <div class="col-md-6">
            <label class="form-label">Min. Order Quantity</label>
            <input type="number" name="min_order_quantity" class="form-control"
                   value="{{ old('min_order_quantity', $product->min_order_quantity ?? 1) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Stock Status</label>
            <select name="stock_status" class="form-select">
                @foreach (['in_stock' => 'In Stock', 'out_of_stock' => 'Out of Stock', 'made_to_order' => 'Made to Order'] as $val => $label)
                    <option value="{{ $val }}" {{ old('stock_status', $product->stock_status ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- Photos --}}
<div class="form-section">
    <div class="section-eyebrow">
        <div class="section-icon"><i class="bi bi-image"></i></div>
        <div>
            <p class="section-title">Photos</p>
            <p class="section-desc">Clear photos help your product get approved and sell faster.</p>
        </div>
    </div>

    <label class="uploader uploader-multi">
        <input type="file" name="images[]" id="imagesInput" multiple accept="image/*">
        <div class="uploader-placeholder photos-icon"><i class="bi bi-cloud-arrow-up"></i></div>
        <div>
            <div class="uploader-text-title">Upload photos</div>
            <div class="uploader-text-sub">PNG or JPG, multiple files allowed <span class="js-file-name" id="imagesFileCount"></span></div>
        </div>
    </label>

    <div class="photo-grid mt-3" id="newImagePreviewGrid"></div>

    @if (!empty($product) && $product->images->count())
        <div class="form-text-hint mt-3 mb-2">Current photos</div>
        <div class="photo-grid">
            @foreach ($product->images as $img)
                <div class="photo-thumb-wrap">
                    <img src="{{ asset('storage/' . $img->path) }}" class="photo-thumb">
                    @if ($img->is_primary)
                        <span class="photo-primary-badge">Primary</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
document.getElementById('category-select')?.addEventListener('change', function () {
    const categoryId = this.value;
    const subSelect = document.getElementById('subcategory-select');
    subSelect.innerHTML = '<option value="">Select subcategory</option>';
    if (!categoryId) return;

    fetch(`/material-categories/${categoryId}/subcategories`)
        .then(r => r.json())
        .then(data => {
            data.forEach(sub => {
                const opt = document.createElement('option');
                opt.value = sub.id;
                opt.textContent = sub.name;
                subSelect.appendChild(opt);
            });
        })
        .catch(() => {}); // fails silently if endpoint isn't set up yet
});

document.getElementById('imagesInput')?.addEventListener('change', function () {
    const grid = document.getElementById('newImagePreviewGrid');
    const countEl = document.getElementById('imagesFileCount');
    grid.innerHTML = '';

    const files = Array.from(this.files || []);
    countEl.textContent = files.length ? `· ${files.length} file${files.length > 1 ? 's' : ''} selected` : '';

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const wrap = document.createElement('div');
            wrap.className = 'photo-thumb-wrap';
            wrap.innerHTML = `<img src="${e.target.result}" class="photo-thumb">`;
            grid.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
});
</script>