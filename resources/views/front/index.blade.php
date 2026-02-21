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

<div class="property-location-section-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="property-headeing heading1 space-margin60 text-center">
                    <h5>property location</h5>
                    <div class="space20"></div>
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        <div class="split-line" style="display: block; text-align: center; position: relative;">
                            <div style="position:relative;display:inline-block;">
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">E</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">x</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">p</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">l</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">o</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">r</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">e</div>
                            </div>
                            <div style="position:relative;display:inline-block;">
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">O</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">u</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">r</div>
                            </div>
                            <div style="position:relative;display:inline-block;">
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">P</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">r</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">o</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">p</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">e</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">r</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">t</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">y</div>
                            </div>
                        </div>
                        <div class="split-line" style="display: block; text-align: center; position: relative;">
                            <div style="position:relative;display:inline-block;">
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">L</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">o</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">c</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">a</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">t</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">i</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">o</div>
                                <div style="position: relative; display: inline-block; translate: none; rotate: none; scale: none; transform: translate(0px, 0px); opacity: 1;">n</div>
                            </div>
                        </div>
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                <div class="property-single-slider owl-carousel owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(-3182px, 0px, 0px); transition: 2s; width: 5304px;">
                            @foreach($districts as $district => $data)
                            <div class="owl-item cloned" style="width: 235.2px; margin-right: 30px;">
                                <div class="propety-single-boxarea">
                                    <div class="img1 image-anime">
                                        <img src="{{ asset('front/assets/img/all-images/property_location/property-img1.png') }}" alt="{{ $district }}">
                                    </div>
                                    <h3>{{ $data['total'] ?? 0 }}</h3>
                                    <a href="property-details-v1.html">{{ $district }}</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><i class="fa-solid fa-angle-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="fa-solid fa-angle-right"></i></button></div>
                    <div class="owl-dots disabled"></div>
                </div>
            </div>
        </div>
    </div>
</div>


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
                    <h2>How can Terra real estate help you?</h2>
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
                                <a href="{{ route('services.category', $category->slug) }}">
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


<div class="mission-section-area sp1"
    style="background-image: url(front/assets/img/all-images/bg/bg1.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="heading1 text-center space-margin60">
                    <h5>Trusted Agents</h5>
                    <div class="space20"></div>
                    <h2>Our Agents &amp; Professional Network</h2>
                </div>
                <div class="space100 d-lg-block d-none"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="vission-mission-box">
                    <h3>Connecting Buyers & Sellers Through Verified Agents</h3>
                    <div class="space24"></div>

                    <p>
                        Our platform brings together experienced, verified real estate agents
                        who help buyers and sellers navigate property and land transactions
                        with confidence. Agents act as trusted intermediaries, ensuring
                        transparency, accuracy, and smooth communication.
                    </p>

                    <div class="space24"></div>

                    <h4>Agent Role</h4>
                    <div class="space16"></div>
                    <p>
                        Agents assist with property listings, buyer inquiries, negotiations,
                        and documentation. Every agent profile is verified, showcasing
                        credentials, experience, and client reviews for full trust.
                    </p>

                    <div class="space24"></div>

                    <h4>Our Commitment</h4>
                    <div class="space16"></div>
                    <p>
                        We are committed to empowering professional agents with modern tools,
                        visibility, and a reliable marketplace that helps them grow their
                        business while delivering value to clients.
                    </p>

                    <div class="space32"></div>

                    <div class="btn-area1">
                        <a href="property-halfmap-grid.html" class="theme-btn1">
                            See All Agents
                            <span class="arrow1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    width="24" height="24" fill="currentColor">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg>
                            </span>
                            <span class="arrow2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    width="24" height="24" fill="currentColor">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="img1">
                    <img src="{{ asset('front/assets/img/all-images/properties/property-img47.png') }}"
                        alt="verified real estate agents">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about1-section-area sp1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-images-area">
                    <div class="img2 image-anime reveal" style="opacity: 1; visibility: inherit; translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                        <img src="{{ asset('front/assets/img/all-images/about/about-img2.png') }}" alt="housebox" style="translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                    </div>
                    <div class="img1 image-anime reveal" style="opacity: 1; visibility: inherit; translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                        <img src="{{ asset('front/assets/img/all-images/about/about-img1.png') }}" alt="housebox" style="translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                    </div>
                    <div class="author-img aniamtion-key-1">
                        <h3>Our Happy Customer</h3>
                        <div class="space18"></div>
                        <img src="{{ asset('front/assets/img/all-images/others/author-img1.png') }}" alt="housebox">
                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-5">
                <div class="about-heading heading1">
                    <h5 data-aos="fade-left" data-aos-duration="100" class="aos-init aos-animate">Terra Agent</h5>
                    <div class="space20"></div>
                    <h2 class="text-anime-style-3" style="perspective: 400px;">
                        Connecting Buyers & Sellers Through Verified Agents
                    </h2>
                    <div class="space18"></div>
                    <p data-aos="fade-left" data-aos-duration="100" class="aos-init aos-animate">
                        Agents assist with property listings, buyer inquiries, negotiations,
                        and documentation. Every agent profile is verified, showcasing
                        credentials, experience, and client reviews for full trust.</p>
                    <div class="space32"></div>
                    <div class="counter-boxes aos-init aos-animate" data-aos="fade-left" data-aos-duration="1000">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-6">
                                <div class="counter-boxarea text-center">
                                    <h2><span class="counter">10</span>K</h2>
                                    <div class="space12"></div>
                                    <p>Homes Sold</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-6">
                                <div class="counter-boxarea text-center">
                                    <h2><span class="counter">9</span>K</h2>
                                    <div class="space12"></div>
                                    <p>Happy Client</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-6">
                                <div class="space20 d-md-none d-block"></div>
                                <div class="counter-boxarea text-center">
                                    <h2><span class="counter">98</span>%</h2>
                                    <div class="space12"></div>
                                    <p>Satisfaction Rate</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space32"></div>
                    <div class="btn-area1 aos-init" data-aos="fade-left" data-aos-duration="1100">
                        <a href="property-halfmap-grid.html" class="theme-btn1">See All Agents <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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
<!--===== CTA AREA STARTS =======-->
<div class="cta1-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-bg-area" style="background-image: url(front/assets/img/all-images/bg/cta-bg1.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="cta-header">
                                <h2 class="text-anime-style-3">Are you a property Owner?</h2>
                                <div class="space16"></div>
                                <p data-aos="fade-left" data-aos-duration="1000">At Terra real estate, we believe your next move is more than just a place – it’s where your future begins.</p>
                            </div>
                        </div>
                        <div class="col-lg-2"></div>
                        <div class="col-lg-5" data-aos="zoom-in" data-aos-duration="1000">
                            <div class="btn-area1 text-center">
                                <a href="sidebar-grid" class="theme-btn1">Put your email address and get listed. <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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
<!--===== CTA AREA ENDS =======-->
@endsection