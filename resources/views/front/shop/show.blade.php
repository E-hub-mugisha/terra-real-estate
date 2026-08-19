@extends('layouts.guest')

@section('content')
<style>
  .shop-page {
    font-family: 'DM Sans', sans-serif;
    background: #f7f8fb;
    min-height: 60vh;
  }

  .shop-banner {
    height: 220px;
    width: 100%;
    background: linear-gradient(135deg, #19265d, #2c3d8f);
    background-size: cover;
    background-position: center;
    position: relative;
  }

  .shop-banner::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(25, 38, 93, 0) 40%, rgba(25, 38, 93, .55) 100%);
  }

  .shop-header-wrap {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .shop-header-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 12px 34px rgba(25, 38, 93, .1);
    margin-top: -70px;
    position: relative;
    z-index: 2;
    padding: 22px 26px 24px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
    flex-wrap: wrap;
  }

  .shop-header-logo {
    width: 88px;
    height: 88px;
    border-radius: 16px;
    border: 4px solid #fff;
    box-shadow: 0 6px 18px rgba(25, 38, 93, .18);
    background: #eef0f8;
    display: grid;
    place-items: center;
    overflow: hidden;
    flex-shrink: 0;
    margin-top: -40px;
  }

  .shop-header-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .shop-header-logo span {
    font-size: 1.8rem;
    font-weight: 700;
    color: #19265d;
  }

  .shop-header-info {
    flex: 1;
    min-width: 240px;
  }

  .shop-header-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #19265d;
    margin: 0 0 4px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  .shop-badge {
    font-size: .68rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 6px;
    background: #D05208;
    color: #fff;
  }

  .shop-header-meta {
    font-size: .82rem;
    color: rgba(25, 38, 93, .55);
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-top: 6px;
  }

  .shop-header-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .shop-header-meta svg {
    width: 14px;
    height: 14px;
  }

  .shop-header-desc {
    font-size: .87rem;
    color: rgba(25, 38, 93, .65);
    margin-top: 10px;
    line-height: 1.6;
    max-width: 640px;
  }

  .shop-contact-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .shop-contact-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 16px;
    border-radius: 9px;
    font-size: .82rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    white-space: nowrap;
  }

  .shop-contact-btn.wa {
    background: #25D366;
    color: #fff;
    box-shadow: 0 4px 14px rgba(37, 211, 102, .28);
  }

  .shop-contact-btn.wa:hover {
    background: #1eb857;
    color: #fff;
    transform: translateY(-1px);
  }

  .shop-contact-btn.primary {
    background: #19265d;
    color: #fff;
  }

  .shop-contact-btn.primary:hover {
    background: #D05208;
    color: #fff;
  }

  .shop-contact-btn.outline {
    background: #fff;
    border: 1px solid rgba(25, 38, 93, .2);
    color: #19265d;
  }

  .shop-contact-btn.outline:hover {
    border-color: #D05208;
    color: #D05208;
  }

  .shop-contact-btn svg {
    width: 14px;
    height: 14px;
  }

  .shop-body {
    max-width: 1240px;
    margin: 0 auto;
    padding: 30px 20px 60px;
  }

  .shop-section-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #19265d;
    margin: 0 0 4px;
  }

  .shop-section-sub {
    font-size: .84rem;
    color: rgba(25, 38, 93, .5);
    margin: 0 0 18px;
  }

  .shop-search {
    max-width: 340px;
    margin-bottom: 22px;
    display: flex;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(25, 38, 93, .15);
  }

  .shop-search input {
    flex: 1;
    border: none;
    outline: none;
    padding: 10px 14px;
    font-size: .84rem;
    font-family: 'DM Sans', sans-serif;
  }

  .shop-search button {
    border: none;
    background: #D05208;
    color: #fff;
    padding: 0 16px;
    cursor: pointer;
  }

  .shop-search button svg {
    width: 14px;
    height: 14px;
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
  }

  .product-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(25, 38, 93, .06);
    border: 1px solid rgba(25, 38, 93, .05);
    text-decoration: none;
    color: inherit;
    display: block;
    transition: transform .2s, box-shadow .2s;
  }

  .product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(25, 38, 93, .12);
    color: inherit;
  }

  .product-image {
    height: 150px;
    width: 100%;
    background: #eef0f8 center/cover no-repeat;
    display: grid;
    place-items: center;
    position: relative;
  }

  .product-image svg {
    width: 34px;
    height: 34px;
    color: rgba(25, 38, 93, .2);
  }

  .product-badge {
    position: absolute;
    font-size: .65rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 6px;
  }

  .product-badge.featured {
    top: 8px;
    left: 8px;
    background: #D05208;
    color: #fff;
  }

  .product-badge.stock {
    top: 8px;
    right: 8px;
  }

  .product-body {
    padding: 12px 14px 14px;
  }

  .product-cat {
    font-size: .68rem;
    font-weight: 600;
    color: rgba(25, 38, 93, .4);
    text-transform: uppercase;
    letter-spacing: .03em;
    margin-bottom: 3px;
  }

  .product-name {
    font-size: .88rem;
    font-weight: 700;
    color: #19265d;
    margin: 0 0 4px;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .product-price-row {
    display: flex;
    align-items: baseline;
    gap: 4px;
    margin-top: 4px;
  }

  .product-price {
    font-size: .92rem;
    font-weight: 700;
    color: #D05208;
  }

  .product-price-request {
    font-size: .8rem;
    color: rgba(25, 38, 93, .5);
    font-weight: 600;
  }

  .product-unit {
    font-size: .72rem;
    color: rgba(25, 38, 93, .45);
  }

  .shop-empty {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 16px;
    color: rgba(25, 38, 93, .5);
  }
</style>

<div class="shop-page">

  <div class="shop-banner" style="{{ $shop->cover_image ? 'background-image:url(' . asset('image/shops/covers/' . $shop->cover_image) . ')' : '' }}"></div>

  <div class="shop-header-wrap">
    <div class="shop-header-card">
      <div class="shop-header-logo">
        @if($shop->logo)
        <img src="{{ asset('image/shops/logos/' . $shop->logo) }}" alt="{{ $shop->name }}">
        @else
        <span>{{ Str::substr($shop->name, 0, 1) }}</span>
        @endif
      </div>

      <div class="shop-header-info">
        <h1 class="shop-header-name">
          {{ $shop->name }}
          @if($shop->is_featured)<span class="shop-badge">Featured</span>@endif
        </h1>
        <div class="shop-header-meta">
          <span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
            {{ $shop->sector ? $shop->sector . ', ' : '' }}{{ $shop->district }}, {{ $shop->province }}
          </span>
          <span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
              <circle cx="12" cy="12" r="3" />
            </svg>
            {{ number_format($shop->views_count) }} views
          </span>
          <span>
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
            </svg>
            {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
          </span>
        </div>
        @if($shop->description)
        <p class="shop-header-desc">{{ $shop->description }}</p>
        @endif
      </div>

      <div class="shop-contact-actions">
        @if($shop->whatsapp_number)
        @php
        $shopWaNumber = preg_replace('/\D/', '', $shop->whatsapp_number);
        if (str_starts_with($shopWaNumber, '0')) { $shopWaNumber = '25' . $shopWaNumber; }
        $shopWaText = "Hello {$shop->name}, I saw your shop on Terra and I'd like to know more about your products.";
        @endphp
        <a href="https://wa.me/{{ $shopWaNumber }}?text={{ urlencode($shopWaText) }}" target="_blank" rel="noopener" class="shop-contact-btn wa">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M20.5 3.5A11 11 0 0 0 2.9 17L2 22l5.2-.9A11 11 0 1 0 20.5 3.5zM12 20a8 8 0 0 1-4.1-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8 8 0 1 1 12 20zm4.4-5.9c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1-.2.2-.6.8-.8 1-.1.1-.3.2-.5.1-.7-.3-1.4-.7-2-1.3-.5-.5-1-1.1-1.4-1.7-.1-.2 0-.4.1-.5l.4-.4c.1-.1.2-.3.2-.4.1-.1 0-.3 0-.4-.1-.1-.5-1.3-.7-1.7-.2-.5-.4-.4-.5-.4h-.4c-.2 0-.4.1-.6.3-.6.6-.8 1.4-.8 2.2.1.9.5 1.8 1 2.6 1.1 1.7 2.4 3 4.3 3.8.5.2.9.3 1.3.5.5.1 1 .1 1.4.1.4-.1 1.3-.5 1.5-1 .2-.5.2-1 .1-1.1l-.4-.2z" />
          </svg>
          WhatsApp
        </a>
        @endif
        @if($shop->phone)
        <a href="tel:{{ $shop->phone }}" class="shop-contact-btn primary">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M6.6 10.8c1.4 2.7 3.6 4.9 6.3 6.3l2.1-2.1c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.5.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.2.2 2.4.6 3.5.1.4 0 .8-.2 1L6.6 10.8z" />
          </svg>
          Call
        </a>
        @endif
        @if($shop->email)
        <a href="mailto:{{ $shop->email }}" class="shop-contact-btn outline">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 4h16v16H4z" />
            <path d="m22 6-10 7L2 6" />
          </svg>
          Email
        </a>
        @endif
      </div>
    </div>
  </div>

  <div class="shop-body">
    <h2 class="shop-section-title">Products</h2>
    <p class="shop-section-sub">Browse everything {{ $shop->name }} has listed.</p>

    <form class="shop-search" method="GET">
      <input type="text" name="q" value="{{ $search }}" placeholder="Search products…">
      <button type="submit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <circle cx="11" cy="11" r="8" />
          <path d="m21 21-4.35-4.35" />
        </svg>
      </button>
    </form>

    @if($products->isEmpty())
    <div class="shop-empty">No products found{{ $search ? ' for "' . $search . '"' : '' }}.</div>
    @else
    <div class="product-grid">
      @foreach($products as $product)
      @php
      $img = $product->primaryImage();
      $stockLabel = match($product->stock_status ?? null) {
      'in_stock' => ['In Stock', '#1a9d5c', 'rgba(26,157,92,.1)'],
      'low_stock' => ['Low Stock', '#D05208', 'rgba(208,82,8,.1)'],
      'out_of_stock' => ['Out of Stock', '#c73a3a', 'rgba(199,58,58,.1)'],
      default => null,
      };
      @endphp
      <a href="{{ route('front.materials.show', ['category' => $product->category->slug, 'material' => $product->slug]) }}" class="product-card">
        <div class="product-image" style="{{ $img ? 'background-image:url(' . asset('storage/' . $img->path) . ')' : '' }}">
          @unless($img)
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="3" y="3" width="18" height="18" rx="2" />
            <circle cx="8.5" cy="8.5" r="1.5" />
            <path d="m21 15-5-5L5 21" />
          </svg>
          @endunless
          @if($product->is_featured)<span class="product-badge featured">Featured</span>@endif
          @if($stockLabel)<span class="product-badge stock" style="color:{{ $stockLabel[1] }};background:{{ $stockLabel[2] }};">{{ $stockLabel[0] }}</span>@endif
        </div>
        <div class="product-body">
          @if($product->category)<div class="product-cat">{{ $product->category->name }}</div>@endif
          <h3 class="product-name">{{ $product->title }}</h3>
          <div class="product-price-row">
            @if($product->price)
            <span class="product-price">{{ number_format($product->price) }} {{ $product->currency }}</span>
            @if($product->unit)<span class="product-unit">/ {{ $product->unit }}</span>@endif
            @else
            <span class="product-price-request">Price on request</span>
            @endif
          </div>
        </div>
      </a>
      @endforeach
    </div>

    <div class="mt-4">
      {{ $products->links() }}
    </div>
    @endif
  </div>
</div>
@endsection