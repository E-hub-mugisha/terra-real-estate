@extends('layouts.guest')

@section('content')
<style>
  .shops-page { font-family: 'DM Sans', sans-serif; background: #f7f8fb; min-height: 60vh; }

  .shops-hero {
    background: linear-gradient(135deg, #19265d, #263876);
    color: #fff;
    padding: 44px 0 90px;
    position: relative;
    overflow: hidden;
  }
  .shops-hero::after {
    content: '';
    position: absolute;
    right: -80px;
    top: -80px;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: rgba(208,82,8,.18);
  }
  .shops-hero-inner { max-width: 1240px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 1; }
  .shops-crumb { font-size: .8rem; color: rgba(255,255,255,.6); margin-bottom: 8px; }
  .shops-crumb a { color: rgba(255,255,255,.75); text-decoration: none; }
  .shops-crumb a:hover { color: #fff; }
  .shops-title { font-size: 1.9rem; font-weight: 700; margin: 0 0 6px; }
  .shops-subtitle { font-size: .92rem; color: rgba(255,255,255,.65); margin: 0; }

  .shops-search {
    max-width: 460px;
    margin-top: 22px;
    display: flex;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(0,0,0,.18);
  }
  .shops-search input {
    flex: 1; border: none; outline: none; padding: 13px 16px; font-size: .88rem; font-family: 'DM Sans', sans-serif;
  }
  .shops-search button {
    border: none; background: #D05208; color: #fff; padding: 0 20px; font-weight: 600; cursor: pointer; font-size: .85rem;
    transition: background .2s;
  }
  .shops-search button:hover { background: #b84607; }

  .shops-body { max-width: 1240px; margin: -50px auto 0; padding: 0 20px 60px; position: relative; z-index: 2; }

  .shops-filter-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 10px 30px rgba(25,38,93,.08);
    margin-bottom: 28px;
  }
  .shops-filter-label { font-size: .72rem; text-transform: uppercase; letter-spacing: .04em; color: rgba(25,38,93,.45); font-weight: 700; margin-bottom: 10px; }
  .chip-row { display: flex; flex-wrap: wrap; gap: 8px; }
  .chip {
    display: inline-flex; align-items: center; padding: 7px 14px; border-radius: 20px;
    font-size: .8rem; font-weight: 600; text-decoration: none; border: 1px solid rgba(25,38,93,.15);
    color: #19265d; background: rgba(25,38,93,.03); transition: all .2s;
  }
  .chip:hover { border-color: #D05208; color: #D05208; background: rgba(208,82,8,.06); }
  .chip.active { background: #19265d; border-color: #19265d; color: #fff; }

  .shop-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 22px; }

  .shop-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(25,38,93,.07);
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    transition: transform .22s cubic-bezier(.4,0,.2,1), box-shadow .22s;
    border: 1px solid rgba(25,38,93,.05);
  }
  .shop-card:hover { transform: translateY(-4px); box-shadow: 0 16px 36px rgba(25,38,93,.14); color: inherit; }

  .shop-cover {
    height: 120px; width: 100%; background: linear-gradient(135deg,#eef0f8,#e2e5f2);
    background-size: cover; background-position: center; position: relative;
  }
  .shop-featured-badge {
    position: absolute; top: 10px; left: 10px; background: #D05208; color: #fff;
    font-size: .68rem; font-weight: 700; padding: 4px 9px; border-radius: 6px; letter-spacing: .02em;
  }
  .shop-logo-wrap {
    width: 62px; height: 62px; border-radius: 14px; background: #fff; border: 3px solid #fff;
    box-shadow: 0 4px 14px rgba(25,38,93,.15); margin: -32px 0 0 18px; position: relative; z-index: 1;
    display: grid; place-items: center; overflow: hidden; flex-shrink: 0;
  }
  .shop-logo-wrap img { width: 100%; height: 100%; object-fit: cover; }
  .shop-logo-fallback { font-size: 1.3rem; font-weight: 700; color: #19265d; }

  .shop-card-body { padding: 12px 18px 18px; flex: 1; display: flex; flex-direction: column; gap: 6px; }
  .shop-name { font-size: 1rem; font-weight: 700; color: #19265d; margin: 0; line-height: 1.3; }
  .shop-location { font-size: .78rem; color: rgba(25,38,93,.5); display: flex; align-items: center; gap: 5px; }
  .shop-location svg { width: 13px; height: 13px; flex-shrink: 0; }
  .shop-desc { font-size: .8rem; color: rgba(25,38,93,.55); line-height: 1.5; margin: 2px 0 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

  .shop-card-foot {
    margin-top: auto; padding-top: 10px; border-top: 1px solid rgba(25,38,93,.06);
    display: flex; align-items: center; justify-content: space-between;
    font-size: .76rem; font-weight: 600; color: #D05208;
  }
  .shop-card-foot .count-badge { color: rgba(25,38,93,.45); font-weight: 500; }

  .shops-empty { text-align: center; padding: 70px 20px; background: #fff; border-radius: 16px; color: rgba(25,38,93,.5); }

  .shops-pagination { margin-top: 30px; }
</style>

<div class="shops-page">

  <div class="shops-hero">
    <div class="shops-hero-inner">
      <div class="shops-crumb">
        <a href="{{ route('front.home') }}">Home</a> /
        <a href="{{ route('front.shops.locations') }}">Shops</a>
        @if($province) / <a href="{{ route('front.shops.locations', ['province' => $province]) }}">{{ $province }}</a> @endif
        @if($district) / {{ $district }} @endif
      </div>
      <h1 class="shops-title">
        Shops
        @if($province) in {{ $province }} @endif
        @if($district) &mdash; {{ $district }} @endif
      </h1>
      <p class="shops-subtitle">{{ $shops->total() }} approved {{ Str::plural('shop', $shops->total()) }} listed</p>

      <form class="shops-search" method="GET">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search shops by name…">
        <button type="submit">Search</button>
      </form>
    </div>
  </div>

  <div class="shops-body">

    @if($provinces->isNotEmpty())
    <div class="shops-filter-card">
      <div class="shops-filter-label">Province</div>
      <div class="chip-row">
        <a href="{{ route('front.shops.locations') }}" class="chip {{ !$province ? 'active' : '' }}">All Provinces</a>
        @foreach($provinces as $p)
        <a href="{{ route('front.shops.locations', ['province' => $p]) }}" class="chip {{ $province === $p ? 'active' : '' }}">{{ $p }}</a>
        @endforeach
      </div>

      @if($province && $districts->isNotEmpty())
      <div class="shops-filter-label" style="margin-top:16px;">District</div>
      <div class="chip-row">
        <a href="{{ route('front.shops.locations', ['province' => $province]) }}" class="chip {{ !$district ? 'active' : '' }}">All Districts</a>
        @foreach($districts as $d)
        <a href="{{ route('front.shops.locations', ['province' => $province, 'district' => $d]) }}" class="chip {{ $district === $d ? 'active' : '' }}">{{ $d }}</a>
        @endforeach
      </div>
      @endif
    </div>
    @endif

    @if($shops->isEmpty())
      <div class="shops-empty">No shops found{{ $district ? ' in ' . $district : ($province ? ' in ' . $province : '') }}.</div>
    @else
      <div class="shop-grid">
        @foreach($shops as $shop)
        <a href="{{ route('shops.show', $shop->slug) }}" class="shop-card">
          <div class="shop-cover" @if($shop->cover_image) style="background-image: url('{{ asset('image/shops/covers/' . $shop->cover_image) }}')" @endif>
            @if($shop->is_featured)
              <span class="shop-featured-badge">Featured</span>
            @endif
          </div>
          <div class="shop-logo-wrap">
            @if($shop->logo)
              <img src="{{ asset('image/shops/logos/' . $shop->logo) }}" alt="{{ $shop->name }}">
            @else
              <span class="shop-logo-fallback">{{ Str::substr($shop->name, 0, 1) }}</span>
            @endif
          </div>
          <div class="shop-card-body">
            <h3 class="shop-name">{{ $shop->name }}</h3>
            <div class="shop-location">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              {{ $shop->district }}, {{ $shop->province }}
            </div>
            @if($shop->description)
            <p class="shop-desc">{{ $shop->description }}</p>
            @endif
            <div class="shop-card-foot">
              <span>View Shop &rarr;</span>
              <span class="count-badge">{{ $shop->material_products_count }} {{ Str::plural('product', $shop->material_products_count) }}</span>
            </div>
          </div>
        </a>
        @endforeach
      </div>

      <div class="shops-pagination">
        {{ $shops->links() }}
      </div>
    @endif

  </div>
</div>
@endsection