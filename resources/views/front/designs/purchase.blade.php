@extends('layouts.guest')
@section('title', 'Buy ' . $design->title)

@section('content')
@php
    $item = \App\Support\Listing::design($design);
    $fallback = asset('front/assets/img/all-images/properties/property-img26.png');
@endphp
<div class="tu-container tu-detail" style="max-width:980px">
    <ol class="tu-crumbs tu-crumbs-dark">
        <li><a href="{{ route('front.home') }}">Home</a></li>
        <li><a href="{{ route('front.properties.architecture') }}">Designs</a></li>
        <li><a href="{{ route('front.buy.design.show', $design->slug) }}">{{ \Illuminate\Support\Str::limit($design->title, 30) }}</a></li>
        <li>Buy</li>
    </ol>

    <div class="tu-detail-grid" style="grid-template-columns:minmax(0,1fr) 420px">
        <div class="tu-panel" style="padding:0;overflow:hidden">
            <img src="{{ $item['image'] ?: $fallback }}" alt="{{ $design->title }}" style="width:100%;aspect-ratio:4/3;object-fit:cover"
                onerror="this.onerror=null;this.src='{{ $fallback }}'">
            <div style="padding:22px">
                <span class="tu-badge tu-badge-design">{{ $item['kind_label'] }}</span>
                <h1 class="tu-detail-title" style="font-size:1.5rem">{{ $design->title }}</h1>
                <p class="tu-prose" style="margin:0;color:var(--tu-muted)">{{ \Illuminate\Support\Str::limit((string) $design->description, 320) }}</p>
            </div>
        </div>

        <div class="tu-panel">
            <h2 class="tu-panel-title">Request this design</h2>
            <p class="tu-hint" style="font-size:.88rem;margin:-6px 0 18px">
                Price: <strong style="color:var(--tu-ink)">{{ $design->is_free ? 'Free' : ($design->price > 0 ? number_format($design->price) . ' ' . ($design->currency ?: 'RWF') : 'On request') }}</strong>.
                The designer will contact you with payment and delivery details.
            </p>
            @if ($design->is_free)
                <a href="{{ route('front.buy.design.download', $design->slug) }}" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block"><x-tu-icon name="download" /> Download free</a>
            @else
                <form action="{{ route('front.buy.design.inquiry') }}" method="POST" class="tu-stack" style="gap:14px">
                    @csrf
                    <input type="hidden" name="design_id" value="{{ $design->id }}">
                    <div class="tu-field">
                        <label for="pName">Full name</label>
                        <input id="pName" class="tu-input" type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    </div>
                    <div class="tu-field">
                        <label for="pEmail">Email</label>
                        <input id="pEmail" class="tu-input" type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    </div>
                    <div class="tu-field">
                        <label for="pMsg">Message</label>
                        <textarea id="pMsg" name="message" required maxlength="2000">{{ old('message', "Hi, I'd like to buy the design \"{$design->title}\".") }}</textarea>
                    </div>
                    <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Send request</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
