<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $product->title ?? '') }}">
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
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
        @error('material_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Subcategory</label>
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

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" name="price" class="form-control"
               value="{{ old('price', $product->price ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Currency</label>
        <select name="currency" class="form-select">
            <option value="RWF" {{ old('currency', $product->currency ?? 'RWF') === 'RWF' ? 'selected' : '' }}>RWF</option>
            <option value="USD" {{ old('currency', $product->currency ?? '') === 'USD' ? 'selected' : '' }}>USD</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Unit</label>
        <input type="text" name="unit" placeholder="e.g. per bag, per m2" class="form-control"
               value="{{ old('unit', $product->unit ?? '') }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Min. Order Quantity</label>
        <input type="number" name="min_order_quantity" class="form-control"
               value="{{ old('min_order_quantity', $product->min_order_quantity ?? 1) }}">
    </div>
    <div class="col-md-6 mb-3">
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

<div class="mb-3">
    <label class="form-label">Photos</label>
    <input type="file" name="images[]" multiple accept="image/*" class="form-control">
    @if (!empty($product) && $product->images->count())
        <div class="d-flex gap-2 mt-2 flex-wrap">
            @foreach ($product->images as $img)
                <img src="{{ asset('storage/' . $img->path) }}" width="70" height="70" style="object-fit:cover;" class="rounded border">
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

    fetch(`/api/material-categories/${categoryId}/subcategories`)
        .then(r => r.json())
        .then(data => {
            data.forEach(sub => {
                const opt = document.createElement('option');
                opt.value = sub.id;
                opt.textContent = sub.name;
                subSelect.appendChild(opt);
            });
        });
});
</script>