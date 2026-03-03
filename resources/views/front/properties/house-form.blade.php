<div class="add-property-section sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="heading1">
                    <h2>Add Property</h2>
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
                    <div class="property-main-boxarea">
                        <h3>Upload Media</h3>
                        <div class="space38"></div>
                        <div class="box-uploadfile text-center">
                            <div class="uploadfile">
                                <div class="btn-upload theme-btn1 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM5.00242 8L5.00019 20H14.9998V8H5.00242ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6Z">
                                        </path>
                                    </svg>
                                    Select Property Photos
                                    <input type="file" name="images[]" class="ip-file" multiple>
                                </div>
                            </div>
                            <div class="space20"></div>
                        </div>
                    </div>
                    <div class="space60"></div>
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
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Full Address*</h5>
                                    <div class="space16"></div>
                                    <input type="text" name="address" placeholder="Property Full Address*">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Zip Code*</h5>
                                    <div class="space16"></div>
                                    <input type="text" name="zip_code" placeholder="Property Zip Code">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Country*</h5>
                                    <div class="space16"></div>
                                    <input name="country" class="form-control" value="Rwanda">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Province/State*</h5>
                                    <div class="space16"></div>
                                    <input name="state" type="text" class="form-control" id="propertyState"
                                        placeholder="Enter state" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Neighborhood:</h5>
                                    <div class="space16"></div>
                                    <input type="text" placeholder="None">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Location*</h5>
                                    <div class="space16"></div>
                                    <input name="city" type="text" class="form-control" id="propertyCity"
                                        placeholder="Enter city" required>
                                </div>
                            </div>

                        </div>
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
                            <div class="col-lg-6 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Names*</h5>
                                    <div class="space16"></div>
                                    <input name="name" type="text" class="form-control" id="propertyNames"
                                        placeholder="Enter user names" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Email*</h5>
                                    <div class="space16"></div>
                                    <input name="email" type="email" class="form-control" id="propertyEmail"
                                        placeholder="Enter user email" required>
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