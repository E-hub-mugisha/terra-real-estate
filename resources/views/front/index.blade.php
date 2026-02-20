@extends('layouts.guest')
@section('title', 'Your Dream Home Awaits - Explore Our Real Estate Listings')
@section('content')

<!--===== HERO AREA STARTS =======-->
<div class="hero-area-slider">
    <div class="hero1-section-area">
        <img src="{{ asset('front/assets/img/all-images/hero/hero-img1.png') }}" alt="housebox" class="hero-img1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-header-area text-center">
                        <h5>Discover Your Ideal Property Today!</h5>
                        <div class="space32"></div>
                        <h1>Find Your Perfect Home</h1>
                        <div class="space40"></div>
                        <div class="btn-area1">
                            <a href="property-details-v1" class="theme-btn1">Find Your Dream Home Now <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></span></a>
                            <a href="property-halfmap-grid" class="theme-btn2">View Listings<span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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

    <div class="hero1-section-area">
        <img src="{{ asset('front/assets/img/all-images/hero/hero-img2.png') }}" alt="housebox" class="hero-img1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-header-area text-center">
                        <h5>Discover Your Ideal Property Today!</h5>
                        <div class="space32"></div>
                        <h1>Find Your Dream Home</h1>
                        <div class="space40"></div>
                        <div class="btn-area1">
                            <a href="property-details-v1" class="theme-btn1">Find Your Dream Home Now <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></span></a>
                            <a href="property-halfmap-grid" class="theme-btn2">View Listings<span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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

    <div class="hero1-section-area">
        <img src="{{ asset('front/assets/img/all-images/hero/hero-img3.png') }}" alt="housebox" class="hero-img1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-header-area text-center">
                        <h5>Discover Your Ideal Property Today!</h5>
                        <div class="space32"></div>
                        <h1>Find Your Luxury Home</h1>
                        <div class="space40"></div>
                        <div class="btn-area1">
                            <a href="property-details-v1" class="theme-btn1">Find Your Dream Home Now <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></span></a>
                            <a href="property-halfmap-grid" class="theme-btn2">View Listings<span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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
<div class="testimonial-arrows">
    <div class="testimonial-prev-arrow">
        <button><i class="fa-solid fa-angle-left"></i></button>
    </div>
    <div class="testimonial-next-arrow">
        <button><i class="fa-solid fa-angle-right"></i></button>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== OTHERS AREA STARTS =======-->
<div class="others-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="theme-btn1 open-search-filter-form">
                    <p class="open-text">Open Search Form
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                        </svg>
                    </p>
                    <p class="close-text">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z"></path>
                        </svg>
                        Close
                    </p>
                </div>
                <div class="property-tab-section search-filter-form">
                    <div class="tab-header">
                        <button class="tab-btn active" data-tab="for-sale">For Sale</button>
                        <button class="tab-btn" data-tab="for-rent">For Rent</button>
                        <button class="tab-btn" data-tab="for-rent">Land</button>
                        <button class="tab-btn" data-tab="for-rent">Design</button>
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
                                    Advance <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6.17071 18C6.58254 16.8348 7.69378 16 9 16C10.3062 16 11.4175 16.8348 11.8293 18H22V20H11.8293C11.4175 21.1652 10.3062 22 9 22C7.69378 22 6.58254 21.1652 6.17071 20H2V18H6.17071ZM12.1707 11C12.5825 9.83481 13.6938 9 15 9C16.3062 9 17.4175 9.83481 17.8293 11H22V13H17.8293C17.4175 14.1652 16.3062 15 15 15C13.6938 15 12.5825 14.1652 12.1707 13H2V11H12.1707ZM6.17071 4C6.58254 2.83481 7.69378 2 9 2C10.3062 2 11.4175 2.83481 11.8293 4H22V6H11.8293C11.4175 7.16519 10.3062 8 9 8C7.69378 8 6.58254 7.16519 6.17071 6H2V4H6.17071Z"></path>
                                        </svg></span>
                                </button>
                            </div>
                            <div class="search-button">
                                <button id="search-sale">Search <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
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
                                    Advance <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6.17071 18C6.58254 16.8348 7.69378 16 9 16C10.3062 16 11.4175 16.8348 11.8293 18H22V20H11.8293C11.4175 21.1652 10.3062 22 9 22C7.69378 22 6.58254 21.1652 6.17071 20H2V18H6.17071ZM12.1707 11C12.5825 9.83481 13.6938 9 15 9C16.3062 9 17.4175 9.83481 17.8293 11H22V13H17.8293C17.4175 14.1652 16.3062 15 15 15C13.6938 15 12.5825 14.1652 12.1707 13H2V11H12.1707ZM6.17071 4C6.58254 2.83481 7.69378 2 9 2C10.3062 2 11.4175 2.83481 11.8293 4H22V6H11.8293C11.4175 7.16519 10.3062 8 9 8C7.69378 8 6.58254 7.16519 6.17071 6H2V4H6.17071Z"></path>
                                        </svg></span>
                                </button>
                            </div>
                            <div class="search-button">
                                <button id="search-sale1">Search <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
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
                                    <input type="range" id="price-range-min" class="range-min" min="200" max="2500000" value="200" step="100">
                                    <input type="range" id="price-range-max" class="range-max" min="200" max="2500000" value="2500000" step="100">
                                    <div class="slider-fill"></div>
                                </div>
                            </div>

                            <div class="slider-item">
                                <div class="slider-label">Size Range: <span id="size-output">146 SqFt - 448 SqFt</span></div>
                                <div class="slider size-slider">
                                    <input type="range" id="size-range-min" class="range-min" min="146" max="448" value="146" step="1">
                                    <input type="range" id="size-range-max" class="range-max" min="146" max="448" value="448" step="1">
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
<!--===== OTHERS AREA STARTS =======-->

<div class="properties-section-area sp2" style="background-image: url(assets/img/all-images/bg/bg1.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="property-heading heading1 text-center space-margin60">
                    <h5>Featured Properties</h5>
                    <div class="space20"></div>
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        <div class="split-line" style="display: block; text-align: center; position: relative;">
                            <div style="position:relative;display:inline-block;">
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">O</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">u</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">r</div>
                            </div>
                            <div style="position:relative;display:inline-block;">
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">F</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">e</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">a</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">t</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">u</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">r</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">e</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">d</div>
                            </div>
                            <div style="position:relative;display:inline-block;">
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">P</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">r</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">o</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">p</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">e</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">r</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">t</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">i</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">e</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">s</div>
                            </div>
                        </div>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="property-feature-slider">
                    <div class="col-lg-12 m-auto">
                        <div class="tabs-btn-area space-margin60 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-sell-tab" data-bs-toggle="pill" data-bs-target="#pills-sell" type="button" role="tab" aria-controls="pills-sell" aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19 21H5C4.44772 21 4 20.5523 4 20V11L1 11L11.3273 1.6115C11.7087 1.26475 12.2913 1.26475 12.6727 1.6115L23 11L20 11V20C20 20.5523 19.5523 21 19 21ZM6 19H18V9.15745L12 3.7029L6 9.15745V19ZM8 15H16V17H8V15Z"></path>
                                        </svg>
                                        For Sale
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Rent-tab" data-bs-toggle="pill" data-bs-target="#pills-Rent" type="button" role="tab" aria-controls="pills-Rent" aria-selected="false" tabindex="-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12.5812 2.68627C12.2335 2.43791 11.7664 2.43791 11.4187 2.68627L1.9187 9.47198L3.08118 11.0994L11.9999 4.7289L20.9187 11.0994L22.0812 9.47198L12.5812 2.68627ZM19.5812 12.6863L12.5812 7.68627C12.2335 7.43791 11.7664 7.43791 11.4187 7.68627L4.4187 12.6863C4.15591 12.874 3.99994 13.177 3.99994 13.5V20C3.99994 20.5523 4.44765 21 4.99994 21H18.9999C19.5522 21 19.9999 20.5523 19.9999 20V13.5C19.9999 13.177 19.844 12.874 19.5812 12.6863ZM5.99994 19V14.0146L11.9999 9.7289L17.9999 14.0146V19H5.99994Z"></path>
                                        </svg>
                                        For Rent
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-land-tab" data-bs-toggle="pill" data-bs-target="#pills-land" type="button" role="tab" aria-controls="pills-land" aria-selected="false" tabindex="-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H19V11H17V9H20C20.5523 9 21 9.44772 21 10V19ZM5 5V19H13V5H5ZM7 11H11V13H7V11ZM7 7H11V9H7V7Z"></path>
                                        </svg>
                                        Lands
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Plans-tab" data-bs-toggle="pill" data-bs-target="#pills-Plans" type="button" role="tab" aria-controls="pills-Plans" aria-selected="false" tabindex="-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12.6727 1.61162 20.7999 9H17.8267L12 3.70302 6 9.15757V19.0001H11V21.0001H5C4.44772 21.0001 4 20.5524 4 20.0001V11.0001L1 11.0001 11.3273 1.61162C11.7087 1.26488 12.2913 1.26488 12.6727 1.61162ZM14 11H23V18H14V11ZM16 13V16H21V13H16ZM24 21H13V19H24V21Z"></path>
                                        </svg>
                                        Houses Plans
                                    </button>
                                </li>

                            </ul>
                        </div>

                        <div class="tab-content aos-init aos-animate" id="pills-tabContent" data-aos="fade-up" data-aos-duration="1000">
                            <div class="tab-pane fade show active" id="pills-sell" role="tabpanel" aria-labelledby="pills-sell-tab" tabindex="0">
                                <div class="row">
                                    @forelse ($forSellHouses as $house)
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
                                                    <li><a href="{{ route('front.buy.home.details', $house->id) }}">Featured</a></li>
                                                    <li><a href="{{ route('front.buy.home.details', $house->id) }}">{{ $house->condition }}</a></li>
                                                </ul>
                                            </div>
                                            <div class="content-area">
                                                <a href="{{ route('front.buy.home.details', $house->id) }}">{{ $house->title }} </a>
                                                <div class="space18"></div>
                                                <p>{{ $house->address }}</p>
                                                <div class="space24"></div>
                                                <ul>
                                                    <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x{{ $house->bedrooms }}</a></li>
                                                    <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x{{ $house->bathrooms }}</a></li>
                                                    <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">{{ $house->area_sqft }} sq.fit</a></li>
                                                </ul>
                                                <div class="btn-area">
                                                    <a href="#" class="nm-btn">{{ number_format($house->price) }} RWF</a>
                                                    <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox" class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    @empty
                                    <p>No houses found.</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Rent" role="tabpanel" aria-labelledby="pills-Rent-tab" tabindex="0">
                                <div class="row">
                                    @forelse ($forRentHouses as $house)
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
                                                    <li><a href="{{ route('front.buy.home.details', $house->id) }}">Featured</a></li>
                                                    <li><a href="{{ route('front.buy.home.details', $house->id) }}">{{ $house->condition }}</a></li>
                                                </ul>
                                            </div>
                                            <div class="content-area">
                                                <a href="{{ route('front.buy.home.details', $house->id) }}">{{ $house->title }} </a>
                                                <div class="space18"></div>
                                                <p>{{ $house->address }}</p>
                                                <div class="space24"></div>
                                                <ul>
                                                    <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">x{{ $house->bedrooms }}</a></li>
                                                    <li><a href="#"><img src="assets/img/icons/bath1.svg" alt="housebox">x{{ $house->bathrooms }}</a></li>
                                                    <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">{{ $house->area_sqft }} sq.fit</a></li>
                                                </ul>
                                                <div class="btn-area">
                                                    <a href="#" class="nm-btn">{{ number_format($house->price) }} RWF</a>
                                                    <a href="javascript:void(0)" class="heart"><img src="assets/img/icons/heart1.svg" alt="housebox" class="heart1"> <img src="assets/img/icons/heart2.svg" alt="housebox" class="heart2"></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    @empty
                                    <p>No houses found.</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-land" role="tabpanel" aria-labelledby="pills-land-tab" tabindex="0">
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
                                    <p>No lands found.</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Plans" role="tabpanel" aria-labelledby="pills-Plans-tab" tabindex="0">
                                <div class="row">
                                    @forelse($designs as $design)
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
                                                    <li><a href="{{ route('front.buy.design.show', $design->slug) }}">Featured</a></li>
                                                    <li><a href="{{ route('front.buy.design.show', $design->slug) }}">{{ $design->category?->name ?? 'N/A' }}</a></li>
                                                </ul>
                                            </div>
                                            <div class="content-area">
                                                <a href="{{ route('front.buy.design.show', $design->slug) }}">{{ $design->title }}</a>
                                                <div class="space18"></div>
                                                <p>{{ $design->sector }},{{ $design->district }},{{ $design->province }}</p>
                                                <div class="space24"></div>
                                                <ul>
                                                    <li><a href="#"><img src="assets/img/icons/bed1.svg" alt="housebox">{{ $design->zoning }}</a></li>
                                                    <li><a href="#"><img src="assets/img/icons/sqare1.svg" alt="housebox">{{ $design->size_sqm }} sq.fit</a></li>
                                                </ul>
                                                <div class="btn-area">
                                                    <a href="{{ route('front.buy.design.show', $design->slug) }}" class="mr-[15px] text-[#B1AEAE] hover:text-secondary">
                                                        View Details
                                                    </a>
                                                    @if($design->is_free)
                                                    <a href="{{ asset($design->design_file) }}" download class="text-[#B1AEAE] hover:text-secondary">
                                                        Download Free
                                                    </a>
                                                    @else
                                                    <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="text-[#B1AEAE] hover:text-secondary">Buy Now</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    @empty
                                    <div class="col-12 text-center py-5">
                                        <h4>No designs found.</h4>
                                    </div>
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


<!-- About Us Sectin Start -->
<section class="about-section pt-10">
    <div class="container">
        <div class="grid grid-cols-12 gap-6 items-center">
            <div class="col-span-12 lg:col-span-6">
                <span class="text-secondary text-tiny inline-block mb-2">Why Choose us</span>
                <h2
                    class="font-lora text-primary text-[24px] sm:text-[30px] leading-[1.277] xl:text-xl capitalize mb-5 lg:mb-16 font-medium max-w-[500px]">
                    We Provide Latest Properties for our valuable Clients<span class="text-secondary">.</span></h2>
                <div class="scene" data-relative-input="true">
                    <img data-depth="0.1" src="{{ asset('front/assets/images/about/about1.png') }}" class=""
                        loading="lazy" width="729" height="663" alt="about Image">
                </div>
            </div>
            <div class="col-span-12 lg:col-span-6 lg:pl-[70px]">
                <p class="max-w-[448px] ">Huge number of propreties availabe here for buy, sell and
                    Rent. Also you find here co-living property so lots opportunity
                    you have to choose here and enjoy huge discount. </p>

                <div class="-mb-10 mt-12 xl:mt-[70px] 2xl:mt-[100px]">
                    <div class="flex flex-wrap mb-5 lg:mb-10">
                        <img src="{{ asset('front/assets/images/icon/doller.png') }}" class="self-start mr-5"
                            loading="lazy" width="50" height="50" alt="about Image">
                        <div class="flex-1">
                            <h3 class="font-lora text-primary text-[22px] xl:text-lg capitalize mb-2">Budget
                                Friendly</h3>
                            <p class="max-w-[315px]">Properties are most budget friendly so you
                                have opportunity to find the best one</p>
                        </div>

                    </div>
                    <div class="flex flex-wrap mb-5 lg:mb-10">
                        <img src="{{ asset('front/assets/images/icon/location.png') }}" class="self-start mr-5"
                            loading="lazy" width="50" height="50" alt="about Image">
                        <div class="flex-1">
                            <h3 class="font-lora text-primary text-[22px] xl:text-lg capitalize mb-2">Prime
                                Location</h3>
                            <p class="max-w-[315px]">Properties are most budget friendly so you
                                have opportunity to find the best one</p>
                        </div>

                    </div>
                    <div class="flex flex-wrap mb-5 lg:mb-10">
                        <img src="{{ asset('front/assets/images/icon/trusted.png') }}" class="self-start mr-5"
                            loading="lazy" width="50" height="50" alt="about Image">
                        <div class="flex-1">
                            <h3 class="font-lora text-primary text-[22px] xl:text-lg capitalize mb-2">
                                Trusted by
                                Thousand</h3>
                            <p class="max-w-[315px]">Properties are most budget friendly so you
                                have opportunity to find the best one</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- About Us Sectin End -->

<!-- Featured Properties Start -->
<section class="featured-properties py-[80px] lg:py-[125px]">
    <div class="container">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <span class="text-secondary text-tiny inline-block mb-2">Newly Added</span>
            </div>
            <div class="col-span-12 flex flex-wrap flex-col md:flex-row items-start justify-between mb-[50px]">
                <div class="mb-5 lg:mb-0">

                    <h2 class="font-lora text-primary text-[24px] sm:text-[30px] xl:text-xl capitalize font-medium">
                        Featured
                        Properties<span class="text-secondary">.</span></h2>
                </div>
                <ul class="all-properties flex flex-wrap lg:pt-[10px]">
                    <li data-tab="all-properties" class="mr-[30px] md:mr-[45px] mb-4 lg:mb-0 leading-none active">
                        <button
                            class="leading-none capitalize text-primary hover:text-secondary transition-all text-[16px] ease-out">All
                            Properties</button>
                    </li>

                    <li data-tab="ForSale" class="mr-[30px] md:mr-[45px] mb-4 lg:mb-0 leading-none"><button
                            class="leading-none capitalize text-primary hover:text-secondary transition-all text-[16px] ease-out">For
                            Sale</button></li>
                    <li data-tab="ForRent" class="mr-[30px] md:mr-[45px] mb-4 lg:mb-0 leading-none"><button
                            class="leading-none capitalize text-primary hover:text-secondary transition-all text-[16px] ease-out">For
                            Rent</button></li>
                    <li data-tab="co-living2" class="md:mr-[0px] mb-4 lg:mb-0 leading-none"><button
                            class="leading-none capitalize text-primary hover:text-secondary transition-all text-[16px] ease-out">Land</button>
                    </li>
                </ul>
            </div>
            <div class="col-span-12">
                <div class="all-properties properties-tab-content active">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-[30px]">

                        @forelse ($houses as $house)
                        <div class="swiper-slide">
                            <div
                                class="overflow-hidden rounded-md drop-shadow-[0px_0px_5px_rgba(0,0,0,0.1)] bg-[#FFFDFC] text-center transition-all duration-300 hover:-translate-y-[10px]">
                                <div class="relative">
                                    <a href="{{ route('front.buy.home.details', $house->id) }}" class="block">
                                        <img src="{{ asset('front/assets/images/properties/properties1.png') }}"
                                            class="w-full h-full" loading="lazy" width="370" height="266"
                                            alt="Orchid Casel de Paradise.">
                                    </a>
                                    <div class="flex flex-wrap flex-col absolute top-5 right-5">
                                        <button
                                            class="flex flex-wrap items-center bg-[rgb(11,44,61,0.8)] p-[5px] rounded-[2px] text-white mb-[5px] text-xs"><img
                                                class="mr-1" src="{{ asset('front/assets/images/icon/camera.png') }}"
                                                loading="lazy" width="13" height="10" alt="camera icon">07</button>
                                        <button
                                            class="flex flex-wrap items-center bg-[rgb(11,44,61,0.8)] p-[5px] rounded-[2px] text-white text-xs"><img
                                                class="mr-1" src="{{ asset('front/assets/images/icon/video.png') }}"
                                                loading="lazy" width="14" height="10" alt="camera icon">08</button>
                                    </div>
                                    <span
                                        class="absolute bottom-5 left-5 bg-[#FFFDFC] p-[5px] rounded-[2px] text-primary leading-none text-[14px] font-normal capitalize">{{
                                        $house->condition }}</span>
                                </div>

                                <div class="py-[20px] px-[20px] text-left">
                                    <h3><a href="{{ route('front.buy.home.details', $house->id) }}"
                                            class="font-lora leading-tight text-[22px] xl:text-[26px] text-primary hover:text-secondary transition-all font-medium">{{
                                            $house->title }}</a></h3>
                                    <h4><a href="{{ route('front.buy.home.details', $house->id) }}"
                                            class="font-light text-[14px] leading-[1.75] underline">{{ $house->address
                                            }}</a></h4>
                                    <span class="font-light text-sm">Added: {{ $house->created_at }}</span>
                                    <ul
                                        class="flex flex-wrap items-center justify-between text-[12px] mt-[10px] mb-[15px] pb-[10px] border-b border-[#E0E0E0]">
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.8125 9.68709V4.31285C12.111 4.23634 12.384 4.0822 12.6037 3.86607C12.8234 3.64994 12.982 3.37951 13.0634 3.08226C13.1448 2.78501 13.1461 2.47151 13.0671 2.1736C12.9882 1.87569 12.8318 1.60398 12.6139 1.38605C12.396 1.16812 12.1243 1.01174 11.8263 0.932792C11.5284 0.85384 11.2149 0.855126 10.9177 0.936521C10.6204 1.01792 10.35 1.17652 10.1339 1.39623C9.91774 1.61593 9.7636 1.88892 9.68709 2.18747H4.31285C4.23634 1.88892 4.0822 1.61593 3.86607 1.39623C3.64994 1.17652 3.37951 1.01792 3.08226 0.936521C2.78501 0.855126 2.47151 0.85384 2.1736 0.932792C1.87569 1.01174 1.60398 1.16812 1.38605 1.38605C1.16812 1.60398 1.01174 1.87569 0.932792 2.1736C0.85384 2.47151 0.855126 2.78501 0.936521 3.08226C1.01792 3.37951 1.17652 3.64994 1.39623 3.86607C1.61593 4.0822 1.88892 4.23634 2.18747 4.31285V9.68709C1.88892 9.7636 1.61593 9.91774 1.39623 10.1339C1.17652 10.35 1.01792 10.6204 0.936521 10.9177C0.855126 11.2149 0.85384 11.5284 0.932792 11.8263C1.01174 12.1243 1.16812 12.396 1.38605 12.6139C1.60398 12.8318 1.87569 12.9882 2.1736 13.0671C2.47151 13.1461 2.78501 13.1448 3.08226 13.0634C3.37951 12.982 3.64994 12.8234 3.86607 12.6037C4.0822 12.384 4.23634 12.111 4.31285 11.8125H9.68709C9.7636 12.111 9.91774 12.384 10.1339 12.6037C10.35 12.8234 10.6204 12.982 10.9177 13.0634C11.2149 13.1448 11.5284 13.1461 11.8263 13.0671C12.1243 12.9882 12.396 12.8318 12.6139 12.6139C12.8318 12.396 12.9882 12.1243 13.0671 11.8263C13.1461 11.5284 13.1448 11.2149 13.0634 10.9177C12.982 10.6204 12.8234 10.35 12.6037 10.1339C12.384 9.91774 12.111 9.7636 11.8125 9.68709ZM11.375 1.74997C11.548 1.74997 11.7172 1.80129 11.8611 1.89744C12.005 1.99358 12.1171 2.13024 12.1834 2.29012C12.2496 2.45001 12.2669 2.62594 12.2332 2.79568C12.1994 2.96541 12.1161 3.12132 11.9937 3.24369C11.8713 3.36606 11.7154 3.4494 11.5457 3.48316C11.3759 3.51692 11.2 3.49959 11.0401 3.43337C10.8802 3.36714 10.7436 3.25499 10.6474 3.11109C10.5513 2.9672 10.5 2.79803 10.5 2.62497C10.5002 2.39298 10.5925 2.17055 10.7565 2.00651C10.9206 1.84246 11.143 1.7502 11.375 1.74997ZM1.74997 2.62497C1.74997 2.45191 1.80129 2.28274 1.89744 2.13885C1.99358 1.99495 2.13024 1.8828 2.29012 1.81658C2.45001 1.75035 2.62594 1.73302 2.79568 1.76678C2.96541 1.80055 3.12132 1.88388 3.24369 2.00625C3.36606 2.12862 3.4494 2.28453 3.48316 2.45427C3.51692 2.624 3.49959 2.79993 3.43337 2.95982C3.36714 3.1197 3.25499 3.25636 3.11109 3.35251C2.9672 3.44865 2.79803 3.49997 2.62497 3.49997C2.39298 3.49974 2.17055 3.40748 2.00651 3.24343C1.84246 3.07939 1.7502 2.85696 1.74997 2.62497ZM2.62497 12.25C2.45191 12.25 2.28274 12.1987 2.13885 12.1025C1.99495 12.0064 1.8828 11.8697 1.81658 11.7098C1.75035 11.5499 1.73302 11.374 1.76678 11.2043C1.80055 11.0345 1.88388 10.8786 2.00625 10.7563C2.12862 10.6339 2.28453 10.5505 2.45427 10.5168C2.624 10.483 2.79993 10.5003 2.95982 10.5666C3.1197 10.6328 3.25636 10.745 3.35251 10.8888C3.44865 11.0327 3.49997 11.2019 3.49997 11.375C3.49974 11.607 3.40748 11.8294 3.24343 11.9934C3.07939 12.1575 2.85696 12.2497 2.62497 12.25ZM9.68709 10.9375H4.31285C4.23448 10.6367 4.07729 10.3622 3.8575 10.1424C3.63771 9.92265 3.36326 9.76546 3.06247 9.68709V4.31285C3.36324 4.23444 3.63766 4.07724 3.85745 3.85745C4.07724 3.63766 4.23444 3.36324 4.31285 3.06247H9.68709C9.76546 3.36326 9.92265 3.63771 10.1424 3.8575C10.3622 4.07729 10.6367 4.23448 10.9375 4.31285V9.68709C10.6367 9.76542 10.3622 9.92259 10.1424 10.1424C9.92259 10.3622 9.76542 10.6367 9.68709 10.9375ZM11.375 12.25C11.2019 12.25 11.0327 12.1987 10.8888 12.1025C10.745 12.0064 10.6328 11.8697 10.5666 11.7098C10.5003 11.5499 10.483 11.374 10.5168 11.2043C10.5505 11.0345 10.6339 10.8786 10.7563 10.7563C10.8786 10.6339 11.0345 10.5505 11.2043 10.5168C11.374 10.483 11.5499 10.5003 11.7098 10.5666C11.8697 10.6328 12.0064 10.745 12.1025 10.8888C12.1987 11.0327 12.25 11.2019 12.25 11.375C12.2496 11.6069 12.1573 11.8293 11.9933 11.9933C11.8293 12.1573 11.6069 12.2496 11.375 12.25Z" />
                                            </svg>

                                            <span>{{ $house->area_sqft }} Sq.fit</span>

                                        </li>
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="10" viewBox="0 0 14 10"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.0002 4.18665V2.33331C13.0002 1.23331 12.1002 0.333313 11.0002 0.333313H8.3335C7.82016 0.333313 7.3535 0.533313 7.00016 0.853313C6.64683 0.533313 6.18016 0.333313 5.66683 0.333313H3.00016C1.90016 0.333313 1.00016 1.23331 1.00016 2.33331V4.18665C0.593496 4.55331 0.333496 5.07998 0.333496 5.66665V9.66665H1.66683V8.33331H12.3335V9.66665H13.6668V5.66665C13.6668 5.07998 13.4068 4.55331 13.0002 4.18665ZM8.3335 1.66665H11.0002C11.3668 1.66665 11.6668 1.96665 11.6668 2.33331V3.66665H7.66683V2.33331C7.66683 1.96665 7.96683 1.66665 8.3335 1.66665ZM2.3335 2.33331C2.3335 1.96665 2.6335 1.66665 3.00016 1.66665H5.66683C6.0335 1.66665 6.3335 1.96665 6.3335 2.33331V3.66665H2.3335V2.33331ZM1.66683 6.99998V5.66665C1.66683 5.29998 1.96683 4.99998 2.3335 4.99998H11.6668C12.0335 4.99998 12.3335 5.29998 12.3335 5.66665V6.99998H1.66683Z" />
                                            </svg>

                                            <span>{{ $house->bedrooms }}</span>

                                        </li>
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.6875 7.65627H2.1875V2.7344C2.18699 2.54904 2.22326 2.36543 2.29419 2.19418C2.36512 2.02294 2.46932 1.86746 2.60075 1.73676L2.61168 1.72582C2.81765 1.52015 3.0821 1.38309 3.36889 1.33336C3.65568 1.28362 3.95083 1.32364 4.21403 1.44795C3.96546 1.86122 3.86215 2.34571 3.9205 2.82443C3.97885 3.30315 4.19552 3.74864 4.53608 4.0901L4.83552 4.38954L4.28436 4.94073L4.90304 5.55941L5.4542 5.00825L8.5082 1.95431L9.05937 1.40314L8.44066 0.78443L7.88946 1.3356L7.59002 1.03616C7.23151 0.678646 6.75892 0.458263 6.2546 0.413412C5.75029 0.368561 5.24622 0.502086 4.83025 0.790719C4.3916 0.513704 3.87178 0.394114 3.35619 0.451596C2.84059 0.509078 2.35987 0.740213 1.993 1.10703L1.98207 1.11797C1.76912 1.32975 1.6003 1.58165 1.48537 1.85911C1.37044 2.13657 1.31168 2.43407 1.3125 2.7344V7.65627H0.4375V8.53127H1.3125V9.37072C1.31248 9.44126 1.32386 9.51133 1.34619 9.57823L2.16016 12.02C2.20359 12.1508 2.28712 12.2645 2.39887 12.345C2.51062 12.4256 2.64491 12.4689 2.78266 12.4688H3.1354L2.81641 13.5625H3.72786L4.04688 12.4688H9.73711L10.0652 13.5625H10.9785L10.6504 12.4688H11.2172C11.355 12.4689 11.4893 12.4256 11.6011 12.3451C11.7129 12.2645 11.7964 12.1508 11.8398 12.02L12.6538 9.57823C12.6761 9.51133 12.6875 9.44126 12.6875 9.37072V8.53127H13.5625V7.65627H12.6875ZM5.15484 1.65486C5.3959 1.41433 5.72254 1.27924 6.06308 1.27924C6.40362 1.27924 6.73026 1.41433 6.97132 1.65486L7.2707 1.95431L5.45429 3.77072L5.15484 3.47134C4.91432 3.23027 4.77924 2.90364 4.77924 2.5631C4.77924 2.22256 4.91432 1.89593 5.15484 1.65486ZM11.8125 9.33518L11.0597 11.5938H2.94033L2.1875 9.33518V8.53127H11.8125V9.33518Z" />
                                            </svg>

                                            <span>{{ $house->bathrooms }}</span>

                                        </li>
                                        <li class="flex flex-wrap items-center">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.25 6.98507H12.236L11.1307 4.49805C11.0275 4.26615 10.8592 4.06913 10.6464 3.93083C10.4335 3.79253 10.1851 3.71887 9.93125 3.71875H4.06875C3.81491 3.71888 3.56655 3.79256 3.3537 3.93086C3.14085 4.06916 2.97263 4.26616 2.86937 4.49805L1.76397 6.98507H1.75C1.51802 6.98533 1.29561 7.0776 1.13157 7.24164C0.967531 7.40568 0.875261 7.62809 0.875 7.86007V10.9226C0.875261 11.1546 0.967531 11.377 1.13157 11.541C1.29561 11.705 1.51802 11.7973 1.75 11.7976V12.9062C1.7502 13.0802 1.81941 13.247 1.94243 13.3701C2.06546 13.4931 2.23226 13.5623 2.40625 13.5625H3.9375C4.11149 13.5623 4.27829 13.4931 4.40131 13.3701C4.52434 13.247 4.59355 13.0802 4.59375 12.9062V11.7976H9.40625V12.9062C9.40645 13.0802 9.47566 13.247 9.59869 13.3701C9.72171 13.4931 9.88851 13.5623 10.0625 13.5625H11.5938C11.7677 13.5623 11.9345 13.4931 12.0576 13.3701C12.1806 13.247 12.2498 13.0802 12.25 12.9062V11.7976C12.482 11.7973 12.7044 11.705 12.8684 11.541C13.0325 11.377 13.1247 11.1546 13.125 10.9226V7.86007C13.1247 7.62809 13.0325 7.40568 12.8684 7.24164C12.7044 7.0776 12.482 6.98533 12.25 6.98507ZM3.66885 4.85352C3.70327 4.7762 3.75936 4.71052 3.83033 4.66442C3.90131 4.61831 3.98412 4.59377 4.06875 4.59375H9.93125C10.0159 4.59379 10.0986 4.61835 10.1696 4.66445C10.2406 4.71055 10.2966 4.77622 10.331 4.85352L11.2784 6.98504H2.7215L3.66885 4.85352ZM3.71875 12.6875H2.625V11.7976H3.71875V12.6875ZM11.375 12.6875H10.2812V11.7976H11.375V12.6875ZM12.25 10.9226H1.75V7.86007H12.25V10.9226Z" />
                                                <path d="M2.625 8.96875H4.8125V9.84375H2.625V8.96875Z" />
                                                <path d="M9.1875 8.96875H11.375V9.84375H9.1875V8.96875Z" />
                                                <path
                                                    d="M7 0.403564L0.4375 3.03849V3.98139L7 1.34649L13.5625 3.98139V3.03849L7 0.403564Z" />
                                            </svg>

                                            <span>{{ $house->garages }}</span>

                                        </li>
                                    </ul>

                                    <ul>
                                        <li class="flex flex-wrap items-center justify-between">
                                            <span
                                                class="font-lora text-base text-primary leading-none font-medium">Price:
                                                ${{ number_format($house->price) }}</span>

                                            <span class="flex flex-wrap items-center">
                                                <button class="mr-[15px] text-[#9D9C9C] hover:text-secondary"
                                                    aria-label="svg">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M13.1667 11.6667C12.8572 11.6667 12.5605 11.7896 12.3417 12.0084C12.1229 12.2272 12 12.5239 12 12.8334C12 13.1428 12.1229 13.4395 12.3417 13.6583C12.5605 13.8771 12.8572 14 13.1667 14C13.4761 14 13.7728 13.8771 13.9916 13.6583C14.2104 13.4395 14.3333 13.1428 14.3333 12.8334C14.3333 12.5239 14.2104 12.2272 13.9916 12.0084C13.7728 11.7896 13.4761 11.6667 13.1667 11.6667ZM11 12.8334C11 12.2587 11.2283 11.7076 11.6346 11.3013C12.0409 10.895 12.592 10.6667 13.1667 10.6667C13.7413 10.6667 14.2924 10.895 14.6987 11.3013C15.1051 11.7076 15.3333 12.2587 15.3333 12.8334C15.3333 13.408 15.1051 13.9591 14.6987 14.3654C14.2924 14.7717 13.7413 15 13.1667 15C12.592 15 12.0409 14.7717 11.6346 14.3654C11.2283 13.9591 11 13.408 11 12.8334Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M9.26984 1.14667C9.36347 1.24042 9.41606 1.3675 9.41606 1.5C9.41606 1.6325 9.36347 1.75958 9.26984 1.85333L8.4565 2.66667H11.1665C11.8295 2.66667 12.4654 2.93006 12.9343 3.3989C13.4031 3.86774 13.6665 4.50363 13.6665 5.16667V11C13.6665 11.1326 13.6138 11.2598 13.5201 11.3536C13.4263 11.4473 13.2991 11.5 13.1665 11.5C13.0339 11.5 12.9067 11.4473 12.813 11.3536C12.7192 11.2598 12.6665 11.1326 12.6665 11V5.16667C12.6665 4.96968 12.6277 4.77463 12.5523 4.59264C12.4769 4.41065 12.3665 4.24529 12.2272 4.10601C12.0879 3.96672 11.9225 3.85623 11.7405 3.78085C11.5585 3.70547 11.3635 3.66667 11.1665 3.66667H8.45717L9.2705 4.48C9.36154 4.57434 9.41188 4.70067 9.41068 4.83177C9.40948 4.96287 9.35683 5.08825 9.26409 5.18091C9.17134 5.27357 9.04591 5.32609 8.91481 5.32717C8.78371 5.32825 8.65743 5.27779 8.56317 5.18667L6.8965 3.52C6.80287 3.42625 6.75028 3.29917 6.75028 3.16667C6.75028 3.03417 6.80287 2.90708 6.8965 2.81333L8.56317 1.14667C8.65692 1.05303 8.784 1.00044 8.9165 1.00044C9.049 1.00044 9.17609 1.05303 9.26984 1.14667ZM2.83317 4.33333C2.98638 4.33333 3.13809 4.30316 3.27963 4.24453C3.42118 4.1859 3.54979 4.09996 3.65813 3.99162C3.76646 3.88329 3.8524 3.75468 3.91103 3.61313C3.96966 3.47158 3.99984 3.31988 3.99984 3.16667C3.99984 3.01346 3.96966 2.86175 3.91103 2.7202C3.8524 2.57866 3.76646 2.45004 3.65813 2.34171C3.54979 2.23337 3.42118 2.14744 3.27963 2.08881C3.13809 2.03018 2.98638 2 2.83317 2C2.52375 2 2.22701 2.12292 2.00821 2.34171C1.78942 2.5605 1.6665 2.85725 1.6665 3.16667C1.6665 3.47609 1.78942 3.77283 2.00821 3.99162C2.22701 4.21042 2.52375 4.33333 2.83317 4.33333ZM4.99984 3.16667C4.99984 3.7413 4.77156 4.2924 4.36524 4.69873C3.95891 5.10506 3.40781 5.33333 2.83317 5.33333C2.25853 5.33333 1.70743 5.10506 1.30111 4.69873C0.894777 4.2924 0.666504 3.7413 0.666504 3.16667C0.666504 2.59203 0.894777 2.04093 1.30111 1.6346C1.70743 1.22827 2.25853 1 2.83317 1C3.40781 1 3.95891 1.22827 4.36524 1.6346C4.77156 2.04093 4.99984 2.59203 4.99984 3.16667Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M6.73016 14.8533C6.63653 14.7596 6.58394 14.6325 6.58394 14.5C6.58394 14.3675 6.63653 14.2404 6.73016 14.1467L7.5435 13.3333H4.8335C4.17046 13.3333 3.53457 13.0699 3.06573 12.6011C2.59689 12.1323 2.3335 11.4964 2.3335 10.8333V5C2.3335 4.86739 2.38617 4.74021 2.47994 4.64645C2.57371 4.55268 2.70089 4.5 2.8335 4.5C2.9661 4.5 3.09328 4.55268 3.18705 4.64645C3.28082 4.74021 3.3335 4.86739 3.3335 5V10.8333C3.3335 11.2312 3.49153 11.6127 3.77284 11.894C4.05414 12.1753 4.43567 12.3333 4.8335 12.3333H7.54283L6.7295 11.52C6.68176 11.4739 6.6437 11.4187 6.61752 11.3576C6.59135 11.2966 6.57759 11.231 6.57704 11.1646C6.5765 11.0982 6.58918 11.0324 6.61435 10.971C6.63952 10.9095 6.67667 10.8537 6.72364 10.8068C6.77061 10.7599 6.82645 10.7228 6.88791 10.6977C6.94937 10.6726 7.01521 10.6599 7.0816 10.6605C7.14799 10.6612 7.2136 10.675 7.27459 10.7012C7.33557 10.7274 7.39073 10.7656 7.43683 10.8133L9.1035 12.48C9.19713 12.5738 9.24972 12.7008 9.24972 12.8333C9.24972 12.9658 9.19713 13.0929 9.1035 13.1867L7.43683 14.8533C7.34308 14.947 7.216 14.9996 7.0835 14.9996C6.951 14.9996 6.82391 14.947 6.73016 14.8533Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </button>
                                                <button class="text-[#9D9C9C] hover:text-secondary" aria-label="svg">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(.clip0_656_640)">
                                                            <path
                                                                d="M7.9999 2.74799L7.2829 2.01099C5.5999 0.280988 2.5139 0.877988 1.39989 3.05299C0.876895 4.07599 0.758895 5.55299 1.71389 7.43799C2.63389 9.25299 4.5479 11.427 7.9999 13.795C11.4519 11.427 13.3649 9.25299 14.2859 7.43799C15.2409 5.55199 15.1239 4.07599 14.5999 3.05299C13.4859 0.877988 10.3999 0.279988 8.7169 2.00999L7.9999 2.74799ZM7.9999 15C-7.33311 4.86799 3.27889 -3.04001 7.82389 1.14299C7.88389 1.19799 7.94289 1.25499 7.9999 1.31399C8.05632 1.25504 8.11503 1.19833 8.17589 1.14399C12.7199 -3.04201 23.3329 4.86699 7.9999 15Z"
                                                                fill="currentColor" />
                                                        </g>
                                                        <defs>
                                                            <clipPath class="clip0_656_640">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </button>
                                            </span>
                                        </li>
                                    </ul>


                                </div>
                            </div>
                        </div>
                        @empty
                        <p>No houses found.</p>
                        @endforelse
                    </div>
                </div>
                <div class="ForSale properties-tab-content">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-[30px]">

                        @forelse ($forSellHouses as $house)
                        <div class="swiper-slide">
                            <div
                                class="overflow-hidden rounded-md drop-shadow-[0px_0px_5px_rgba(0,0,0,0.1)] bg-[#FFFDFC] text-center transition-all duration-300 hover:-translate-y-[10px]">
                                <div class="relative">
                                    <a href="{{ route('front.buy.home.details', $house->id) }}" class="block">
                                        <img src="{{ asset('front/assets/images/properties/properties1.png') }}"
                                            class="w-full h-full" loading="lazy" width="370" height="266"
                                            alt="Orchid Casel de Paradise.">
                                    </a>
                                    <div class="flex flex-wrap flex-col absolute top-5 right-5">
                                        <button
                                            class="flex flex-wrap items-center bg-[rgb(11,44,61,0.8)] p-[5px] rounded-[2px] text-white mb-[5px] text-xs"><img
                                                class="mr-1" src="{{ asset('front/assets/images/icon/camera.png') }}"
                                                loading="lazy" width="13" height="10" alt="camera icon">07</button>
                                        <button
                                            class="flex flex-wrap items-center bg-[rgb(11,44,61,0.8)] p-[5px] rounded-[2px] text-white text-xs"><img
                                                class="mr-1" src="{{ asset('front/assets/images/icon/video.png') }}"
                                                loading="lazy" width="14" height="10" alt="camera icon">08</button>
                                    </div>
                                    <span
                                        class="absolute bottom-5 left-5 bg-[#FFFDFC] p-[5px] rounded-[2px] text-primary leading-none text-[14px] font-normal capitalize">{{
                                        $house->condition }}</span>
                                </div>

                                <div class="py-[20px] px-[20px] text-left">
                                    <h3><a href="{{ route('front.buy.home.details', $house->id) }}"
                                            class="font-lora leading-tight text-[22px] xl:text-[26px] text-primary hover:text-secondary transition-all font-medium">{{
                                            $house->title }}</a></h3>
                                    <h4><a href="{{ route('front.buy.home.details', $house->id) }}"
                                            class="font-light text-[14px] leading-[1.75] underline">{{ $house->address
                                            }}</a></h4>
                                    <span class="font-light text-sm">Added: {{ $house->created_at }}</span>
                                    <ul
                                        class="flex flex-wrap items-center justify-between text-[12px] mt-[10px] mb-[15px] pb-[10px] border-b border-[#E0E0E0]">
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.8125 9.68709V4.31285C12.111 4.23634 12.384 4.0822 12.6037 3.86607C12.8234 3.64994 12.982 3.37951 13.0634 3.08226C13.1448 2.78501 13.1461 2.47151 13.0671 2.1736C12.9882 1.87569 12.8318 1.60398 12.6139 1.38605C12.396 1.16812 12.1243 1.01174 11.8263 0.932792C11.5284 0.85384 11.2149 0.855126 10.9177 0.936521C10.6204 1.01792 10.35 1.17652 10.1339 1.39623C9.91774 1.61593 9.7636 1.88892 9.68709 2.18747H4.31285C4.23634 1.88892 4.0822 1.61593 3.86607 1.39623C3.64994 1.17652 3.37951 1.01792 3.08226 0.936521C2.78501 0.855126 2.47151 0.85384 2.1736 0.932792C1.87569 1.01174 1.60398 1.16812 1.38605 1.38605C1.16812 1.60398 1.01174 1.87569 0.932792 2.1736C0.85384 2.47151 0.855126 2.78501 0.936521 3.08226C1.01792 3.37951 1.17652 3.64994 1.39623 3.86607C1.61593 4.0822 1.88892 4.23634 2.18747 4.31285V9.68709C1.88892 9.7636 1.61593 9.91774 1.39623 10.1339C1.17652 10.35 1.01792 10.6204 0.936521 10.9177C0.855126 11.2149 0.85384 11.5284 0.932792 11.8263C1.01174 12.1243 1.16812 12.396 1.38605 12.6139C1.60398 12.8318 1.87569 12.9882 2.1736 13.0671C2.47151 13.1461 2.78501 13.1448 3.08226 13.0634C3.37951 12.982 3.64994 12.8234 3.86607 12.6037C4.0822 12.384 4.23634 12.111 4.31285 11.8125H9.68709C9.7636 12.111 9.91774 12.384 10.1339 12.6037C10.35 12.8234 10.6204 12.982 10.9177 13.0634C11.2149 13.1448 11.5284 13.1461 11.8263 13.0671C12.1243 12.9882 12.396 12.8318 12.6139 12.6139C12.8318 12.396 12.9882 12.1243 13.0671 11.8263C13.1461 11.5284 13.1448 11.2149 13.0634 10.9177C12.982 10.6204 12.8234 10.35 12.6037 10.1339C12.384 9.91774 12.111 9.7636 11.8125 9.68709ZM11.375 1.74997C11.548 1.74997 11.7172 1.80129 11.8611 1.89744C12.005 1.99358 12.1171 2.13024 12.1834 2.29012C12.2496 2.45001 12.2669 2.62594 12.2332 2.79568C12.1994 2.96541 12.1161 3.12132 11.9937 3.24369C11.8713 3.36606 11.7154 3.4494 11.5457 3.48316C11.3759 3.51692 11.2 3.49959 11.0401 3.43337C10.8802 3.36714 10.7436 3.25499 10.6474 3.11109C10.5513 2.9672 10.5 2.79803 10.5 2.62497C10.5002 2.39298 10.5925 2.17055 10.7565 2.00651C10.9206 1.84246 11.143 1.7502 11.375 1.74997ZM1.74997 2.62497C1.74997 2.45191 1.80129 2.28274 1.89744 2.13885C1.99358 1.99495 2.13024 1.8828 2.29012 1.81658C2.45001 1.75035 2.62594 1.73302 2.79568 1.76678C2.96541 1.80055 3.12132 1.88388 3.24369 2.00625C3.36606 2.12862 3.4494 2.28453 3.48316 2.45427C3.51692 2.624 3.49959 2.79993 3.43337 2.95982C3.36714 3.1197 3.25499 3.25636 3.11109 3.35251C2.9672 3.44865 2.79803 3.49997 2.62497 3.49997C2.39298 3.49974 2.17055 3.40748 2.00651 3.24343C1.84246 3.07939 1.7502 2.85696 1.74997 2.62497ZM2.62497 12.25C2.45191 12.25 2.28274 12.1987 2.13885 12.1025C1.99495 12.0064 1.8828 11.8697 1.81658 11.7098C1.75035 11.5499 1.73302 11.374 1.76678 11.2043C1.80055 11.0345 1.88388 10.8786 2.00625 10.7563C2.12862 10.6339 2.28453 10.5505 2.45427 10.5168C2.624 10.483 2.79993 10.5003 2.95982 10.5666C3.1197 10.6328 3.25636 10.745 3.35251 10.8888C3.44865 11.0327 3.49997 11.2019 3.49997 11.375C3.49974 11.607 3.40748 11.8294 3.24343 11.9934C3.07939 12.1575 2.85696 12.2497 2.62497 12.25ZM9.68709 10.9375H4.31285C4.23448 10.6367 4.07729 10.3622 3.8575 10.1424C3.63771 9.92265 3.36326 9.76546 3.06247 9.68709V4.31285C3.36324 4.23444 3.63766 4.07724 3.85745 3.85745C4.07724 3.63766 4.23444 3.36324 4.31285 3.06247H9.68709C9.76546 3.36326 9.92265 3.63771 10.1424 3.8575C10.3622 4.07729 10.6367 4.23448 10.9375 4.31285V9.68709C10.6367 9.76542 10.3622 9.92259 10.1424 10.1424C9.92259 10.3622 9.76542 10.6367 9.68709 10.9375ZM11.375 12.25C11.2019 12.25 11.0327 12.1987 10.8888 12.1025C10.745 12.0064 10.6328 11.8697 10.5666 11.7098C10.5003 11.5499 10.483 11.374 10.5168 11.2043C10.5505 11.0345 10.6339 10.8786 10.7563 10.7563C10.8786 10.6339 11.0345 10.5505 11.2043 10.5168C11.374 10.483 11.5499 10.5003 11.7098 10.5666C11.8697 10.6328 12.0064 10.745 12.1025 10.8888C12.1987 11.0327 12.25 11.2019 12.25 11.375C12.2496 11.6069 12.1573 11.8293 11.9933 11.9933C11.8293 12.1573 11.6069 12.2496 11.375 12.25Z" />
                                            </svg>

                                            <span>{{ $house->area_sqft }} Sq.fit</span>

                                        </li>
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="10" viewBox="0 0 14 10"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.0002 4.18665V2.33331C13.0002 1.23331 12.1002 0.333313 11.0002 0.333313H8.3335C7.82016 0.333313 7.3535 0.533313 7.00016 0.853313C6.64683 0.533313 6.18016 0.333313 5.66683 0.333313H3.00016C1.90016 0.333313 1.00016 1.23331 1.00016 2.33331V4.18665C0.593496 4.55331 0.333496 5.07998 0.333496 5.66665V9.66665H1.66683V8.33331H12.3335V9.66665H13.6668V5.66665C13.6668 5.07998 13.4068 4.55331 13.0002 4.18665ZM8.3335 1.66665H11.0002C11.3668 1.66665 11.6668 1.96665 11.6668 2.33331V3.66665H7.66683V2.33331C7.66683 1.96665 7.96683 1.66665 8.3335 1.66665ZM2.3335 2.33331C2.3335 1.96665 2.6335 1.66665 3.00016 1.66665H5.66683C6.0335 1.66665 6.3335 1.96665 6.3335 2.33331V3.66665H2.3335V2.33331ZM1.66683 6.99998V5.66665C1.66683 5.29998 1.96683 4.99998 2.3335 4.99998H11.6668C12.0335 4.99998 12.3335 5.29998 12.3335 5.66665V6.99998H1.66683Z" />
                                            </svg>

                                            <span>{{ $house->bedrooms }}</span>

                                        </li>
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.6875 7.65627H2.1875V2.7344C2.18699 2.54904 2.22326 2.36543 2.29419 2.19418C2.36512 2.02294 2.46932 1.86746 2.60075 1.73676L2.61168 1.72582C2.81765 1.52015 3.0821 1.38309 3.36889 1.33336C3.65568 1.28362 3.95083 1.32364 4.21403 1.44795C3.96546 1.86122 3.86215 2.34571 3.9205 2.82443C3.97885 3.30315 4.19552 3.74864 4.53608 4.0901L4.83552 4.38954L4.28436 4.94073L4.90304 5.55941L5.4542 5.00825L8.5082 1.95431L9.05937 1.40314L8.44066 0.78443L7.88946 1.3356L7.59002 1.03616C7.23151 0.678646 6.75892 0.458263 6.2546 0.413412C5.75029 0.368561 5.24622 0.502086 4.83025 0.790719C4.3916 0.513704 3.87178 0.394114 3.35619 0.451596C2.84059 0.509078 2.35987 0.740213 1.993 1.10703L1.98207 1.11797C1.76912 1.32975 1.6003 1.58165 1.48537 1.85911C1.37044 2.13657 1.31168 2.43407 1.3125 2.7344V7.65627H0.4375V8.53127H1.3125V9.37072C1.31248 9.44126 1.32386 9.51133 1.34619 9.57823L2.16016 12.02C2.20359 12.1508 2.28712 12.2645 2.39887 12.345C2.51062 12.4256 2.64491 12.4689 2.78266 12.4688H3.1354L2.81641 13.5625H3.72786L4.04688 12.4688H9.73711L10.0652 13.5625H10.9785L10.6504 12.4688H11.2172C11.355 12.4689 11.4893 12.4256 11.6011 12.3451C11.7129 12.2645 11.7964 12.1508 11.8398 12.02L12.6538 9.57823C12.6761 9.51133 12.6875 9.44126 12.6875 9.37072V8.53127H13.5625V7.65627H12.6875ZM5.15484 1.65486C5.3959 1.41433 5.72254 1.27924 6.06308 1.27924C6.40362 1.27924 6.73026 1.41433 6.97132 1.65486L7.2707 1.95431L5.45429 3.77072L5.15484 3.47134C4.91432 3.23027 4.77924 2.90364 4.77924 2.5631C4.77924 2.22256 4.91432 1.89593 5.15484 1.65486ZM11.8125 9.33518L11.0597 11.5938H2.94033L2.1875 9.33518V8.53127H11.8125V9.33518Z" />
                                            </svg>

                                            <span>{{ $house->bathrooms }}</span>

                                        </li>
                                        <li class="flex flex-wrap items-center">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.25 6.98507H12.236L11.1307 4.49805C11.0275 4.26615 10.8592 4.06913 10.6464 3.93083C10.4335 3.79253 10.1851 3.71887 9.93125 3.71875H4.06875C3.81491 3.71888 3.56655 3.79256 3.3537 3.93086C3.14085 4.06916 2.97263 4.26616 2.86937 4.49805L1.76397 6.98507H1.75C1.51802 6.98533 1.29561 7.0776 1.13157 7.24164C0.967531 7.40568 0.875261 7.62809 0.875 7.86007V10.9226C0.875261 11.1546 0.967531 11.377 1.13157 11.541C1.29561 11.705 1.51802 11.7973 1.75 11.7976V12.9062C1.7502 13.0802 1.81941 13.247 1.94243 13.3701C2.06546 13.4931 2.23226 13.5623 2.40625 13.5625H3.9375C4.11149 13.5623 4.27829 13.4931 4.40131 13.3701C4.52434 13.247 4.59355 13.0802 4.59375 12.9062V11.7976H9.40625V12.9062C9.40645 13.0802 9.47566 13.247 9.59869 13.3701C9.72171 13.4931 9.88851 13.5623 10.0625 13.5625H11.5938C11.7677 13.5623 11.9345 13.4931 12.0576 13.3701C12.1806 13.247 12.2498 13.0802 12.25 12.9062V11.7976C12.482 11.7973 12.7044 11.705 12.8684 11.541C13.0325 11.377 13.1247 11.1546 13.125 10.9226V7.86007C13.1247 7.62809 13.0325 7.40568 12.8684 7.24164C12.7044 7.0776 12.482 6.98533 12.25 6.98507ZM3.66885 4.85352C3.70327 4.7762 3.75936 4.71052 3.83033 4.66442C3.90131 4.61831 3.98412 4.59377 4.06875 4.59375H9.93125C10.0159 4.59379 10.0986 4.61835 10.1696 4.66445C10.2406 4.71055 10.2966 4.77622 10.331 4.85352L11.2784 6.98504H2.7215L3.66885 4.85352ZM3.71875 12.6875H2.625V11.7976H3.71875V12.6875ZM11.375 12.6875H10.2812V11.7976H11.375V12.6875ZM12.25 10.9226H1.75V7.86007H12.25V10.9226Z" />
                                                <path d="M2.625 8.96875H4.8125V9.84375H2.625V8.96875Z" />
                                                <path d="M9.1875 8.96875H11.375V9.84375H9.1875V8.96875Z" />
                                                <path
                                                    d="M7 0.403564L0.4375 3.03849V3.98139L7 1.34649L13.5625 3.98139V3.03849L7 0.403564Z" />
                                            </svg>

                                            <span>{{ $house->garages }}</span>

                                        </li>
                                    </ul>

                                    <ul>
                                        <li class="flex flex-wrap items-center justify-between">
                                            <span
                                                class="font-lora text-base text-primary leading-none font-medium">Price:
                                                ${{ number_format($house->price) }}</span>

                                            <span class="flex flex-wrap items-center">
                                                <button class="mr-[15px] text-[#9D9C9C] hover:text-secondary"
                                                    aria-label="svg">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M13.1667 11.6667C12.8572 11.6667 12.5605 11.7896 12.3417 12.0084C12.1229 12.2272 12 12.5239 12 12.8334C12 13.1428 12.1229 13.4395 12.3417 13.6583C12.5605 13.8771 12.8572 14 13.1667 14C13.4761 14 13.7728 13.8771 13.9916 13.6583C14.2104 13.4395 14.3333 13.1428 14.3333 12.8334C14.3333 12.5239 14.2104 12.2272 13.9916 12.0084C13.7728 11.7896 13.4761 11.6667 13.1667 11.6667ZM11 12.8334C11 12.2587 11.2283 11.7076 11.6346 11.3013C12.0409 10.895 12.592 10.6667 13.1667 10.6667C13.7413 10.6667 14.2924 10.895 14.6987 11.3013C15.1051 11.7076 15.3333 12.2587 15.3333 12.8334C15.3333 13.408 15.1051 13.9591 14.6987 14.3654C14.2924 14.7717 13.7413 15 13.1667 15C12.592 15 12.0409 14.7717 11.6346 14.3654C11.2283 13.9591 11 13.408 11 12.8334Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M9.26984 1.14667C9.36347 1.24042 9.41606 1.3675 9.41606 1.5C9.41606 1.6325 9.36347 1.75958 9.26984 1.85333L8.4565 2.66667H11.1665C11.8295 2.66667 12.4654 2.93006 12.9343 3.3989C13.4031 3.86774 13.6665 4.50363 13.6665 5.16667V11C13.6665 11.1326 13.6138 11.2598 13.5201 11.3536C13.4263 11.4473 13.2991 11.5 13.1665 11.5C13.0339 11.5 12.9067 11.4473 12.813 11.3536C12.7192 11.2598 12.6665 11.1326 12.6665 11V5.16667C12.6665 4.96968 12.6277 4.77463 12.5523 4.59264C12.4769 4.41065 12.3665 4.24529 12.2272 4.10601C12.0879 3.96672 11.9225 3.85623 11.7405 3.78085C11.5585 3.70547 11.3635 3.66667 11.1665 3.66667H8.45717L9.2705 4.48C9.36154 4.57434 9.41188 4.70067 9.41068 4.83177C9.40948 4.96287 9.35683 5.08825 9.26409 5.18091C9.17134 5.27357 9.04591 5.32609 8.91481 5.32717C8.78371 5.32825 8.65743 5.27779 8.56317 5.18667L6.8965 3.52C6.80287 3.42625 6.75028 3.29917 6.75028 3.16667C6.75028 3.03417 6.80287 2.90708 6.8965 2.81333L8.56317 1.14667C8.65692 1.05303 8.784 1.00044 8.9165 1.00044C9.049 1.00044 9.17609 1.05303 9.26984 1.14667ZM2.83317 4.33333C2.98638 4.33333 3.13809 4.30316 3.27963 4.24453C3.42118 4.1859 3.54979 4.09996 3.65813 3.99162C3.76646 3.88329 3.8524 3.75468 3.91103 3.61313C3.96966 3.47158 3.99984 3.31988 3.99984 3.16667C3.99984 3.01346 3.96966 2.86175 3.91103 2.7202C3.8524 2.57866 3.76646 2.45004 3.65813 2.34171C3.54979 2.23337 3.42118 2.14744 3.27963 2.08881C3.13809 2.03018 2.98638 2 2.83317 2C2.52375 2 2.22701 2.12292 2.00821 2.34171C1.78942 2.5605 1.6665 2.85725 1.6665 3.16667C1.6665 3.47609 1.78942 3.77283 2.00821 3.99162C2.22701 4.21042 2.52375 4.33333 2.83317 4.33333ZM4.99984 3.16667C4.99984 3.7413 4.77156 4.2924 4.36524 4.69873C3.95891 5.10506 3.40781 5.33333 2.83317 5.33333C2.25853 5.33333 1.70743 5.10506 1.30111 4.69873C0.894777 4.2924 0.666504 3.7413 0.666504 3.16667C0.666504 2.59203 0.894777 2.04093 1.30111 1.6346C1.70743 1.22827 2.25853 1 2.83317 1C3.40781 1 3.95891 1.22827 4.36524 1.6346C4.77156 2.04093 4.99984 2.59203 4.99984 3.16667Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M6.73016 14.8533C6.63653 14.7596 6.58394 14.6325 6.58394 14.5C6.58394 14.3675 6.63653 14.2404 6.73016 14.1467L7.5435 13.3333H4.8335C4.17046 13.3333 3.53457 13.0699 3.06573 12.6011C2.59689 12.1323 2.3335 11.4964 2.3335 10.8333V5C2.3335 4.86739 2.38617 4.74021 2.47994 4.64645C2.57371 4.55268 2.70089 4.5 2.8335 4.5C2.9661 4.5 3.09328 4.55268 3.18705 4.64645C3.28082 4.74021 3.3335 4.86739 3.3335 5V10.8333C3.3335 11.2312 3.49153 11.6127 3.77284 11.894C4.05414 12.1753 4.43567 12.3333 4.8335 12.3333H7.54283L6.7295 11.52C6.68176 11.4739 6.6437 11.4187 6.61752 11.3576C6.59135 11.2966 6.57759 11.231 6.57704 11.1646C6.5765 11.0982 6.58918 11.0324 6.61435 10.971C6.63952 10.9095 6.67667 10.8537 6.72364 10.8068C6.77061 10.7599 6.82645 10.7228 6.88791 10.6977C6.94937 10.6726 7.01521 10.6599 7.0816 10.6605C7.14799 10.6612 7.2136 10.675 7.27459 10.7012C7.33557 10.7274 7.39073 10.7656 7.43683 10.8133L9.1035 12.48C9.19713 12.5738 9.24972 12.7008 9.24972 12.8333C9.24972 12.9658 9.19713 13.0929 9.1035 13.1867L7.43683 14.8533C7.34308 14.947 7.216 14.9996 7.0835 14.9996C6.951 14.9996 6.82391 14.947 6.73016 14.8533Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </button>
                                                <button class="text-[#9D9C9C] hover:text-secondary" aria-label="svg">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(.clip0_656_640)">
                                                            <path
                                                                d="M7.9999 2.74799L7.2829 2.01099C5.5999 0.280988 2.5139 0.877988 1.39989 3.05299C0.876895 4.07599 0.758895 5.55299 1.71389 7.43799C2.63389 9.25299 4.5479 11.427 7.9999 13.795C11.4519 11.427 13.3649 9.25299 14.2859 7.43799C15.2409 5.55199 15.1239 4.07599 14.5999 3.05299C13.4859 0.877988 10.3999 0.279988 8.7169 2.00999L7.9999 2.74799ZM7.9999 15C-7.33311 4.86799 3.27889 -3.04001 7.82389 1.14299C7.88389 1.19799 7.94289 1.25499 7.9999 1.31399C8.05632 1.25504 8.11503 1.19833 8.17589 1.14399C12.7199 -3.04201 23.3329 4.86699 7.9999 15Z"
                                                                fill="currentColor" />
                                                        </g>
                                                        <defs>
                                                            <clipPath class="clip0_656_640">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </button>
                                            </span>
                                        </li>
                                    </ul>


                                </div>
                            </div>
                        </div>
                        @empty
                        <p>No houses found.</p>
                        @endforelse
                    </div>
                </div>
                <div class="ForRent properties-tab-content">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-[30px]">

                        @forelse ($forRentHouses as $house)
                        <div class="swiper-slide">
                            <div
                                class="overflow-hidden rounded-md drop-shadow-[0px_0px_5px_rgba(0,0,0,0.1)] bg-[#FFFDFC] text-center transition-all duration-300 hover:-translate-y-[10px]">
                                <div class="relative">
                                    <a href="{{ route('front.buy.home.details', $house->id) }}" class="block">
                                        <img src="{{ asset('front/assets/images/properties/properties1.png') }}"
                                            class="w-full h-full" loading="lazy" width="370" height="266"
                                            alt="Orchid Casel de Paradise.">
                                    </a>
                                    <div class="flex flex-wrap flex-col absolute top-5 right-5">
                                        <button
                                            class="flex flex-wrap items-center bg-[rgb(11,44,61,0.8)] p-[5px] rounded-[2px] text-white mb-[5px] text-xs"><img
                                                class="mr-1" src="{{ asset('front/assets/images/icon/camera.png') }}"
                                                loading="lazy" width="13" height="10" alt="camera icon">07</button>
                                        <button
                                            class="flex flex-wrap items-center bg-[rgb(11,44,61,0.8)] p-[5px] rounded-[2px] text-white text-xs"><img
                                                class="mr-1" src="{{ asset('front/assets/images/icon/video.png') }}"
                                                loading="lazy" width="14" height="10" alt="camera icon">08</button>
                                    </div>
                                    <span
                                        class="absolute bottom-5 left-5 bg-[#FFFDFC] p-[5px] rounded-[2px] text-primary leading-none text-[14px] font-normal capitalize">{{
                                        $house->condition }}</span>
                                </div>

                                <div class="py-[20px] px-[20px] text-left">
                                    <h3><a href="{{ route('front.buy.home.details', $house->id) }}"
                                            class="font-lora leading-tight text-[22px] xl:text-[26px] text-primary hover:text-secondary transition-all font-medium">{{
                                            $house->title }}</a></h3>
                                    <h4><a href="{{ route('front.buy.home.details', $house->id) }}"
                                            class="font-light text-[14px] leading-[1.75] underline">{{ $house->address
                                            }}</a></h4>
                                    <span class="font-light text-sm">Added: {{ $house->created_at }}</span>
                                    <ul
                                        class="flex flex-wrap items-center justify-between text-[12px] mt-[10px] mb-[15px] pb-[10px] border-b border-[#E0E0E0]">
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.8125 9.68709V4.31285C12.111 4.23634 12.384 4.0822 12.6037 3.86607C12.8234 3.64994 12.982 3.37951 13.0634 3.08226C13.1448 2.78501 13.1461 2.47151 13.0671 2.1736C12.9882 1.87569 12.8318 1.60398 12.6139 1.38605C12.396 1.16812 12.1243 1.01174 11.8263 0.932792C11.5284 0.85384 11.2149 0.855126 10.9177 0.936521C10.6204 1.01792 10.35 1.17652 10.1339 1.39623C9.91774 1.61593 9.7636 1.88892 9.68709 2.18747H4.31285C4.23634 1.88892 4.0822 1.61593 3.86607 1.39623C3.64994 1.17652 3.37951 1.01792 3.08226 0.936521C2.78501 0.855126 2.47151 0.85384 2.1736 0.932792C1.87569 1.01174 1.60398 1.16812 1.38605 1.38605C1.16812 1.60398 1.01174 1.87569 0.932792 2.1736C0.85384 2.47151 0.855126 2.78501 0.936521 3.08226C1.01792 3.37951 1.17652 3.64994 1.39623 3.86607C1.61593 4.0822 1.88892 4.23634 2.18747 4.31285V9.68709C1.88892 9.7636 1.61593 9.91774 1.39623 10.1339C1.17652 10.35 1.01792 10.6204 0.936521 10.9177C0.855126 11.2149 0.85384 11.5284 0.932792 11.8263C1.01174 12.1243 1.16812 12.396 1.38605 12.6139C1.60398 12.8318 1.87569 12.9882 2.1736 13.0671C2.47151 13.1461 2.78501 13.1448 3.08226 13.0634C3.37951 12.982 3.64994 12.8234 3.86607 12.6037C4.0822 12.384 4.23634 12.111 4.31285 11.8125H9.68709C9.7636 12.111 9.91774 12.384 10.1339 12.6037C10.35 12.8234 10.6204 12.982 10.9177 13.0634C11.2149 13.1448 11.5284 13.1461 11.8263 13.0671C12.1243 12.9882 12.396 12.8318 12.6139 12.6139C12.8318 12.396 12.9882 12.1243 13.0671 11.8263C13.1461 11.5284 13.1448 11.2149 13.0634 10.9177C12.982 10.6204 12.8234 10.35 12.6037 10.1339C12.384 9.91774 12.111 9.7636 11.8125 9.68709ZM11.375 1.74997C11.548 1.74997 11.7172 1.80129 11.8611 1.89744C12.005 1.99358 12.1171 2.13024 12.1834 2.29012C12.2496 2.45001 12.2669 2.62594 12.2332 2.79568C12.1994 2.96541 12.1161 3.12132 11.9937 3.24369C11.8713 3.36606 11.7154 3.4494 11.5457 3.48316C11.3759 3.51692 11.2 3.49959 11.0401 3.43337C10.8802 3.36714 10.7436 3.25499 10.6474 3.11109C10.5513 2.9672 10.5 2.79803 10.5 2.62497C10.5002 2.39298 10.5925 2.17055 10.7565 2.00651C10.9206 1.84246 11.143 1.7502 11.375 1.74997ZM1.74997 2.62497C1.74997 2.45191 1.80129 2.28274 1.89744 2.13885C1.99358 1.99495 2.13024 1.8828 2.29012 1.81658C2.45001 1.75035 2.62594 1.73302 2.79568 1.76678C2.96541 1.80055 3.12132 1.88388 3.24369 2.00625C3.36606 2.12862 3.4494 2.28453 3.48316 2.45427C3.51692 2.624 3.49959 2.79993 3.43337 2.95982C3.36714 3.1197 3.25499 3.25636 3.11109 3.35251C2.9672 3.44865 2.79803 3.49997 2.62497 3.49997C2.39298 3.49974 2.17055 3.40748 2.00651 3.24343C1.84246 3.07939 1.7502 2.85696 1.74997 2.62497ZM2.62497 12.25C2.45191 12.25 2.28274 12.1987 2.13885 12.1025C1.99495 12.0064 1.8828 11.8697 1.81658 11.7098C1.75035 11.5499 1.73302 11.374 1.76678 11.2043C1.80055 11.0345 1.88388 10.8786 2.00625 10.7563C2.12862 10.6339 2.28453 10.5505 2.45427 10.5168C2.624 10.483 2.79993 10.5003 2.95982 10.5666C3.1197 10.6328 3.25636 10.745 3.35251 10.8888C3.44865 11.0327 3.49997 11.2019 3.49997 11.375C3.49974 11.607 3.40748 11.8294 3.24343 11.9934C3.07939 12.1575 2.85696 12.2497 2.62497 12.25ZM9.68709 10.9375H4.31285C4.23448 10.6367 4.07729 10.3622 3.8575 10.1424C3.63771 9.92265 3.36326 9.76546 3.06247 9.68709V4.31285C3.36324 4.23444 3.63766 4.07724 3.85745 3.85745C4.07724 3.63766 4.23444 3.36324 4.31285 3.06247H9.68709C9.76546 3.36326 9.92265 3.63771 10.1424 3.8575C10.3622 4.07729 10.6367 4.23448 10.9375 4.31285V9.68709C10.6367 9.76542 10.3622 9.92259 10.1424 10.1424C9.92259 10.3622 9.76542 10.6367 9.68709 10.9375ZM11.375 12.25C11.2019 12.25 11.0327 12.1987 10.8888 12.1025C10.745 12.0064 10.6328 11.8697 10.5666 11.7098C10.5003 11.5499 10.483 11.374 10.5168 11.2043C10.5505 11.0345 10.6339 10.8786 10.7563 10.7563C10.8786 10.6339 11.0345 10.5505 11.2043 10.5168C11.374 10.483 11.5499 10.5003 11.7098 10.5666C11.8697 10.6328 12.0064 10.745 12.1025 10.8888C12.1987 11.0327 12.25 11.2019 12.25 11.375C12.2496 11.6069 12.1573 11.8293 11.9933 11.9933C11.8293 12.1573 11.6069 12.2496 11.375 12.25Z" />
                                            </svg>

                                            <span>{{ $house->area_sqft }} Sq.fit</span>

                                        </li>
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="10" viewBox="0 0 14 10"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.0002 4.18665V2.33331C13.0002 1.23331 12.1002 0.333313 11.0002 0.333313H8.3335C7.82016 0.333313 7.3535 0.533313 7.00016 0.853313C6.64683 0.533313 6.18016 0.333313 5.66683 0.333313H3.00016C1.90016 0.333313 1.00016 1.23331 1.00016 2.33331V4.18665C0.593496 4.55331 0.333496 5.07998 0.333496 5.66665V9.66665H1.66683V8.33331H12.3335V9.66665H13.6668V5.66665C13.6668 5.07998 13.4068 4.55331 13.0002 4.18665ZM8.3335 1.66665H11.0002C11.3668 1.66665 11.6668 1.96665 11.6668 2.33331V3.66665H7.66683V2.33331C7.66683 1.96665 7.96683 1.66665 8.3335 1.66665ZM2.3335 2.33331C2.3335 1.96665 2.6335 1.66665 3.00016 1.66665H5.66683C6.0335 1.66665 6.3335 1.96665 6.3335 2.33331V3.66665H2.3335V2.33331ZM1.66683 6.99998V5.66665C1.66683 5.29998 1.96683 4.99998 2.3335 4.99998H11.6668C12.0335 4.99998 12.3335 5.29998 12.3335 5.66665V6.99998H1.66683Z" />
                                            </svg>

                                            <span>{{ $house->bedrooms }}</span>

                                        </li>
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.6875 7.65627H2.1875V2.7344C2.18699 2.54904 2.22326 2.36543 2.29419 2.19418C2.36512 2.02294 2.46932 1.86746 2.60075 1.73676L2.61168 1.72582C2.81765 1.52015 3.0821 1.38309 3.36889 1.33336C3.65568 1.28362 3.95083 1.32364 4.21403 1.44795C3.96546 1.86122 3.86215 2.34571 3.9205 2.82443C3.97885 3.30315 4.19552 3.74864 4.53608 4.0901L4.83552 4.38954L4.28436 4.94073L4.90304 5.55941L5.4542 5.00825L8.5082 1.95431L9.05937 1.40314L8.44066 0.78443L7.88946 1.3356L7.59002 1.03616C7.23151 0.678646 6.75892 0.458263 6.2546 0.413412C5.75029 0.368561 5.24622 0.502086 4.83025 0.790719C4.3916 0.513704 3.87178 0.394114 3.35619 0.451596C2.84059 0.509078 2.35987 0.740213 1.993 1.10703L1.98207 1.11797C1.76912 1.32975 1.6003 1.58165 1.48537 1.85911C1.37044 2.13657 1.31168 2.43407 1.3125 2.7344V7.65627H0.4375V8.53127H1.3125V9.37072C1.31248 9.44126 1.32386 9.51133 1.34619 9.57823L2.16016 12.02C2.20359 12.1508 2.28712 12.2645 2.39887 12.345C2.51062 12.4256 2.64491 12.4689 2.78266 12.4688H3.1354L2.81641 13.5625H3.72786L4.04688 12.4688H9.73711L10.0652 13.5625H10.9785L10.6504 12.4688H11.2172C11.355 12.4689 11.4893 12.4256 11.6011 12.3451C11.7129 12.2645 11.7964 12.1508 11.8398 12.02L12.6538 9.57823C12.6761 9.51133 12.6875 9.44126 12.6875 9.37072V8.53127H13.5625V7.65627H12.6875ZM5.15484 1.65486C5.3959 1.41433 5.72254 1.27924 6.06308 1.27924C6.40362 1.27924 6.73026 1.41433 6.97132 1.65486L7.2707 1.95431L5.45429 3.77072L5.15484 3.47134C4.91432 3.23027 4.77924 2.90364 4.77924 2.5631C4.77924 2.22256 4.91432 1.89593 5.15484 1.65486ZM11.8125 9.33518L11.0597 11.5938H2.94033L2.1875 9.33518V8.53127H11.8125V9.33518Z" />
                                            </svg>

                                            <span>{{ $house->bathrooms }}</span>

                                        </li>
                                        <li class="flex flex-wrap items-center">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.25 6.98507H12.236L11.1307 4.49805C11.0275 4.26615 10.8592 4.06913 10.6464 3.93083C10.4335 3.79253 10.1851 3.71887 9.93125 3.71875H4.06875C3.81491 3.71888 3.56655 3.79256 3.3537 3.93086C3.14085 4.06916 2.97263 4.26616 2.86937 4.49805L1.76397 6.98507H1.75C1.51802 6.98533 1.29561 7.0776 1.13157 7.24164C0.967531 7.40568 0.875261 7.62809 0.875 7.86007V10.9226C0.875261 11.1546 0.967531 11.377 1.13157 11.541C1.29561 11.705 1.51802 11.7973 1.75 11.7976V12.9062C1.7502 13.0802 1.81941 13.247 1.94243 13.3701C2.06546 13.4931 2.23226 13.5623 2.40625 13.5625H3.9375C4.11149 13.5623 4.27829 13.4931 4.40131 13.3701C4.52434 13.247 4.59355 13.0802 4.59375 12.9062V11.7976H9.40625V12.9062C9.40645 13.0802 9.47566 13.247 9.59869 13.3701C9.72171 13.4931 9.88851 13.5623 10.0625 13.5625H11.5938C11.7677 13.5623 11.9345 13.4931 12.0576 13.3701C12.1806 13.247 12.2498 13.0802 12.25 12.9062V11.7976C12.482 11.7973 12.7044 11.705 12.8684 11.541C13.0325 11.377 13.1247 11.1546 13.125 10.9226V7.86007C13.1247 7.62809 13.0325 7.40568 12.8684 7.24164C12.7044 7.0776 12.482 6.98533 12.25 6.98507ZM3.66885 4.85352C3.70327 4.7762 3.75936 4.71052 3.83033 4.66442C3.90131 4.61831 3.98412 4.59377 4.06875 4.59375H9.93125C10.0159 4.59379 10.0986 4.61835 10.1696 4.66445C10.2406 4.71055 10.2966 4.77622 10.331 4.85352L11.2784 6.98504H2.7215L3.66885 4.85352ZM3.71875 12.6875H2.625V11.7976H3.71875V12.6875ZM11.375 12.6875H10.2812V11.7976H11.375V12.6875ZM12.25 10.9226H1.75V7.86007H12.25V10.9226Z" />
                                                <path d="M2.625 8.96875H4.8125V9.84375H2.625V8.96875Z" />
                                                <path d="M9.1875 8.96875H11.375V9.84375H9.1875V8.96875Z" />
                                                <path
                                                    d="M7 0.403564L0.4375 3.03849V3.98139L7 1.34649L13.5625 3.98139V3.03849L7 0.403564Z" />
                                            </svg>

                                            <span>{{ $house->garages }}</span>

                                        </li>
                                    </ul>

                                    <ul>
                                        <li class="flex flex-wrap items-center justify-between">
                                            <span
                                                class="font-lora text-base text-primary leading-none font-medium">Price:
                                                ${{ number_format($house->price) }}</span>

                                            <span class="flex flex-wrap items-center">
                                                <button class="mr-[15px] text-[#9D9C9C] hover:text-secondary"
                                                    aria-label="svg">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M13.1667 11.6667C12.8572 11.6667 12.5605 11.7896 12.3417 12.0084C12.1229 12.2272 12 12.5239 12 12.8334C12 13.1428 12.1229 13.4395 12.3417 13.6583C12.5605 13.8771 12.8572 14 13.1667 14C13.4761 14 13.7728 13.8771 13.9916 13.6583C14.2104 13.4395 14.3333 13.1428 14.3333 12.8334C14.3333 12.5239 14.2104 12.2272 13.9916 12.0084C13.7728 11.7896 13.4761 11.6667 13.1667 11.6667ZM11 12.8334C11 12.2587 11.2283 11.7076 11.6346 11.3013C12.0409 10.895 12.592 10.6667 13.1667 10.6667C13.7413 10.6667 14.2924 10.895 14.6987 11.3013C15.1051 11.7076 15.3333 12.2587 15.3333 12.8334C15.3333 13.408 15.1051 13.9591 14.6987 14.3654C14.2924 14.7717 13.7413 15 13.1667 15C12.592 15 12.0409 14.7717 11.6346 14.3654C11.2283 13.9591 11 13.408 11 12.8334Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M9.26984 1.14667C9.36347 1.24042 9.41606 1.3675 9.41606 1.5C9.41606 1.6325 9.36347 1.75958 9.26984 1.85333L8.4565 2.66667H11.1665C11.8295 2.66667 12.4654 2.93006 12.9343 3.3989C13.4031 3.86774 13.6665 4.50363 13.6665 5.16667V11C13.6665 11.1326 13.6138 11.2598 13.5201 11.3536C13.4263 11.4473 13.2991 11.5 13.1665 11.5C13.0339 11.5 12.9067 11.4473 12.813 11.3536C12.7192 11.2598 12.6665 11.1326 12.6665 11V5.16667C12.6665 4.96968 12.6277 4.77463 12.5523 4.59264C12.4769 4.41065 12.3665 4.24529 12.2272 4.10601C12.0879 3.96672 11.9225 3.85623 11.7405 3.78085C11.5585 3.70547 11.3635 3.66667 11.1665 3.66667H8.45717L9.2705 4.48C9.36154 4.57434 9.41188 4.70067 9.41068 4.83177C9.40948 4.96287 9.35683 5.08825 9.26409 5.18091C9.17134 5.27357 9.04591 5.32609 8.91481 5.32717C8.78371 5.32825 8.65743 5.27779 8.56317 5.18667L6.8965 3.52C6.80287 3.42625 6.75028 3.29917 6.75028 3.16667C6.75028 3.03417 6.80287 2.90708 6.8965 2.81333L8.56317 1.14667C8.65692 1.05303 8.784 1.00044 8.9165 1.00044C9.049 1.00044 9.17609 1.05303 9.26984 1.14667ZM2.83317 4.33333C2.98638 4.33333 3.13809 4.30316 3.27963 4.24453C3.42118 4.1859 3.54979 4.09996 3.65813 3.99162C3.76646 3.88329 3.8524 3.75468 3.91103 3.61313C3.96966 3.47158 3.99984 3.31988 3.99984 3.16667C3.99984 3.01346 3.96966 2.86175 3.91103 2.7202C3.8524 2.57866 3.76646 2.45004 3.65813 2.34171C3.54979 2.23337 3.42118 2.14744 3.27963 2.08881C3.13809 2.03018 2.98638 2 2.83317 2C2.52375 2 2.22701 2.12292 2.00821 2.34171C1.78942 2.5605 1.6665 2.85725 1.6665 3.16667C1.6665 3.47609 1.78942 3.77283 2.00821 3.99162C2.22701 4.21042 2.52375 4.33333 2.83317 4.33333ZM4.99984 3.16667C4.99984 3.7413 4.77156 4.2924 4.36524 4.69873C3.95891 5.10506 3.40781 5.33333 2.83317 5.33333C2.25853 5.33333 1.70743 5.10506 1.30111 4.69873C0.894777 4.2924 0.666504 3.7413 0.666504 3.16667C0.666504 2.59203 0.894777 2.04093 1.30111 1.6346C1.70743 1.22827 2.25853 1 2.83317 1C3.40781 1 3.95891 1.22827 4.36524 1.6346C4.77156 2.04093 4.99984 2.59203 4.99984 3.16667Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M6.73016 14.8533C6.63653 14.7596 6.58394 14.6325 6.58394 14.5C6.58394 14.3675 6.63653 14.2404 6.73016 14.1467L7.5435 13.3333H4.8335C4.17046 13.3333 3.53457 13.0699 3.06573 12.6011C2.59689 12.1323 2.3335 11.4964 2.3335 10.8333V5C2.3335 4.86739 2.38617 4.74021 2.47994 4.64645C2.57371 4.55268 2.70089 4.5 2.8335 4.5C2.9661 4.5 3.09328 4.55268 3.18705 4.64645C3.28082 4.74021 3.3335 4.86739 3.3335 5V10.8333C3.3335 11.2312 3.49153 11.6127 3.77284 11.894C4.05414 12.1753 4.43567 12.3333 4.8335 12.3333H7.54283L6.7295 11.52C6.68176 11.4739 6.6437 11.4187 6.61752 11.3576C6.59135 11.2966 6.57759 11.231 6.57704 11.1646C6.5765 11.0982 6.58918 11.0324 6.61435 10.971C6.63952 10.9095 6.67667 10.8537 6.72364 10.8068C6.77061 10.7599 6.82645 10.7228 6.88791 10.6977C6.94937 10.6726 7.01521 10.6599 7.0816 10.6605C7.14799 10.6612 7.2136 10.675 7.27459 10.7012C7.33557 10.7274 7.39073 10.7656 7.43683 10.8133L9.1035 12.48C9.19713 12.5738 9.24972 12.7008 9.24972 12.8333C9.24972 12.9658 9.19713 13.0929 9.1035 13.1867L7.43683 14.8533C7.34308 14.947 7.216 14.9996 7.0835 14.9996C6.951 14.9996 6.82391 14.947 6.73016 14.8533Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </button>
                                                <button class="text-[#9D9C9C] hover:text-secondary" aria-label="svg">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(.clip0_656_640)">
                                                            <path
                                                                d="M7.9999 2.74799L7.2829 2.01099C5.5999 0.280988 2.5139 0.877988 1.39989 3.05299C0.876895 4.07599 0.758895 5.55299 1.71389 7.43799C2.63389 9.25299 4.5479 11.427 7.9999 13.795C11.4519 11.427 13.3649 9.25299 14.2859 7.43799C15.2409 5.55199 15.1239 4.07599 14.5999 3.05299C13.4859 0.877988 10.3999 0.279988 8.7169 2.00999L7.9999 2.74799ZM7.9999 15C-7.33311 4.86799 3.27889 -3.04001 7.82389 1.14299C7.88389 1.19799 7.94289 1.25499 7.9999 1.31399C8.05632 1.25504 8.11503 1.19833 8.17589 1.14399C12.7199 -3.04201 23.3329 4.86699 7.9999 15Z"
                                                                fill="currentColor" />
                                                        </g>
                                                        <defs>
                                                            <clipPath class="clip0_656_640">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </button>
                                            </span>
                                        </li>
                                    </ul>


                                </div>
                            </div>
                        </div>
                        @empty
                        <p>No houses found.</p>
                        @endforelse
                    </div>
                </div>
                <div class="co-living2 properties-tab-content">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-[30px]">

                        @forelse ($lands as $land)
                        <div class="swiper-slide">
                            <div
                                class="overflow-hidden rounded-md drop-shadow-[0px_0px_5px_rgba(0,0,0,0.1)] bg-[#FFFDFC] text-center transition-all duration-300 hover:-translate-y-[10px]">
                                <div class="relative">
                                    <a href="{{ route('front.buy.land.details', $land->id) }}" class="block">
                                        <img src="{{ asset('front/assets/images/properties/properties1.png') }}"
                                            class="w-full h-full" loading="lazy" width="370" height="266"
                                            alt="Orchid Casel de Paradise.">
                                    </a>
                                    <div class="flex flex-wrap flex-col absolute top-5 right-5">
                                        <button
                                            class="flex flex-wrap items-center bg-[rgb(11,44,61,0.8)] p-[5px] rounded-[2px] text-white mb-[5px] text-xs"><img
                                                class="mr-1" src="{{ asset('front/assets/images/icon/camera.png') }}"
                                                loading="lazy" width="13" height="10" alt="camera icon">07</button>
                                        <button
                                            class="flex flex-wrap items-center bg-[rgb(11,44,61,0.8)] p-[5px] rounded-[2px] text-white text-xs"><img
                                                class="mr-1" src="{{ asset('front/assets/images/icon/video.png') }}"
                                                loading="lazy" width="14" height="10" alt="camera icon">08</button>
                                    </div>
                                    <span
                                        class="absolute bottom-5 left-5 bg-[#FFFDFC] p-[5px] rounded-[2px] text-primary leading-none text-[14px] font-normal capitalize">{{
                                        $land->land_use }}</span>
                                </div>

                                <div class="py-[20px] px-[20px] text-left">
                                    <h3><a href="{{ route('front.buy.land.details', $land->id) }}"
                                            class="font-lora leading-tight text-[22px] xl:text-[26px] text-primary hover:text-secondary transition-all font-medium">{{
                                            $land->title }}</a></h3>
                                    <h4><a href="{{ route('front.buy.land.details', $land->id) }}"
                                            class="font-light text-[14px] leading-[1.75] underline">{{ $land->sector
                                            }},{{ $land->district }},{{ $land->province }}</a></h4>
                                    <span class="font-light text-sm">Added: {{ $land->created_at }}</span>
                                    <ul
                                        class="flex flex-wrap items-center justify-between text-[12px] mt-[10px] mb-[15px] pb-[10px] border-b border-[#E0E0E0]">
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="14" viewBox="0 0 14 14"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.8125 9.68709V4.31285C12.111 4.23634 12.384 4.0822 12.6037 3.86607C12.8234 3.64994 12.982 3.37951 13.0634 3.08226C13.1448 2.78501 13.1461 2.47151 13.0671 2.1736C12.9882 1.87569 12.8318 1.60398 12.6139 1.38605C12.396 1.16812 12.1243 1.01174 11.8263 0.932792C11.5284 0.85384 11.2149 0.855126 10.9177 0.936521C10.6204 1.01792 10.35 1.17652 10.1339 1.39623C9.91774 1.61593 9.7636 1.88892 9.68709 2.18747H4.31285C4.23634 1.88892 4.0822 1.61593 3.86607 1.39623C3.64994 1.17652 3.37951 1.01792 3.08226 0.936521C2.78501 0.855126 2.47151 0.85384 2.1736 0.932792C1.87569 1.01174 1.60398 1.16812 1.38605 1.38605C1.16812 1.60398 1.01174 1.87569 0.932792 2.1736C0.85384 2.47151 0.855126 2.78501 0.936521 3.08226C1.01792 3.37951 1.17652 3.64994 1.39623 3.86607C1.61593 4.0822 1.88892 4.23634 2.18747 4.31285V9.68709C1.88892 9.7636 1.61593 9.91774 1.39623 10.1339C1.17652 10.35 1.01792 10.6204 0.936521 10.9177C0.855126 11.2149 0.85384 11.5284 0.932792 11.8263C1.01174 12.1243 1.16812 12.396 1.38605 12.6139C1.60398 12.8318 1.87569 12.9882 2.1736 13.0671C2.47151 13.1461 2.78501 13.1448 3.08226 13.0634C3.37951 12.982 3.64994 12.8234 3.86607 12.6037C4.0822 12.384 4.23634 12.111 4.31285 11.8125H9.68709C9.7636 12.111 9.91774 12.384 10.1339 12.6037C10.35 12.8234 10.6204 12.982 10.9177 13.0634C11.2149 13.1448 11.5284 13.1461 11.8263 13.0671C12.1243 12.9882 12.396 12.8318 12.6139 12.6139C12.8318 12.396 12.9882 12.1243 13.0671 11.8263C13.1461 11.5284 13.1448 11.2149 13.0634 10.9177C12.982 10.6204 12.8234 10.35 12.6037 10.1339C12.384 9.91774 12.111 9.7636 11.8125 9.68709ZM11.375 1.74997C11.548 1.74997 11.7172 1.80129 11.8611 1.89744C12.005 1.99358 12.1171 2.13024 12.1834 2.29012C12.2496 2.45001 12.2669 2.62594 12.2332 2.79568C12.1994 2.96541 12.1161 3.12132 11.9937 3.24369C11.8713 3.36606 11.7154 3.4494 11.5457 3.48316C11.3759 3.51692 11.2 3.49959 11.0401 3.43337C10.8802 3.36714 10.7436 3.25499 10.6474 3.11109C10.5513 2.9672 10.5 2.79803 10.5 2.62497C10.5002 2.39298 10.5925 2.17055 10.7565 2.00651C10.9206 1.84246 11.143 1.7502 11.375 1.74997ZM1.74997 2.62497C1.74997 2.45191 1.80129 2.28274 1.89744 2.13885C1.99358 1.99495 2.13024 1.8828 2.29012 1.81658C2.45001 1.75035 2.62594 1.73302 2.79568 1.76678C2.96541 1.80055 3.12132 1.88388 3.24369 2.00625C3.36606 2.12862 3.4494 2.28453 3.48316 2.45427C3.51692 2.624 3.49959 2.79993 3.43337 2.95982C3.36714 3.1197 3.25499 3.25636 3.11109 3.35251C2.9672 3.44865 2.79803 3.49997 2.62497 3.49997C2.39298 3.49974 2.17055 3.40748 2.00651 3.24343C1.84246 3.07939 1.7502 2.85696 1.74997 2.62497ZM2.62497 12.25C2.45191 12.25 2.28274 12.1987 2.13885 12.1025C1.99495 12.0064 1.8828 11.8697 1.81658 11.7098C1.75035 11.5499 1.73302 11.374 1.76678 11.2043C1.80055 11.0345 1.88388 10.8786 2.00625 10.7563C2.12862 10.6339 2.28453 10.5505 2.45427 10.5168C2.624 10.483 2.79993 10.5003 2.95982 10.5666C3.1197 10.6328 3.25636 10.745 3.35251 10.8888C3.44865 11.0327 3.49997 11.2019 3.49997 11.375C3.49974 11.607 3.40748 11.8294 3.24343 11.9934C3.07939 12.1575 2.85696 12.2497 2.62497 12.25ZM9.68709 10.9375H4.31285C4.23448 10.6367 4.07729 10.3622 3.8575 10.1424C3.63771 9.92265 3.36326 9.76546 3.06247 9.68709V4.31285C3.36324 4.23444 3.63766 4.07724 3.85745 3.85745C4.07724 3.63766 4.23444 3.36324 4.31285 3.06247H9.68709C9.76546 3.36326 9.92265 3.63771 10.1424 3.8575C10.3622 4.07729 10.6367 4.23448 10.9375 4.31285V9.68709C10.6367 9.76542 10.3622 9.92259 10.1424 10.1424C9.92259 10.3622 9.76542 10.6367 9.68709 10.9375ZM11.375 12.25C11.2019 12.25 11.0327 12.1987 10.8888 12.1025C10.745 12.0064 10.6328 11.8697 10.5666 11.7098C10.5003 11.5499 10.483 11.374 10.5168 11.2043C10.5505 11.0345 10.6339 10.8786 10.7563 10.7563C10.8786 10.6339 11.0345 10.5505 11.2043 10.5168C11.374 10.483 11.5499 10.5003 11.7098 10.5666C11.8697 10.6328 12.0064 10.745 12.1025 10.8888C12.1987 11.0327 12.25 11.2019 12.25 11.375C12.2496 11.6069 12.1573 11.8293 11.9933 11.9933C11.8293 12.1573 11.6069 12.2496 11.375 12.25Z" />
                                            </svg>

                                            <span>{{ $land->size_sqm }} Sq.fit</span>

                                        </li>
                                        <li
                                            class="flex flex-wrap items-center pr-[25px] sm:pr-[5px] md:pr-[25px] border-r border-[#E0DEDE]">
                                            <svg class="mr-[5px]" width="14" height="10" viewBox="0 0 14 10"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.0002 4.18665V2.33331C13.0002 1.23331 12.1002 0.333313 11.0002 0.333313H8.3335C7.82016 0.333313 7.3535 0.533313 7.00016 0.853313C6.64683 0.533313 6.18016 0.333313 5.66683 0.333313H3.00016C1.90016 0.333313 1.00016 1.23331 1.00016 2.33331V4.18665C0.593496 4.55331 0.333496 5.07998 0.333496 5.66665V9.66665H1.66683V8.33331H12.3335V9.66665H13.6668V5.66665C13.6668 5.07998 13.4068 4.55331 13.0002 4.18665ZM8.3335 1.66665H11.0002C11.3668 1.66665 11.6668 1.96665 11.6668 2.33331V3.66665H7.66683V2.33331C7.66683 1.96665 7.96683 1.66665 8.3335 1.66665ZM2.3335 2.33331C2.3335 1.96665 2.6335 1.66665 3.00016 1.66665H5.66683C6.0335 1.66665 6.3335 1.96665 6.3335 2.33331V3.66665H2.3335V2.33331ZM1.66683 6.99998V5.66665C1.66683 5.29998 1.96683 4.99998 2.3335 4.99998H11.6668C12.0335 4.99998 12.3335 5.29998 12.3335 5.66665V6.99998H1.66683Z" />
                                            </svg>

                                            <span>{{ $land->zoning }}</span>

                                        </li>

                                    </ul>

                                    <ul>
                                        <li class="flex flex-wrap items-center justify-between">
                                            <span
                                                class="font-lora text-base text-primary leading-none font-medium">Price:
                                                {{ number_format($land->price) }} RWF</span>

                                            <span class="flex flex-wrap items-center">
                                                <button class="mr-[15px] text-[#9D9C9C] hover:text-secondary"
                                                    aria-label="svg">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M13.1667 11.6667C12.8572 11.6667 12.5605 11.7896 12.3417 12.0084C12.1229 12.2272 12 12.5239 12 12.8334C12 13.1428 12.1229 13.4395 12.3417 13.6583C12.5605 13.8771 12.8572 14 13.1667 14C13.4761 14 13.7728 13.8771 13.9916 13.6583C14.2104 13.4395 14.3333 13.1428 14.3333 12.8334C14.3333 12.5239 14.2104 12.2272 13.9916 12.0084C13.7728 11.7896 13.4761 11.6667 13.1667 11.6667ZM11 12.8334C11 12.2587 11.2283 11.7076 11.6346 11.3013C12.0409 10.895 12.592 10.6667 13.1667 10.6667C13.7413 10.6667 14.2924 10.895 14.6987 11.3013C15.1051 11.7076 15.3333 12.2587 15.3333 12.8334C15.3333 13.408 15.1051 13.9591 14.6987 14.3654C14.2924 14.7717 13.7413 15 13.1667 15C12.592 15 12.0409 14.7717 11.6346 14.3654C11.2283 13.9591 11 13.408 11 12.8334Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M9.26984 1.14667C9.36347 1.24042 9.41606 1.3675 9.41606 1.5C9.41606 1.6325 9.36347 1.75958 9.26984 1.85333L8.4565 2.66667H11.1665C11.8295 2.66667 12.4654 2.93006 12.9343 3.3989C13.4031 3.86774 13.6665 4.50363 13.6665 5.16667V11C13.6665 11.1326 13.6138 11.2598 13.5201 11.3536C13.4263 11.4473 13.2991 11.5 13.1665 11.5C13.0339 11.5 12.9067 11.4473 12.813 11.3536C12.7192 11.2598 12.6665 11.1326 12.6665 11V5.16667C12.6665 4.96968 12.6277 4.77463 12.5523 4.59264C12.4769 4.41065 12.3665 4.24529 12.2272 4.10601C12.0879 3.96672 11.9225 3.85623 11.7405 3.78085C11.5585 3.70547 11.3635 3.66667 11.1665 3.66667H8.45717L9.2705 4.48C9.36154 4.57434 9.41188 4.70067 9.41068 4.83177C9.40948 4.96287 9.35683 5.08825 9.26409 5.18091C9.17134 5.27357 9.04591 5.32609 8.91481 5.32717C8.78371 5.32825 8.65743 5.27779 8.56317 5.18667L6.8965 3.52C6.80287 3.42625 6.75028 3.29917 6.75028 3.16667C6.75028 3.03417 6.80287 2.90708 6.8965 2.81333L8.56317 1.14667C8.65692 1.05303 8.784 1.00044 8.9165 1.00044C9.049 1.00044 9.17609 1.05303 9.26984 1.14667ZM2.83317 4.33333C2.98638 4.33333 3.13809 4.30316 3.27963 4.24453C3.42118 4.1859 3.54979 4.09996 3.65813 3.99162C3.76646 3.88329 3.8524 3.75468 3.91103 3.61313C3.96966 3.47158 3.99984 3.31988 3.99984 3.16667C3.99984 3.01346 3.96966 2.86175 3.91103 2.7202C3.8524 2.57866 3.76646 2.45004 3.65813 2.34171C3.54979 2.23337 3.42118 2.14744 3.27963 2.08881C3.13809 2.03018 2.98638 2 2.83317 2C2.52375 2 2.22701 2.12292 2.00821 2.34171C1.78942 2.5605 1.6665 2.85725 1.6665 3.16667C1.6665 3.47609 1.78942 3.77283 2.00821 3.99162C2.22701 4.21042 2.52375 4.33333 2.83317 4.33333ZM4.99984 3.16667C4.99984 3.7413 4.77156 4.2924 4.36524 4.69873C3.95891 5.10506 3.40781 5.33333 2.83317 5.33333C2.25853 5.33333 1.70743 5.10506 1.30111 4.69873C0.894777 4.2924 0.666504 3.7413 0.666504 3.16667C0.666504 2.59203 0.894777 2.04093 1.30111 1.6346C1.70743 1.22827 2.25853 1 2.83317 1C3.40781 1 3.95891 1.22827 4.36524 1.6346C4.77156 2.04093 4.99984 2.59203 4.99984 3.16667Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M6.73016 14.8533C6.63653 14.7596 6.58394 14.6325 6.58394 14.5C6.58394 14.3675 6.63653 14.2404 6.73016 14.1467L7.5435 13.3333H4.8335C4.17046 13.3333 3.53457 13.0699 3.06573 12.6011C2.59689 12.1323 2.3335 11.4964 2.3335 10.8333V5C2.3335 4.86739 2.38617 4.74021 2.47994 4.64645C2.57371 4.55268 2.70089 4.5 2.8335 4.5C2.9661 4.5 3.09328 4.55268 3.18705 4.64645C3.28082 4.74021 3.3335 4.86739 3.3335 5V10.8333C3.3335 11.2312 3.49153 11.6127 3.77284 11.894C4.05414 12.1753 4.43567 12.3333 4.8335 12.3333H7.54283L6.7295 11.52C6.68176 11.4739 6.6437 11.4187 6.61752 11.3576C6.59135 11.2966 6.57759 11.231 6.57704 11.1646C6.5765 11.0982 6.58918 11.0324 6.61435 10.971C6.63952 10.9095 6.67667 10.8537 6.72364 10.8068C6.77061 10.7599 6.82645 10.7228 6.88791 10.6977C6.94937 10.6726 7.01521 10.6599 7.0816 10.6605C7.14799 10.6612 7.2136 10.675 7.27459 10.7012C7.33557 10.7274 7.39073 10.7656 7.43683 10.8133L9.1035 12.48C9.19713 12.5738 9.24972 12.7008 9.24972 12.8333C9.24972 12.9658 9.19713 13.0929 9.1035 13.1867L7.43683 14.8533C7.34308 14.947 7.216 14.9996 7.0835 14.9996C6.951 14.9996 6.82391 14.947 6.73016 14.8533Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </button>
                                                <button class="text-[#9D9C9C] hover:text-secondary" aria-label="svg">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(.clip0_656_640)">
                                                            <path
                                                                d="M7.9999 2.74799L7.2829 2.01099C5.5999 0.280988 2.5139 0.877988 1.39989 3.05299C0.876895 4.07599 0.758895 5.55299 1.71389 7.43799C2.63389 9.25299 4.5479 11.427 7.9999 13.795C11.4519 11.427 13.3649 9.25299 14.2859 7.43799C15.2409 5.55199 15.1239 4.07599 14.5999 3.05299C13.4859 0.877988 10.3999 0.279988 8.7169 2.00999L7.9999 2.74799ZM7.9999 15C-7.33311 4.86799 3.27889 -3.04001 7.82389 1.14299C7.88389 1.19799 7.94289 1.25499 7.9999 1.31399C8.05632 1.25504 8.11503 1.19833 8.17589 1.14399C12.7199 -3.04201 23.3329 4.86699 7.9999 15Z"
                                                                fill="currentColor" />
                                                        </g>
                                                        <defs>
                                                            <clipPath class="clip0_656_640">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </button>
                                            </span>
                                        </li>
                                    </ul>


                                </div>
                            </div>
                        </div>
                        @empty
                        <p>No lands found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Featured Properties End -->

<!-- Video Section Start -->
<section class="video-section">
    <div class="container">
        <div
            class="grid grid-cols-12 gap-3 sm:gap-[30px] items-center bg-primary z-[-2] lg:pl-[60px] lg:pr-0 lg:py-0 sm:pl-10 sm:pr-10 pl-5 pr-5 py-5 sm:py-12 rounded-[7px]">
            <div class="col-span-12 lg:col-span-6 relative">
                <div class="mb-5 lg:mb-0 max-w-[450px]">
                    <span class="text-secondary text-tiny inline-block mb-2">Take a video tour</span>
                    <h2
                        class="font-lora text-white text-[24px] sm:text-[30px] leading-[1.277] xl:text-xl mb-[10px] font-medium">
                        Watch the video for taking your decision easily<span class="text-secondary">.</span></h2>
                    <a href="#" class="flex flex-wrap items-center text-secondary text-tiny mt-[20px]">View all
                        <svg class="ml-[10px]" width="26" height="11" viewBox="0 0 26 11" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20.0877 0.69303L24.2075 5.00849H0V5.99151H24.2075L20.0877 10.307L20.7493 11L26 5.5L20.7493 0L20.0877 0.69303Z"
                                fill="currentColor"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-6 text-center">
                <div class="relative rounded-[24px] lg:pt-[45px] lg:pr-[45px] z-[1] lg:inline-block">
                    <div class="">
                        <img src="{{ asset('front/assets/images/video/shape-3.png') }}"
                            class="absolute top-[30px] right-[30px] z-[-1]" loading="lazy" width="50" height="60"
                            alt="shape image">
                        <img src="{{ asset('front/assets/images/video/shape-2.png') }}"
                            class="absolute left-1/2 hidden lg:block lg:bottom-5 lg:-left-[160px]" loading="lazy"
                            width="128" height="56" alt="Shape">
                    </div>
                    <div class="relative lg:-mb-16">
                        <div class="scene" data-relative-input="true">
                            <img data-depth="0.1" src="{{ asset('front/assets/images/video/video.png') }}"
                                class="rounded-[24px] max-w-full" loading="lazy" width="507" height="349"
                                alt="video image">
                        </div>
                        <a href="https://www.youtube.com/watch?v=mSC6GwizOag" class="play-button bg-white text-white hover:text-primary absolute left-0 right-0 mx-auto top-1/2 -translate-y-1/2 hover:scale-105 hover:bg-primary w-[55px] h-[55px] flex 
            flex-wrap z-[1] items-center justify-center opacity-100 shadow-[0px 4px 4px rgba(0, 0, 0, 0.25)] transition-all rounded-full group
            
            before:block before:absolute  before:bg-white before:opacity-80 before:shadow-[0px 4px 4px rgba(0, 0, 0, 0.25)] hover:before:bg-primary hover:before:opacity-80 before:w-[70px] before:h-[70px] before:rounded-full before:z-[-1]
            " aria-label="play button">
                            <svg width="21" height="22" viewBox="0 0 21 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path class="stroke-primary group-hover:stroke-white"
                                    d="M1.63861 10.764V6.70324C1.63861 1.66145 5.20893 -0.403178 9.57772 2.11772L13.1024 4.14812L16.6271 6.17853C20.9959 8.69942 20.9959 12.8287 16.6271 15.3496L13.1024 17.38L9.57772 19.4104C5.20893 21.9313 1.63861 19.8666 1.63861 14.8249V10.764Z"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="flex flex-row items-baseline gap-2 mt-10 leading-[1]">
            <span class="text-secondary text-[16px] sm:text-[20px] font-lora font-normal">Have a question?</span>
            <a class="text-primary text-[22px] sm:text-[28px] font-lora font-medium" href="tel:+01234874854">+01234 874
                854</a>
        </div>
    </div>
</section>
<!-- Video Section End -->

<!-- Explore Cities Start-->
<section class="explore-cities-section pb-[50px] pt-[80px] lg:pt-[125px]">
    <div class="container">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="mb-[30px] lg:mb-[60px] text-center">
                    <span class="text-secondary text-tiny inline-block mb-2">Explore Location</span>
                    <h2 class="font-lora text-primary text-[24px] sm:text-[30px] xl:text-xl capitalize font-medium">Find
                        Your
                        Neighborhood<span class="text-secondary">.</span></h2>
                </div>
                <div class="cities-slider">
                    <div class="swiper  -mx-[30px] -my-[60px] px-[30px] py-[60px]">
                        <div class="swiper-wrapper">
                            @foreach($districts as $district => $data)
                            <div class="swiper-slide text-center">
                                <div class="relative group">
                                    <a href="{{ route('properties.by.district', $district) }}"
                                        class="block group-hover:shadow-[0_10px_15px_rgba(0,0,0,0.1)] transition-all duration-300">

                                        <img src="{{ asset('front/assets/images/cities/image2.png') }}"
                                            class="w-full h-[380px] object-cover rounded-[6px]" alt="{{ $district }}">

                                        <div class="bg-[rgb(255,253,252,0.95)] rounded-[6px] px-4 py-4 absolute
                        group-hover:bottom-[25px] group-hover:opacity-100
                        bottom-[0px] opacity-0 left-[25px] right-[25px]
                        transition-all duration-500">

                                            <span class="font-lora text-[18px] text-primary block">
                                                {{ $district }}
                                            </span>

                                            <p class="text-[14px] text-secondary">
                                                {{ $data['houses'] ?? 0 }} Houses • {{ $data['lands'] ?? 0 }} Lands
                                            </p>

                                            <p class="text-[13px] font-semibold text-primary mt-1">
                                                {{ $data['total'] ?? 0 }} Properties
                                            </p>

                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Explore Cities End-->

<!-- Testimonial carousel Start -->
<section class="testimonial-section pt-[80px] lg:pt-[125px] bg-center bg-no-repeat bg-white z-10">
    <div class="container testimonial-carousel-two relative">
        <div class="scene dots-shape absolute left-0">
            <img data-depth="0.4" class="z-[1]" src="{{ asset('front/assets/images/testimonial/dots.png') }}"
                width="106" height="129" loading="lazy" alt="shape">
        </div>
        <div class="grid items-center grid-cols-12 gap-x-[30px]">
            <div class="col-span-12 relative">
                <div class="swiper rounded-[30px] pb-[40px] md:pb-0">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <!-- shape and images -->

                            <div class="pl-[50px] xl:pl-[150px]">
                                <div class="inline-block relative bg-primary text-primary rounded-[30px] z-10">
                                    <img src="{{ asset('front/assets/images/testimonial/person2.png') }}"
                                        class="w-auto h-auto block mx-auto relative z-[2] thumb" loading="lazy"
                                        width="402" height="505" alt="Oliver Stephen">
                                    <img class="absolute left-[0px] top-0 z-[1]"
                                        src="{{ asset('front/assets/images/testimonial/persone-pattern.png') }}"
                                        width="400" height="500" loading="lazy" alt="shape">
                                </div>
                            </div>


                            <div
                                class="before:absolute before:top-1/2 before:-translate-y-1/2 before:left-0 before:w-full before:h-[395px] before:content-[''] before:bg-[#F5F9F8] before:rounded-[30px]">

                                <div
                                    class="text-left rounded-[14px] max-w-[100%] sm:max-w-[90%] md:max-w-[560px] mx-auto md:ml-auto absolute top-[65%] sm:top-1/2 left-0 md:left-auto right-0 md:right-[50px] xl:right-0 -translate-y-1/2 px-[20px] md:px-[30px] xl:pl-[0px] xl:pr-[60px]  py-[20px] md:py-[30px] z-20 bg-white xl:bg-transparent shadow lg:shadow-none scale-[0.8] sm:scale-100">
                                    <div class="relative">
                                        <span class="block absolute right-[0px] top-[0px]">

                                            <svg class="ml-auto mb-[4px]" width="78" height="57" viewBox="0 0 78 57"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.08">
                                                    <path
                                                        d="M5.50357 56.0343H22.0143L33.0214 34.02V0.998535H0V34.02H16.5107L5.50357 56.0343ZM49.5321 56.0343H66.0429L77.05 34.02V0.998535H44.0286V34.02H60.5393L49.5321 56.0343Z"
                                                        fill="#01614E" />
                                                </g>
                                            </svg>


                                        </span>

                                        <span
                                            class="text-secondary text-tiny capitalize inline-block mb-[5px] xl:mb-[10px]">Testimonial</span>
                                        <h2
                                            class="font-lora text-primary text-[24px] xl:text-xl capitalize mb-[10px] xl:mb-[20px] leading-[1.2] font-medium">
                                            Reviews from our <br class="hidden xl:block" /> happy Clients<span
                                                class="text-secondary">.</span>
                                        </h2>
                                        <p class="max-w-[480px]">
                                            Bary do a great job to find the perfect home. It’s very easy for
                                            every one to buy, sell or rent property we belive they continure
                                            their great service and appriciate them recomended.

                                        </p>
                                    </div>

                                    <ul>
                                        <li class="flex flex-wrap items-center justify-between mt-4">
                                            <span
                                                class="font-lora text-[18px] leading-none capitalize text-secondary">Oliver
                                                Stephen</span>
                                            <span class="flex flex-wrap">
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                            </span>
                                        </li>
                                    </ul>

                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide">
                            <!-- shape and images -->

                            <div class="pl-[50px] xl:pl-[150px]">
                                <div class="inline-block relative bg-primary text-primary rounded-[30px] z-10">
                                    <img src="{{ asset('front/assets/images/testimonial/person4.png') }}"
                                        class="w-auto h-auto block mx-auto relative z-[2] thumb" loading="lazy"
                                        width="402" height="505" alt="Sun Francisco">
                                    <img class="absolute left-[0px] top-0 z-[1]"
                                        src="{{ asset('front/assets/images/testimonial/persone-pattern.png') }}"
                                        width="400" height="500" loading="lazy" alt="shape">
                                </div>
                            </div>


                            <div
                                class="before:absolute before:top-1/2 before:-translate-y-1/2 before:left-0 before:w-full before:h-[395px] before:content-[''] before:bg-[#F5F9F8] before:rounded-[30px]">

                                <div
                                    class="text-left rounded-[14px] max-w-[100%] sm:max-w-[90%] md:max-w-[560px] mx-auto md:ml-auto absolute top-[65%] sm:top-1/2 left-0 md:left-auto right-0 md:right-[50px] xl:right-0 -translate-y-1/2 px-[20px] md:px-[30px] xl:pl-[0px] xl:pr-[60px]  py-[20px] md:py-[30px] z-20 bg-white xl:bg-transparent shadow lg:shadow-none scale-[0.8] sm:scale-100">
                                    <div class="relative">
                                        <span class="block absolute right-[0px] top-[0px]">

                                            <svg class="ml-auto mb-[4px]" width="78" height="57" viewBox="0 0 78 57"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.08">
                                                    <path
                                                        d="M5.50357 56.0343H22.0143L33.0214 34.02V0.998535H0V34.02H16.5107L5.50357 56.0343ZM49.5321 56.0343H66.0429L77.05 34.02V0.998535H44.0286V34.02H60.5393L49.5321 56.0343Z"
                                                        fill="#01614E" />
                                                </g>
                                            </svg>


                                        </span>

                                        <span
                                            class="text-secondary text-tiny capitalize inline-block mb-[5px] xl:mb-[10px]">Testimonial</span>
                                        <h2
                                            class="font-lora text-primary text-[24px] xl:text-xl capitalize mb-[10px] xl:mb-[20px] leading-[1.2] font-medium">
                                            Reviews from our <br class="hidden xl:block" /> happy Clients<span
                                                class="text-secondary">.</span>
                                        </h2>
                                        <p class="max-w-[480px]">
                                            Bary do a great job to find the perfect home. It’s very easy for
                                            every one to buy, sell or rent property we belive they continure
                                            their great service and appriciate them recomended.

                                        </p>
                                    </div>

                                    <ul>
                                        <li class="flex flex-wrap items-center justify-between mt-4">
                                            <span
                                                class="font-lora text-[18px] leading-none capitalize text-secondary">Sun
                                                Francisco</span>
                                            <span class="flex flex-wrap">
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                            </span>
                                        </li>
                                    </ul>

                                </div>

                            </div>
                        </div>
                        <div class="swiper-slide">
                            <!-- shape and images -->

                            <div class="pl-[50px] xl:pl-[150px]">
                                <div class="inline-block relative bg-primary text-primary rounded-[30px] z-10">
                                    <img src="{{ asset('front/assets/images/testimonial/person2.png') }}"
                                        class="w-auto h-auto block mx-auto relative z-[2] thumb" loading="lazy"
                                        width="402" height="505" alt="Oliver Stephen">
                                    <img class="absolute left-[0px] top-0 z-[1]"
                                        src="{{ asset('front/assets/images/testimonial/persone-pattern.png') }}"
                                        width="400" height="500" loading="lazy" alt="shape">
                                </div>
                            </div>


                            <div
                                class="before:absolute before:top-1/2 before:-translate-y-1/2 before:left-0 before:w-full before:h-[395px] before:content-[''] before:bg-[#F5F9F8] before:rounded-[30px]">

                                <div
                                    class="text-left rounded-[14px] max-w-[100%] sm:max-w-[90%] md:max-w-[560px] mx-auto md:ml-auto absolute top-[65%] sm:top-1/2 left-0 md:left-auto right-0 md:right-[50px] xl:right-0 -translate-y-1/2 px-[20px] md:px-[30px] xl:pl-[0px] xl:pr-[60px]  py-[20px] md:py-[30px] z-20 bg-white xl:bg-transparent shadow lg:shadow-none scale-[0.8] sm:scale-100">
                                    <div class="relative">
                                        <span class="block absolute right-[0px] top-[0px]">

                                            <svg class="ml-auto mb-[4px]" width="78" height="57" viewBox="0 0 78 57"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.08">
                                                    <path
                                                        d="M5.50357 56.0343H22.0143L33.0214 34.02V0.998535H0V34.02H16.5107L5.50357 56.0343ZM49.5321 56.0343H66.0429L77.05 34.02V0.998535H44.0286V34.02H60.5393L49.5321 56.0343Z"
                                                        fill="#01614E" />
                                                </g>
                                            </svg>


                                        </span>

                                        <span
                                            class="text-secondary text-tiny capitalize inline-block mb-[5px] xl:mb-[10px]">Testimonial</span>
                                        <h2
                                            class="font-lora text-primary text-[24px] xl:text-xl capitalize mb-[10px] xl:mb-[20px] leading-[1.2] font-medium">
                                            Reviews from our <br class="hidden xl:block" /> happy Clients<span
                                                class="text-secondary">.</span>
                                        </h2>
                                        <p class="max-w-[480px]">
                                            Bary do a great job to find the perfect home. It’s very easy for
                                            every one to buy, sell or rent property we belive they continure
                                            their great service and appriciate them recomended.

                                        </p>
                                    </div>

                                    <ul>
                                        <li class="flex flex-wrap items-center justify-between mt-4">
                                            <span
                                                class="font-lora text-[18px] leading-none capitalize text-secondary">Oliver
                                                Stephen</span>
                                            <span class="flex flex-wrap">
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                                <span class="ml-[4px]">
                                                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.64181 4.13829L6.66642 3.70586L5.33634 1.00938C5.30001 0.935551 5.24024 0.875786 5.16642 0.839457C4.98126 0.748051 4.75626 0.824223 4.66368 1.00938L3.3336 3.70586L0.358214 4.13829C0.276182 4.15 0.201182 4.18868 0.143761 4.24727C0.0743407 4.31862 0.0360871 4.41461 0.0374056 4.51416C0.038724 4.6137 0.0795065 4.70864 0.150792 4.77813L2.30353 6.87696L1.79493 9.84063C1.78301 9.90957 1.79063 9.98048 1.81695 10.0453C1.84327 10.1101 1.88723 10.1663 1.94384 10.2074C2.00045 10.2485 2.06745 10.2729 2.13724 10.2779C2.20702 10.2829 2.27681 10.2682 2.33868 10.2356L5.00001 8.83633L7.66134 10.2356C7.73399 10.2742 7.81837 10.2871 7.89923 10.2731C8.10314 10.2379 8.24024 10.0445 8.20509 9.84063L7.69649 6.87696L9.84923 4.77813C9.90782 4.72071 9.94649 4.64571 9.95821 4.56368C9.98985 4.3586 9.84688 4.16875 9.64181 4.13829Z"
                                                            fill="#B39359" />
                                                    </svg>
                                                </span>
                                            </span>
                                        </li>
                                    </ul>

                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- If we need navigation buttons -->
                    <div class="testimonial-pagination hidden sm:block">
                        <div
                            class="swiper-button-prev w-[36px] h-[36px] rounded-full bg-secondary xl:bg-primary  text-white hover:bg-secondary top-auto bottom-[85px] left-[30px]">
                        </div>
                        <div
                            class="swiper-button-next w-[36px] h-[36px] rounded-full bg-secondary xl:bg-primary  text-white hover:bg-secondary top-auto bottom-[85px] left-[85px]">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Testimonial carousel End -->

<!-- Brand section Start-->
<section class="brand-section pt-[80px] lg:pt-[125px] pb-[80px] lg:pb-[125px]">
    <div class="container">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="mb-[60px] text-center">
                    <span class="text-secondary text-tiny inline-block mb-2">Our Partner’s</span>
                    <h2 class="font-lora text-primary text-[24px] sm:text-[30px] xl:text-xl capitalize font-medium">
                        Reliable Partner’s<span class="text-secondary">.</span></h2>
                </div>
            </div>
            <div class="col-span-12">
                <div class="brand-slider">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <!-- swiper-slide start -->
                            <div class="swiper-slide text-center">
                                <a href="#" class="block">
                                    <img src="{{ asset('front/assets/images/brand/brand1.png') }}"
                                        class="w-auto h-auto block mx-auto" loading="lazy" width="125" height="109"
                                        alt="@@title">
                                </a>
                            </div>
                            <div class="swiper-slide text-center">
                                <a href="#" class="block">
                                    <img src="{{ asset('front/assets/images/brand/brand2.png') }}"
                                        class="w-auto h-auto block mx-auto" loading="lazy" width="125" height="109"
                                        alt="@@title">
                                </a>
                            </div>
                            <div class="swiper-slide text-center">
                                <a href="#" class="block">
                                    <img src="{{ asset('front/assets/images/brand/brand3.png') }}"
                                        class="w-auto h-auto block mx-auto" loading="lazy" width="125" height="109"
                                        alt="@@title">
                                </a>
                            </div>
                            <div class="swiper-slide text-center">
                                <a href="#" class="block">
                                    <img src="{{ asset('front/assets/images/brand/brand4.png') }}"
                                        class="w-auto h-auto block mx-auto" loading="lazy" width="125" height="109"
                                        alt="@@title">
                                </a>
                            </div>
                            <div class="swiper-slide text-center">
                                <a href="#" class="block">
                                    <img src="{{ asset('front/assets/images/brand/brand5.png') }}"
                                        class="w-auto h-auto block mx-auto" loading="lazy" width="125" height="109"
                                        alt="@@title">
                                </a>
                            </div>
                            <div class="swiper-slide text-center">
                                <a href="#" class="block">
                                    <img src="{{ asset('front/assets/images/brand/brand3.png') }}"
                                        class="w-auto h-auto block mx-auto" loading="lazy" width="125" height="109"
                                        alt="@@title">
                                </a>
                            </div>

                            <!-- swiper-slide end-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Brand section End-->

<!-- Team Section Etart-->
<section class="team-section pb-[80px] lg:pb-[125px] overflow-hidden">
    <div class="container">
        <div class="grid sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-x-5 md:gap-x-[30px] mb-[-30px]">
            <div class="xl:pr-[20px] self-center mb-[30px] sm:col-span-3 lg:col-span-1 max-w-[500px]">
                <span class="text-secondary text-tiny capitalize inline-block mb-[15px]">Our Agents</span>
                <h2
                    class="font-lora text-primary text-[24px] sm:text-[30px] leading-[1.277] xl:text-xl capitalize mb-[15px] font-medium">
                    Here is our Experts<span class="text-secondary">.</span></h2>

                <p>Huge number propreties availabe
                    here for buy, sell and Rent, you a
                    find here co-living property lots
                    to choose here and enjoy huge. </p>
                <a href="blog-grid.html" class="flex flex-wrap items-center text-secondary text-tiny mt-[20px]">View all
                    Post
                    <svg class="ml-[10px]" width="26" height="11" viewBox="0 0 26 11" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20.0877 0.69303L24.2075 5.00849H0V5.99151H24.2075L20.0877 10.307L20.7493 11L26 5.5L20.7493 0L20.0877 0.69303Z"
                            fill="currentColor"></path>
                    </svg>
                </a>

            </div>
            <!-- single team start -->
            @forelse ($agents as $agent)
            <div class="text-center group mb-[30px]">
                <div class="relative rounded-[6px_6px_0px_0px]">
                    <a href="{{ route('front.agent.details', $agent) }}">
                        <img src="{{ asset('front/assets/images/team/person1.png') }}"
                            class="w-auto h-auto block mx-auto" loading="lazy" width="215" height="310"
                            alt="{{ $agent->full_name }}">
                    </a>
                    <ul class="flex flex-col absolute w-full top-[30px] left-0 overflow-hidden">
                        <li
                            class="translate-x-[0px] group-hover:translate-x-[30px] opacity-0 group-hover:opacity-100 transition-all duration-300 mb-[15px]">
                            <a href="#" aria-label="svg"
                                class="w-[26px] h-[26px] transition-all rounded-full bg-[#FFF6F0] flex items-center justify-center hover:drop-shadow-[0px_4px_10px_rgba(0,0,0,0.25)] text-[#494949] hover:text-[#3B5998]">
                                <svg width="7" height="12" viewBox="0 0 7 12" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.36 4.20156V3.12156C4.36 2.65356 4.468 2.40156 5.224 2.40156H6.16V0.601562H4.72C2.92 0.601562 2.2 1.78956 2.2 3.12156V4.20156H0.760002V6.00156H2.2V11.4016H4.36V6.00156H5.944L6.16 4.20156H4.36Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                        </li>
                        <li
                            class="translate-x-[0px] group-hover:translate-x-[30px] opacity-0 group-hover:opacity-100 transition-all duration-500 mb-[15px]">
                            <a href="#" aria-label="svg"
                                class="w-[26px] h-[26px] transition-all rounded-full bg-[#FFF6F0] flex items-center justify-center hover:drop-shadow-[0px_4px_10px_rgba(0,0,0,0.25)] text-[#494949] hover:text-[#3B5998]">
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.6667 1.93957C13.1669 2.15783 12.6376 2.30093 12.096 2.36424C12.6645 2.0304 13.092 1.50098 13.2987 0.874908C12.76 1.18846 12.1725 1.40931 11.5607 1.52824C11.303 1.25838 10.9931 1.04383 10.6498 0.897693C10.3065 0.751554 9.93709 0.676884 9.564 0.678241C8.05333 0.678241 6.82866 1.88491 6.82866 3.37157C6.82866 3.58224 6.85266 3.78824 6.89933 3.98491C5.81571 3.93337 4.75474 3.65651 3.78411 3.172C2.81348 2.68749 1.9545 2.00596 1.26199 1.17091C1.01921 1.58051 0.891605 2.04809 0.892662 2.52424C0.893126 2.96955 1.00455 3.40773 1.21685 3.79917C1.42916 4.19061 1.73566 4.52298 2.10866 4.76624C1.67498 4.75224 1.25068 4.63646 0.869995 4.42824V4.46157C0.869995 5.76691 1.81333 6.85557 3.06333 7.10357C2.8284 7.16591 2.58638 7.1975 2.34333 7.19757C2.16666 7.19757 1.99533 7.18091 1.828 7.14757C2.00672 7.68619 2.34873 8.15578 2.80654 8.49113C3.26435 8.82648 3.81522 9.01095 4.38266 9.01891C3.40937 9.7686 2.21454 10.1736 0.985995 10.1702C0.764662 10.1702 0.547328 10.1569 0.333328 10.1329C1.5875 10.9267 3.04172 11.3471 4.52599 11.3449C9.55733 11.3449 12.308 7.24024 12.308 3.68091L12.2987 3.33224C12.8352 2.95469 13.2988 2.4828 13.6667 1.93957Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                        </li>
                        <li
                            class="translate-x-[0px] group-hover:translate-x-[30px] opacity-0 group-hover:opacity-100 transition-all duration-700 last:mb-0 mb-[15px]">
                            <a href="#" aria-label="svg"
                                class="w-[26px] h-[26px] transition-all rounded-full bg-[#FFF6F0] flex items-center justify-center hover:drop-shadow-[0px_4px_10px_rgba(0,0,0,0.25)] text-[#494949] hover:text-[#3B5998]">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7 3.79646C5.22656 3.79646 3.79531 5.22771 3.79531 7.00115C3.79531 8.77458 5.22656 10.2058 7 10.2058C8.77344 10.2058 10.2047 8.77458 10.2047 7.00115C10.2047 5.22771 8.77344 3.79646 7 3.79646ZM7 9.08396C5.85312 9.08396 4.91719 8.14802 4.91719 7.00115C4.91719 5.85427 5.85312 4.91834 7 4.91834C8.14687 4.91834 9.08281 5.85427 9.08281 7.00115C9.08281 8.14802 8.14687 9.08396 7 9.08396ZM10.3359 2.91834C9.92187 2.91834 9.5875 3.25271 9.5875 3.66677C9.5875 4.08084 9.92187 4.41521 10.3359 4.41521C10.75 4.41521 11.0844 4.0824 11.0844 3.66677C11.0845 3.56845 11.0652 3.47107 11.0277 3.38021C10.9901 3.28935 10.935 3.2068 10.8654 3.13727C10.7959 3.06775 10.7134 3.01262 10.6225 2.97506C10.5316 2.93749 10.4343 2.91821 10.3359 2.91834ZM13.2469 7.00115C13.2469 6.13865 13.2547 5.28396 13.2063 4.42302C13.1578 3.42302 12.9297 2.53552 12.1984 1.80427C11.4656 1.07146 10.5797 0.844898 9.57969 0.796461C8.71719 0.748023 7.8625 0.755836 7.00156 0.755836C6.13906 0.755836 5.28437 0.748023 4.42344 0.796461C3.42344 0.844898 2.53594 1.07302 1.80469 1.80427C1.07187 2.53709 0.84531 3.42302 0.796873 4.42302C0.748435 5.28552 0.756248 6.14021 0.756248 7.00115C0.756248 7.86209 0.748435 8.71834 0.796873 9.57927C0.84531 10.5793 1.07344 11.4668 1.80469 12.198C2.5375 12.9308 3.42344 13.1574 4.42344 13.2058C5.28594 13.2543 6.14062 13.2465 7.00156 13.2465C7.86406 13.2465 8.71875 13.2543 9.57969 13.2058C10.5797 13.1574 11.4672 12.9293 12.1984 12.198C12.9312 11.4652 13.1578 10.5793 13.2063 9.57927C13.2562 8.71834 13.2469 7.86365 13.2469 7.00115ZM11.8719 10.6855C11.7578 10.9699 11.6203 11.1824 11.4 11.4011C11.1797 11.6215 10.9687 11.759 10.6844 11.873C9.8625 12.1996 7.91094 12.1261 7 12.1261C6.08906 12.1261 4.13594 12.1996 3.31406 11.8746C3.02969 11.7605 2.81719 11.623 2.59844 11.4027C2.37812 11.1824 2.24062 10.9715 2.12656 10.6871C1.80156 9.86365 1.875 7.91209 1.875 7.00115C1.875 6.09021 1.80156 4.13709 2.12656 3.31521C2.24062 3.03084 2.37812 2.81834 2.59844 2.59959C2.81875 2.38084 3.02969 2.24177 3.31406 2.12771C4.13594 1.80271 6.08906 1.87615 7 1.87615C7.91094 1.87615 9.86406 1.80271 10.6859 2.12771C10.9703 2.24177 11.1828 2.37927 11.4016 2.59959C11.6219 2.8199 11.7594 3.03084 11.8734 3.31521C12.1984 4.13709 12.125 6.09021 12.125 7.00115C12.125 7.91209 12.1984 9.86365 11.8719 10.6855Z"
                                        fill="currentColor" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <div
                    class="bg-[#FFFDFC] z-[1] drop-shadow-[0px_2px_15px_rgba(0,0,0,0.1)] rounded-[0px_0px_6px_6px] px-3 md:px-[15px] py-[20px] border-b-[6px] border-primary transition-all duration-500 before:transition-all before:duration-300 group-hover:border-secondary relative">
                    <h3><a href="{{ route('front.agent.details', $agent) }}"
                            class="font-lora font-normal text-base text-primary group-hover:text-secondary">{{
                            $agent->full_name }}</a></h3>
                    <p class="font-normal text-[14px] leading-none capitalize mt-[5px] group-hover:text-body">Real
                        Estate {{ $agent->user->role }}</p>
                </div>
            </div>
            @empty
            <p>No Agent Found</p>
            @endforelse
            <!-- single team end-->
        </div>
    </div>
</section>
<!-- Team Section End-->

<!-- News Letter section start -->
<section class="py-[80px] lg:p-[90px] bg-primary relative">
    <div class="container">
        <div class="grid grid-cols-1">
            <div class="col-span">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full lg:w-auto">
                        <h3
                            class="font-lora text-white text-[24px] sm:text-[30px] xl:text-[36px] leading-[1.277] mb-[10px]">
                            Are you a Home Owner?</h3>
                        <p class="text-secondary leading-[1.5] tracking-[0.03em] mb-10">Put your email address and get
                            listed.</p>
                        <form id="mc-form" action="#" class="relative w-full">
                            <input id="mc-email"
                                class="font-light text-white leading-[1.75] opacity-100 border border-secondary w-full lg:w-[395px] xl:w-[495px] h-[60px] rounded-[10px] py-[15px] pl-[15px] pr-[15px] sm:pr-[135px] focus:border-white focus:outline-none border-opacity-60 placeholder:text-[#E2E2E2] bg-transparent"
                                type="text" placeholder="Enter your email here...">
                            <button id="mc-submit" type="submit"
                                class="text-white font-medium text-[16px] leading-none tracking-[0.02em] bg-secondary py-[17px] px-[20px] mt-5 sm:mt-0 rounded-[10px] hover:bg-white hover:text-primary transition-all sm:absolute sm:right-[4px] sm:top-1/2 sm:-translate-y-1/2">Get
                                Listed</button>
                        </form>
                        <!-- mailchimp-alerts Start -->
                        <div class="mailchimp-alerts text-centre">
                            <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                            <div class="mailchimp-success text-green-400"></div><!-- mailchimp-success end -->
                            <div class="mailchimp-error text-red-600"></div><!-- mailchimp-error end -->
                        </div>
                        <!-- mailchimp-alerts end -->
                    </div>
                    <div class="w-full hidden lg:block lg:w-auto mt-5 lg:mt-0">
                        <div class="relative mt-10 md:mt-0 lg:absolute lg:right-0 lg:bottom-0">
                            <img class="hero_image lg:max-w-[550px] xl:max-w-[650px] 2xl:max-w-[714px]"
                                src="{{ asset('front/assets/images/newsletter/bg-1.png') }}" width="866" height="879"
                                alt="hero image">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- News Letter section End -->

@endsection