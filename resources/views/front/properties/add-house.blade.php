@extends('layouts.guest')
@section('title', 'Your Dream Home Awaits - Explore Our Real Estate Listings')
@section('content')

<!--===== DASHBOARD AREA STARTS =======-->
<div class="add-property-section sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="heading1">
                    <h2>Add House</h2>
                    <div class="space32"></div>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="col-lg-12">
                <form method="POST" action="{{ route('user.properties.houses.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="upload-main-boxarea">
                        <h3>Property Details</h3>
                        <div class="space32"></div>
                        <div class="input-area">
                            <h5>Property Title*</h5>
                            <div class="space16"></div>
                            <input type="text" name="title" required placeholder="Property title">
                        </div>
                        <div class="space28"></div>
                        <div class="input-area">
                            <h5>Description</h5>
                            <div class="space16"></div>
                            <textarea name="description" placeholder="Property Description"></textarea>
                        </div>
                        @include('includes.form')
                    </div>
                    <div class="space60"></div>
                    <div class="upload-main-boxarea">
                        <h3>Property Price</h3>
                        <div class="space4"></div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Property Price*</h5>
                                    <div class="space16"></div>
                                    <input type="number" name="price" placeholder="Price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <label>Service</label>
                                    <div class="space16"></div>
                                    <select class="form-select" name="service_id" required>
                                        <option value="">Select service</option>
                                        @foreach($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space60"></div>
                    <div class="upload-main-boxarea">
                        <h3>Additional Information</h3>
                        <div class="space4"></div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Property Type*</h5>
                                    <div class="space16"></div>
                                    <select class="form-select" id="propertyType" name="type" required>
                                        <option value="">Select type</option>
                                        <option value="house">House</option>
                                        <option value="apartment">Apartment</option>
                                        <option value="villa">Villa</option>
                                        <option value="townhouse">Townhouse</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Property Status*</h5>
                                    <div class="space16"></div>
                                    <select name="status" class="form-control">
                                        <option value="available">Available</option>
                                        <option value="reserved">Reserved</option>
                                        <option value="sold">Sold</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Property condition*</h5>
                                    <div class="space16"></div>
                                    <select name="condition" class="form-control">
                                        <option value="for_rent">For Rent</option>
                                        <option value="for_sale">For Sale</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Size (SQFT)*</h5>
                                    <div class="space16"></div>
                                    <input type="number" name="area_sqft" placeholder="Size">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Bedrooms*</h5>
                                    <div class="space16"></div>
                                    <input name="bedrooms" type="number" class="form-control" id="propertyBeds"
                                        placeholder="Enter number of bedrooms" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Bathrooms*</h5>
                                    <div class="space16"></div>
                                    <input name="bathrooms" type="number" class="form-control" id="propertyBaths"
                                        placeholder="Enter number of bathrooms" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Garages*</h5>
                                    <div class="space16"></div>
                                    <input name="garages" type="number" class="form-control" id="propertyGarage"
                                        placeholder="Enter number of garages" required>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Upload images*</h5>
                                    <div class="space16"></div>
                                    <input type="file" name="images[]" class="form-control" multiple>
                                    <small class="form-text text-muted">You can upload multiple images for the property.</small>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="space60"></div>
        <div class="upload-main-boxarea">
            <h3>Amenities*</h3>
            <div class="space16"></div>
            <div class="row">
                @foreach($facilities as $facility)
                <div class="col-lg-2 col-md-6">
                    <fieldset class="checkbox-item style-1">
                        <label>
                            <input type="checkbox" name="amenities[]" value="{{ $facility->id }}">
                            <span class="btn-checkbox"></span>
                            <span class="text-4">{{ $facility->name }}</span>
                        </label>
                    </fieldset>
                </div>
                @endforeach
            </div>
        </div>
        <div class="space60"></div>
        <div class="upload-main-boxarea">
            <h3>User Information</h3>
            <div class="space28"></div>
            <div class="input-area">
                <h5>Enter user information?</h5>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="space28"></div>
                    <div class="input-area">
                        <h5>Names*</h5>
                        <div class="space16"></div>
                        <input name="name" type="text" class="form-control" id="propertyNames"
                            placeholder="Enter user names" required>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="space28"></div>
                    <div class="input-area">
                        <h5>Email*</h5>
                        <div class="space16"></div>
                        <input name="email" type="email" class="form-control" id="propertyEmail"
                            placeholder="Enter user email" required>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="space28"></div>
                    <div class="input-area">
                        <h5>Phone*</h5>
                        <div class="space16"></div>
                        <input name="phone" type="tel" class="form-control" id="propertyPhone"
                            placeholder="Enter user phone" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="space48"></div>
        <div class="btn-area1 text-center">
            <button type="submit" class="theme-btn1">Add Property <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                    </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                        height="24" fill="currentColor">
                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                    </svg></span></button>
        </div>
        </form>
    </div>
</div>
</div>
</div>
<!--===== DASHBOARD AREA ENDS =======-->

<!--===== CTA AREA STARTS =======-->
<div class="cta1-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-bg-area"
                    style="background-image: url({{ asset('front/assets/img/all-images/bg/cta-bg1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="cta-header">
                                <h2 class="text-anime-style-3">Step Into Your Dream with HouseBox</h2>
                                <div class="space16"></div>
                                <p data-aos="fade-left" data-aos-duration="1000">At HouseBox, we believe your next home is more than
                                    just a place – it’s where your future begins you’re buy.</p>
                            </div>
                        </div>
                        <div class="col-lg-2"></div>
                        <div class="col-lg-5" data-aos="zoom-in" data-aos-duration="1000">
                            <div class="btn-area text-center">
                                <a href="property-halfmap-grid" class="theme-btn1">Find Your Dream Home <span class="arrow1"><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                            fill="currentColor">
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
</div>
<!--===== CTA AREA ENDS =======-->

@endsection