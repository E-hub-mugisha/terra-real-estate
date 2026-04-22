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
                <form method="POST" action="{{ route('user.properties.land.store') }}" enctype="multipart/form-data">
                    @csrf
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
                                    <h5>Village*</h5>
                                    <div class="space16"></div>
                                    <input name="village" type="text" class="form-control" id="village"
                                        placeholder="Village (e.g. Nyamirambo)" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Cell*</h5>
                                    <div class="space16"></div>
                                    <input name="cell" type="text" class="form-control" id="cell"
                                        placeholder="Cell (e.g. Kacyiru)" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Sector*</h5>
                                    <div class="space16"></div>
                                    <input name="sector" type="text" class="form-control" id="sector"
                                        placeholder="Sector (e.g. Nyamirambo)" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>District*</h5>
                                    <div class="space16"></div>
                                    <input name="district" type="text" class="form-control" id="district"
                                        placeholder="District (e.g. Gasabo)" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Province*</h5>
                                    <div class="space16"></div>
                                    <input name="province" type="text" class="form-control" id="province"
                                        placeholder="Province (e.g. Kigali City)" required>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="space60"></div>
                    <div class="upload-main-boxarea">
                        <h3>Land Price</h3>
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
                                    <select name="zoning" class="form-control">
                                        <option value="R1">R1 – Low density residential</option>
                                        <option value="R2">R2 – Medium density residential</option>
                                        <option value="R3">R3 – High density residential</option>
                                        <option value="Commercial">Commercial</option>
                                        <option value="Industrial">Industrial</option>
                                        <option value="Agricultural">Agricultural</option>
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
                                    <h5>Land Use*</h5>
                                    <div class="space16"></div>
                                    <input type="text" class="form-control" id="land_use"
                                        placeholder="Enter land_use" name="land_use" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Size (SQFT)*</h5>
                                    <div class="space16"></div>
                                    <input type="number" name="size_sqm" placeholder="Size">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Land UPI*</h5>
                                    <div class="space16"></div>
                                    <input type="text" class="form-control" id="propertyType" name="upi" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="space28"></div>
                                <div class="input-area">
                                    <h5>Title Document*</h5>
                                    <div class="space16"></div>
                                    <input type="file" class="form-control" id="propertyType" name="title_doc" required>
                                </div>
                            </div>
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
                                </svg></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>