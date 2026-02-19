@extends('layouts.guest')
@section('title', $design->title)

@section('content')

<!-- Page Header Start -->
<div class="page-header parallaxie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header-box">
                    <h1 class="text-anime-style-3" data-cursor="-opaque">{{ $design->title }}</h1>
                    <p>Explore this architectural design in detail and download or purchase it.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Design Details Start -->
<div class="container my-5">
    <div class="row">
        <!-- Preview Image -->
        <div class="col-md-6 mb-4">
            @if($design->preview_image)
                <img src="{{ asset($design->preview_image) }}" class="img-fluid rounded shadow-sm" alt="{{ $design->title }}">
            @else
                <img src="{{ asset('images/placeholder.png') }}" class="img-fluid rounded shadow-sm" alt="No Preview">
            @endif
        </div>

        <!-- Design Info -->
        <div class="col-md-6">
            <h2>{{ $design->title }}</h2>
            <p><strong>Category:</strong> {{ $design->category?->name ?? 'N/A' }}</p>
            <p><strong>Uploaded By:</strong> {{ $design->user?->name ?? 'Admin' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($design->status) }}</p>
            <p><strong>Price:</strong> {{ $design->is_free ? 'Free' : '$'.$design->price }}</p>
            <p><strong>Downloads:</strong> {{ $design->download_count }}</p>
            <p><strong>Featured:</strong> {{ $design->featured ? 'Yes' : 'No' }}</p>
            
            <!-- Buttons -->
            @if($design->is_free)
                <a href="{{ asset($design->design_file) }}" download class="btn btn-success btn-lg mt-3 w-100">Download Free</a>
            @else
                <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="btn btn-warning btn-lg mt-3 w-100">Buy Now</a>
            @endif
        </div>
    </div>

    <!-- Full Description -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Description</h3>
            <p>{!! nl2br(e($design->description)) !!}</p>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="row mt-4">
        <div class="col-md-4">
            <p><strong>Uploaded On:</strong> {{ $design->created_at->format('M d, Y') }}</p>
        </div>
        <div class="col-md-4">
            <p><strong>Last Updated:</strong> {{ $design->updated_at->format('M d, Y') }}</p>
        </div>
        <div class="col-md-4">
            <p><strong>File Type:</strong> {{ pathinfo($design->design_file, PATHINFO_EXTENSION) }}</p>
        </div>
    </div>

    <!-- Related Designs Carousel -->
    @if($relatedDesigns->count())
    <div class="row mt-5">
        <div class="col-12">
            <h3>Related Designs</h3>
            <div class="owl-carousel owl-theme">
                @foreach($relatedDesigns as $related)
                <div class="item card shadow-sm p-2">
                    <a href="{{ route('front.buy.design.show', $related->slug) }}">
                        <img src="{{ asset($related->preview_image ?? 'images/placeholder.png') }}" class="card-img-top" alt="{{ $related->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $related->title }}</h5>
                            <p class="card-text">{{ $related->is_free ? 'Free' : '$'.$related->price }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
<!-- Design Details End -->

<!-- Include Owl Carousel JS -->

<link rel="stylesheet" href="{{ asset('vendor/owlcarousel/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/owlcarousel/owl.theme.default.min.css') }}">
<script src="{{ asset('vendor/owlcarousel/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:15,
            nav:true,
            responsive:{
                0:{ items:1 },
                576:{ items:2 },
                992:{ items:3 }
            }
        });
    });
</script>

@endsection
