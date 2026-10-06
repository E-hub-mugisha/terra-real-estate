@extends('public.layouts.app')

@section('title', 'Units for Rent | Terra Property Management')

@section(
    'meta_description',
    'Browse professionally managed rental units and apartments available in Kigali, Rwanda.'
)

@section('content')

<style>

    .rent-page {
        background: #f7f8fa;
    }

    .rent-hero {
        background: #ffffff;
        border-bottom: 1px solid #e7e9ee;
        padding: 58px 0 48px;
    }

    .rent-eyebrow {
        color: #D05208;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        margin-bottom: 13px;
    }

    .rent-title {
        color: #19265d;
        font-size: clamp(2rem, 4vw, 3.25rem);
        font-weight: 800;
        letter-spacing: -.045em;
        line-height: 1.05;
        margin: 0;
    }

    .rent-description {
        max-width: 650px;
        margin: 17px 0 0;
        color: #737b8c;
        font-size: .9rem;
        line-height: 1.8;
    }

    .rent-count {
        margin-top: 25px;
        color: #303643;
        font-size: .78rem;
        font-weight: 600;
    }

    .rent-count strong {
        color: #D05208;
    }

    /*
    |--------------------------------------------------------------------------
    | Search / Filters
    |--------------------------------------------------------------------------
    */

    .filter-card {
        margin-top: -25px;
        position: relative;
        z-index: 10;
        background: #ffffff;
        border: 1px solid #e7e9ee;
        box-shadow: 0 12px 35px rgba(25, 38, 93, .07);
    }

    .filter-card-header {
        padding: 21px 25px;
        border-bottom: 1px solid #e9edf2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .filter-title {
        color: #19265d;
        font-size: .88rem;
        font-weight: 800;
        margin: 0;
    }

    .clear-filters {
        color: #737b8c;
        font-size: .72rem;
        font-weight: 700;
        text-decoration: none;
    }

    .clear-filters:hover {
        color: #D05208;
    }

    .filter-body {
        padding: 24px 25px;
    }

    .filter-label {
        color: #374151;
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .07em;
        margin-bottom: 8px;
    }

    .filter-control {
        min-height: 45px;
        border: 1px solid #dfe3e9;
        border-radius: 0;
        color: #303643;
        font-family: inherit;
        font-size: .78rem;
        box-shadow: none !important;
    }

    .filter-control:focus {
        border-color: #D05208;
    }

    .search-control {
        padding-left: 42px;
    }

    .search-wrap {
        position: relative;
    }

    .search-wrap i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #8b92a0;
        z-index: 2;
    }

    .filter-submit {
        width: 100%;
        min-height: 45px;
        border: 1px solid #D05208;
        background: #D05208;
        color: #ffffff;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .filter-submit:hover {
        background: #ad4205;
        border-color: #ad4205;
    }

    /*
    |--------------------------------------------------------------------------
    | Results header
    |--------------------------------------------------------------------------
    */

    .results-section {
        padding: 45px 0 80px;
    }

    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .results-heading {
        color: #19265d;
        font-size: 1.15rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -.025em;
    }

    .results-subtitle {
        color: #8a91a0;
        font-size: .73rem;
        margin: 5px 0 0;
    }

    .sort-control {
        min-width: 190px;
        min-height: 42px;
        border: 1px solid #dfe3e9;
        border-radius: 0;
        font-size: .75rem;
        color: #303643;
        box-shadow: none !important;
    }

    /*
    |--------------------------------------------------------------------------
    | Unit card
    |--------------------------------------------------------------------------
    */

    .unit-card {
        height: 100%;
        background: #ffffff;
        border: 1px solid #e7e9ee;
        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }

    .unit-card:hover {
        transform: translateY(-4px);
        border-color: #d8dce3;
        box-shadow: 0 15px 35px rgba(25, 38, 93, .08);
    }

    .unit-image {
        height: 210px;
        background:
            linear-gradient(
                135deg,
                #eef1f5,
                #f8f9fa
            );
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .unit-image i {
        font-size: 3rem;
        color: #c8cdd5;
    }

    .unit-status {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 6px 10px;
        background: #ffffff;
        color: #198754;
        font-size: .62rem;
        font-weight: 800;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .unit-type {
        position: absolute;
        right: 15px;
        top: 15px;
        padding: 6px 10px;
        background: #19265d;
        color: #ffffff;
        font-size: .62rem;
        font-weight: 700;
    }

    .unit-content {
        padding: 22px;
    }

    .unit-number {
        color: #8a91a0;
        font-size: .66rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-bottom: 7px;
    }

    .unit-title {
        color: #19265d;
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 5px;
    }

    .unit-location {
        color: #737b8c;
        font-size: .72rem;
        margin-bottom: 18px;
    }

    .unit-location i {
        color: #D05208;
        margin-right: 4px;
    }

    .unit-features {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        padding: 15px 0;
        border-top: 1px solid #edf0f3;
        border-bottom: 1px solid #edf0f3;
    }

    .unit-feature {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #5f6674;
        font-size: .7rem;
    }

    .unit-feature i {
        color: #D05208;
        font-size: .82rem;
    }

    .unit-bottom {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 15px;
        padding-top: 18px;
    }

    .unit-price-label {
        color: #8a91a0;
        font-size: .62rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 3px;
    }

    .unit-price {
        color: #19265d;
        font-size: 1rem;
        font-weight: 800;
    }

    .unit-price span {
        color: #8a91a0;
        font-size: .63rem;
        font-weight: 500;
    }

    .unit-details {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 38px;
        padding: 0 13px;
        background: #19265d;
        color: #ffffff;
        text-decoration: none;
        font-size: .65rem;
        font-weight: 800;
    }

    .unit-details:hover {
        background: #D05208;
        color: #ffffff;
    }

    /*
    |--------------------------------------------------------------------------
    | Empty state
    |--------------------------------------------------------------------------
    */

    .empty-state {
        padding: 80px 30px;
        background: #ffffff;
        border: 1px solid #e7e9ee;
        text-align: center;
    }

    .empty-icon {
        width: 65px;
        height: 65px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f7f8fa;
        color: #D05208;
        font-size: 1.4rem;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #19265d;
        font-size: 1.1rem;
        font-weight: 800;
    }

    .empty-state p {
        max-width: 480px;
        margin: 10px auto 22px;
        color: #737b8c;
        font-size: .78rem;
        line-height: 1.7;
    }

    .reset-button {
        display: inline-flex;
        align-items: center;
        min-height: 42px;
        padding: 0 17px;
        background: #D05208;
        color: #ffffff;
        text-decoration: none;
        font-size: .7rem;
        font-weight: 800;
    }

    .reset-button:hover {
        background: #ad4205;
        color: #ffffff;
    }

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    .pagination {
        margin-top: 45px;
    }

    .pagination .page-link {
        border-radius: 0 !important;
        border-color: #e2e5ea;
        color: #19265d;
        font-size: .72rem;
        min-width: 38px;
        text-align: center;
    }

    .pagination .page-item.active .page-link {
        background: #D05208;
        border-color: #D05208;
    }

    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767.98px) {

        .rent-hero {
            padding: 42px 0 40px;
        }

        .filter-card {
            margin-top: 0;
        }

        .results-section {
            padding-top: 35px;
        }

        .results-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .sort-control {
            width: 100%;
        }

        .unit-image {
            height: 190px;
        }

    }

</style>


<div class="rent-page">

    {{-- ============================================================
        HERO
    ============================================================= --}}

    <section class="rent-hero">

        <div class="container">

            <div class="rent-eyebrow">
                Terra Property Management
            </div>

            <h1 class="rent-title">
                Units for Rent
            </h1>

            <p class="rent-description">
                Discover quality rental homes and apartments across Kigali,
                professionally managed by Terra Property Management.
            </p>

            <div class="rent-count">

                <strong>
                    {{ $units->total() }}
                </strong>

                {{ $units->total() === 1 ? 'unit' : 'units' }}
                currently available

            </div>

        </div>

    </section>


    <div class="container">

        {{-- ========================================================
            FILTERS
        ========================================================= --}}

        <div class="filter-card">

            <div class="filter-card-header">

                <h2 class="filter-title">
                    Find your next home
                </h2>

                <a href="{{ route('terra.properties.index') }}"
                   class="clear-filters">

                    Clear all filters

                </a>

            </div>

            <form method="GET"
                  action="{{ route('terra.properties.index') }}">

                <div class="filter-body">

                    <div class="row g-3">

                        {{-- Search --}}

                        <div class="col-lg-4">

                            <label class="filter-label">
                                Search
                            </label>

                            <div class="search-wrap">

                                <i class="bi bi-search"></i>

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control filter-control search-control"
                                    placeholder="Property, unit, location..."
                                >

                            </div>

                        </div>


                        {{-- Unit type --}}

                        <div class="col-md-4 col-lg-2">

                            <label class="filter-label">
                                Unit Type
                            </label>

                            <select
                                name="unit_type"
                                class="form-select filter-control">

                                <option value="">
                                    Any type
                                </option>

                                @foreach($unitTypes as $type)

                                    <option
                                        value="{{ $type }}"
                                        @selected(request('unit_type') === $type)
                                    >
                                        {{ ucwords(str_replace('_', ' ', $type)) }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Bedrooms --}}

                        <div class="col-md-4 col-lg-2">

                            <label class="filter-label">
                                Bedrooms
                            </label>

                            <select
                                name="bedrooms"
                                class="form-select filter-control">

                                <option value="">
                                    Any
                                </option>

                                @foreach([0,1,2,3,4,5] as $bedroom)

                                    <option
                                        value="{{ $bedroom }}"
                                        @selected(
                                            request('bedrooms') !== null &&
                                            (int) request('bedrooms') === $bedroom
                                        )
                                    >
                                        {{ $bedroom === 0 ? 'Studio' : $bedroom . '+' }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Bathrooms --}}

                        <div class="col-md-4 col-lg-2">

                            <label class="filter-label">
                                Bathrooms
                            </label>

                            <select
                                name="bathrooms"
                                class="form-select filter-control">

                                <option value="">
                                    Any
                                </option>

                                @foreach([1,2,3,4,5] as $bathroom)

                                    <option
                                        value="{{ $bathroom }}"
                                        @selected(
                                            request('bathrooms') !== null &&
                                            (int) request('bathrooms') === $bathroom
                                        )
                                    >
                                        {{ $bathroom }}+
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- District --}}

                        <div class="col-md-6 col-lg-2">

                            <label class="filter-label">
                                District
                            </label>

                            <select
                                name="district"
                                class="form-select filter-control">

                                <option value="">
                                    All districts
                                </option>

                                @foreach($districts as $district)

                                    <option
                                        value="{{ $district }}"
                                        @selected(request('district') === $district)
                                    >
                                        {{ $district }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Sector --}}

                        <div class="col-md-6 col-lg-2">

                            <label class="filter-label">
                                Sector
                            </label>

                            <select
                                name="sector"
                                class="form-select filter-control">

                                <option value="">
                                    All sectors
                                </option>

                                @foreach($sectors as $sector)

                                    <option
                                        value="{{ $sector }}"
                                        @selected(request('sector') === $sector)
                                    >
                                        {{ $sector }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Minimum rent --}}

                        <div class="col-md-6 col-lg-2">

                            <label class="filter-label">
                                Min Rent
                            </label>

                            <input
                                type="number"
                                name="min_rent"
                                value="{{ request('min_rent') }}"
                                class="form-control filter-control"
                                placeholder="RWF"
                            >

                        </div>


                        {{-- Maximum rent --}}

                        <div class="col-md-6 col-lg-2">

                            <label class="filter-label">
                                Max Rent
                            </label>

                            <input
                                type="number"
                                name="max_rent"
                                value="{{ request('max_rent') }}"
                                class="form-control filter-control"
                                placeholder="RWF"
                            >

                        </div>


                        {{-- Minimum size --}}

                        <div class="col-md-6 col-lg-2">

                            <label class="filter-label">
                                Min Size
                            </label>

                            <input
                                type="number"
                                name="min_size"
                                value="{{ request('min_size') }}"
                                class="form-control filter-control"
                                placeholder="m²"
                            >

                        </div>


                        {{-- Maximum size --}}

                        <div class="col-md-6 col-lg-2">

                            <label class="filter-label">
                                Max Size
                            </label>

                            <input
                                type="number"
                                name="max_size"
                                value="{{ request('max_size') }}"
                                class="form-control filter-control"
                                placeholder="m²"
                            >

                        </div>


                        {{-- Submit --}}

                        <div class="col-md-6 col-lg-2">

                            <label class="filter-label d-none d-lg-block">
                                &nbsp;
                            </label>

                            <button
                                type="submit"
                                class="filter-submit">

                                <i class="bi bi-search me-1"></i>

                                Search Units

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ============================================================
        RESULTS
    ============================================================= --}}

    <section class="results-section">

        <div class="container">

            <div class="results-header">

                <div>

                    <h2 class="results-heading">
                        Available rental units
                    </h2>

                    <p class="results-subtitle">

                        Showing
                        {{ $units->firstItem() ?? 0 }}
                        –
                        {{ $units->lastItem() ?? 0 }}
                        of
                        {{ $units->total() }}

                    </p>

                </div>


                <form method="GET"
                      action="{{ route('terra.properties.index') }}">

                    @foreach(request()->except('sort', 'page') as $key => $value)

                        <input
                            type="hidden"
                            name="{{ $key }}"
                            value="{{ $value }}"
                        >

                    @endforeach

                    <select
                        name="sort"
                        class="form-select sort-control"
                        onchange="this.form.submit()">

                        <option value="">
                            Sort: Newest
                        </option>

                        <option
                            value="rent_low"
                            @selected(request('sort') === 'rent_low')>
                            Rent: Low to High
                        </option>

                        <option
                            value="rent_high"
                            @selected(request('sort') === 'rent_high')>
                            Rent: High to Low
                        </option>

                        <option
                            value="size_low"
                            @selected(request('sort') === 'size_low')>
                            Size: Small to Large
                        </option>

                        <option
                            value="size_high"
                            @selected(request('sort') === 'size_high')>
                            Size: Large to Small
                        </option>

                        <option
                            value="bedrooms"
                            @selected(request('sort') === 'bedrooms')>
                            Most Bedrooms
                        </option>

                    </select>

                </form>

            </div>


            @if($units->count())

                <div class="row g-4">

                    @foreach($units as $unit)

                        @php

                            $floor = $unit->floor;

                            $building = $floor?->building;

                            $property = $building?->property;

                        @endphp

                        <div class="col-md-6 col-xl-4">

                            <article class="unit-card">

                                <div class="unit-image">

                                    <i class="bi bi-building"></i>

                                    <span class="unit-status">
                                        Available
                                    </span>

                                    @if($unit->unit_type)

                                        <span class="unit-type">

                                            {{ ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $unit->unit_type
                                                )
                                            ) }}

                                        </span>

                                    @endif

                                </div>


                                <div class="unit-content">

                                    <div class="unit-number">

                                        Unit
                                        {{ $unit->unit_number }}

                                        @if($building?->reference)
                                            · {{ $building->reference }}
                                        @endif

                                    </div>


                                    <h3 class="unit-title">

                                        {{ $property?->title
                                            ?? $building?->name
                                            ?? 'Rental Unit'
                                        }}

                                    </h3>


                                    <div class="unit-location">

                                        <i class="bi bi-geo-alt-fill"></i>

                                        {{ $property?->district ?? 'Kigali' }}

                                        @if($property?->sector)
                                            · {{ $property->sector }}
                                        @endif

                                    </div>


                                    <div class="unit-features">

                                        @if($unit->bedrooms !== null)

                                            <div class="unit-feature">

                                                <i class="bi bi-door-open"></i>

                                                {{ $unit->bedrooms == 0
                                                    ? 'Studio'
                                                    : $unit->bedrooms . ' Bed'
                                                }}

                                            </div>

                                        @endif


                                        @if($unit->bathrooms !== null)

                                            <div class="unit-feature">

                                                <i class="bi bi-droplet"></i>

                                                {{ $unit->bathrooms }}
                                                Bath{{ $unit->bathrooms == 1 ? '' : 's' }}

                                            </div>

                                        @endif


                                        @if($unit->size)

                                            <div class="unit-feature">

                                                <i class="bi bi-arrows-angle-expand"></i>

                                                {{ number_format($unit->size) }}
                                                m²

                                            </div>

                                        @endif

                                    </div>


                                    <div class="unit-bottom">

                                        <div>

                                            <div class="unit-price-label">
                                                Monthly rent
                                            </div>

                                            <div class="unit-price">

                                                RWF
                                                {{ number_format($unit->rent) }}

                                                <span>
                                                    / month
                                                </span>

                                            </div>

                                        </div>


                                        <a href="{{ route(
                                            'terra.properties.show',
                                            $unit
                                        ) }}"
                                           class="unit-details">

                                            View Unit

                                            <i class="bi bi-arrow-right"></i>

                                        </a>

                                    </div>

                                </div>

                            </article>

                        </div>

                    @endforeach

                </div>


                <div>
                    {{ $units->links() }}
                </div>

            @else

                <div class="empty-state">

                    <div class="empty-icon">

                        <i class="bi bi-search"></i>

                    </div>

                    <h3>
                        No rental units found
                    </h3>

                    <p>
                        We couldn't find any available units matching
                        your current search criteria. Try removing some
                        filters or searching for another location.
                    </p>

                    <a href="{{ route('terra.properties.index') }}"
                       class="reset-button">

                        Reset Search

                    </a>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection