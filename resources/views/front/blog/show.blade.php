@extends('layouts.guest')
@section('title', $blog->title)
@section('content')

<div class="blog-inner-section sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="blog-siderbar">
                    <div class="all-category">
                        <div class="search-area">
                            <h3>Search Blog</h3>
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
                            <h3>Blog Category</h3>
                            <ul>
                                @foreach($blogCategories as $category)
                                    <li><a href="#">{{ $category->name }} ({{ $category->blogs_count }}) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path>
                                        </svg></a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="space30"></div>
                        <div class="posts-area">
                            <h3>Related News</h3>
                            @forelse($related as $new)
                            <div class="post-auhtor-area">
                                <div class="img1">
                                    <img src="{{ asset('front/assets/img/all-images/blog/blog-img4.png') }}" alt="housebox">
                                </div>
                                <div class="content">
                                    <a href="#" class="date"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M2 11H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V11ZM17 3H21C21.5523 3 22 3.44772 22 4V9H2V4C2 3.44772 2.44772 3 3 3H7V1H9V3H15V1H17V3Z"></path>
                                        </svg> {{ $new->created_at->format('d F Y') }}</a>
                                    <a href="#" class="head">{{ $new->title }}</a>
                                </div>
                            </div>

                            @empty
                            <p>No related posts found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="space40 d-lg-none d-block"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog-post-details-area heading1">
                            <div class="img1">
                                <img src="{{ asset('front/assets/img/all-images/blog/blog-img20.png') }}" alt="{{ $blog->title }}">
                            </div>
                            <div class="space32"></div>
                            <ul class="list-author">
                                <li><a href="#">#{{ $blog->category->name }}</a></li>
                                <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="21" viewBox="0 0 16 21" fill="none">
                                            <path d="M7.08317 12.8894V18.3327H8.9165V12.8894C12.5339 13.3405 15.3332 16.4264 15.3332 20.166H0.666504C0.666504 16.4264 3.46572 13.3405 7.08317 12.8894ZM7.99984 11.916C4.96109 11.916 2.49984 9.45477 2.49984 6.41602C2.49984 3.37727 4.96109 0.916016 7.99984 0.916016C11.0386 0.916016 13.4998 3.37727 13.4998 6.41602C13.4998 9.45477 11.0386 11.916 7.99984 11.916Z" fill="#030E0F"></path>
                                        </svg> By {{ $blog->author->name }} <span> | </span></a></li>
                                <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M1.6665 9.16732H18.3332V16.6673C18.3332 17.1276 17.9601 17.5007 17.4998 17.5007H2.49984C2.0396 17.5007 1.6665 17.1276 1.6665 16.6673V9.16732ZM14.1665 2.50065H17.4998C17.9601 2.50065 18.3332 2.87375 18.3332 3.33398V7.50065H1.6665V3.33398C1.6665 2.87375 2.0396 2.50065 2.49984 2.50065H5.83317V0.833984H7.49984V2.50065H12.4998V0.833984H14.1665V2.50065Z" fill="#030E0F"></path>
                                        </svg> {{ $blog->created_at->format('d F Y') }}</a></li>
                            </ul>
                            <div class="space20"></div>
                            <h2>{{ $blog->title }}</h2>
                            <div class="space18"></div>
                            <p>{!! $blog->content !!}</p>

                            <div class="space28"></div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection