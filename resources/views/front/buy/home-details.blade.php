@extends('layouts.guest')
@section('title', $home->title)
@section('content')

<!--===== PROPERTIES AREA STARTS =======-->
<div class="properties-details1-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="images-area-details" style="padding-top: 5rem;">
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img29.png') }}" alt="{{ $home->title }}">
                    </div>
                    <div class="space40"></div>
                    <div class="content-area">
                        <div class="content heading2">
                            <h2>{{ $home->title }}</h2>
                            <ul>
                                <li><a href="#">{{ number_format($home->price, 0) }} RWF</a></li>
                                <li><a href="#">/{{ $home->type }}</a></li>
                            </ul>
                        </div>

                        <div class="list-area">
                            <div class="list">
                                <ul>
                                    <li>Features:</li>
                                    <li><a href="#"><img src="{{ asset('front/assets/img/icons/bed1.svg') }}" alt="{{ $home->title }}">x{{ $home->bedrooms }} <span> | </span></a></li>
                                    <li><a href="#"><img src="{{ asset('front/assets/img/icons/bath1.svg') }}" alt="{{ $home->title }}">x{{ $home->bathrooms }} <span> | </span></a></li>
                                    <li><a href="#"><img src="{{ asset('front/assets/img/icons/sqare1.svg') }}" alt="{{ $home->title }}">{{ $home->area_sqft }} sq</a></li>
                                </ul>
                                <ul class="m-0">
                                    <li>Location:</li>
                                    <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995L16.9497 15.9497ZM12 13C10.8954 13 10 12.1046 10 11C10 9.89543 10.8954 9 12 9C13.1046 9 14 9.89543 14 11C14 12.1046 13.1046 13 12 13Z">
                                                </path>
                                            </svg> {{ $home->address }}</a></li>
                                </ul>
                            </div>

                            <ul class="share">
                                <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853ZM18.827 6.1701C17.3279 4.66794 14.9076 4.60701 13.337 6.01687L12.0019 7.21524L10.6661 6.01781C9.09098 4.60597 6.67506 4.66808 5.17157 6.17157C3.68183 7.66131 3.60704 10.0473 4.97993 11.6232L11.9999 18.6543L19.0201 11.6232C20.3935 10.0467 20.319 7.66525 18.827 6.1701Z">
                                            </path>
                                        </svg></a></li>
                                <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M13.1202 17.0228L8.92129 14.7324C8.19135 15.5125 7.15261 16 6 16C3.79086 16 2 14.2091 2 12C2 9.79086 3.79086 8 6 8C7.15255 8 8.19125 8.48746 8.92118 9.26746L13.1202 6.97713C13.0417 6.66441 13 6.33707 13 6C13 3.79086 14.7909 2 17 2C19.2091 2 21 3.79086 21 6C21 8.20914 19.2091 10 17 10C15.8474 10 14.8087 9.51251 14.0787 8.73246L9.87977 11.0228C9.9583 11.3355 10 11.6629 10 12C10 12.3371 9.95831 12.6644 9.87981 12.9771L14.0788 15.2675C14.8087 14.4875 15.8474 14 17 14C19.2091 14 21 15.7909 21 18C21 20.2091 19.2091 22 17 22C14.7909 22 13 20.2091 13 18C13 17.6629 13.0417 17.3355 13.1202 17.0228ZM6 14C7.10457 14 8 13.1046 8 12C8 10.8954 7.10457 10 6 10C4.89543 10 4 10.8954 4 12C4 13.1046 4.89543 14 6 14ZM17 8C18.1046 8 19 7.10457 19 6C19 4.89543 18.1046 4 17 4C15.8954 4 15 4.89543 15 6C15 7.10457 15.8954 8 17 8ZM17 20C18.1046 20 19 19.1046 19 18C19 16.8954 18.1046 16 17 16C15.8954 16 15 16.8954 15 18C15 19.1046 15.8954 20 17 20Z">
                                            </path>
                                        </svg></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="space48"></div>
                <div class="property-details-slider owl-carousel">
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img30.png')}}" alt="{{ $home->title }}">
                    </div>
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img31.png')}}" alt="{{ $home->title }}">
                    </div>
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img32.png')}}" alt="{{ $home->title }}">
                    </div>
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img30.png')}}" alt="{{ $home->title }}">
                    </div>
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img31.png')}}" alt="{{ $home->title }}">
                    </div>
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img32.png')}}" alt="{{ $home->title }}">
                    </div>
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img30.png')}}" alt="{{ $home->title }}">
                    </div>
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img31.png')}}" alt="{{ $home->title }}">
                    </div>
                    <div class="img1">
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img32.png')}}" alt="{{ $home->title }}">
                    </div>
                </div>
                <div class="space80"></div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="details-siderbar">
                            <h3>Play Video</h3>
                            <div class="space32"></div>
                            <div class="vide-images">
                                <div class="img1">
                                    <img src="{{ asset('front/assets/img/all-images/properties/property-img33.png') }}" alt="housebox">
                                </div>
                                <a href="https://www.youtube.com/watch?v=ec_fXMrD7Ow&amp;ab_channel=ProjectRemark"
                                    class="popup-youtube"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path
                                            d="M6 20.1957V3.80421C6 3.01878 6.86395 2.53993 7.53 2.95621L20.6432 11.152C21.2699 11.5436 21.2699 12.4563 20.6432 12.848L7.53 21.0437C6.86395 21.46 6 20.9812 6 20.1957Z">
                                        </path>
                                    </svg></a>
                            </div>
                            <div class="space60"></div>
                            <h3>{{ $home->title }} Amenities</h3>
                            <div class="space12"></div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row gap-1">
                                    @foreach($home->facilities as $facility)
                                    <div class="list-box col-auto">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                                <g clip-path="url(#clip0_2294_3357)">
                                                    <path
                                                        d="M13 31.0054H5C4.46957 31.0054 3.96086 30.7947 3.58579 30.4196C3.21071 30.0445 3 29.5358 3 29.0054V3.00537C3 2.47494 3.21071 1.96623 3.58579 1.59116C3.96086 1.21608 4.46957 1.00537 5 1.00537H19C19.5304 1.00537 20.0391 1.21608 20.4142 1.59116C20.7893 1.96623 21 2.47494 21 3.00537V10"
                                                        stroke="#073B3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M7.49997 15.5053C7.40086 15.5053 7.30398 15.5348 7.22164 15.59C7.1393 15.6452 7.07523 15.7236 7.03754 15.8152C6.99986 15.9069 6.99028 16.0077 7.01001 16.1049C7.02973 16.202 7.07789 16.2911 7.14835 16.3608C7.21881 16.4305 7.3084 16.4777 7.40574 16.4964C7.50308 16.5151 7.60377 16.5044 7.69504 16.4657C7.7863 16.4271 7.86402 16.3621 7.91831 16.2792C7.97261 16.1963 8.00103 16.0991 7.99997 16C7.99997 15.8674 7.94729 15.7402 7.85352 15.6464C7.75976 15.5527 7.63258 15.5 7.49997 15.5"
                                                        stroke="#073B3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M27 21.0054H19C17.8954 21.0054 17 21.9008 17 23.0054V29.0054C17 30.1099 17.8954 31.0054 19 31.0054H27C28.1046 31.0054 29 30.1099 29 29.0054V23.0054C29 21.9008 28.1046 21.0054 27 21.0054Z"
                                                        stroke="#073B3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M19 21.0054V19.0054C19 17.9445 19.4214 16.9271 20.1716 16.1769C20.9217 15.4268 21.9391 15.0054 23 15.0054C24.0609 15.0054 25.0783 15.4268 25.8284 16.1769C26.5786 16.9271 27 17.9445 27 19.0054V21.0054"
                                                        stroke="#073B3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M23 25.5054C22.9011 25.5054 22.8044 25.5347 22.7222 25.5896C22.64 25.6446 22.5759 25.7227 22.5381 25.814C22.5002 25.9054 22.4903 26.0059 22.5096 26.1029C22.5289 26.1999 22.5765 26.289 22.6464 26.3589C22.7164 26.4289 22.8055 26.4765 22.9025 26.4958C22.9994 26.5151 23.1 26.5052 23.1913 26.4673C23.2827 26.4295 23.3608 26.3654 23.4157 26.2832C23.4707 26.2009 23.5 26.1043 23.5 26.0054C23.5 25.8728 23.4473 25.7456 23.3536 25.6518C23.2598 25.558 23.1326 25.5054 23 25.5054Z"
                                                        stroke="#073B3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_2294_3357">
                                                        <rect width="32" height="32" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="text">
                                            <p>{{ $facility->name }} </p>
                                        </div>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="space60"></div>
                            <div class="download-box">
                                <h3>{{ $home->title }} File</h3>
                                <div class="space28"></div>
                                <div class="download">
                                    <a href="#"><span><img src="{{ asset('front/assets/img/icons/pdf1.svg')}}" alt="{{ $home->title }}"></span>{{ $home->service->title }} Document. pdf
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M13 10H18L12 16L6 10H11V3H13V10ZM4 19H20V12H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V12H4V19Z">
                                            </path>
                                        </svg></a>
                                    <a href="#" class="m-0"><span><img src="{{ asset('front/assets/img/icons/pdf2.svg')}}" alt="{{ $home->title }}"></span>{{ $home->service->title }}
                                        Document. pdf <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M13 10H18L12 16L6 10H11V3H13V10ZM4 19H20V12H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V12H4V19Z">
                                            </path>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="space60"></div>
                            <h3>Explore 360° View</h3>
                            <div class="space32"></div>
                            <div class="rotate-images">
                                <div class="img1">
                                    <img src="{{ asset('front/assets/img/all-images/properties/property-img34.png') }}" alt="{{ $home->title }}">
                                </div>
                                <a href="#"><img src="{{ asset('front/assets/img/icons/rotate.svg') }}" alt="{{ $home->title }}"></a>
                            </div>
                            <div class="space60"></div>
                            <h3>Map Locations</h3>
                            <div class="space32"></div>
                            <div class="map-section">
                                <iframe
                                    src="https://www.google.com/maps?q={{ urlencode($home->address . ', ' . $home->city . ', ' . $home->country) }}&output=embed"
                                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <div class="space12"></div>
                                <div class="list">
                                    <ul>
                                        <li>
                                            <span>Address:</span>
                                            <div>{{ $home->address}}</div>
                                        </li>
                                        <li>
                                            <span>City:</span>
                                            <div>{{ $home->city }}</div>
                                        </li>
                                    </ul>
                                    <ul class="m-0 ">
                                        <li>
                                            <span>Postal Code:</span>
                                            <div>{{ $home->zip_code}}</div>
                                        </li>
                                        <li>
                                            <span>Area Name:</span>
                                            <div>{{ $home->state}}</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="space60"></div>
                            
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="all-side-details">
                            <div class="details-siderbar2">
                                <h4>Contact Seller</h4>
                                <div class="space24"></div>
                                <div class="personal-info">
                                    <div class="img1">
                                        <img src="{{ asset('front/assets/img/all-images/blog/blog-img17.png') }}" alt="housebox">
                                    </div>
                                    <div class="content">
                                        <a href="#">{{ $home->user->name }}</a>
                                        <a href="mailto:{{ $home->user->email }}"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594V19H20V7.23792ZM4.51146 5L12.0619 11.662L19.501 5H4.51146Z">
                                                </path>
                                            </svg>{{ $home->user->email }}</a>
                                        <a href="tel:{{ $home->user->phone ?? 'N/A' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z">
                                                </path>
                                            </svg>{{ $home->user->phone ?? 'N/A' }}</a>
                                    </div>
                                </div>
                                <div class="space10"></div>
                                <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                                    <p class="text-muted mb-0">Office Phone :</p>
                                    <h6 class="mb-0">{{ $home->user->phone ?? 'N/A' }}</h6>
                                </div>
                                <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                                    <p class="text-muted mb-0">Email :</p>
                                    <h6 class="mb-0">{{ $home->user->email }}</h6>
                                </div>
                                <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                                    <p class="text-muted mb-0">Website :</p>
                                    <h6 class="mb-0">{{ $home->user->website ?? 'N/A' }}</h6>
                                </div>
                                <div class="mb-5 d-flex flex-wrap gap-2 justify-content-between">
                                    <p class="text-muted mb-0">Role :</p>
                                    <h6 class="mb-0">{{ $home->user->role }}</h6>
                                </div>
                                <div class="d-flex flex-wrap gap-2 justify-content-between">
                                    <p class="text-muted mb-0">Working Hours :</p>
                                    <h6 class="mb-0">Mon - Fri, 9am - 6pm</h6>
                                </div>
                                <div class="input-area">
                                    <button type="submit" class="theme-btn1">Find Properties <span class="arrow1"><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                                fill="currentColor">
                                                <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                            </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="24" height="24" fill="currentColor">
                                                <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                            </svg></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="propoerties-boxes-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading1 space-margin60">
                    <h2>Our Latest Properties</h2>
                    <div class="btn-area1">
                        <a href="property-halfmap-grid" class="theme-btn1">See All Properties <span class="arrow1"><svg
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
        <div class="row">
            <div class="col-lg-12">
                <div class="single-slider-area owl-carousel">
                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img2.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Luxury Suite Villa</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x12</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x16</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                            </div>
                        </div>
                    </div>

                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img4.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Three Room Apartment</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x20</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x30</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                            </div>
                        </div>
                    </div>
                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img6.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Gorgeous Home for Sale</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x23</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x34</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                            </div>
                        </div>
                    </div>

                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img2.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Luxury Suite Villa</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x12</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x16</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                            </div>
                        </div>
                    </div>

                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img4.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Three Room Apartment</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x20</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x30</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                            </div>
                        </div>
                    </div>
                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img6.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Gorgeous Home for Sale</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x23</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x34</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                            </div>
                        </div>
                    </div>

                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img2.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Luxury Suite Villa</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x12</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x16</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                            </div>
                        </div>
                    </div>

                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img4.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Three Room Apartment</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x20</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x30</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                            </div>
                        </div>
                    </div>
                    <div class="property-boxarea">
                        <div class="img1 image-anime">
                            <img src="assets/img/all-images/properties/property-img6.png" alt="housebox">
                        </div>
                        <div class="category-list">
                            <ul>
                                <li><a href="property-details-v1">Featured</a></li>
                                <li><a href="property-details-v1">For Sale</a></li>
                            </ul>
                        </div>
                        <div class="content-area">
                            <a href="property-details-v1">Gorgeous Home for Sale</a>
                            <div class="space18"></div>
                            <p>Los Angeles City, CA, USA</p>
                            <div class="space24"></div>
                            <ul>
                                <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x23</a></li>
                                <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x34</a></li>
                                <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">1200 sq</a></li>
                            </ul>
                            <div class="btn-area">
                                <a href="#" class="nm-btn">$820,000</a>
                                <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox"
                                        class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
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