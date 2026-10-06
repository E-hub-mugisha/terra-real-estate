@extends('public.layouts.app')

@section('title', ($unit->unit_number ?? 'Unit') . ' | Terra Property Management')

@section('content')

@php
    $floor = $unit->floor;
    $building = $floor?->building;
    $property = $building?->property;

    $images = [];

    if (!empty($unit->image)) {
        $images[] = $unit->image;
    }

    if (!empty($unit->images)) {
        $unitImages = is_array($unit->images)
            ? $unit->images
            : json_decode($unit->images, true);

        if (is_array($unitImages)) {
            $images = array_merge($images, $unitImages);
        }
    }

    if (empty($images) && !empty($property?->image)) {
        $images[] = $property->image;
    }

    $images = collect($images)
        ->filter()
        ->unique()
        ->values();

    $imageUrl = function ($image) {
        if (!$image) {
            return asset('images/property-placeholder.jpg');
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        return asset('storage/' . ltrim($image, '/'));
    };

    $rent = $unit->rent ?? $unit->monthly_rent ?? $unit->price ?? null;
@endphp

<style>
    .property-detail-page {
        background: #f7f8fa;
        min-height: 100vh;
        padding-bottom: 80px;
    }

    .property-breadcrumb {
        padding: 28px 0 20px;
    }

    .property-breadcrumb a {
        color: #737b8c;
        text-decoration: none;
        font-size: 14px;
    }

    .property-breadcrumb a:hover {
        color: #d05208;
    }

    .property-breadcrumb .current {
        color: #303643;
        font-weight: 600;
    }

    .property-gallery {
        background: #fff;
        border: 1px solid #e7e9ee;
        border-radius: 18px;
        overflow: hidden;
    }

    .property-main-image {
        width: 100%;
        height: 520px;
        object-fit: cover;
        display: block;
        background: #eef0f3;
    }

    .property-thumbnails {
        display: flex;
        gap: 10px;
        padding: 12px;
        overflow-x: auto;
        border-top: 1px solid #e7e9ee;
    }

    .property-thumbnail {
        width: 82px;
        height: 64px;
        flex: 0 0 auto;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        padding: 0;
        background: none;
    }

    .property-thumbnail.active {
        border-color: #d05208;
    }

    .property-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .property-summary {
        background: #fff;
        border: 1px solid #e7e9ee;
        border-radius: 18px;
        padding: 30px;
        position: sticky;
        top: 100px;
    }

    .property-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 30px;
        background: #eaf8f0;
        color: #167044;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .property-status::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #24945d;
    }

    .property-title {
        font-size: clamp(28px, 3vw, 40px);
        line-height: 1.15;
        font-weight: 800;
        color: #19265d;
        margin: 18px 0 10px;
    }

    .property-location {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: #737b8c;
        font-size: 14px;
        line-height: 1.6;
    }

    .property-location i {
        color: #d05208;
        margin-top: 2px;
    }

    .property-price {
        margin-top: 28px;
        padding: 20px 0;
        border-top: 1px solid #e7e9ee;
        border-bottom: 1px solid #e7e9ee;
    }

    .property-price-label {
        color: #737b8c;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .property-price-value {
        color: #d05208;
        font-size: 30px;
        font-weight: 800;
    }

    .property-price-period {
        color: #737b8c;
        font-size: 14px;
        font-weight: 500;
    }

    .property-specs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin: 24px 0;
    }

    .property-spec {
        padding: 15px;
        background: #f7f8fa;
        border-radius: 12px;
    }

    .property-spec i {
        color: #d05208;
        font-size: 18px;
        margin-right: 7px;
    }

    .property-spec-label {
        display: block;
        color: #737b8c;
        font-size: 12px;
        margin-top: 7px;
    }

    .property-spec-value {
        color: #303643;
        font-size: 15px;
        font-weight: 700;
    }

    .property-inquiry-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 9px;
        width: 100%;
        background: #d05208;
        color: #fff;
        border: 0;
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .property-inquiry-btn:hover {
        background: #ad4205;
        color: #fff;
        transform: translateY(-1px);
    }

    .property-contact-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 9px;
        width: 100%;
        background: #fff;
        color: #19265d;
        border: 1px solid #dfe2e8;
        border-radius: 10px;
        padding: 14px 20px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        margin-top: 10px;
    }

    .property-contact-btn:hover {
        border-color: #d05208;
        color: #d05208;
    }

    .property-content-card {
        background: #fff;
        border: 1px solid #e7e9ee;
        border-radius: 18px;
        padding: 30px;
        margin-top: 24px;
    }

    .section-title {
        color: #19265d;
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 18px;
    }

    .property-description {
        color: #596174;
        font-size: 15px;
        line-height: 1.8;
        white-space: pre-line;
    }

    .property-info-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
        border-top: 1px solid #e7e9ee;
    }

    .property-info-item {
        padding: 16px 0;
        border-bottom: 1px solid #e7e9ee;
    }

    .property-info-item:nth-child(odd) {
        padding-right: 20px;
    }

    .property-info-item:nth-child(even) {
        padding-left: 20px;
        border-left: 1px solid #e7e9ee;
    }

    .property-info-label {
        color: #737b8c;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .property-info-value {
        color: #303643;
        font-size: 14px;
        font-weight: 700;
    }

    .management-card {
        background: #19265d;
        color: #fff;
        border-radius: 18px;
        padding: 30px;
        margin-top: 24px;
    }

    .management-card h3 {
        color: #fff;
        font-size: 21px;
        font-weight: 800;
    }

    .management-card p {
        color: rgba(255,255,255,.75);
        font-size: 14px;
        line-height: 1.7;
    }

    .management-card a {
        color: #fff;
        text-decoration: none;
        font-weight: 700;
    }

    .management-card a:hover {
        color: #f5b08a;
    }

    .empty-gallery {
        height: 520px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #737b8c;
        background: #eef0f3;
    }

    .empty-gallery i {
        font-size: 48px;
        margin-bottom: 12px;
        color: #c7ccd5;
    }

    @media (max-width: 991.98px) {
        .property-summary {
            position: static;
            margin-top: 24px;
        }

        .property-main-image,
        .empty-gallery {
            height: 420px;
        }
    }

    @media (max-width: 767.98px) {
        .property-detail-page {
            padding-bottom: 50px;
        }

        .property-main-image,
        .empty-gallery {
            height: 300px;
        }

        .property-summary,
        .property-content-card,
        .management-card {
            padding: 22px;
        }

        .property-info-list {
            grid-template-columns: 1fr;
        }

        .property-info-item:nth-child(even) {
            padding-left: 0;
            border-left: 0;
        }

        .property-info-item:nth-child(odd) {
            padding-right: 0;
        }

        .property-specs {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="property-detail-page">

    <div class="container">

        {{-- Breadcrumb --}}
        <div class="property-breadcrumb">
            <a href="{{ route('terra.home') }}">
                Home
            </a>

            <span class="mx-2 text-muted">/</span>

            <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}">
                Units for Rent
            </a>

            <span class="mx-2 text-muted">/</span>

            <span class="current">
                {{ $unit->unit_number ?? 'Unit Details' }}
            </span>
        </div>

        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-8">

                {{-- Gallery --}}
                <div class="property-gallery">

                    @if($images->count())

                        <img
                            id="mainPropertyImage"
                            src="{{ $imageUrl($images->first()) }}"
                            alt="{{ $property?->title ?? 'Rental property' }}"
                            class="property-main-image"
                        >

                        @if($images->count() > 1)
                            <div class="property-thumbnails">

                                @foreach($images as $index => $image)
                                    <button
                                        type="button"
                                        class="property-thumbnail {{ $index === 0 ? 'active' : '' }}"
                                        onclick="changePropertyImage('{{ $imageUrl($image) }}', this)"
                                    >
                                        <img
                                            src="{{ $imageUrl($image) }}"
                                            alt="Property image {{ $index + 1 }}"
                                        >
                                    </button>
                                @endforeach

                            </div>
                        @endif

                    @else

                        <div class="empty-gallery">
                            <i class="bi bi-house"></i>
                            <div>No property images available</div>
                        </div>

                    @endif

                </div>

                {{-- Description --}}
                <div class="property-content-card">

                    <h2 class="section-title">
                        About this unit
                    </h2>

                    <div class="property-description">
                        @if($unit->description)
                            {{ $unit->description }}
                        @elseif($property?->description)
                            {{ $property->description }}
                        @else
                            This unit is available for rent through Terra Property Management.
                            Contact our team to arrange a viewing and receive more information
                            about the property.
                        @endif
                    </div>

                </div>

                {{-- Unit / Property Information --}}
                <div class="property-content-card">

                    <h2 class="section-title">
                        Property information
                    </h2>

                    <div class="property-info-list">

                        <div class="property-info-item">
                            <div class="property-info-label">Unit</div>
                            <div class="property-info-value">
                                {{ $unit->unit_number ?? '—' }}
                            </div>
                        </div>

                        <div class="property-info-item">
                            <div class="property-info-label">Unit type</div>
                            <div class="property-info-value">
                                {{ $unit->unit_type
                                    ? ucwords(str_replace('_', ' ', $unit->unit_type))
                                    : '—'
                                }}
                            </div>
                        </div>

                        <div class="property-info-item">
                            <div class="property-info-label">Building</div>
                            <div class="property-info-value">
                                {{ $building?->name ?? $building?->reference ?? '—' }}
                            </div>
                        </div>

                        <div class="property-info-item">
                            <div class="property-info-label">Property</div>
                            <div class="property-info-value">
                                {{ $property?->title ?? '—' }}
                            </div>
                        </div>

                        <div class="property-info-item">
                            <div class="property-info-label">District</div>
                            <div class="property-info-value">
                                {{ $property?->district ?? '—' }}
                            </div>
                        </div>

                        <div class="property-info-item">
                            <div class="property-info-label">Sector</div>
                            <div class="property-info-value">
                                {{ $property?->sector ?? '—' }}
                            </div>
                        </div>

                        <div class="property-info-item">
                            <div class="property-info-label">Floor</div>
                            <div class="property-info-value">
                                {{ $floor?->name ?? $floor?->floor_number ?? '—' }}
                            </div>
                        </div>

                        <div class="property-info-item">
                            <div class="property-info-label">Availability</div>
                            <div class="property-info-value">
                                Available for rent
                            </div>
                        </div>

                    </div>

                </div>

                {{-- Management Information --}}
                <div class="management-card">

                    <h3>
                        Professionally managed by Terra
                    </h3>

                    <p class="mb-3">
                        This rental is presented through Terra Property Management.
                        We help tenants find quality homes while providing owners and
                        developers with professional property management services.
                    </p>

                    <a href="{{ route('terra.home') }}#property-management">
                        Learn about property management
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-4">

                <div class="property-summary">

                    <span class="property-status">
                        Available
                    </span>

                    <h1 class="property-title">
                        {{ $unit->unit_number
                            ? 'Unit ' . $unit->unit_number
                            : ($property?->title ?? 'Rental Unit')
                        }}
                    </h1>

                    @if($property?->title)
                        <div class="fw-semibold mb-2" style="color:#303643;">
                            {{ $property->title }}
                        </div>
                    @endif

                    <div class="property-location">

                        <i class="bi bi-geo-alt-fill"></i>

                        <span>
                            @if($property?->district)
                                {{ $property->district }}

                                @if($property?->sector)
                                    , {{ $property->sector }}
                                @endif
                            @else
                                Kigali, Rwanda
                            @endif
                        </span>

                    </div>

                    {{-- Rent --}}
                    <div class="property-price">

                        <div class="property-price-label">
                            Monthly rent
                        </div>

                        @if($rent !== null)
                            <div class="property-price-value">
                                {{ number_format((float) $rent) }}
                                <span style="font-size:16px;">RWF</span>
                            </div>

                            <div class="property-price-period">
                                per month
                            </div>
                        @else
                            <div class="property-price-value" style="font-size:24px;">
                                Price on request
                            </div>
                        @endif

                    </div>

                    {{-- Specs --}}
                    <div class="property-specs">

                        <div class="property-spec">

                            <div>
                                <i class="bi bi-door-open"></i>

                                <span class="property-spec-value">
                                    {{ $unit->bedrooms ?? 0 }}
                                </span>
                            </div>

                            <span class="property-spec-label">
                                Bedrooms
                            </span>

                        </div>

                        <div class="property-spec">

                            <div>
                                <i class="bi bi-droplet"></i>

                                <span class="property-spec-value">
                                    {{ $unit->bathrooms ?? 0 }}
                                </span>
                            </div>

                            <span class="property-spec-label">
                                Bathrooms
                            </span>

                        </div>

                        <div class="property-spec">

                            <div>
                                <i class="bi bi-aspect-ratio"></i>

                                <span class="property-spec-value">
                                    {{ $unit->size ?? '—' }}
                                </span>

                                @if($unit->size)
                                    <small class="text-muted">m²</small>
                                @endif
                            </div>

                            <span class="property-spec-label">
                                Size
                            </span>

                        </div>

                        <div class="property-spec">

                            <div>
                                <i class="bi bi-building"></i>

                                <span class="property-spec-value">
                                    {{ $building?->name ?? 'Property' }}
                                </span>
                            </div>

                            <span class="property-spec-label">
                                Building
                            </span>

                        </div>

                    </div>

                    {{-- Inquiry --}}
                    <a
                        href="{{ route('terra.contact', [
                            'unit' => $unit->id
                        ]) }}"
                        class="property-inquiry-btn"
                    >
                        <i class="bi bi-send"></i>
                        Inquire About This Unit
                    </a>

                    <a
                        href="https://wa.me/250788000000?text={{ urlencode(
                            'Hello Terra Property Management, I am interested in Unit ' .
                            ($unit->unit_number ?? $unit->id) .
                            ($property?->title ? ' at ' . $property->title : '') .
                            '. Please share more information.'
                        ) }}"
                        target="_blank"
                        rel="noopener"
                        class="property-contact-btn"
                    >
                        <i class="bi bi-whatsapp"></i>
                        Contact on WhatsApp
                    </a>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Available for viewing by appointment
                        </small>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    function changePropertyImage(url, button) {
        const mainImage = document.getElementById('mainPropertyImage');

        if (!mainImage) {
            return;
        }

        mainImage.src = url;

        document
            .querySelectorAll('.property-thumbnail')
            .forEach(function (item) {
                item.classList.remove('active');
            });

        button.classList.add('active');
    }
</script>

@endsection