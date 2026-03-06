@extends('layouts.guest')
@section('title', 'Tenders')
@section('content')

<div class="blog-inner-section sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="blog-siderbar">
                    <div class="all-category">
                        <div class="search-area">
                            <h3>Search Tender</h3>
                            <div class="space24"></div>
                            <form>
                                <input type="text" placeholder="Search...">
                                <button><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                                    </svg></button>
                            </form>
                        </div>
                        <div class="space30"></div>
                        <div class="categories-area">
                            <h3>Locations</h3>
                            <ul>
                                @foreach($locations as $location)
                                    <li><a href="#">{{ $location }} ({{ $tenders->where('location', $location)->count() }}) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path>
                                        </svg></a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="space30"></div>
                        <div class="posts-area">
                            <h3>Featured Tenders</h3>
                            @forelse ($featuredTenders as $tender)
                            <div class="post-auhtor-area">
                                <div class="img1">
                                    <img src="{{ asset('front/assets/img/all-images/blog/blog-img4.png') }}" alt="{{ $tender->title }}">
                                </div>
                                <div class="content">
                                    <a href="#" class="date"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M2 11H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V11ZM17 3H21C21.5523 3 22 3.44772 22 4V9H2V4C2 3.44772 2.44772 3 3 3H7V1H9V3H15V1H17V3Z"></path>
                                        </svg> {{ $tender->created_at->format('d F Y') }}</a>
                                    <a href="property-details-v1.html" class="head">{{ $tender->title }}</a>
                                </div>
                            </div>
                            @empty
                            <div class="no-results">
                                <p>No featured tenders found.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="space40 d-lg-none d-block"></div>
                <div class="row">
                    @forelse ($tenders as $tender)
                    <div class="col-lg-12">
                        <div class="blog-details-boxarea mb-8">
                            <div class="content-area">
                                <ul>
                                    <li><a href="{{ route('front.tenders.details', $tender->id) }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M11 14.0619V20H13V14.0619C16.9463 14.554 20 17.9204 20 22H4C4 17.9204 7.05369 14.554 11 14.0619ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z"></path>
                                            </svg> By {{ $tender->user->name }}</a></li>
                                    <li><a href="{{ route('front.tenders.details', $tender->id) }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M2 11H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V11ZM17 3H21C21.5523 3 22 3.44772 22 4V9H2V4C2 3.44772 2.44772 3 3 3H7V1H9V3H15V1H17V3Z"></path>
                                            </svg> {{ $tender->created_at->format('d F Y') }}</a></li>
                                </ul>
                                <div class="space24"></div>
                                <a href="{{ route('front.tenders.details', $tender->id) }}">{{ $tender->title }}</a>
                                <div class="space16"></div>
                                <p>{{ Str::limit($tender->description, 100) }}</p>
                                <div class="space24"></div>
                                <a href="{{ route('front.tenders.details', $tender->id) }}" class="readmore">learn more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"></path>
                                    </svg></a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="no-results">
                        <p>No tenders found.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection