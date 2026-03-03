@extends('layouts.guest')
@section('title', 'Properties For Sale')
@section('content')
<div class="container py-5">
    <div class="property-inner-section sp2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="property-mapgrid-area">
                        <div class="heading1">
                            <h3>Homes for Sale ({{ $homes->count()}})</h3>
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
                                                            <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}" alt="{{ $home->title}}">
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="{{ asset('front/assets/img/all-images/properties/property-img2.png') }}" alt="{{ $home->title}}">
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
                                                <p>{{ $home->service->title ?? 'N/A' }}</p>
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
                                                        <p>{{ $home->service->title ?? 'N/A' }}</p>
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
                </div>
            </div>
        </div>

    </div>


    <div class="property-inner-section sp2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
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
                                                        <p>{{ $land->service->title ?? 'N/A' }}</p>
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
                </div>
            </div>
        </div>

    </div>
</div>
@endsection