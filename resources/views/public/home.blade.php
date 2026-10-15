@extends('public.layouts.app')

@section('title', 'Terra Property Management | Available Units & Property Management in Kigali')

@section('content')

<style>
    .terra-pm {
        --terra-orange: #D05208;
        --terra-orange-dark: #ad4205;
        --terra-orange-soft: #f07b37;
        --terra-navy: #19265d;
        --terra-dark: #111936;
        --terra-text: #303643;
        --terra-muted: #737b8c;
        --terra-light: #f7f8fa;
        --terra-border: #e7e9ee;

        background: #fff;
        color: var(--terra-text);
    }

    /* ---------- Hero ---------- */
    .terra-pm .pm-hero {
        position: relative;
        overflow: hidden;
        padding: 110px 0 150px;
        background: linear-gradient(135deg, #111936 0%, #19265d 55%, #303d75 100%);
    }

    .terra-pm .pm-hero::after {
        content: "";
        position: absolute;
        width: 520px;
        height: 520px;
        right: -180px;
        top: -180px;
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 50%;
    }

    .terra-pm .pm-hero-content {
        position: relative;
        z-index: 2;
        max-width: 760px;
    }

    .terra-pm .pm-eyebrow {
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

    .terra-pm .pm-eyebrow::before {
        content: "";
        width: 38px;
        height: 2px;
        background: var(--terra-orange);
    }

    .terra-pm .pm-hero h1 {
        color: #fff;
        font-size: clamp(2.6rem, 5vw, 4.8rem);
        line-height: 1.04;
        font-weight: 700;
        letter-spacing: -.045em;
        margin-bottom: 22px;
    }

    .terra-pm .pm-hero h1 span {
        color: var(--terra-orange-soft);
    }

    .terra-pm .pm-hero-text {
        color: rgba(255, 255, 255, .78);
        font-size: 1.1rem;
        line-height: 1.8;
        max-width: 640px;
        margin-bottom: 32px;
    }

    .terra-pm .btn-terra {
        background: var(--terra-orange);
        color: #fff;
        border: 1px solid var(--terra-orange);
        border-radius: 5px;
        padding: 13px 24px;
        font-weight: 700;
    }

    .terra-pm .btn-terra:hover {
        background: var(--terra-orange-dark);
        border-color: var(--terra-orange-dark);
        color: #fff;
    }

    .terra-pm .btn-outline-white {
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .55);
        background: rgba(255, 255, 255, .04);
        border-radius: 5px;
        padding: 13px 24px;
        font-weight: 600;
    }

    .terra-pm .btn-outline-white:hover {
        background: #fff;
        color: var(--terra-navy);
    }

    /* ---------- Stats (overlaps hero) ---------- */
    .terra-pm .stats-wrap {
        position: relative;
        z-index: 5;
        margin-top: -75px;
    }

    .terra-pm .stats-card {
        background: #fff;
        border: 1px solid var(--terra-border);
        box-shadow: 0 22px 55px rgba(25, 38, 93, .12);
    }

    .terra-pm .stat {
        padding: 34px 20px;
        text-align: center;
        border-right: 1px solid var(--terra-border);
        height: 100%;
    }

    .terra-pm .stats-card .col-6:last-child .stat,
    .terra-pm .stats-card .col-lg-3:last-child .stat {
        border-right: none;
    }

    .terra-pm .stat-number {
        color: var(--terra-navy);
        font-size: 2.1rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 9px;
    }

    .terra-pm .stat-number small {
        font-size: .9rem;
        font-weight: 700;
        color: var(--terra-muted);
    }

    .terra-pm .stat-label {
        color: var(--terra-muted);
        font-size: .74rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        font-weight: 600;
    }

    /* ---------- Sections ---------- */
    .terra-pm .pm-section {
        padding: 90px 0;
    }

    .terra-pm .pm-section-soft {
        background: var(--terra-light);
    }

    .terra-pm .pm-section-label {
        color: var(--terra-orange);
        font-size: .75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .14em;
        margin-bottom: 12px;
    }

    .terra-pm .pm-section-title {
        color: var(--terra-navy);
        font-size: clamp(1.9rem, 3.2vw, 3.1rem);
        font-weight: 700;
        line-height: 1.12;
        letter-spacing: -.035em;
        margin-bottom: 16px;
    }

    .terra-pm .pm-section-text {
        color: var(--terra-muted);
        line-height: 1.85;
    }

    /* ---------- Why Terra ---------- */
    .terra-pm .feature-box {
        height: 100%;
        padding: 32px 28px;
        background: #fff;
        border: 1px solid var(--terra-border);
    }

    .terra-pm .feature-icon {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(208, 82, 8, .09);
        color: var(--terra-orange);
        font-size: 1.4rem;
        margin-bottom: 18px;
    }

    .terra-pm .feature-box h3 {
        color: var(--terra-navy);
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .terra-pm .feature-box p {
        color: var(--terra-muted);
        font-size: .93rem;
        line-height: 1.75;
        margin: 0;
    }

    /* ---------- Filter bar ---------- */
    .terra-pm .filter-bar {
        background: var(--terra-light);
        border: 1px solid var(--terra-border);
        padding: 22px;
        margin-bottom: 34px;
    }

    .terra-pm .filter-bar label {
        font-size: .7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--terra-navy);
        margin-bottom: 6px;
    }

    .terra-pm .filter-bar .form-control,
    .terra-pm .filter-bar .form-select {
        border-radius: 4px;
        border-color: var(--terra-border);
        font-size: .9rem;
        padding: 10px 12px;
    }

    .terra-pm .filter-bar .form-control:focus,
    .terra-pm .filter-bar .form-select:focus {
        border-color: var(--terra-orange);
        box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .12);
    }

    .terra-pm .results-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 22px;
        color: var(--terra-muted);
        font-size: .9rem;
    }

    .terra-pm .results-bar strong {
        color: var(--terra-navy);
    }

    /* ---------- Unit cards ---------- */
    .terra-pm .unit-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 1px solid var(--terra-border);
        transition: .25s ease;
    }

    .terra-pm .unit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 45px rgba(25, 38, 93, .1);
    }

    .terra-pm .unit-image {
        height: 190px;
        position: relative;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        padding: 18px;
        overflow: hidden;
        background: linear-gradient(135deg, #19265d, #46527d);
    }

    .terra-pm .unit-image::before {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 50%;
        top: -100px;
        right: -60px;
    }

    .terra-pm .unit-badge {
        position: relative;
        z-index: 2;
        color: #fff;
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: 6px 10px;
        background: rgba(208, 82, 8, .95);
    }

    .terra-pm .unit-number {
        position: relative;
        z-index: 2;
        color: rgba(255, 255, 255, .85);
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .04em;
    }

    .terra-pm .unit-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .terra-pm .unit-title {
        color: var(--terra-navy);
        font-weight: 700;
        font-size: 1.05rem;
        line-height: 1.4;
        margin-bottom: 6px;
    }

    .terra-pm .unit-location {
        color: var(--terra-muted);
        font-size: .82rem;
        margin-bottom: 18px;
    }

    .terra-pm .unit-features {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        border-top: 1px solid var(--terra-border);
        padding-top: 14px;
        margin-bottom: 18px;
    }

    .terra-pm .unit-feature {
        color: var(--terra-muted);
        font-size: .8rem;
    }

    .terra-pm .unit-feature i {
        color: var(--terra-orange);
        margin-right: 4px;
    }

    .terra-pm .unit-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 10px;
    }

    .terra-pm .unit-price {
        color: var(--terra-navy);
        font-size: 1.15rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .terra-pm .unit-price small {
        color: var(--terra-muted);
        font-size: .7rem;
        font-weight: 500;
    }

    .terra-pm .unit-deposit {
        display: block;
        color: var(--terra-muted);
        font-size: .72rem;
        font-weight: 500;
        margin-top: 3px;
    }

    .terra-pm .unit-details {
        color: var(--terra-orange);
        font-weight: 700;
        font-size: .82rem;
        text-decoration: none;
        background: none;
        border: none;
        padding: 0;
        white-space: nowrap;
    }

    .terra-pm .unit-details:hover {
        color: var(--terra-orange-dark);
    }

    /* ---------- Property cards ---------- */
    .terra-pm .residence-card {
        height: 100%;
        border: 1px solid var(--terra-border);
        background: #fff;
        transition: .25s ease;
    }

    .terra-pm .residence-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(25, 38, 93, .09);
    }

    .terra-pm .residence-top {
        min-height: 170px;
        padding: 26px;
        color: #fff;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(25, 38, 93, .97), rgba(25, 38, 93, .75));
    }

    .terra-pm .residence-top::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 50%;
        right: -50px;
        bottom: -70px;
    }

    .terra-pm .residence-status {
        display: inline-block;
        padding: 6px 10px;
        font-size: .66rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        background: var(--terra-orange);
        margin-bottom: 38px;
    }

    .terra-pm .residence-top h3 {
        position: relative;
        z-index: 2;
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0;
    }

    .terra-pm .residence-body {
        padding: 22px 24px;
    }

    .terra-pm .residence-location {
        color: var(--terra-muted);
        font-size: .9rem;
        margin-bottom: 16px;
    }

    .terra-pm .residence-meta {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        font-size: .83rem;
        color: var(--terra-muted);
    }

    .terra-pm .residence-meta i {
        color: var(--terra-orange);
        margin-right: 5px;
    }

    /* ---------- Process steps ---------- */
    .terra-pm .step-box {
        position: relative;
        padding: 30px 26px;
        background: #fff;
        border: 1px solid var(--terra-border);
        height: 100%;
    }

    .terra-pm .step-no {
        color: rgba(25, 38, 93, .1);
        font-size: 3.4rem;
        font-weight: 800;
        line-height: 1;
        position: absolute;
        top: 14px;
        right: 20px;
    }

    .terra-pm .step-box h4 {
        color: var(--terra-navy);
        font-size: 1.08rem;
        font-weight: 700;
        margin-bottom: 9px;
        position: relative;
    }

    .terra-pm .step-box p {
        color: var(--terra-muted);
        font-size: .92rem;
        line-height: 1.75;
        margin: 0;
        position: relative;
    }

    /* ---------- Owner CTA ---------- */
    .terra-pm .owner-section {
        background: var(--terra-navy);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .terra-pm .owner-section::before {
        content: "";
        position: absolute;
        width: 480px;
        height: 480px;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 50%;
        left: -220px;
        top: -200px;
    }

    .terra-pm .owner-content {
        position: relative;
        z-index: 2;
        padding: 90px 0;
    }

    .terra-pm .owner-content .pm-section-label {
        color: var(--terra-orange-soft);
    }

    .terra-pm .owner-content h2 {
        font-size: clamp(2rem, 4vw, 3.4rem);
        font-weight: 700;
        letter-spacing: -.035em;
        margin-bottom: 20px;
    }

    .terra-pm .owner-content p {
        color: rgba(255, 255, 255, .7);
        line-height: 1.8;
        max-width: 680px;
    }

    .terra-pm .owner-service {
        display: flex;
        gap: 13px;
        align-items: flex-start;
        margin-bottom: 14px;
        color: rgba(255, 255, 255, .84);
    }

    .terra-pm .owner-service i {
        color: var(--terra-orange-soft);
        margin-top: 3px;
    }

    /* ---------- FAQ ---------- */
    .terra-pm .accordion-item {
        border: 1px solid var(--terra-border);
        border-radius: 0 !important;
        margin-bottom: 12px;
    }

    .terra-pm .accordion-button {
        color: var(--terra-navy);
        font-weight: 700;
        border-radius: 0 !important;
    }

    .terra-pm .accordion-button:not(.collapsed) {
        color: var(--terra-orange);
        background: rgba(208, 82, 8, .05);
        box-shadow: none;
    }

    .terra-pm .accordion-button:focus {
        box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .12);
    }

    .terra-pm .accordion-body {
        color: var(--terra-muted);
        line-height: 1.8;
    }

    /* ---------- Empty state ---------- */
    .terra-pm .empty-units {
        padding: 60px 30px;
        border: 1px dashed #d9dde5;
        text-align: center;
        background: #fff;
    }

    .terra-pm .empty-units i {
        display: block;
        color: var(--terra-orange);
        font-size: 2rem;
        margin-bottom: 14px;
    }

    .terra-pm .empty-units h4 {
        color: var(--terra-navy);
        font-weight: 700;
    }

    .terra-pm .empty-units p {
        color: var(--terra-muted);
    }

    /* ---------- Modal ---------- */
    .terra-pm-modal .modal-content {
        border-radius: 0;
        border: none;
    }

    .terra-pm-modal .modal-header {
        background: #19265d;
        color: #fff;
        border-radius: 0;
        border: none;
    }

    .terra-pm-modal .btn-close {
        filter: invert(1);
    }

    .terra-pm-modal .spec-row {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 11px 0;
        border-bottom: 1px solid #e7e9ee;
        font-size: .92rem;
    }

    .terra-pm-modal .spec-row span:first-child {
        color: #737b8c;
    }

    .terra-pm-modal .spec-row span:last-child {
        color: #19265d;
        font-weight: 700;
        text-align: right;
    }

    .terra-pm-modal .btn-terra {
        background: #D05208;
        color: #fff;
        border: 1px solid #D05208;
        border-radius: 5px;
        padding: 12px 22px;
        font-weight: 700;
    }

    .terra-pm-modal .btn-terra:hover {
        background: #ad4205;
        border-color: #ad4205;
        color: #fff;
    }

    /* ---------- Final CTA ---------- */
    .terra-pm .final-cta {
        padding: 90px 0;
        text-align: center;
        background: var(--terra-light);
    }

    .terra-pm .final-cta h2 {
        color: var(--terra-navy);
        font-size: clamp(2rem, 4vw, 3.3rem);
        font-weight: 700;
        letter-spacing: -.04em;
        margin-bottom: 16px;
    }

    .terra-pm .final-cta p {
        max-width: 640px;
        margin: 0 auto 28px;
        color: var(--terra-muted);
        line-height: 1.8;
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 991px) {
        .terra-pm .pm-hero {
            padding: 90px 0 130px;
        }

        .terra-pm .stat {
            border-right: none;
            border-bottom: 1px solid var(--terra-border);
        }
    }

    @media (max-width: 767px) {

        .terra-pm .pm-section,
        .terra-pm .owner-content,
        .terra-pm .final-cta {
            padding: 65px 0;
        }

        .terra-pm .pm-hero h1 {
            font-size: 2.6rem;
        }

        .terra-pm .stat {
            padding: 24px 12px;
        }

        .terra-pm .stat-number {
            font-size: 1.6rem;
        }
    }
</style>

@php
// Helpers (ManagedProperty column names are tolerant: name/title, sector/district/city/address)
$propName = fn ($p) => $p?->name ?? $p?->title ?? 'Managed Property';

$propLocation = function ($p) {
$parts = collect([$p?->sector, $p?->district, $p?->city])->filter()->unique();
return $parts->isNotEmpty() ? $parts->implode(', ') : ($p?->address ?: 'Kigali');
};

$typeLabel = fn ($t) => $t ? ucwords(str_replace(['_', '-'], ' ', $t)) : 'Apartment';

$money = fn ($amount, $currency = 'RWF') => number_format((float) $amount) . ' ' . ($currency ?: 'RWF');

$hasFilters = collect($filters)->filter(fn ($v) => $v !== null && $v !== '')->except('sort')->isNotEmpty();
@endphp

<div class="terra-pm">

    {{-- =====================================================
         HERO
    ====================================================== --}}
    <section class="pm-hero">
        <div class="container">
            <div class="pm-hero-content">

                <div class="pm-eyebrow">Terra Property Management</div>

                <h1>
                    Kigali rentals,
                    <span>professionally managed.</span>
                </h1>

                <p class="pm-hero-text">
                    Browse available apartments and houses in properties managed by Terra,
                    with clear rent, deposit and unit details up front. Property owners and
                    developers get one trusted partner to run their buildings.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#available-units" class="btn btn-terra">View Available Units</a>
                    <a href="#property-management" class="btn btn-outline-white">Property Management</a>
                </div>

            </div>
        </div>
    </section>


    {{-- =====================================================
         STATS
    ====================================================== --}}
    <div class="container stats-wrap">
        <div class="stats-card">
            <div class="row g-0">

                <div class="col-6 col-lg-3">
                    <div class="stat">
                        <div class="stat-number">{{ number_format($managedProperties) }}</div>
                        <div class="stat-label">Managed Properties</div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat">
                        <div class="stat-number">{{ number_format($totalUnits) }}</div>
                        <div class="stat-label">Rental Units</div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat">
                        <div class="stat-number">{{ number_format($availableUnitCount) }}</div>
                        <div class="stat-label">Available Now</div>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="stat">
                        <div class="stat-number">
                            @if($startingRent)
                            <small>From</small> {{ number_format((float) $startingRent) }}
                            @else
                            —
                            @endif
                        </div>
                        <div class="stat-label">Monthly Rent (RWF)</div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- =====================================================
         WHY TERRA
    ====================================================== --}}
    <section class="pm-section">
        <div class="container">

            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <div class="pm-section-label">Why Rent With Terra</div>
                    <h2 class="pm-section-title">Quality homes. Reliable management.</h2>
                    <p class="pm-section-text mb-0">
                        Every unit on this page belongs to a property managed by our team,
                        so you deal with one professional point of contact from viewing to move-in.
                    </p>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <div class="feature-icon"><i class="bi bi-cash-stack"></i></div>
                        <h3>Transparent pricing</h3>
                        <p>Monthly rent and security deposit are shown on every unit, with no surprises at viewing.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <div class="feature-icon"><i class="bi bi-buildings"></i></div>
                        <h3>Managed buildings</h3>
                        <p>Properties are administered by Terra, from tenant communication to unit upkeep.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <div class="feature-icon"><i class="bi bi-file-earmark-text"></i></div>
                        <h3>Clear lease process</h3>
                        <p>Applications and leases are handled in one place, so you always know where you stand.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <div class="feature-icon"><i class="bi bi-tools"></i></div>
                        <h3>Maintenance support</h3>
                        <p>Report issues to the management team and have them tracked until they are resolved.</p>
                    </div>
                </div>

            </div>

        </div>
    </section>


    {{-- =====================================================
         AVAILABLE UNITS
    ====================================================== --}}
    <section class="pm-section pm-section-soft" id="available-units">
        <div class="container">

            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="pm-section-label">Available Units</div>
                    <h2 class="pm-section-title mb-2">Find your new home in Kigali</h2>
                    <p class="pm-section-text mb-0">
                        Units currently open for rent in Terra-managed properties.
                        Use the filters to narrow down by property, type, bedrooms or budget.
                    </p>
                </div>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ url()->current() }}#available-units" class="filter-bar">
                <div class="row g-3 align-items-end">

                    <div class="col-lg-3 col-md-6">
                        <label for="f-q">Search</label>
                        <input type="text" id="f-q" name="q" class="form-control"
                            placeholder="Unit number or keyword"
                            value="{{ $filters['q'] ?? '' }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="f-property">Property</label>
                        <select id="f-property" name="property" class="form-select">
                            <option value="">All properties</option>
                            @foreach($filterProperties as $fp)
                            <option value="{{ $fp->id }}" @selected((string) ($filters['property'] ?? '' )===(string) $fp->id)>
                                {{ $propName($fp) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <label for="f-type">Type</label>
                        <select id="f-type" name="type" class="form-select">
                            <option value="">Any type</option>
                            @foreach($unitTypes as $type)
                            <option value="{{ $type }}" @selected(($filters['type'] ?? '' )===$type)>
                                {{ $typeLabel($type) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <label for="f-beds">Bedrooms</label>
                        <select id="f-beds" name="bedrooms" class="form-select">
                            <option value="">Any</option>
                            <option value="0" @selected((string) ($filters['bedrooms'] ?? '' )==='0' )>Studio</option>
                            <option value="1" @selected((string) ($filters['bedrooms'] ?? '' )==='1' )>1</option>
                            <option value="2" @selected((string) ($filters['bedrooms'] ?? '' )==='2' )>2</option>
                            <option value="3" @selected((string) ($filters['bedrooms'] ?? '' )==='3' )>3</option>
                            <option value="4" @selected((string) ($filters['bedrooms'] ?? '' )==='4' )>4+</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <label for="f-sort">Sort by</label>
                        <select id="f-sort" name="sort" class="form-select">
                            <option value="newest" @selected($sort==='newest' )>Newest</option>
                            <option value="price_asc" @selected($sort==='price_asc' )>Rent: low to high</option>
                            <option value="price_desc" @selected($sort==='price_desc' )>Rent: high to low</option>
                            <option value="size_desc" @selected($sort==='size_desc' )>Largest first</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="f-min">Min rent (RWF)</label>
                        <input type="number" min="0" step="10000" id="f-min" name="min_rent" class="form-control"
                            placeholder="e.g. 200000" value="{{ $filters['min_rent'] ?? '' }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="f-max">Max rent (RWF)</label>
                        <input type="number" min="0" step="10000" id="f-max" name="max_rent" class="form-control"
                            placeholder="e.g. 800000" value="{{ $filters['max_rent'] ?? '' }}">
                    </div>

                    <div class="col-lg-6 d-flex gap-2 justify-content-lg-end">
                        <button type="submit" class="btn btn-terra px-4">
                            <i class="bi bi-search me-1"></i> Apply Filters
                        </button>

                        @if($hasFilters || $sort !== 'newest')
                        <a href="{{ url()->current() }}#available-units" class="btn btn-outline-dark px-4">Reset</a>
                        @endif
                    </div>

                </div>
            </form>

            {{-- Results --}}
            <div class="results-bar">
                <div>
                    Showing <strong>{{ $units->firstItem() ?? 0 }}–{{ $units->lastItem() ?? 0 }}</strong>
                    of <strong>{{ number_format($units->total()) }}</strong>
                    available {{ \Illuminate\Support\Str::plural('unit', $units->total()) }}
                </div>
            </div>

            @if($units->count())

            <div class="row g-4">

                @foreach($units as $unit)

                @php
                $property = $unit->managedProperty;
                $building = $unit->building;
                $floor = $unit->floor;
                $currency = $unit->currency ?: 'RWF';
                $type = $typeLabel($unit->unit_type);

                $floorLabel = $floor
                ? ($floor->name ?? $floor->label ?? ($floor->floor_number !== null ? 'Floor ' . $floor->floor_number : null))
                : null;

                $buildingLabel = $building?->name ?? $building?->title;

                $bedLabel = $unit->bedrooms > 0
                ? $unit->bedrooms . ' ' . \Illuminate\Support\Str::plural('Bedroom', $unit->bedrooms)
                : 'Studio';

                $modalId = 'unitModal' . $unit->id;
                @endphp

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <article class="unit-card">

                        <div class="unit-image">
                            <span class="unit-badge">{{ $type }}</span>
                            <span class="unit-number">Unit {{ $unit->unit_number }}</span>
                        </div>

                        <div class="unit-body">

                            <div class="unit-title">
                                {{ $bedLabel }} {{ $type }}
                                @if($property) <br><span class="fw-normal">at {{ $propName($property) }}</span> @endif
                            </div>

                            <div class="unit-location">
                                <i class="bi bi-geo-alt"></i>
                                {{ $propLocation($property) }}
                                @if($buildingLabel || $floorLabel)
                                <br>
                                <span>
                                    {{ collect([$buildingLabel, $floorLabel])->filter()->implode(' · ') }}
                                </span>
                                @endif
                            </div>

                            <div class="unit-features">
                                <span class="unit-feature">
                                    <i class="bi bi-door-closed"></i>
                                    {{ $unit->bedrooms > 0 ? $unit->bedrooms . ' Bd' : 'Studio' }}
                                </span>

                                <span class="unit-feature">
                                    <i class="bi bi-droplet"></i>
                                    {{ $unit->bathrooms }} {{ \Illuminate\Support\Str::plural('Bath', $unit->bathrooms) }}
                                </span>

                                @if($unit->area_sqm && (float) $unit->area_sqm > 0)
                                <span class="unit-feature">
                                    <i class="bi bi-rulers"></i>
                                    {{ number_format((float) $unit->area_sqm, 0) }} m²
                                </span>
                                @endif
                            </div>

                            <div class="unit-footer">
                                <div class="unit-price">
                                    {{ $money($unit->monthly_rent, $currency) }}
                                    <small>/ month</small>

                                    @if((float) $unit->security_deposit > 0)
                                    <span class="unit-deposit">
                                        Deposit: {{ $money($unit->security_deposit, $currency) }}
                                    </span>
                                    @endif
                                </div>

                                <button type="button"
                                    class="unit-details"
                                    data-bs-toggle="modal"
                                    data-bs-target="#{{ $modalId }}">
                                    Details <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>

                        </div>

                    </article>
                </div>

                @endforeach

            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $units->links('pagination::bootstrap-5') }}
            </div>

            @else

            <div class="empty-units">
                <i class="bi bi-house-door"></i>

                <h4>
                    {{ $hasFilters ? 'No units match your filters' : 'No units currently available' }}
                </h4>

                <p>
                    @if($hasFilters)
                    Try widening your search, or contact Terra and we will help you
                    find a suitable property.
                    @else
                    We do not have any vacant units listed right now. Contact Terra and we
                    will help you find a suitable property.
                    @endif
                </p>

                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    @if($hasFilters)
                    <a href="{{ url()->current() }}#available-units" class="btn btn-outline-dark mt-2">Clear Filters</a>
                    @endif
                    <a href="{{ route('terra.contact') }}" class="btn btn-terra mt-2">Inquire Now</a>
                </div>
            </div>

            @endif

        </div>
    </section>


    {{-- =====================================================
         MANAGED PROPERTIES
    ====================================================== --}}
    <section class="pm-section">
        <div class="container">

            <div class="row mb-5">
                <div class="col-lg-8">
                    <div class="pm-section-label">Our Residences</div>
                    <h2 class="pm-section-title mb-2">Properties managed by Terra</h2>
                    <p class="pm-section-text mb-0">
                        Residential properties and rental communities professionally managed
                        by the Terra team.
                    </p>
                </div>
            </div>

            <div class="row g-4">

                @forelse($properties as $property)

                <div class="col-lg-4 col-md-6">
                    <div class="residence-card">

                        <div class="residence-top">
                            <span class="residence-status">
                                {{ $property->available_units_count > 0 ? 'Units Available' : 'Fully Let' }}
                            </span>
                            <h3>{{ $propName($property) }}</h3>
                        </div>

                        <div class="residence-body">

                            <div class="residence-location">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $propLocation($property) }}
                            </div>

                            <div class="residence-meta">
                                <span>
                                    <i class="bi bi-door-open"></i>
                                    {{ $property->units_count }} {{ \Illuminate\Support\Str::plural('Unit', $property->units_count) }}
                                </span>

                                <span>
                                    <i class="bi bi-check2-circle"></i>
                                    {{ $property->available_units_count }} Available
                                </span>
                            </div>

                            @if($property->available_units_count > 0)
                            <a href="{{ url()->current() }}?property={{ $property->id }}#available-units"
                                class="d-inline-block mt-3 fw-bold small text-decoration-none"
                                style="color:#D05208;">
                                See available units <i class="bi bi-arrow-right"></i>
                            </a>
                            @endif

                        </div>

                    </div>
                </div>

                @empty

                <div class="col-12">
                    <div class="empty-units">
                        <i class="bi bi-buildings"></i>
                        <h4>Properties are being prepared</h4>
                        <p class="mb-0">
                            Our managed residential portfolio will appear here as properties are added.
                        </p>
                    </div>
                </div>

                @endforelse

            </div>

        </div>
    </section>


    {{-- =====================================================
         HOW RENTING WORKS
    ====================================================== --}}
    <section class="pm-section pm-section-soft">
        <div class="container">

            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <div class="pm-section-label">How It Works</div>
                    <h2 class="pm-section-title">From search to move-in</h2>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-lg-3 col-md-6">
                    <div class="step-box">
                        <span class="step-no">01</span>
                        <h4>Find a unit</h4>
                        <p>Filter available units by property, type, bedrooms and budget.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="step-box">
                        <span class="step-no">02</span>
                        <h4>Contact our team</h4>
                        <p>Send an inquiry for the unit you like and we will arrange a viewing.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="step-box">
                        <span class="step-no">03</span>
                        <h4>Apply</h4>
                        <p>Submit your tenant application and the management team reviews it.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="step-box">
                        <span class="step-no">04</span>
                        <h4>Sign &amp; move in</h4>
                        <p>Once approved, sign your lease, pay the deposit and collect your keys.</p>
                    </div>
                </div>

            </div>

        </div>
    </section>


    {{-- =====================================================
         FOR OWNERS & DEVELOPERS
    ====================================================== --}}
    <section class="owner-section" id="property-management">
        <div class="container">
            <div class="owner-content">
                <div class="row align-items-center g-5">

                    <div class="col-lg-8">

                        <div class="pm-section-label">For Owners &amp; Developers</div>

                        <h2>One partner.<br>All handled.</h2>

                        <p>
                            Terra Property Management runs residential properties, rental buildings
                            and real-estate investments across Kigali, so you can focus on the
                            return instead of the day-to-day.
                        </p>

                        <div class="mt-4">
                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>Tenant management and support</span>
                            </div>
                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>Rental and occupancy management</span>
                            </div>
                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>Lease and application management</span>
                            </div>
                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>Maintenance request handling</span>
                            </div>
                            <div class="owner-service">
                                <i class="bi bi-check2-circle"></i>
                                <span>Property expense tracking and reporting</span>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="border p-4" style="border-color: rgba(255,255,255,.16) !important;">

                            <div class="small text-uppercase fw-bold mb-3"
                                style="color:#f07b37; letter-spacing:.12em;">
                                Property Management
                            </div>

                            <h4 class="fw-bold mb-3">Let us manage your property.</h4>

                            <p class="small mb-4" style="color:rgba(255,255,255,.65); line-height:1.8;">
                                Talk to our team about managing your residential property,
                                rental building or real-estate portfolio.
                            </p>

                            <a href="{{ route('terra.contact') }}" class="btn btn-terra w-100">Inquire Now</a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    {{-- =====================================================
         FAQ
    ====================================================== --}}
    <section class="pm-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="text-center mb-5">
                        <div class="pm-section-label">FAQ</div>
                        <h2 class="pm-section-title">Renting with Terra</h2>
                    </div>

                    <div class="accordion" id="pmFaq">

                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How do I see a unit in person?
                                </button>
                            </h3>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#pmFaq">
                                <div class="accordion-body">
                                    Open a unit's details, then send an inquiry. Our team will confirm
                                    availability and arrange a viewing.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq2">
                                    What is the security deposit?
                                </button>
                            </h3>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#pmFaq">
                                <div class="accordion-body">
                                    The security deposit for each unit is shown on its card and in its
                                    details. Your lease sets out the exact terms.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Can a unit be reserved?
                                </button>
                            </h3>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#pmFaq">
                                <div class="accordion-body">
                                    Units that are already reserved or occupied are not listed here.
                                    Contact our team to ask about upcoming availability.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Who do I contact for maintenance after I move in?
                                </button>
                            </h3>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#pmFaq">
                                <div class="accordion-body">
                                    Report issues to the Terra management team. Requests are logged
                                    against your unit and followed up until resolved.
                                </div>
                            </div>
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

            <div class="pm-section-label">Terra Real Estate</div>

            <h2>Looking for your next home?</h2>

            <p>
                Explore available units across Kigali, or speak with our team
                about your requirements.
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="#available-units" class="btn btn-terra px-4 py-3">Browse Available Units</a>
                <a href="{{ route('terra.contact') }}" class="btn btn-outline-dark px-4 py-3">Contact Terra</a>
            </div>

        </div>
    </section>

</div>


{{-- =====================================================
     UNIT DETAIL MODALS
===================================================== --}}
@foreach($units as $unit)

@php
$property = $unit->managedProperty;
$building = $unit->building;
$floor = $unit->floor;
$currency = $unit->currency ?: 'RWF';
$type = $typeLabel($unit->unit_type);

$floorLabel = $floor
? ($floor->name ?? $floor->label ?? ($floor->floor_number !== null ? 'Floor ' . $floor->floor_number : null))
: null;

$buildingLabel = $building?->name ?? $building?->title;
@endphp

<div class="modal fade terra-pm-modal" id="unitModal{{ $unit->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <div class="small text-uppercase" style="letter-spacing:.12em; color:#f07b37; font-weight:700;">
                        {{ $type }} · Unit {{ $unit->unit_number }}
                    </div>
                    <h5 class="modal-title fw-bold mt-1">
                        {{ $property ? $propName($property) : 'Rental Unit' }}
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">

                <div class="mb-3" style="color:#19265d; font-size:1.6rem; font-weight:800;">
                    {{ $money($unit->monthly_rent, $currency) }}
                    <small style="font-size:.8rem; font-weight:500; color:#737b8c;">/ month</small>
                </div>

                <div class="spec-row">
                    <span>Location</span>
                    <span>{{ $propLocation($property) }}</span>
                </div>

                @if($buildingLabel)
                <div class="spec-row"><span>Building</span><span>{{ $buildingLabel }}</span></div>
                @endif

                @if($floorLabel)
                <div class="spec-row"><span>Floor</span><span>{{ $floorLabel }}</span></div>
                @endif

                <div class="spec-row">
                    <span>Bedrooms</span>
                    <span>{{ $unit->bedrooms > 0 ? $unit->bedrooms : 'Studio' }}</span>
                </div>

                <div class="spec-row"><span>Bathrooms</span><span>{{ $unit->bathrooms }}</span></div>

                @if($unit->area_sqm && (float) $unit->area_sqm > 0)
                <div class="spec-row">
                    <span>Size</span>
                    <span>{{ number_format((float) $unit->area_sqm, 0) }} m²</span>
                </div>
                @endif

                <div class="spec-row">
                    <span>Security deposit</span>
                    <span>
                        {{ (float) $unit->security_deposit > 0 ? $money($unit->security_deposit, $currency) : 'Contact us' }}
                    </span>
                </div>

                @if($unit->description)
                <div class="mt-4">
                    <div class="small text-uppercase fw-bold mb-2" style="letter-spacing:.1em; color:#D05208;">
                        About this unit
                    </div>
                    <p class="mb-0" style="color:#737b8c; line-height:1.8; white-space:pre-line;">{{ $unit->description }}</p>
                </div>
                @endif

            </div>

            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('terra.rental-applications.create', $unit->id) }}"
                    class="btn btn-terra w-100">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Apply for this Unit
                </a>
            </div>

        </div>
    </div>
</div>

@endforeach

@endsection