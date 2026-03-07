@extends('layouts.guest')
@section('title', 'Explore Our Terra Services')
@section('content')

<div class="offer1-section-area sp1"
    style="background-image: url(front/assets/img/all-images/bg/bg1.png);
     background-position: center;
     background-repeat: no-repeat;
     background-size: cover;">

    <div class="container">
        <div class="row">
            <div class="col-lg-7 m-auto">
                <div class="heading1 text-center space-margin60">
                    <h5>What We Offer</h5>
                    <div class="space20"></div>
                    <h2>How can Terra Real Estate Help You?</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Image -->
            <div class="col-lg-4">
                <div class="img1">
                    <img src="{{ asset('front/assets/img/all-images/about/about-img9.png') }}" alt="Terra Services">
                </div>
            </div>

            <!-- Services -->
            <div class="col-lg-8">
                <div class="row">

                    @foreach($serviceCategories as $category)
                    <div class="col-lg-6 col-md-6">
                        <div class="offer-boxarea">

                            <div class="icons">
                                {!! $category->icon_svg ?? '<i class="bi bi-building"></i>' !!}
                            </div>

                            <div class="space24"></div>

                            <div class="content">
                                <a href="{{ route('services.category', $category->id) }}">
                                    {{ $category->name }}
                                </a>

                                <div class="space16"></div>

                                <p>
                                    {{ Str::limit($category->description, 120) }}
                                </p>

                                <div class="space24"></div>

                                <a href="{{ route('services.category', $category->slug) }}" class="readmore">
                                    learn more
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"></path>
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

@endsection