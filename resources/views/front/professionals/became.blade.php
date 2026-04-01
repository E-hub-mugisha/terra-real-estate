@extends('layouts.guest')

@section('title', 'Become a Consultant')

@section('content')

<div class="hero3-section-area" style="background-image: url(front/assets/img/all-images/bg/hero-bg3.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="hero3-header">
                    <h5>Become a Trusted Consultant!</h5>
                    <div class="space20"></div>
                    <h1>Become a Trusted Consultant <br> <span class="word">create account</span></h1>
                    <p class="mt-3 fs-5 text-white">
                        Share your expertise, connect with clients, and grow your professional brand
                        on our real estate platform.
                    </p>
                    <a href="{{ route('consultant.register') }}" class="btn btn-primary btn-lg mt-3">
                        Register as Consultant
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-imagesarea">
        <div class="img1 aniamtion-key-2">
            <img src="{{ asset('front/assets/img/all-images/hero/hero3-img1.png') }}" alt="housebox">
        </div>
        <div class="img2">
            <img src="{{ asset('front/assets/img/elements/bottom-img2.png') }}" alt="housebox">
        </div>
    </div>
    <div class="img3">
        <img src="{{ asset('front/assets/img/elements/bottom-img1.png') }}" alt="housebox">
    </div>

</div>
<!-- Hero Section -->


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
                    <div class="author-img">
                        <h3>Our Happy Consultants</h3>
                        <div class="space18"></div>
                        <img src="{{ asset('front/assets/img/all-images/others/author-img1.png') }}" alt="housebox">
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about-heading heading1">
                    <h5 data-aos="fade-left" data-aos-duration="800" class="aos-init aos-animate">About housebox</h5>
                    <div class="space20"></div>
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        Why Become a Consultant?
                    </h2>
                    <div class="space18"></div>
                    <p data-aos="fade-left" data-aos-duration="900" class="aos-init aos-animate">
                        Unlock opportunities, gain visibility, and offer your services to clients who need expert guidance.
                    </p>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Showcase Your Expertise
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <p>Highlight your experience in real estate services and attract clients looking
                                        for trusted professionals.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Grow Your Business
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Get discovered by property buyers, sellers, and investors actively seeking professional help.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Connect With Clients
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Engage directly with clients, respond to inquiries, and build long-term relationships.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space32"></div>
                    <div class="btn-area1">
                        <a href="{{ route('front.consultants.index')}}" class="theme-btn1">See All Consultants <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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

<div class="about3-section-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 m-auto">
                <div class="about2-header text-center heading2 space-margin60">
                    <h5 data-aos="fade-left" data-aos-duration="800" class="aos-init aos-animate">Terra </h5>
                    <div class="space20"></div>
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        Consultant Features
                    </h2>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-4 col-md-6 d-lg-block d-none aos-init aos-animate" data-aos="fade-right" data-aos-duration="1000">
                <div class="about-list-box box1">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Professional consultant profile
                </div>
                <div class="space56"></div>
                <div class="about-list-box box2">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Assign service categories & expertise
                </div>
                <div class="space56"></div>
                <div class="about-list-box box3">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Appear on public consultant listings
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-images">
                    <div class="img1 reveal" style="opacity: 1; visibility: inherit; translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                        <img src="{{ asset('front/assets/img/all-images/about/about-img6.png') }}" alt="housebox" style="translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                    </div>
                </div>
                <div class="space30 d-lg-none d-block"></div>
            </div>

            <div class="col-lg-4 col-md-6 d-lg-none d-block">
                <div class="about-list-box box1">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Receive direct client inquiries
                </div>
                <div class="space56"></div>
                <div class="about-list-box box2">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Manage availability & services
                </div>
                <div class="space56"></div>
                <div class="about-list-box box3">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Increase trust & visibility
                </div>
                <div class="space56 d-lg-none d-block"></div>
            </div>
            <div class="col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-left" data-aos-duration="1000">
                <div class="about-list-box2 box1">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Professional consultant profile
                </div>
                <div class="space56"></div>
                <div class="about-list-box2 box2">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Assign service categories & expertise
                </div>
                <div class="space56"></div>
                <div class="about-list-box2 box3">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path>
                        </svg></span>
                    Appear on public consultant listings
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cta4-section-area" style="background-image: url(front/assets/img/all-images/bg/bg4.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="cta-header heading2">
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        Ready to Get Started?
                    </h2>
                    <div class="space16"></div>
                    <p data-aos="fade-left" data-aos-duration="900" class="aos-init aos-animate">Join our growing network of real estate consultants and start connecting with clients today.</p>
                    <div class="space30"></div>
                    <a href="{{ route('consultant.register') }}" class="btn btn-success btn-lg mt-3">
                        Become a Consultant Now
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="img1 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000">
        <img src="{{ asset('front/assets/img/all-images/cta/cta-img1.png') }}" alt="housebox">
    </div>
</div>


@endsection