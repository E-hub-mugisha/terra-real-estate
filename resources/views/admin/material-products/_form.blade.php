{{-- resources/views/admin/material-products/_form.blade.php --}}
<div class="mp-grid">
    <div class="mp-col mp-col-main">
        <div class="mp-card">
            <h3 class="mp-card-title">Basic Information</h3>

            <div class="mp-field">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required value="{{ old('title', $product->title) }}">
                @error('title') <div class="mp-error">{{ $message }}</div> @enderror
            </div>

            <div class="mp-field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                @error('description') <div class="mp-error">{{ $message }}</div> @enderror
            </div>

            <div class="mp-field-row">
                <div class="mp-field">
                    <label for="material_category_id">Category</label>
                    <select id="material_category_id" name="material_category_id" required onchange="mpFilterSubcategories()">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ (string) old('material_category_id', $product->material_category_id) === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('material_category_id') <div class="mp-error">{{ $message }}</div> @enderror
                </div>

                <div class="mp-field">
                    <label for="material_subcategory_id">Subcategory</label>
                    <select id="material_subcategory_id" name="material_subcategory_id">
                        <option value="">Select subcategory</option>
                    </select>
                    @error('material_subcategory_id') <div class="mp-error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="mp-card">
            <h3 class="mp-card-title">Pricing &amp; Stock</h3>

            <div class="mp-field-row">
                <div class="mp-field">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}">
                    @error('price') <div class="mp-error">{{ $message }}</div> @enderror
                </div>
                <div class="mp-field">
                    <label for="currency">Currency</label>
                    <input type="text" id="currency" name="currency" required value="{{ old('currency', $product->currency ?? 'RWF') }}">
                    @error('currency') <div class="mp-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mp-field-row">
                <div class="mp-field">
                    <label for="unit">Unit</label>
                    <input type="text" id="unit" name="unit" placeholder="e.g. per bag, per m²" value="{{ old('unit', $product->unit) }}">
                    @error('unit') <div class="mp-error">{{ $message }}</div> @enderror
                </div>
                <div class="mp-field">
                    <label for="min_order_quantity">Min. Order Quantity</label>
                    <input type="number" id="min_order_quantity" name="min_order_quantity" min="1" value="{{ old('min_order_quantity', $product->min_order_quantity) }}">
                    @error('min_order_quantity') <div class="mp-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mp-field">
                <label for="stock_status">Stock Status</label>
                <select id="stock_status" name="stock_status" required>
                    @foreach ($stockStatuses as $option)
                        <option value="{{ $option }}" {{ (string) old('stock_status', $product->stock_status) === $option ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $option)) }}
                        </option>
                    @endforeach
                </select>
                @error('stock_status') <div class="mp-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mp-card">
            <h3 class="mp-card-title">Images</h3>

            @if ($product->exists && $product->images->isNotEmpty())
                <ul class="mp-image-list">
                    @foreach ($product->images as $image)
                        <li class="mp-image-item">
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->title }}">
                            <div class="mp-image-controls">
                                <label class="mp-radio">
                                    <input type="radio" name="primary_image_id" value="{{ $image->id }}" {{ $image->is_primary ? 'checked' : '' }}>
                                    Primary
                                </label>
                                <label class="mp-checkbox mp-checkbox-danger">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                    Delete
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mp-field">
                <label for="images">{{ $product->exists ? 'Add more images' : 'Upload images' }}</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple>
                <p class="mp-hint">First uploaded image becomes primary if none is set yet. JPG/PNG, max 4MB each.</p>
                @error('images.*') <div class="mp-error">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    <div class="mp-col mp-col-side">
        <div class="mp-card">
            <h3 class="mp-card-title">Listing</h3>

            <div class="mp-field">
                <label for="shop_id">Shop</label>
                <select id="shop_id" name="shop_id" required>
                    <option value="">Select shop</option>
                    @foreach ($shops as $shop)
                        <option value="{{ $shop->id }}" {{ (string) old('shop_id', $product->shop_id) === (string) $shop->id ? 'selected' : '' }}>
                            {{ $shop->name }}
                        </option>
                    @endforeach
                </select>
                @error('shop_id') <div class="mp-error">{{ $message }}</div> @enderror
            </div>

            <div class="mp-field">
                <label for="status">Status</label>
                <select id="status" name="status" required onchange="mpToggleRejectionReason()">
                    @foreach ($statuses as $option)
                        <option value="{{ $option }}" {{ (string) old('status', $product->status ?? 'pending') === $option ? 'selected' : '' }}>
                            {{ ucfirst($option) }}
                        </option>
                    @endforeach
                </select>
                @error('status') <div class="mp-error">{{ $message }}</div> @enderror
            </div>

            <div class="mp-field" id="rejectionReasonField">
                <label for="rejection_reason">Rejection Reason</label>
                <textarea id="rejection_reason" name="rejection_reason" rows="3">{{ old('rejection_reason', $product->rejection_reason) }}</textarea>
                @error('rejection_reason') <div class="mp-error">{{ $message }}</div> @enderror
            </div>

            <div class="mp-field mp-field-inline">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                <label for="is_featured" style="margin:0;">Featured product</label>
            </div>
        </div>
    </div>
</div>

<script>
    const mpSubcategoriesByCategory = @json(
        $categories->mapWithKeys(fn ($category) => [
            $category->id => $category->materialSubcategories->map(fn ($sub) => ['id' => $sub->id, 'name' => $sub->name]),
        ])
    );
    const mpSelectedSubcategoryId = @json(old('material_subcategory_id', $product->material_subcategory_id));

    function mpFilterSubcategories() {
        const categoryId = document.getElementById('material_category_id').value;
        const subSelect = document.getElementById('material_subcategory_id');
        const currentValue = subSelect.value || (mpSelectedSubcategoryId ? String(mpSelectedSubcategoryId) : '');

        subSelect.innerHTML = '<option value="">Select subcategory</option>';

        const subs = mpSubcategoriesByCategory[categoryId] || [];
        subs.forEach(function (sub) {
            const opt = document.createElement('option');
            opt.value = sub.id;
            opt.textContent = sub.name;
            if (String(sub.id) === String(currentValue)) opt.selected = true;
            subSelect.appendChild(opt);
        });
    }

    function mpToggleRejectionReason() {
        const status = document.getElementById('status').value;
        const field = document.getElementById('rejectionReasonField');
        field.style.display = status === 'rejected' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        mpFilterSubcategories();
        mpToggleRejectionReason();
    });
</script>
