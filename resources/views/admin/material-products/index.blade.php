{{-- resources/views/admin/material-products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div data-h-scope="material-products">
@include('admin.material-products._styles')

<div class="mp-header">
    <h1 class="mp-title">Products</h1>
    <a href="{{ route('admin.materials-products.create') }}" class="mp-btn">+ Add Product</a>
</div>

@if (session('success'))
    <div class="mp-alert mp-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mp-alert mp-alert-error">{{ session('error') }}</div>
@endif

<div class="mp-filters">
    <form method="GET" action="{{ route('admin.materials-products.index') }}">
        <div class="mp-field">
            <label for="search">Search</label>
            <input type="text" id="search" name="search" placeholder="Product title" value="{{ request('search') }}">
        </div>

        <div class="mp-field">
            <label for="shop_id">Shop</label>
            <select id="shop_id" name="shop_id">
                <option value="">All shops</option>
                @foreach ($shops as $shop)
                    <option value="{{ $shop->id }}" {{ (string) request('shop_id') === (string) $shop->id ? 'selected' : '' }}>
                        {{ $shop->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mp-field">
            <label for="material_category_id">Category</label>
            <select id="material_category_id" name="material_category_id">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (string) request('material_category_id') === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mp-field">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">All statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <button type="submit" class="mp-btn mp-btn-sm">Filter</button>
        <a href="{{ route('admin.materials-products.index') }}" class="mp-btn mp-btn-ghost mp-btn-sm">Reset</a>
    </form>
</div>

<div class="mp-table-wrap">
    <table class="mp-table">
        <thead>
            <tr>
                <th style="width:60px">Image</th>
                <th>Product</th>
                <th>Shop</th>
                <th>Category</th>
                <th style="width:120px">Price</th>
                <th style="width:110px">Stock</th>
                <th style="width:110px">Status</th>
                <th style="width:220px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                @php $primary = $product->primaryImage(); @endphp
                <tr>
                    <td>
                        @if ($primary)
                            <img class="mp-thumb" src="{{ Storage::url($primary->image_path) }}" alt="{{ $product->title }}">
                        @else
                            <div class="mp-thumb-placeholder">📦</div>
                        @endif
                    </td>
                    <td>
                        <div class="mp-product-title">
                            {{ $product->title }}
                            @if ($product->is_featured)
                                <span class="mp-badge mp-badge-featured">Featured</span>
                            @endif
                        </div>
                        <div class="mp-product-sub">{{ $product->images_count }} image(s)</div>
                    </td>
                    <td>{{ $product->shop?->name ?? '—' }}</td>
                    <td>
                        {{ $product->category?->name ?? '—' }}
                        @if ($product->subcategory)
                            <div class="mp-product-sub">{{ $product->subcategory->name }}</div>
                        @endif
                    </td>
                    <td>
                        @if ($product->price)
                            {{ number_format($product->price, 0) }} {{ $product->currency }}
                        @else
                            <span class="mp-product-sub">On request</span>
                        @endif
                    </td>
                    <td>
                        <span class="mp-badge mp-badge-stock-{{ $product->stock_status }}">
                            {{ ucwords(str_replace('_', ' ', $product->stock_status)) }}
                        </span>
                    </td>
                    <td>
                        <span class="mp-badge mp-badge-{{ $product->status }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="mp-actions">
                            <a href="{{ route('admin.materials-products.show', $product) }}" class="mp-btn mp-btn-ghost mp-btn-sm">View</a>
                            <a href="{{ route('admin.materials-products.edit', $product) }}" class="mp-btn mp-btn-outline mp-btn-sm">Edit</a>
                            <form action="{{ route('admin.materials-products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('Delete this product?');" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="mp-btn mp-btn-danger mp-btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center; padding:2rem; color:var(--mp-muted);">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mp-pagination">
    {{ $products->links() }}
</div>
</div>
@endsection