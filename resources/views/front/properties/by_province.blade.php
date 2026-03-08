@extends('layouts.guest')

@section('title', 'Properties in' . $province)

@section('content')

<div class="container py-5">
    <div class="property-inner-section sp2">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="text-anime-style-3">
                        Properties in this {{ $province }} Location
                    </h2>
                    <p>Explore all available houses and lands under this location.</p>
                </div>
            </div>
            @if($homes->count() > 0)
            <div class="property-mapgrid-area">
                <div class="heading1">
                    <h3>Homes ({{ $homes->count()}})</h3>
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
                            @forelse($homes as $home)
                            <div class="col-lg-4 col-md-4">
                                <div class="property-boxarea">
                                    <div class="img1">
                                        <div class="swiper swiper-fade">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/' . optional($home->images->first())->image_path ?? 'dashboard/assets/images/property-1.jpg') }}"
                                                        alt="{{ $home->title }}">
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/' . $home->images->get(1)->image_path ?? 'dashboard/assets/images/property-2.jpg') }}" alt="{{ $home->title}}">
                                                </div>

                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>
                                    <div class="category-list">
                                        <ul>
                                            <li><a href="{{ route('front.buy.home.details', $home) }}">Featured</a></li>
                                            <li><a href="{{ route('front.buy.home.details', $home) }}">{{ $home->condition}}</a></li>
                                        </ul>
                                    </div>
                                    <div class="content-area">
                                        <a href="{{ route('front.buy.home.details', $home) }}">{{ $home->title}}</a>
                                        <div class="space18"></div>
                                        <p>{{ $home->service->title }}</p>
                                        <div class="space18"></div>
                                        <p>{{ $home->address }}</p>
                                        <div class="space24"></div>
                                        <ul>
                                            <li><a href="{{ route('front.buy.home.details', $home) }}"><img src="{{ asset('front/assets/img/icons/bed1.svg')}}" alt="{{ $home->title}}">x{{ $home->bedrooms}}</a></li>
                                            <li><a href="{{ route('front.buy.home.details', $home) }}"><img src="{{ asset('front/assets/img/icons/bath1.svg')}}" alt="{{ $home->title}}">x{{ $home->bathrooms}}</a></li>
                                            <li><a href="{{ route('front.buy.home.details', $home) }}"><img src="{{ asset('front/assets/img/icons/sqare1.svg')}}" alt="{{ $home->title}}">{{ $home->area_sqft}} sq</a></li>
                                        </ul>
                                        <div class="btn-area">
                                            <a href="{{ route('front.buy.home.details', $home) }}" class="nm-btn">{{ number_format($home->price) }} RWF</a>
                                            <a href="{{ route('front.buy.home.details', $home) }}" class="heart"><img src="{{ asset('front/assets/img/icons/heart1.svg') }}"
                                                    alt="{{ $home->title}}" class="heart1"> <img src="{{ asset('front/assets/img/icons/heart2.svg') }}" alt="{{ $home->title}}"
                                                    class="heart2"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-gray-500">No homes found.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                        tabindex="0">
                        <div class="row">
                            @forelse($homes as $home)
                            <div class="col-lg-12 col-md-12">
                                <div class="property-boxarea">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="img1 image-anime">
                                                <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png')}}" alt="{{ $home->title}}">
                                            </div>
                                            <div class="category-list">
                                                <ul>
                                                    <li><a href="{{ route('front.buy.home.details', $home) }}">Featured</a></li>
                                                    <li><a href="{{ route('front.buy.home.details', $home) }}">{{ $home->condition}}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="content-area">
                                                <a href="{{ route('front.buy.home.details', $home) }}">{{ $home->title}}</a>
                                                <div class="space18"></div>
                                                <p>{{ $home->service->title }}</p>
                                                <div class="space18"></div>
                                                <p>{{ $home->address }}</p>
                                                <div class="space24"></div>
                                                <ul>
                                                    <li><a href="{{ route('front.buy.home.details', $home) }}"><img src="{{ asset('front/assets/img/icons/bed1.svg') }}" alt="housebox">x{{ $home->bedrooms}}</a></li>
                                                    <li><a href="{{ route('front.buy.home.details', $home) }}"><img src="{{ asset('front/assets/img/icons/bath1.svg') }}" alt="housebox">x{{ $home->bathrooms}}</a></li>
                                                    <li><a href="{{ route('front.buy.home.details', $home) }}"><img src="{{ asset('front/assets/img/icons/sqare1.svg') }}" alt="housebox">{{ $home->area_sqft}} sq</a></li>
                                                </ul>
                                                <div class="btn-area">
                                                    <a href="{{ route('front.buy.home.details', $home) }}" class="nm-btn">{{ number_format($home->price) }} RWF</a>
                                                    <a href="{{ route('front.buy.home.details', $home) }}" class="heart"><img src="{{ asset('front/assets/img/icons/heart1.svg') }}"
                                                            alt="housebox" class="heart1"> <img src="{{ asset('front/assets/img/icons/heart2.svg') }}" alt="housebox"
                                                            class="heart2"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-gray-500">No homes found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($lands->count() > 0)
            <div class="property-mapgrid-area">
                <div class="heading1">
                    <h3>Plots for Sale ({{ $lands->count()}})</h3>
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
                            @forelse ($lands as $land)
                            <div class="col-lg-4 col-md-6">
                                <div class="property-boxarea">
                                    <div class="img1 image-anime">
                                        <div class="swiper swiper-fade swiper-initialized swiper-horizontal swiper-free-mode swiper-watch-progress swiper-backface-hidden">
                                            <div class="swiper-wrapper" id="swiper-wrapper-e0b954628e400158" aria-live="off" style="transition-duration: 0ms; transform: translate3d(-1248px, 0px, 0px); transition-delay: 0ms;">
                                                <div class="swiper-slide" role="group" aria-label="1 / 4" style="width: 416px;">
                                                    <img src="{{ asset('front/assets/img/all-images/properties/property-img2.png') }}" alt="housebox">
                                                </div>
                                                <div class="swiper-slide" role="group" aria-label="2 / 4" style="width: 416px;">
                                                    <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}" alt="housebox">
                                                </div>
                                                <div class="swiper-slide swiper-slide-prev" role="group" aria-label="3 / 4" style="width: 416px;">
                                                    <img src="{{ asset('front/assets/img/all-images/properties/property-img3.png') }}" alt="housebox">
                                                </div>
                                                <div class="swiper-slide swiper-slide-visible swiper-slide-fully-visible swiper-slide-active" role="group" aria-label="4 / 4" style="width: 416px;">
                                                    <img src="{{ asset('front/assets/img/all-images/properties/property-img4.png') }}" alt="housebox">
                                                </div>
                                            </div>
                                            <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 4" aria-current="true"></span></div>
                                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                        </div>
                                    </div>
                                    <div class="category-list">
                                        <ul>
                                            <li><a href="{{ route('front.buy.land.details', $land->id) }}">Featured</a></li>
                                            <li><a href="{{ route('front.buy.land.details', $land->id) }}">{{ $land->land_use }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="content-area">
                                        <a href="{{ route('front.buy.land.details', $land->id) }}">{{ $land->title }} </a>
                                        <div class="space18"></div>
                                        <p>{{ $land->sector }},{{ $land->district }},{{ $land->province }}</p>
                                        <div class="space24"></div>
                                        <ul>
                                            <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">{{ $land->zoning }}</a></li>
                                            <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">{{ $land->size_sqm }} sq.fit</a></li>
                                        </ul>
                                        <div class="btn-area">
                                            <a href="#" class="nm-btn">{{ number_format($land->price) }} RWF</a>
                                            <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox" class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @empty
                            <p class="text-center text-gray-500">No plots found.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                        tabindex="0">
                        <div class="row">
                            @forelse ($lands as $land)
                            <div class="col-lg-12 col-md-12">
                                <div class="property-boxarea">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="img1 image-anime">
                                                <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png')}}" alt="{{ $land->title}}">
                                            </div>
                                            <div class="category-list">
                                                <ul>
                                                    <li><a href="{{ route('front.buy.land.details', $land->id) }}">Featured</a></li>
                                                    <li><a href="{{ route('front.buy.land.details', $land->id) }}">{{ $land->land_use }}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="content-area">
                                                <a href="{{ route('front.buy.land.details', $land->id) }}">{{ $land->title }}</a>
                                                <div class="space18"></div>
                                                <p>{{ $land->service->title }}</p>
                                                <div class="space18"></div>
                                                <p>{{ $land->sector }},{{ $land->district }},{{ $land->province }}</p>
                                                <div class="space24"></div>
                                                <ul>
                                                    <li><a href="{{ route('front.buy.land.details', $land->id) }}"><img src="{{ asset('front/assets/img/icons/bed1.svg') }}" alt="housebox">x{{ $land->zoning }}</a></li>
                                                    <li><a href="{{ route('front.buy.land.details', $land->id) }}"><img src="{{ asset('front/assets/img/icons/sqare1.svg') }}" alt="housebox">{{ $land->size_sqm }} sq</a></li>
                                                </ul>
                                                <div class="btn-area">
                                                    <a href="{{ route('front.buy.land.details', $land->id) }}" class="nm-btn">{{ number_format($land->price) }} RWF</a>
                                                    <a href="{{ route('front.buy.land.details', $land->id) }}" class="heart"><img src="{{ asset('front/assets/img/icons/heart1.svg') }}"
                                                            alt="housebox" class="heart1"> <img src="{{ asset('front/assets/img/icons/heart2.svg') }}" alt="housebox"
                                                            class="heart2"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-gray-500">No plots found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- EMPTY STATE --}}
            @if($homes->count() == 0 && $lands->count() == 0)
            <div class="row">
                <div class="col-12 text-center">
                    <p>No properties found in this location.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!--===== CTA AREA STARTS =======-->
<div class="cta1-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-bg-area" style="background-image: url({{ asset('front/assets/img/all-images/bg/cta-bg1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="cta-header">
                                <h2 class="text-anime-style-3">Request Terra Free Consultation</h2>
                                <div class="space16"></div>
                                <p>At Terra real estate, we believe your next move is more than just a place – it’s where your future begins.</p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="btn-area1 text-center">
                                <a href="sidebar-grid" class="theme-btn1">
                                    <span class="arrow1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                            <path d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 8L12 13L4 8V6L12 11L20 6V8Z" />
                                        </svg>
                                    </span>
                                    Send an Email
                                </a>
                                <a href="https://wa.me/250782390919" target="_blank" class="theme-btn1">

                                    <span class="arrow1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="22" height="22" fill="currentColor">
                                            <path d="M16.001 3C9.373 3 4 8.373 4 15c0 2.646.86 5.088 2.316 7.073L4 29l7.13-2.287C12.966 27.53 14.45 28 16 28c6.627 0 12-5.373 12-12S22.627 3 16.001 3zm0 22c-1.338 0-2.648-.355-3.8-1.026l-.272-.158-4.23 1.358 1.38-4.115-.176-.288C7.9 19.476 7.5 17.763 7.5 16c0-4.687 3.813-8.5 8.5-8.5S24.5 11.313 24.5 16 20.687 25 16.001 25zm4.768-6.405c-.26-.13-1.536-.758-1.774-.845-.238-.087-.41-.13-.582.13-.173.26-.67.845-.82 1.018-.15.173-.302.195-.562.065-.26-.13-1.097-.404-2.09-1.287-.773-.69-1.294-1.543-1.445-1.803-.15-.26-.016-.4.113-.53.117-.116.26-.302.39-.454.13-.15.173-.26.26-.433.087-.173.043-.325-.022-.455-.065-.13-.582-1.404-.797-1.922-.21-.503-.423-.435-.582-.443l-.496-.01c-.173 0-.455.065-.693.325-.238.26-.91.89-.91 2.17s.932 2.52 1.062 2.692c.13.173 1.834 2.803 4.445 3.93.621.268 1.106.428 1.484.548.623.198 1.19.17 1.638.103.5-.074 1.536-.628 1.753-1.235.216-.607.216-1.128.15-1.235-.065-.108-.238-.173-.497-.303z" />
                                        </svg>
                                    </span>
                                    WhatsApp Chat
                                </a>
                                <a href="tel:+250782390919" class="theme-btn1">

                                    <span class="arrow1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                            <path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.69 14.9 16.08 14.82 16.43 14.93C17.55 15.3 18.75 15.5 20 15.5C20.55 15.5 21 15.95 21 16.5V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z" />
                                        </svg>
                                    </span>
                                    Call Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== CTA AREA ENDS =======-->

@endsection