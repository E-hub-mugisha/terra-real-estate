{{-- resources/views/admin/material-products/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div data-h-scope="material-products">
@include('admin.material-products._styles')

@php $primary = $product->primaryImage(); @endphp

<div class="mp-header">
    <h1 class="mp-title">{{ $product->title }}</h1>
    <div class="mp-actions">
        <a href="{{ route('admin.materials-products.edit', $product) }}" class="mp-btn mp-btn-outline">Edit</a>
        <a href="{{ route('admin.materials-products.index') }}" class="mp-btn mp-btn-ghost">Back to Products</a>
        <form action="{{ route('admin.materials-products.destroy', $product) }}" method="POST"
              onsubmit="return confirm('Delete this product?');" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="mp-btn mp-btn-danger">Delete</button>
        </form>
    </div>
</div>

@if (session('success'))
    <div class="mp-alert mp-alert-success">{{ session('success') }}</div>
@endif

<div class="mp-show-grid">
    <div>
        @if ($primary)
            <img class="mp-gallery-main" id="mpGalleryMain" src="{{ Storage::url($primary->image_path) }}" alt="{{ $product->title }}">
        @else
            <div class="mp-gallery-main" style="display:flex;align-items:center;justify-content:center;color:var(--mp-muted);font-size:2rem;">📦</div>
        @endif

        @if ($product->images->count() > 1)
            <div class="mp-gallery-thumbs">
                @foreach ($product->images as $image)
                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->title }}"
                         class="{{ $image->is_primary ? 'is-active' : '' }}"
                         onclick="document.getElementById('mpGalleryMain').src = this.src;
                                  document.querySelectorAll('.mp-gallery-thumbs img').forEach(el => el.classList.remove('is-active'));
                                  this.classList.add('is-active');">
                @endforeach
            </div>
        @endif
    </div>

    <div>
        <div class="mp-card">
            <div class="mp-price">
                @if ($product->price)
                    {{ number_format($product->price, 0) }} {{ $product->currency }}
                    @if ($product->unit) <span style="font-size:.9rem; color:var(--mp-muted); font-weight:400;">({{ $product->unit }})</span> @endif
                @else
                    Price on request
                @endif
            </div>

            <div style="margin: .75rem 0 1.25rem; display:flex; gap:.5rem; flex-wrap:wrap;">
                <span class="mp-badge mp-badge-{{ $product->status }}">{{ ucfirst($product->status) }}</span>
                <span class="mp-badge mp-badge-stock-{{ $product->stock_status }}">
                    {{ ucwords(str_replace('_', ' ', $product->stock_status)) }}
                </span>
                @if ($product->is_featured)
                    <span class="mp-badge mp-badge-featured">Featured</span>
                @endif
            </div>

            @if ($product->shop)
                <a href="{{ $product->whatsappLink() }}" target="_blank" rel="noopener" class="mp-btn mp-whatsapp-btn" style="width:100%; justify-content:center; margin-bottom:1.25rem;">
                    Contact on WhatsApp
                </a>
            @endif

            <ul class="mp-info-list">
                <li><span class="mp-info-label">Shop</span> <span>{{ $product->shop?->name ?? '—' }}</span></li>
                <li><span class="mp-info-label">Category</span> <span>{{ $product->category?->name ?? '—' }}</span></li>
                <li><span class="mp-info-label">Subcategory</span> <span>{{ $product->subcategory?->name ?? '—' }}</span></li>
                <li><span class="mp-info-label">Min. order qty</span> <span>{{ $product->min_order_quantity ?? '—' }}</span></li>
                <li><span class="mp-info-label">Slug</span> <span>{{ $product->slug }}</span></li>
                <li><span class="mp-info-label">Created</span> <span>{{ $product->created_at->format('M d, Y') }}</span></li>
            </ul>

            @if ($product->status === 'rejected' && $product->rejection_reason)
                <div class="mp-alert mp-alert-error" style="margin-top:1rem;">
                    <strong>Rejection reason:</strong> {{ $product->rejection_reason }}
                </div>
            @endif
        </div>

        @if ($product->description)
            <div class="mp-card">
                <h3 class="mp-card-title">Description</h3>
                <p style="font-size:.9rem; line-height:1.6; white-space:pre-line;">{{ $product->description }}</p>
            </div>
        @endif
    </div>
</div>
</div>
@endsection