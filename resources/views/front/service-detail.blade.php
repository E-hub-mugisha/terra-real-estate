@extends('layouts.guest')

@section('title', $category->name)

@section('content')

<div class="about2-section-area sp1">
    <div class="container">

        {{-- CATEGORY HEADER --}}
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="about-images-area">
                    <div class="row align-items-center">

                        <div class="col-lg-6 col-md-6">
                            <div class="img2 image-anime reveal">
                                <img src="{{ asset('front/assets/img/all-images/about/about-img3.png') }}" alt="service">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="img1 image-anime reveal">
                                <img src="{{ asset('front/assets/img/all-images/about/about-img4.png') }}" alt="service">
                            </div>
                            <div class="space30"></div>
                            <div class="img1 image-anime reveal">
                                <img src="{{ asset('front/assets/img/all-images/about/about-img5.png') }}" alt="service">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="about-heading heading1">
                    <h2 class="text-anime-style-3">{{ $category->name }}</h2>
                    <div class="space18"></div>
                    <p>{{ $category->description }}</p>
                    <div class="space20"></div>
                    <div class="btn-area1">
                        <a href="{{ route('front.properties.category', $category->id) }}" class="theme-btn1">
                            Explore Property
                            <span class="arrow1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="properties-section-area sp2"
    style="background-image: url({{ asset('front/assets/img/all-images/bg/bg1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            {{-- CASE 1: Services directly under category --}}
            @if($category->services->count() > 0)
            <div class="space60"></div>
            <h2 class="text-anime-style-3">
                Our <span class="text-gradient">{{ $category->name }} Services</span>
            </h2>
            <div class="space18"></div>
            <div class="col-lg-12">
                <div class="property-feature-slider">
                    <div class="row">
                        @foreach($category->services as $service)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="property-boxarea">
                                <div class="content-area">
                                    <h3 class="card-title">{{ $service->title }}</h3>
                                    <p class="card-text">{{ $service->description }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
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