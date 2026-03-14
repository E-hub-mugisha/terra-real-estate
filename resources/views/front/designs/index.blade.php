@extends('layouts.guest')
@section('title', 'Architectural Designs Marketplace')

@section('content')

<!--===== HERO AREA STARTS =======-->
<div class="hero-inner-section-area grid-area">
    <img src="{{ asset('front/assets/img/all-images/hero/hero-img1.png') }}" alt="housebox" class="hero-img1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-header-area text-center">
                    <a href="index.html">Home <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                            </path>
                        </svg> Architectural Designs Marketplace <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                            </path>
                        </svg>Architectural Designs Marketplace</a>
                    <div class="space24"></div>
                    <h1>Architectural Designs Marketplace</h1>
                </div>
                <div class="space80"></div>
            </div>
        </div>
    </div>
    <!--===== OTHERS AREA STARTS =======-->
    
    <div class="space60"></div>
    <!--===== OTHERS AREA STARTS =======-->
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== PROPERTIES AREA STARTS =======-->
<div class="property-inner-section sp2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="property-mapgrid-area">
                    <div class="heading1">
                        <h3>Architectural design available ({{ $designs->count()}})</h3>
                        <div class="tabs-btn">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M22 12.999V20C22 20.5523 21.5523 21 21 21H13V12.999H22ZM11 12.999V21H3C2.44772 21 2 20.5523 2 20V12.999H11ZM11 3V10.999H2V4C2 3.44772 2.44772 3 3 3H11ZM21 3C21.5523 3 22 3.44772 22 4V10.999H13V3H21Z">
                                            </path>
                                        </svg>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                        aria-selected="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z">
                                            </path>
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                            <div class="filter-group">
                                <select>
                                    <option>Sort by (Default)</option>
                                    <option>Oldest</option>
                                    <option>Newest</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="space32"></div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                            tabindex="0">
                            <div class="row">
                                @forelse($designs as $design)
                                <div class="col-lg-4 col-md-4">
                                    <div class="property-boxarea">
                                        <div class="img1">
                                            <div class="swiper swiper-fade">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        @if($design->preview_image)
                                                        <img src="{{ asset('storage/'.$design->preview_image) }}" alt="{{ $design->title }}">
                                                        @else
                                                        <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png')}}" alt="{{ $design->title}}">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="category-list">
                                            <ul>
                                                <li><a href="{{ route('front.buy.design.show', $design->slug) }}">Featured</a></li>
                                                <li><a href="{{ route('front.buy.design.show', $design->slug) }}">{{ $design->category?->name ?? 'N/A' }}</a></li>
                                            </ul>
                                        </div>
                                        <div class="content-area">
                                            <a href="{{ route('front.buy.design.show', $design->slug) }}">{{ $design->title}}</a>
                                            <div class="space18"></div>
                                            <p>{{ $design->service->title }}</p>
                                            <div class="space24"></div>
                                            <ul>
                                                <li><a href="{{ route('front.buy.design.show', $design->slug) }}"><img src="{{ asset('front/assets/img/icons/bed1.svg') }}" alt="housebox">x3</a></li>
                                                <li><a href="{{ route('front.buy.design.show', $design->slug) }}"><img src="{{ asset('front/assets/img/icons/bath1.svg') }}" alt="housebox">x2</a></li>
                                                <li><a href="{{ route('front.buy.design.show', $design->slug) }}"><img src="{{ asset('front/assets/img/icons/sqare1.svg') }}" alt="housebox">345 sq</a></li>
                                            </ul>
                                            <div class="btn-area">
                                                @if($design->is_free)
                                                <a href="{{ asset($design->design_file) }}" download class="nm-btn">
                                                    Download Free
                                                </a>
                                                @else
                                                <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="nm-btn">Buy Now</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p class="text-center text-gray-500">No design found.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                            tabindex="0">
                            <div class="row">
                                @forelse($designs as $design)
                                <div class="col-lg-12 col-md-12">
                                    <div class="property-boxarea">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="img1 image-anime">
                                                    @if($design->preview_image)
                                                    <img src="{{ asset('storage/'.$design->preview_image) }}" alt="{{ $design->title }}">
                                                    @else
                                                    <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png')}}" alt="{{ $design->title}}">
                                                    @endif
                                                </div>
                                                <div class="category-list">
                                                    <ul>
                                                        <li><a href="{{ route('front.buy.design.show', $design->slug) }}">Featured</a></li>
                                                        <li><a href="{{ route('front.buy.design.show', $design->slug) }}">{{ $design->category?->name ?? 'N/A' }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="content-area">
                                                    <a href="{{ route('front.buy.design.show', $design->slug) }}">{{ $design->title}}</a>
                                                    <div class="space18"></div>
                                                    <p>{{ $design->service->title }}</p>
                                                    <div class="space24"></div>
                                                    <ul>
                                                        <li><a href="{{ route('front.buy.design.show', $design->slug) }}"><img src="{{ asset('front/assets/img/icons/bed1.svg') }}" alt="housebox">x3</a></li>
                                                        <li><a href="{{ route('front.buy.design.show', $design->slug) }}"><img src="{{ asset('front/assets/img/icons/bath1.svg') }}" alt="housebox">x2</a></li>
                                                        <li><a href="{{ route('front.buy.design.show', $design->slug) }}"><img src="{{ asset('front/assets/img/icons/sqare1.svg') }}" alt="housebox">345 sq</a></li>
                                                    </ul>
                                                    <div class="btn-area">
                                                        @if($design->is_free)
                                                        <a href="{{ asset($design->design_file) }}" download class="nm-btn">
                                                            Download Free
                                                        </a>
                                                        @else
                                                        <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="nm-btn">Buy Now</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p class="text-center text-gray-500">No design found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--===== PROPERTIES AREA ENDS =======-->


@endsection