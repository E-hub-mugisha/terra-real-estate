@extends('layouts.guest')
@section('title', $design->title)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) $design->description), 155))

@section('content')
@php
    $item = \App\Support\Listing::design($design);
    $images = $design->images->map(fn ($img) => asset('image/architectural_designs/images/' . $img->image_path))->all();
    if (!$images && $design->preview_image) $images = [asset('storage/' . $design->preview_image)];
    $format = $design->design_file ? strtoupper(pathinfo($design->design_file, PATHINFO_EXTENSION)) : null;
    $related = \App\Support\Listing::collect($relatedDesigns);
    $free = (bool) $design->is_free;

    $downloadBox = $free
        ? '<a href="' . e(route('front.buy.design.download', $design->slug)) . '" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block" style="margin-bottom:10px">'
            . '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12M7 10l5 5 5-5M4 21h16"/></svg>'
            . ' Download free</a>'
        : '';
@endphp

<div class="tu-container tu-detail">
    <ol class="tu-crumbs tu-crumbs-dark">
        <li><a href="{{ route('front.home') }}">Home</a></li>
        <li><a href="{{ route('front.properties.architecture') }}">Designs</a></li>
        <li>{{ \Illuminate\Support\Str::limit($design->title, 40) }}</li>
    </ol>

    <div class="tu-detail-head">
        <div>
            <div style="display:flex;gap:6px;flex-wrap:wrap">
                <span class="tu-badge tu-badge-design">{{ $item['kind_label'] }}</span>
                @if ($free)<span class="tu-badge tu-badge-success">Free download</span>@endif
                @if ($item['featured'])<span class="tu-badge tu-badge-featured">Featured</span>@endif
            </div>
            <h1 class="tu-detail-title">{{ $design->title }}</h1>
            <div class="tu-card-loc" style="font-size:.92rem">
                <x-tu-icon name="ruler" /> Architectural design
                @if ($design->views_count) · {{ number_format($design->views_count) }} views @endif
            </div>
        </div>
        <div class="tu-detail-price">
            <strong>{{ $free ? 'Free' : ($design->price > 0 ? number_format($design->price) . ' ' . ($design->currency ?: 'RWF') : 'Price on request') }}</strong>
            <span>{{ $free ? 'download the full drawing set' : 'complete drawing set' }}</span>
        </div>
    </div>

    @include('front.partials.detail-gallery', [
        'images' => $images,
        'title' => $design->title,
        'fallback' => asset('front/assets/img/all-images/properties/property-img26.png'),
    ])

    <div class="tu-detail-grid">
        <div>
            <div class="tu-panel">
                <div class="tu-facts">
                    <div class="tu-fact"><span class="tu-fact-ico"><x-tu-icon name="layers" /></span><span><strong>{{ $design->category->name ?? 'Design' }}</strong><span>Category</span></span></div>
                    @if ($format)<div class="tu-fact"><span class="tu-fact-ico"><x-tu-icon name="file" /></span><span><strong>{{ $format }}</strong><span>File format</span></span></div>@endif
                    <div class="tu-fact"><span class="tu-fact-ico"><x-tu-icon name="download" /></span><span><strong>{{ number_format($design->download_count ?? 0) }}</strong><span>Downloads</span></span></div>
                    <div class="tu-fact"><span class="tu-fact-ico"><x-tu-icon name="calendar" /></span><span><strong>{{ optional($design->created_at)->format('M Y') }}</strong><span>Published</span></span></div>
                </div>
            </div>

            <div class="tu-panel">
                <h2 class="tu-panel-title">About this design</h2>
                <p class="tu-prose" style="margin:0">{{ $design->description ?: 'No description has been added yet.' }}</p>
            </div>

            <div class="tu-panel">
                <h2 class="tu-panel-title">What you get</h2>
                <div class="tu-amenities">
                    <span class="tu-amenity"><x-tu-icon name="check" /> Floor plans</span>
                    <span class="tu-amenity"><x-tu-icon name="check" /> Elevations &amp; sections</span>
                    <span class="tu-amenity"><x-tu-icon name="check" /> Specifications</span>
                    @if ($format)<span class="tu-amenity"><x-tu-icon name="check" /> {{ $format }} file</span>@endif
                </div>
                <p class="tu-hint" style="margin:14px 0 0">
                    {{ $free ? 'This design is free — download it instantly.' : 'Send an inquiry or message the designer to buy the full drawing set.' }}
                </p>
            </div>

            @include('front.partials.detail-media', ['video' => $design->video_url ?? null])
        </div>

        <aside class="tu-sticky">
            @include('front.partials.detail-contact', [
                'listing' => $design,
                'saveId' => 'design-' . $design->id,
                'agent' => $design->agent,
                'title' => $design->title,
                'wa' => 'https://wa.me/' . \App\Support\Listing::WHATSAPP . '?text=' . rawurlencode("Hi, I'm interested in the design \"{$design->title}\" (" . url()->current() . ').'),
                'inquiryRoute' => route('front.buy.design.inquiry'),
                'idField' => 'design_id',
                'idValue' => $design->id,
                'extra' => $downloadBox,
            ])
        </aside>
    </div>

    @if ($related->isNotEmpty())
        <section style="margin-top:56px">
            <div class="tu-section-head">
                <h2 class="tu-h2">More {{ $design->category->name ?? 'designs' }}</h2>
                <a href="{{ route('front.properties.architecture', ['category' => $design->category_id]) }}" class="tu-link-arrow">See all <x-tu-icon name="arrow-right" /></a>
            </div>
            <div class="tu-grid">
                @foreach ($related as $rel)
                    @include('front.partials.card', ['item' => $rel])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
