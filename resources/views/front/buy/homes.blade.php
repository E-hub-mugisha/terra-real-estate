@extends('layouts.guest')
@section('title', 'Homes for Sale')
@section('content')

<!--===== HERO AREA STARTS =======-->
<div class="hero-inner-section-area grid-area">
    <img src="{{ asset('front/assets/img/all-images/hero/hero-img1.png') }}" alt="housebox" class="hero-img1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-header-area text-center">
                    <a href="index.html">Home <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                            </path>
                        </svg> Listing <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                            </path>
                        </svg> Property Half Map Grid</a>
                    <div class="space24"></div>
                    <h1>Property Half Map Grid</h1>
                </div>
                <div class="space80"></div>
            </div>
        </div>
    </div>
    <!--===== OTHERS AREA STARTS =======-->
    <div class="others-section-area-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="theme-btn1 open-search-filter-form">
                        <p class="open-text">Open Search Form
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                                </path>
                            </svg>
                        </p>
                        <p class="close-text">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z">
                                </path>
                            </svg>
                            Close
                        </p>
                    </div>

                    <div class="property-tab-section search-filter-form">
                        <div class="tab-header">
                            <button class="tab-btn active" data-tab="for-sale">For Sale</button>
                            <button class="tab-btn" data-tab="for-rent">For Rent</button>
                        </div>

                        <div class="tab-content1" id="for-sale">
                            <div class="filters">
                                <div class="filter-group">
                                    <label>Status</label>
                                    <select>
                                        <option>All Status</option>
                                        <option>For Rent</option>
                                        <option>For Sale</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Labels</label>
                                    <select>
                                        <option>All Labels</option>
                                        <option>New Offer</option>
                                        <option>Hot Offer</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Types</label>
                                    <select>
                                        <option>All Types</option>
                                        <option>Apartment</option>
                                        <option>Bar</option>
                                        <option>Cafe</option>
                                        <option>House</option>
                                        <option>Farm</option>
                                        <option>Luxury Homes</option>
                                        <option>Office</option>
                                        <option>Single Family</option>
                                        <option>Store</option>
                                        <option>Villa</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label for="customize-sale">Customize</label>
                                    <button id="customize-sale" class="customize-sale show-form">
                                        Advance <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M6.17071 18C6.58254 16.8348 7.69378 16 9 16C10.3062 16 11.4175 16.8348 11.8293 18H22V20H11.8293C11.4175 21.1652 10.3062 22 9 22C7.69378 22 6.58254 21.1652 6.17071 20H2V18H6.17071ZM12.1707 11C12.5825 9.83481 13.6938 9 15 9C16.3062 9 17.4175 9.83481 17.8293 11H22V13H17.8293C17.4175 14.1652 16.3062 15 15 15C13.6938 15 12.5825 14.1652 12.1707 13H2V11H12.1707ZM6.17071 4C6.58254 2.83481 7.69378 2 9 2C10.3062 2 11.4175 2.83481 11.8293 4H22V6H11.8293C11.4175 7.16519 10.3062 8 9 8C7.69378 8 6.58254 7.16519 6.17071 6H2V4H6.17071Z">
                                                </path>
                                            </svg></span>
                                    </button>
                                </div>
                                <div class="search-button">
                                    <button id="search-sale">Search <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                                            </path>
                                        </svg></button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content1" id="for-rent" style="display: none;">
                            <div class="filters">
                                <div class="filter-group">
                                    <label>Status</label>
                                    <select>
                                        <option>All Status</option>
                                        <option>For Rent</option>
                                        <option>For Sale</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Labels</label>
                                    <select>
                                        <option>All Labels</option>
                                        <option>New Offer</option>
                                        <option>Hot Offer</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Types</label>
                                    <select>
                                        <option>All Types</option>
                                        <option>Apartment</option>
                                        <option>Bar</option>
                                        <option>Cafe</option>
                                        <option>House</option>
                                        <option>Farm</option>
                                        <option>Luxury Homes</option>
                                        <option>Office</option>
                                        <option>Single Family</option>
                                        <option>Store</option>
                                        <option>Villa</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label for="customize-sale">Customize</label>
                                    <button id="customize-sale1" class="customize-sale show-form">
                                        Advance <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M6.17071 18C6.58254 16.8348 7.69378 16 9 16C10.3062 16 11.4175 16.8348 11.8293 18H22V20H11.8293C11.4175 21.1652 10.3062 22 9 22C7.69378 22 6.58254 21.1652 6.17071 20H2V18H6.17071ZM12.1707 11C12.5825 9.83481 13.6938 9 15 9C16.3062 9 17.4175 9.83481 17.8293 11H22V13H17.8293C17.4175 14.1652 16.3062 15 15 15C13.6938 15 12.5825 14.1652 12.1707 13H2V11H12.1707ZM6.17071 4C6.58254 2.83481 7.69378 2 9 2C10.3062 2 11.4175 2.83481 11.8293 4H22V6H11.8293C11.4175 7.16519 10.3062 8 9 8C7.69378 8 6.58254 7.16519 6.17071 6H2V4H6.17071Z">
                                                </path>
                                            </svg></span>
                                    </button>
                                </div>
                                <div class="search-button">
                                    <button id="search-sale1">Search <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                                            </path>
                                        </svg></button>
                                </div>
                            </div>
                        </div>

                        <div class="wd-search-form ">
                            <div class=" group-select">
                                <div class="box-select">
                                    <h5>Bathrooms</h5>
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">Bathrooms</span>
                                        <ul class="list">
                                            <li data-value="1" class="option">1</li>
                                            <li data-value="2" class="option selected">2</li>
                                            <li data-value="3" class="option">3</li>
                                            <li data-value="4" class="option">4</li>
                                            <li data-value="5" class="option">5</li>
                                            <li data-value="6" class="option">6</li>
                                            <li data-value="7" class="option">7</li>
                                            <li data-value="8" class="option">8</li>
                                            <li data-value="9" class="option">9</li>
                                            <li data-value="10" class="option">10</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box-select">
                                    <h5>Bedrooms</h5>
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">Bedrooms</span>
                                        <ul class="list">
                                            <li data-value="1" class="option">1</li>
                                            <li data-value="2" class="option selected">2</li>
                                            <li data-value="3" class="option">3</li>
                                            <li data-value="4" class="option">4</li>
                                            <li data-value="5" class="option">5</li>
                                            <li data-value="6" class="option">6</li>
                                            <li data-value="7" class="option">7</li>
                                            <li data-value="8" class="option">8</li>
                                            <li data-value="9" class="option">9</li>
                                            <li data-value="10" class="option">10</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box-select">
                                    <h5>States</h5>
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">All States</span>
                                        <ul class="list">
                                            <li data-value="1" class="option">New York</li>
                                            <li data-value="2" class="option selected">California</li>
                                            <li data-value="3" class="option">Texas</li>
                                            <li data-value="4" class="option">Sydney</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box-select">
                                    <h5>City</h5>
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">All Cities</span>
                                        <ul class="list">
                                            <li data-value="1" class="option">Alice</li>
                                            <li data-value="2" class="option selected">Bridgaport</li>
                                            <li data-value="3" class="option">Dallas</li>
                                            <li data-value="4" class="option">Kingston</li>
                                            <li data-value="5" class="option">Los Angeles</li>
                                            <li data-value="6" class="option">New York</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class=" group-select">
                                <div class="box-select">
                                    <h5>Garages</h5>
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">Any Garages</span>
                                        <ul class="list">
                                            <li data-value="1" class="option">1</li>
                                            <li data-value="2" class="option selected">2</li>
                                            <li data-value="3" class="option">3</li>
                                            <li data-value="4" class="option">4</li>
                                            <li data-value="5" class="option">5</li>
                                            <li data-value="6" class="option">6</li>
                                            <li data-value="7" class="option">7</li>
                                            <li data-value="8" class="option">8</li>
                                            <li data-value="9" class="option">9</li>
                                            <li data-value="10" class="option">10</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box-select">
                                    <h5>Rooms</h5>
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">Any Rooms</span>
                                        <ul class="list">
                                            <li data-value="1" class="option">1</li>
                                            <li data-value="2" class="option selected">2</li>
                                            <li data-value="3" class="option">3</li>
                                            <li data-value="4" class="option">4</li>
                                            <li data-value="5" class="option">5</li>
                                            <li data-value="6" class="option">6</li>
                                            <li data-value="7" class="option">7</li>
                                            <li data-value="8" class="option">8</li>
                                            <li data-value="9" class="option">9</li>
                                            <li data-value="10" class="option">10</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="group-price">
                                <div class="slider-item">
                                    <div class="slider-label">Price Range: <span id="price-output">$200 - $2,500,000</span></div>
                                    <div class="slider price-slider">
                                        <input type="range" id="price-range-min" class="range-min" min="200" max="2500000" value="200"
                                            step="100">
                                        <input type="range" id="price-range-max" class="range-max" min="200" max="2500000" value="2500000"
                                            step="100">
                                        <div class="slider-fill"></div>
                                    </div>
                                </div>

                                <div class="slider-item">
                                    <div class="slider-label">Size Range: <span id="size-output">146 SqFt - 448 SqFt</span></div>
                                    <div class="slider size-slider">
                                        <input type="range" id="size-range-min" class="range-min" min="146" max="448" value="146"
                                            step="1">
                                        <input type="range" id="size-range-max" class="range-max" min="146" max="448" value="448"
                                            step="1">
                                        <div class="slider-fill"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="group-checkbox">
                                <div class=" title text-4 fw-6">Others Features</div>
                                <div class="space16"></div>
                                <div class="group-amenities ">
                                    <fieldset class="checkbox-item style-1  ">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Air Conditioning</span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4"> Laundry</span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Refrigerator </span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Washer </span>
                                        </label>
                                    </fieldset>

                                    <fieldset class="checkbox-item style-1  ">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4"> Barbeque</span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4"> Lawn</span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Sauna </span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Wifi </span>
                                        </label>
                                    </fieldset>

                                    <fieldset class="checkbox-item style-1  ">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Dryer </span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Microwave</span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4"> Swimming Pool</span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Window Coverings</span>
                                        </label>
                                    </fieldset>

                                    <fieldset class="checkbox-item style-1  ">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4"> Gym</span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Outdoor Shower </span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4"> TV Cable</span>
                                        </label>
                                    </fieldset>
                                    <fieldset class="checkbox-item style-1   mt-12">
                                        <label>
                                            <input type="checkbox">
                                            <span class="btn-checkbox"></span>
                                            <span class="text-4">Fireplace </span>
                                        </label>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space60"></div>
    <!--===== OTHERS AREA STARTS =======-->
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== PROPERTIES AREA STARTS =======-->
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
            </div>
        </div>
    </div>

</div>
<!--===== PROPERTIES AREA ENDS =======-->


@endsection