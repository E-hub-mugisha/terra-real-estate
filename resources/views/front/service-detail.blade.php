@extends('layouts.guest')

@section('title', $service->category->name )

@section('content')

<div class="about2-section-area sp1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="about-images-area">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="img2 image-anime reveal" style="opacity: 1; visibility: inherit; translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                                <img src="{{ asset('front/assets/img/all-images/about/about-img3.png') }}" alt="housebox" style="translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="img1 image-anime reveal" style="opacity: 1; visibility: inherit; translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                                <img src="{{ asset('front/assets/img/all-images/about/about-img4.png') }}" alt="housebox" style="translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                            </div>
                            <div class="space30"></div>
                            <div class="img1 image-anime reveal" style="opacity: 1; visibility: inherit; translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                                <img src="{{ asset('front/assets/img/all-images/about/about-img5.png') }}" alt="housebox" style="translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about-heading heading1">
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        {{ $service->category->name }}
                    </h2>
                    <div class="space18"></div>
                    <p data-aos="fade-left" data-aos-duration="900" class="aos-init aos-animate">
                        {{ $service->description }}
                    </p>
                    <div class="btn-area1">
                        <a href="{{ route('front.properties.buy') }}" class="theme-btn1">Explore Property <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Why Become a Consultant -->

@endsection