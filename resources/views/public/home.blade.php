@extends('public.layouts.app')

@section('title', 'Terra Property Management | Kigali Rentals & Property Management')

@section('content')

<style>
    :root {
        --terra-orange: #D05208;
        --terra-orange-dark: #ad4205;
        --terra-navy: #19265d;
        --terra-dark: #111936;
        --terra-text: #303643;
        --terra-muted: #737b8c;
        --terra-light: #f7f8fa;
        --terra-border: #e7e9ee;
    }

    .terra-home {
        background: #fff;
        color: var(--terra-text);
    }

    /* ---------------------------------------------------------
       HERO
    --------------------------------------------------------- */

    .pm-hero {
        position: relative;
        min-height: 680px;
        display: flex;
        align-items: center;
        overflow: hidden;
        background:
            linear-gradient(
                90deg,
                rgba(17, 25, 54, .96) 0%,
                rgba(17, 25, 54, .88) 42%,
                rgba(17, 25, 54, .38) 72%,
                rgba(17, 25, 54, .15) 100%
            ),
            linear-gradient(135deg, #19265d, #303d75);
    }

    .pm-hero::after {
        content: "";
        position: absolute;
        width: 520px;
        height: 520px;
        right: -180px;
        top: -180px;
        border: 1px solid rgba(255,255,255,.14);
        border-radius: 50%;
    }

    .pm-hero-content {
        position: relative;
        z-index: 2;
        max-width: 760px;
        padding: 110px 0;
    }

    .pm-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
        margin-bottom: 22px;
    }

    .pm-eyebrow::before {
        content: "";
        width: 38px;
        height: 2px;
        background: var(--terra-orange);
    }

    .pm-hero h1 {
        color: #fff;
        font-size: clamp(2.8rem, 5vw, 5.2rem);
        line-height: 1.02;
        font-weight: 700;
        letter-spacing: -.045em;
        margin-bottom: 25px;
    }

    .pm-hero h1 span {
        color: #f07b37;
    }

    .pm-hero-text {
        color: rgba(255,255,255,.78);
        font-size: 1.12rem;
        line-height: 1.8;
        max-width: 650px;
        margin-bottom: 34px;
    }

    .pm-actions {
        display: flex;
        gap: 13px;
        flex-wrap: wrap;
    }

    .btn-terra {
        background: var(--terra-orange);
        color: #fff;
        border: 1px solid var(--terra-orange);
        border-radius: 5px;
        padding: 14px 25px;
        font-weight: 700;
    }

    .btn-terra:hover {
        background: var(--terra-orange-dark);
        border-color: var(--terra-orange-dark);
        color: #fff;
    }

    .btn-outline-white {
        color: #fff;
        border: 1px solid rgba(255,255,255,.55);
        background: rgba(255,255,255,.04);
        border-radius: 5px;
        padding: 14px 25px;
        font-weight: 600;
    }

    .btn-outline-white:hover {
        background: #fff;
        color: var(--terra-navy);
    }

    /* ---------------------------------------------------------
       INTRO
    --------------------------------------------------------- */

    .pm-section {
        padding: 95px 0;
    }

    .pm-section-soft {
        background: var(--terra-light);
    }

    .pm-section-label {
        color: var(--terra-orange);
        font-size: .75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .14em;
        margin-bottom: 12px;
    }

    .pm-section-title {
        color: var(--terra-navy);
        font-size: clamp(2rem, 3.4vw, 3.4rem);
        font-weight: 700;
        line-height: 1.12;
        letter-spacing: -.035em;
        margin-bottom: 18px;
    }

    .pm-section-text {
        color: var(--terra-muted);
        font-size: 1rem;
        line-height: 1.85;
    }

    /* ---------------------------------------------------------
       SERVICE INTRO
    --------------------------------------------------------- */

    .management-intro {
        border-top: 1px solid var(--terra-border);
        border-bottom: 1px solid var(--terra-border);
    }

    .management-box {
        padding: 45px 0;
    }

    .management-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(208, 82, 8, .09);
        color: var(--terra-orange);
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .management-box h3 {
        color: var(--terra-navy);
        font-weight: 700;
        margin-bottom: 12px;
    }

    /* ---------------------------------------------------------
       PROPERTY COLLECTION
    --------------------------------------------------------- */

    .residence-card {
        height: 100%;
        border: 1px solid var(--terra-border);
        background: #fff;
        transition: .25s ease;
    }

    .residence-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(25,38,93,.09);
    }

    .residence-top {
        min-height: 220px;
        padding: 28px;
        background:
            linear-gradient(
                135deg,
                rgba(25,38,93,.96),
                rgba(25,38,93,.75)
            );
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .residence-top::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 50%;
        right: -50px;
        bottom: -70px;
    }

    .residence-status {
        display: inline-block;
        padding: 6px 10px;
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        background: var(--terra-orange);
        margin-bottom: 55px;
    }

    .residence-top h3 {
        position: relative;
        z-index: 2;
        font-size: 1.45rem;
        font-weight: 700;
        margin: 0;
    }

    .residence-body {
        padding: 25px;
    }

    .residence-location {
        color: var(--terra-muted);
        font-size: .9rem;
        margin-bottom: 18px;
    }

    .residence-meta {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        font-size: .83rem;
        color: var(--terra-muted);
    }

    .residence-meta i {
        color: var(--terra-orange);
        margin-right: 5px;
    }

    /* ---------------------------------------------------------
       AVAILABLE UNITS
    --------------------------------------------------------- */

    .unit-card {
        height: 100%;
        background: #fff;
        border: 1px solid var(--terra-border);
        transition: .25s ease;
    }

    .unit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 45px rgba(25,38,93,.09);
    }

    .unit-image {
        height: 235px;
        background:
            linear-gradient(
                135deg,
                #19265d,
                #46527d
            );
        position: relative;
        display: flex;
        align-items: flex-end;
        padding: 20px;
        overflow: hidden;
    }

    .unit-image::before {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 50%;
        top: -100px;
        right: -60px;
    }

    .unit-type {
        position: relative;
        z-index: 2;
        color: #fff;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        background: rgba(208,82,8,.95);
        padding: 7px 11px;
    }

    .unit-body {
        padding: 24px;
    }

    .unit-title {
        color: var(--terra-navy);
        font-weight: 700;
        font-size: 1.05rem;
        line-height: 1.45;
        margin-bottom: 8px;
    }

    .unit-location {
        color: var(--terra-muted);
        font-size: .82rem;
        margin-bottom: 20px;
    }

    .unit-features {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        border-top: 1px solid var(--terra-border);
        padding-top: 16px;
        margin-bottom: 20px;
    }

    .unit-feature {
        color: var(--terra-muted);
        font-size: .8rem;
    }

    .unit-feature i {
        color: var(--terra-orange);
        margin-right: 4px;
    }

    .unit-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .unit-price {
        color: var(--terra-navy);
        font-size: 1.15rem;
        font-weight: 800;
    }

    .unit-price small {
        color: var(--terra-muted);
        font-size: .7rem;
        font-weight: 500;
    }

    .unit-details {
        color: var(--terra-orange);
        font-weight: 700;
        font-size: .82rem;
        text-decoration: none;
    }

    .unit-details:hover {
        color: var(--terra-orange-dark);
    }

    /* ---------------------------------------------------------
       OWNER CTA
    --------------------------------------------------------- */

    .owner-section {
        background: var(--terra-navy);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .owner-section::before {
        content: "";
        position: absolute;
        width: 480px;
        height: 480px;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 50%;
        left: -220px;
        top: -200px;
    }

    .owner-content {
        position: relative;
        z-index: 2;
        padding: 95px 0;
    }

    .owner-content .pm-section-label {
        color: #f07b37;
    }

    .owner-content h2 {
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 700;
        letter-spacing: -.035em;
        margin-bottom: 20px;
    }

    .owner-content p {
        color: rgba(255,255,255,.7);
        line-height: 1.8;
        max-width: 680px;
    }

    .owner-services {
        margin-top: 30px;
    }

    .owner-service {
        display: flex;
        gap: 13px;
        align-items: flex-start;
        margin-bottom: 15px;
        color: rgba(255,255,255,.82);
    }

    .owner-service i {
        color: #f07b37;
        margin-top: 3px;
    }

    /* ---------------------------------------------------------
       STATS
    --------------------------------------------------------- */

    .stats-section {
        background: #fff;
        border-bottom: 1px solid var(--terra-border);
    }

    .stat {
        padding: 45px 25px;
        text-align: center;
        border-right: 1px solid var(--terra-border);
    }

    .stat:last-child {
        border-right: none;
    }

    .stat-number {
        color: var(--terra-navy);
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 9px;
    }

    .stat-label {
        color: var(--terra-muted);
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        font-weight: 600;
    }

    /* ---------------------------------------------------------
       FINAL CTA
    --------------------------------------------------------- */

    .final-cta {
        padding: 95px 0;
        text-align: center;
        background: var(--terra-light);
    }

    .final-cta h2 {
        color: var(--terra-navy);
        font-size: clamp(2rem, 4vw, 3.4rem);
        font-weight: 700;
        letter-spacing: -.04em;
        margin-bottom: 18px;
    }

    .final-cta p {
        max-width: 650px;
        margin: 0 auto 30px;
        color: var(--terra-muted);
        line-height: 1.8;
    }

    /* ---------------------------------------------------------
       EMPTY STATE
    --------------------------------------------------------- */

    .empty-units {
        padding: 60px 30px;
        border: 1px dashed #d9dde5;
        text-align: center;
        background: #fff;
    }

    .empty-units i {
        color: var(--terra-orange);
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .empty-units h4 {
        color: var(--terra-navy);
        font-weight: 700;
    }

    .empty-units p {
        color: var(--terra-muted);
    }

    /* ---------------------------------------------------------
       RESPONSIVE
    --------------------------------------------------------- */

    @media (max-width: 991px) {
        .pm-hero {
            min-height: 600px;
        }

        .stat {
            border-right: none;
            border-bottom: 1px solid var(--terra-border);
        }

        .stat:last-child {
            border-bottom: none;
        }
    }

    @media (max-width: 767px) {
        .pm-section,
        .owner-content,
        .final-cta {
            padding: 70px 0;
        }

        .pm-hero-content {
            padding: 90px 0;
        }

        .pm-hero h1 {
            font-size: 2.8rem;
        }

        .unit-image {
            height: 210px;
        }
    }
</style>

<div class="terra-home">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="pm-hero">

        <div class="container">

            <div class="pm-hero-content">

                <div class="pm-eyebrow">
                    Terra Property Management
                </div>

                <h1>
                    Kigali rentals,
                    <span>professionally managed.</span>
                </h1>

                <p class="pm-hero-text">
                    Discover quality rental homes and professionally managed
                    residences across Kigali. Terra connects you with available
                    apartments, houses and managed properties while giving
                    owners and developers one trusted partner for property management.
                </p>

                <div class="pm-actions">

                    <a href="#available-units" class="btn btn-terra">
                        View Available Units
                    </a>

                    <a href="#property-management" class="btn btn-outline-white">
                        Property Management
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         INTRO
    ====================================================== --}}

    <section class="pm-section">

        <div class="container">

            <div class="row align-items-center g-5">

                <div class="col-lg-7">

                    <div class="pm-section-label">
                        Terra Property Management
                    </div>

                    <h2 class="pm-section-title">
                        Quality homes. Reliable management. One trusted partner.
                    </h2>

                    <p class="pm-section-text">
                        Terra Property Management brings together professionally
                        managed residential properties and rental units across Kigali.
                        Whether you are looking for your next home or need a reliable
                        partner to manage your property, we make the process simple,
                        transparent and professional.
                    </p>

                    <p class="pm-section-text mb-0">
                        Explore available units, discover managed residences and
                        connect directly with our property management team.
                    </p>

                </div>

                <div class="col-lg-5">

                    <div class="management-box">

                        <div class="management-icon">
                            <i class="bi bi-buildings"></i>
                        </div>

                        <h3>
                            Apartments & Homes for Rent
                        </h3>

                        <p class="pm-section-text mb-0">
                            Find available rental units in professionally managed
                            properties throughout Kigali.
                        </p>

                    </div>

                    <div class="management-box border-top">

                        <div class="management-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>

                        <h3>
                            For Owners & Developers
                        </h3>

                        <p class="pm-section-text mb-0">
                            Professional property management designed to protect
                            your investment and simplify operations.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         STATS
    ====================================================== --}}

    <section class="stats-section">

        <div class="container">

            <div class="row g-0">

                <div class="col-lg-4 col-md-4">
                    <div class="stat">
                        <div class="stat-number">
                            {{ number_format($managedProperties) }}
                        </div>
                        <div class="stat-label">
                            Managed Properties
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="stat">
                        <div class="stat-number">
                            {{ number_format($totalUnits) }}
                        </div>
                        <div class="stat-label">
                            Rental Units
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="stat">
                        <div class="stat-number">
                            {{ number_format($availableUnitCount) }}
                        </div>
                        <div class="stat-label">
                            Available Units
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         MANAGED RESIDENCES
    ====================================================== --}}

    <section class="pm-section pm-section-soft">

        <div class="container">

            <div class="row align-items-end mb-5">

                <div class="col-lg-8">

                    <div class="pm-section-label">
                        Our Residences
                    </div>

                    <h2 class="pm-section-title mb-2">
                        Properties managed by Terra
                    </h2>

                    <p class="pm-section-text mb-0">
                        Explore residential properties and rental communities
                        professionally managed through Terra.
                    </p>

                </div>

                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                    <a href="{{ route('terra.properties.index') }}"
                       class="btn btn-outline-dark px-4 py-3">
                        View All Properties
                    </a>

                </div>

            </div>


            <div class="row g-4">

                @forelse($properties->take(6) as $property)

                    <div class="col-lg-4 col-md-6">

                        <div class="residence-card">

                            <div class="residence-top">

                                <span class="residence-status">
                                    {{ ucfirst($property->listing_type ?? 'Rental') }}
                                </span>

                                <h3>
                                    {{ $property->title }}
                                </h3>

                            </div>

                            <div class="residence-body">

                                <div class="residence-location">

                                    <i class="bi bi-geo-alt me-1"></i>

                                    {{ $property->district ?: 'Kigali' }}

                                    @if($property->sector)
                                        , {{ $property->sector }}
                                    @endif

                                </div>

                                <div class="residence-meta">

                                    <span>
                                        <i class="bi bi-buildings"></i>
                                        {{ $property->buildings->count() }}
                                        {{ \Illuminate\Support\Str::plural('Building', $property->buildings->count()) }}
                                    </span>

                                    <span>
                                        <i class="bi bi-door-open"></i>
                                        {{ $property->buildings->sum(fn ($building) => $building->units->count()) }}
                                        Units
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="empty-units">

                            <i class="bi bi-buildings"></i>

                            <h4>
                                Properties are being prepared
                            </h4>

                            <p class="mb-0">
                                Our managed residential portfolio will appear here
                                as properties become available.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </section>


    {{-- =====================================================
         AVAILABLE UNITS
    ====================================================== --}}

    <section class="pm-section" id="available-units">

        <div class="container">

            <div class="row align-items-end mb-5">

                <div class="col-lg-8">

                    <div class="pm-section-label">
                        Available Units
                    </div>

                    <h2 class="pm-section-title mb-2">
                        Find your new home in Kigali
                    </h2>

                    <p class="pm-section-text mb-0">
                        Browse currently available rental units in our managed
                        properties. Contact our team for viewing and availability.
                    </p>

                </div>

                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                    <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}"
                       class="btn btn-terra">
                        See All Rentals
                    </a>

                </div>

            </div>


            @if($availableUnits->count())

                <div class="row g-4">

                    @foreach($availableUnits as $unit)

                        @php
                            $property = $unit->floor?->building?->property;
                            $building = $unit->floor?->building;
                        @endphp

                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <article class="unit-card">

                                <div class="unit-image">

                                    <span class="unit-type">

                                        {{ $unit->unit_type
                                            ? ucwords(str_replace(['_', '-'], ' ', $unit->unit_type))
                                            : 'Apartment'
                                        }}

                                    </span>

                                </div>


                                <div class="unit-body">

                                    <div class="unit-title">

                                        @if($unit->unit_type)
                                            {{ ucwords(str_replace(['_', '-'], ' ', $unit->unit_type)) }}
                                        @else
                                            Rental Unit
                                        @endif

                                        @if($property)
                                            at {{ $property->title }}
                                        @endif

                                    </div>


                                    <div class="unit-location">

                                        <i class="bi bi-geo-alt"></i>

                                        @if($property?->district)
                                            {{ $property->district }}
                                        @else
                                            Kigali
                                        @endif

                                        @if($property?->sector)
                                            , {{ $property->sector }}
                                        @endif

                                    </div>


                                    <div class="unit-features">

                                        @if(!is_null($unit->bedrooms))

                                            <span class="unit-feature">
                                                <i class="bi bi-door-closed"></i>
                                                {{ $unit->bedrooms }}
                                                {{ \Illuminate\Support\Str::plural('Bedroom', $unit->bedrooms) }}
                                            </span>

                                        @endif


                                        @if(!is_null($unit->bathrooms))

                                            <span class="unit-feature">
                                                <i class="bi bi-droplet"></i>
                                                {{ $unit->bathrooms }}
                                                {{ \Illuminate\Support\Str::plural('Bath', $unit->bathrooms) }}
                                            </span>

                                        @endif


                                        @if($unit->size)

                                            <span class="unit-feature">
                                                <i class="bi bi-rulers"></i>
                                                {{ number_format($unit->size, 0) }} m²
                                            </span>

                                        @endif

                                    </div>


                                    <div class="unit-footer">

                                        <div class="unit-price">

                                            {{ number_format((float) $unit->rent) }}
                                            RWF

                                            <small>/ month</small>

                                        </div>


                                        <a href="{{ route('terra.properties.show', $property) }}"
                                           class="unit-details">

                                            Details
                                            <i class="bi bi-arrow-right"></i>

                                        </a>

                                    </div>

                                </div>

                            </article>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="empty-units">

                    <i class="bi bi-house-door"></i>

                    <h4>
                        No units currently available
                    </h4>

                    <p>
                        We do not have any vacant rental units listed at the moment.
                        Contact Terra and we will help you find a suitable property.
                    </p>

                    <a href="{{ route('terra.contact') }}"
                       class="btn btn-terra mt-2">
                        Inquire Now
                    </a>

                </div>

            @endif

        </div>

    </section>


    {{-- =====================================================
         PROPERTY MANAGEMENT
    ====================================================== --}}

    <section class="owner-section" id="property-management">

        <div class="container">

            <div class="owner-content">

                <div class="row align-items-center g-5">

                    <div class="col-lg-8">

                        <div class="pm-section-label">
                            For Owners & Developers
                        </div>

                        <h2>
                            One partner.
                            <br>
                            All handled.
                        </h2>

                        <p>
                            Terra Property Management provides professional
                            management services for residential properties,
                            rental buildings and real-estate investments across Kigali.
                        </p>


                        <div class="owner-services">

                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>
                                    Tenant management and support
                                </span>
                            </div>

                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>
                                    Rental and occupancy management
                                </span>
                            </div>

                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>
                                    Lease and application management
                                </span>
                            </div>

                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>
                                    Property and unit administration
                                </span>
                            </div>

                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>
                                    Professional tenant communication
                                </span>
                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4">

                        <div class="border p-4"
                             style="border-color: rgba(255,255,255,.16) !important;">

                            <div class="small text-uppercase fw-bold mb-3"
                                 style="color:#f07b37; letter-spacing:.12em;">
                                Property Management
                            </div>

                            <h4 class="fw-bold mb-3">
                                Let us manage your property.
                            </h4>

                            <p class="small mb-4"
                               style="color:rgba(255,255,255,.65); line-height:1.8;">
                                Talk to our team about managing your residential
                                property, rental building or real-estate portfolio.
                            </p>

                            <a href="{{ route('terra.contact') }}"
                               class="btn btn-terra w-100">
                                Inquire Now
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         FINAL CTA
    ====================================================== --}}

    <section class="final-cta">

        <div class="container">

            <div class="pm-section-label">
                Terra Real Estate
            </div>

            <h2>
                Looking for your next home?
            </h2>

            <p>
                Explore available properties and rental units across Kigali,
                or speak with our team about your requirements.
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">

                <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}"
                   class="btn btn-terra px-4 py-3">
                    Browse Rentals
                </a>

                <a href="{{ route('terra.contact') }}"
                   class="btn btn-outline-dark px-4 py-3">
                    Contact Terra
                </a>

            </div>

        </div>

    </section>

</div>

@endsection