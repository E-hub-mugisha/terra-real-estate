@extends('layouts.guest')
@section('title', 'Architectural Designs Marketplace')

@section('content')

<!-- Page Header Start -->
<div class="page-header parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-box">
                    <h1 class="text-anime-style-3" data-cursor="-opaque">Architectural Designs Marketplace</h1>
                    <p>Browse, preview, and download architectural designs from our platform.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Marketplace Filters Start -->
<div class="container my-5">
    <form method="GET" action="{{ route('front.buy.design') }}" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title or description">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex">
            <button class="btn btn-primary me-2" type="submit">Filter</button>
            <a href="{{ route('front.buy.design') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>
<!-- Marketplace Filters End -->

<!-- Designs Grid Start -->
<div class="container">
    <div class="row">
        @forelse($designs as $design)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($design->preview_image)
                        <img src="{{ asset($design->preview_image) }}" class="card-img-top" alt="{{ $design->title }}">
                    @else
                        <img src="{{ asset('images/placeholder.png') }}" class="card-img-top" alt="No Preview">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $design->title }}</h5>
                        <p class="card-text mb-1"><strong>Category:</strong> {{ $design->category?->name ?? 'N/A' }}</p>
                        <p class="card-text mb-1"><strong>Price:</strong> {{ $design->is_free ? 'Free' : '$'.$design->price }}</p>
                        <p class="card-text"><small>Downloads: {{ $design->download_count }}</small></p>

                        <div class="mt-auto">
                            <a href="{{ route('front.buy.design.show', $design->slug) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">View Details</a>

                            @if($design->is_free)
                                <a href="{{ asset($design->design_file) }}" download class="btn btn-success btn-sm w-100">Download Free</a>
                            @else
                                <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="btn btn-warning btn-sm w-100">Buy Now</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4>No designs found.</h4>
                <p>Try changing your filters or search terms.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $designs->withQueryString()->links() }}
    </div>
</div>
<!-- Designs Grid End -->

@endsection
