@extends('layouts.guest')

@section('title', 'Agent Advertising')

@section('content')

<!--===== HERO AREA STARTS =======-->
<div class="hero2-slider-sectionarea">
    <div class="hero2-slider-area">
        <img src="{{ asset('front/assets/img/elements/elements1.png') }}" alt="housebox" class="elements1">
        <img src="{{ asset('front/assets/img/elements/elements2.png') }}" alt="housebox" class="elements2">
        <img src="{{ asset('front/assets/img/all-images/hero/hero2-img1.png') }}" alt="housebox" class="hero2-img1">
        <div class="img1">
            <img src="{{ asset('front/assets/img/all-images/hero/hero2-img2.png') }}" alt="housebox">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="hero2-header">
                        <h5>Advertise as an Agent!</h5>
                        <div class="space20"></div>
                        <h1>Advertise as an Agent!</h1>
                        <p class="text-white fs-5 mt-3">
                            Get more visibility, attract serious clients, and stand out by promoting
                            your services, listings, land, or agent profile on our platform.
                        </p>
                        <div class="space20"></div>
                        <div class="btn-area1">
                            <a href="property-details-v1" class="theme-btn3">Start Advertising<span class="arrow1"><svg
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        width="24" height="24" fill="currentColor">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hero2-small-img">
    <div class="img1">
        <img src="{{ asset('front/assets/img/all-images/others/others-img1.png') }}" alt="housebox">
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<div class="offer1-section-area sp1" style="background-image: url({{ asset('front/assets/img/all-images/bg/bg1.png')}}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 m-auto">
                <div class="heading1 text-center space-margin60">
                    <h5>What We Offer</h5>
                    <div class="space20"></div>
                    <h2>What Can You Advertise?</h2>
                    <p class="text-muted">
                        One advertising system. Multiple promotion options.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="img1">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img9.png') }}" alt="housebox">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="offer-boxarea">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 21H5C4.44772 21 4 20.5523 4 20V11L1 11L11.3273 1.6115C11.7087 1.26475 12.2913 1.26475 12.6727 1.6115L23 11L20 11V20C20 20.5523 19.5523 21 19 21ZM6 19H18V9.15745L12 3.7029L6 9.15745V19ZM8 15H16V17H8V15Z"></path>
                                </svg>
                            </div>
                            <div class="space24"></div>
                            <div class="content">
                                <a href="property-details-v1.html">Your Agent Profile</a>
                                <div class="space16"></div>
                                <p>Boost your personal brand and get discovered by clients looking for trusted professionals.</p>
                                <div class="space24"></div>
                                <a href="property-details-v1.html" class="readmore">learn more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"></path>
                                    </svg></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="offer-boxarea">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.5812 2.68627C12.2335 2.43791 11.7664 2.43791 11.4187 2.68627L1.9187 9.47198L3.08118 11.0994L11.9999 4.7289L20.9187 11.0994L22.0812 9.47198L12.5812 2.68627ZM19.5812 12.6863L12.5812 7.68627C12.2335 7.43791 11.7664 7.43791 11.4187 7.68627L4.4187 12.6863C4.15591 12.874 3.99994 13.177 3.99994 13.5V20C3.99994 20.5523 4.44765 21 4.99994 21H18.9999C19.5522 21 19.9999 20.5523 19.9999 20V13.5C19.9999 13.177 19.844 12.874 19.5812 12.6863ZM5.99994 19V14.0146L11.9999 9.7289L17.9999 14.0146V19H5.99994Z"></path>
                                </svg>
                            </div>
                            <div class="space24"></div>
                            <div class="content">
                                <a href="property-details-v1.html">Houses</a>
                                <div class="space16"></div>
                                <p>Promote featured homes and increase inquiries for your listings.</p>
                                <div class="space24"></div>
                                <a href="property-details-v1.html" class="readmore">learn more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"></path>
                                    </svg></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="offer-boxarea">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10.7577 11.8281L18.6066 3.97919L20.0208 5.3934L18.6066 6.80761L21.0815 9.28249L19.6673 10.6967L17.1924 8.22183L15.7782 9.63604L17.8995 11.7574L16.4853 13.1716L14.364 11.0503L12.1719 13.2423C13.4581 15.1837 13.246 17.8251 11.5355 19.5355C9.58291 21.4882 6.41709 21.4882 4.46447 19.5355C2.51184 17.5829 2.51184 14.4171 4.46447 12.4645C6.17493 10.754 8.81633 10.5419 10.7577 11.8281ZM10.1213 18.1213C11.2929 16.9497 11.2929 15.0503 10.1213 13.8787C8.94975 12.7071 7.05025 12.7071 5.87868 13.8787C4.70711 15.0503 4.70711 16.9497 5.87868 18.1213C7.05025 19.2929 8.94975 19.2929 10.1213 18.1213Z"></path>
                                </svg>
                            </div>
                            <div class="space24"></div>
                            <div class="content">
                                <a href="property-details-v1.html">Land</a>
                                <div class="space16"></div>
                                <p>Highlight prime land opportunities to serious investors and buyers.</p>
                                <div class="space24"></div>
                                <a href="property-details-v1.html" class="readmore">learn more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"></path>
                                    </svg></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="offer-boxarea">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8.68637 4.00008L11.293 1.39348C11.6835 1.00295 12.3167 1.00295 12.7072 1.39348L15.3138 4.00008H19.0001C19.5524 4.00008 20.0001 4.4478 20.0001 5.00008V8.68637L22.6067 11.293C22.9972 11.6835 22.9972 12.3167 22.6067 12.7072L20.0001 15.3138V19.0001C20.0001 19.5524 19.5524 20.0001 19.0001 20.0001H15.3138L12.7072 22.6067C12.3167 22.9972 11.6835 22.9972 11.293 22.6067L8.68637 20.0001H5.00008C4.4478 20.0001 4.00008 19.5524 4.00008 19.0001V15.3138L1.39348 12.7072C1.00295 12.3167 1.00295 11.6835 1.39348 11.293L4.00008 8.68637V5.00008C4.00008 4.4478 4.4478 4.00008 5.00008 4.00008H8.68637ZM6.00008 6.00008V9.5148L3.5148 12.0001L6.00008 14.4854V18.0001H9.5148L12.0001 20.4854L14.4854 18.0001H18.0001V14.4854L20.4854 12.0001L18.0001 9.5148V6.00008H14.4854L12.0001 3.5148L9.5148 6.00008H6.00008ZM12.0001 16.0001C9.79094 16.0001 8.00008 14.2092 8.00008 12.0001C8.00008 9.79094 9.79094 8.00008 12.0001 8.00008C14.2092 8.00008 16.0001 9.79094 16.0001 12.0001C16.0001 14.2092 14.2092 16.0001 12.0001 16.0001ZM12.0001 14.0001C13.1047 14.0001 14.0001 13.1047 14.0001 12.0001C14.0001 10.8955 13.1047 10.0001 12.0001 10.0001C10.8955 10.0001 10.0001 10.8955 10.0001 12.0001C10.0001 13.1047 10.8955 14.0001 12.0001 14.0001Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="space24"></div>
                            <div class="content">
                                <a href="property-details-v1.html">Services</a>
                                <div class="space16"></div>
                                <p>Advertise consulting, valuation, architecture, or property services.</p>
                                <div class="space24"></div>
                                <a href="property-details-v1.html" class="readmore">learn more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"></path>
                                    </svg></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="work3-section-area sp2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="heading2 text-center space-margin60">
                    <!-- <h5 data-aos="fade-left" data-aos-duration="800" class="aos-init aos-animate">HOW WE WORK</h5> -->
                    <div class="space20"></div>
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        How It Works
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 aos-init aos-animate" data-aos="zoom-in-up" data-aos-duration="800">
                <div class="work-single-boxarea">
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/work/work-img1.png') }}" alt="housebox">
                    </div>
                    <div class="space20"></div>
                    <div class="content">
                        <h3>1</h3>
                        <div class="space18"></div>
                        <a href="property-details-v1.html">Choose What to Promote</a>
                        <p class="text-muted">
                Select your profile, house, land, or service.
            </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 aos-init aos-animate" data-aos="zoom-in-up" data-aos-duration="900">
                <div class="work-single-boxarea">
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/work/work-img2.png') }}" alt="housebox">
                    </div>
                    <div class="space20"></div>
                    <div class="content">
                        <h3>2</h3>
                        <div class="space18"></div>
                        <a href="property-details-v1.html">Create Your Ad</a>
                        <p class="text-muted">
                Add a title, description, banner image, and select ad type.
            </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 aos-init aos-animate" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="work-single-boxarea">
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/work/work-img3.png') }}" alt="housebox">
                    </div>
                    <div class="space20"></div>
                    <div class="content">
                        <h3>3</h3>
                        <div class="space18"></div>
                        <a href="property-details-v1.html">Get Visibility</a>
                        <p class="text-muted">
                Your ad appears in featured sections across the platform.
            </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="items2-section-area sp1" style="background-image: url({{ asset('front/assets/img/all-images/bg/bg2.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover; background-attachment: fixed;">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 m-auto">
                <div class="item-header heading1 text-center space-margin60">
                    <h5>our best featured</h5>
                    <div class="space20"></div>
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        Why Advertise With Us?
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="items-images-area">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card p-4 h-100">
                            <h2 class="fw-bold">Why Advertise With Us?</h2>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2">✅ Reach verified buyers & investors</li>
                                <li class="mb-2">✅ Boost trust and credibility</li>
                                <li class="mb-2">✅ Priority placement on listings</li>
                                <li class="mb-2">✅ Flexible advertising packages</li>
                                <li class="mb-2">✅ Performance-based exposure</li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold">Perfect For:</h5>
                            <ul class="mb-0">
                                <li>Real estate agents</li>
                                <li>Property consultants</li>
                                <li>Land brokers</li>
                                <li>Property service providers</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="testimonial2-section-area sp1" style="background-image: url({{ asset('front/assets/img/all-images/bg/bg1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-header space-margin60">
                    <div class="heading1">
                        <h5>What Agents Say</h5>
                        <div class="space20"></div>
                        <h2 class="text-anime-style-3" style="perspective: 400px;">
                            Trusted by professionals across the platform
                        </h2>
                    </div>
                    <div class="btn-area1">
                        <a href="index.html" class="theme-btn3">View All Testimonials <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="img1 image-anime reveal" style="opacity: 1; visibility: inherit; translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                    <img src="{{ asset('front/assets/img/all-images/testimonial/testimonial-img3.png') }}" alt="housebox" style="translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="slider-galeria slick-initialized slick-slider">
                    <div class="slick-list draggable">
                        <div class="slick-track" style="opacity: 1; width: 6006px; transform: translate3d(-546px, 0px, 0px);">
                            <div class="testimonial-slider-content-area slick-slide slick-cloned" data-slick-index="-1" id="" aria-hidden="true" tabindex="-1" style="width: 486px;">
                                <div class="testimonial-author-area">
                                    <ul>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                    </ul>
                                    <div class="space16"></div>
                                    <img src="{{ asset('front/assets/img/icons/quito2.svg') }}" alt="housebox" class="quito2">
                                    <img src="{{ asset('front/assets/img/elements/elements3.png') }}" alt="housebox" class="elements3">
                                    <p>"The team at [Your Agency] transformed the way I looked at real estate. Their marketing was incredible—professional photos, virtual tours, and wide exposure. We had multiple offers within the first week!"</p>
                                </div>
                                <div class="space60"></div>
                                <div class="testimonial-man-info-area">
                                    <div class="man-images-text">
                                        <div class="mans-img">
                                            <img src="{{ asset('front/assets/img/all-images/testimonial/testimonial-img4.png') }}" alt="housebox">
                                        </div>
                                        <div class="man-text">
                                            <a href="team.html" tabindex="-1">Sheldon Jackson</a>
                                            <div class="space12"></div>
                                            <p>Shop Store Owner</p>
                                        </div>
                                    </div>
                                    <img src="{{ asset('front/assets/img/elements/elements4.png') }}" alt="housebox">
                                </div>
                            </div>
                            <div class="testimonial-slider-content-area slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="0" style="width: 486px;">
                                <div class="testimonial-author-area">
                                    <ul>
                                        <li><a href="" tabindex="0"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="0"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="0"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="0"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="0"><i class="fa-solid fa-star"></i></a></li>
                                    </ul>
                                    <div class="space16"></div>
                                    <img src="{{ asset('front/assets/img/icons/quito2.svg') }}" alt="housebox" class="quito2">
                                    <img src="{{ asset('front/assets/img/elements/elements3.png') }}" alt="housebox" class="elements3">
                                    <p>“From start to finish, the team was exceptional. There are listened to our needs, provided expert guidance, &amp; found us the perfect home. We couldn’t be happier on with their serviceI got the best deal possible! Thanks””</p>
                                </div>
                                <div class="space60"></div>
                                <div class="testimonial-man-info-area">
                                    <div class="man-images-text">
                                        <div class="mans-img">
                                            <img src="{{ asset('front/assets/img/all-images/testimonial/testimonial-img4.png') }}" alt="housebox">
                                        </div>
                                        <div class="man-text">
                                            <a href="team.html" tabindex="0">Sheldon Jackson</a>
                                            <div class="space12"></div>
                                            <p>Shop Store Owner</p>
                                        </div>
                                    </div>
                                    <img src="{{ asset('front/assets/img/elements/elements4.png') }}" alt="housebox">
                                </div>
                            </div>
                            <div class="testimonial-slider-content-area slick-slide" data-slick-index="1" aria-hidden="true" tabindex="-1" style="width: 486px;">
                                <div class="testimonial-author-area">
                                    <ul>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                        <li><a href="" tabindex="-1"><i class="fa-solid fa-star"></i></a></li>
                                    </ul>
                                    <div class="space16"></div>
                                    <img src="{{ asset('front/assets/img/icons/quito2.svg') }}" alt="housebox" class="quito2">
                                    <img src="{{ asset('front/assets/img/elements/elements3.png') }}" alt="housebox" class="elements3">
                                    <p>"Worth every dollar. I now promote my land listings and profile at the same time."</p>
                                </div>
                                <div class="space60"></div>
                                <div class="testimonial-man-info-area">
                                    <div class="man-images-text">
                                        <div class="mans-img">
                                            <img src="{{ asset('front/assets/img/all-images/testimonial/testimonial-img5.png') }}" alt="housebox">
                                        </div>
                                        <div class="man-text">
                                            <a href="team.html" tabindex="-1">Sheldon Jackson</a>
                                            <div class="space12"></div>
                                            <p>Shop Store Owner</p>
                                        </div>
                                    </div>
                                    <img src="{{ asset('front/assets/img/elements/elements4.png') }}" alt="housebox">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-1">
                <div class="slider-galeria-thumbs text-center d-lg-block d-none slick-initialized slick-slider slick-vertical">
                    <div class="slick-list draggable" style="height: 325.333px;">
                        <div class="slick-track" style="opacity: 1; height: 488px; transform: translate3d(0px, 0px, 0px);">
                            <div class="testimonial3-sliders-img slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="0" style="width: 71px;">
                                <img src="{{ asset('front/assets/img/all-images/testimonial/testimonial-img4.png') }}" alt="housebox">
                            </div>
                            <div class="testimonial3-sliders-img slick-slide slick-active" data-slick-index="1" aria-hidden="false" tabindex="0" style="width: 71px;">
                                <img src="{{ asset('front/assets/img/all-images/testimonial/testimonial-img5.png') }}" alt="housebox">
                            </div>
                            <div class="testimonial3-sliders-img slick-slide slick-active" data-slick-index="2" aria-hidden="false" tabindex="0" style="width: 71px;">
                                <img src="{{ asset('front/assets/img/all-images/testimonial/testimonial-img6.png') }}" alt="housebox">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="faq-section-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="heading1 text-center space-margin60">
                    <h5>FAQ,s</h5>
                    <div class="space20"></div>
                    <h2>Frequently Asked Question</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="faq-area">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What can I advertise?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>You can advertise your agent profile, houses, land, or professional services.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Can I change my plan later?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Yes, you can upgrade or downgrade your plan anytime from your dashboard.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How long does approval take?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Most ads are approved within 24 hours to ensure quality and trust.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cta1-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-bg-area" style="background-image: url({{ asset('front/assets/img/all-images/bg/cta-bg1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="cta-header">
                                <h2 class="text-anime-style-3" style="perspective: 400px;">
                                    Ready to Grow Your Business?
                                </h2>
                                <div class="space16"></div>
                                <p data-aos="fade-left" data-aos-duration="1000" class="aos-init aos-animate">
                                    Create your first advertisement and start attracting more clients today.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-2"></div>
                        <div class="col-lg-5 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000">
                            <div class="btn-area1 text-center">
                                <a href="sidebar-grid.html" class="theme-btn1">Get started<span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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
    </div>
</div>


@endsection