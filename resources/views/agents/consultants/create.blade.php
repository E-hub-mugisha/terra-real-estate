@extends('layouts.app')
@section('title', 'Create New Consultant')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">Consultants Add</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Consultants</a></li>
        <li class="breadcrumb-item active">Consultants Add</li>
    </ul>
</div>
<!-- error -->
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form method="POST" action="{{ route('admin.consultants.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="col-xl-8 col-xxl-9">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Consultant Information</h6>
                </div>
                <div class="card-body">

                    <div class="row g-5">
                        <div class="col-md-6">
                            <label for="consultantName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="consultantName"
                                placeholder="Enter full name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="agentEmail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="agentEmail"
                                placeholder="Enter email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="agentPhone" class="form-label">Phone</label>
                            <input type="tel" name="phone" class="form-control" id="agentPhone"
                                placeholder="Enter phone number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="agenttitle" class="form-label">title</label>
                            <input name="title" class="form-control" placeholder="title (e.g. Senior consultant)">
                        </div>
                        <div class="col-12">
                            <label for="agentBio" class="form-label">Biography</label>
                            <textarea class="form-control" name="bio" id="agentBio" rows="4"
                                placeholder="Enter agent biography"></textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Contact & Social</h6>
                </div>
                <div class="card-body">

                    <div class="row g-5">
                        <div class="col-md-12">
                            <div class="row">
                                @foreach($serviceCategories as $category)
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check mb-2">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="service_categories[]"
                                            value="{{ $category->id }}"
                                            id="cat{{ $category->id }}"
                                            {{ in_array($category->id, old('service_categories', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-xxl-3">
            <div class="card position-sticky top-24">
                <div class="card-body">
                    <h6 class="card-title mb-3">Additional Info</h6>

                    <div class="row g-5">
                        <div class="col-12">
                            <input type="file" name="profile" id="agentImageUpload" class="d-none">
                            <label for="agentImageUpload"
                                class="avatar h-52 w-100 p-5 text-center bg-light-subtle rounded border border-dashed cursor-pointer">
                                <div class="text-muted">
                                    <i data-lucide="image-up"></i>
                                    <div class="mt-3">Upload Profile Image</div>
                                </div>
                            </label>
                        </div>
                        <div class="col-12">
                            <label for="agentWhatsApp" class="form-label">WhatsApp Number</label>
                            <input type="tel" name="whatsapp" class="form-control" id="agentWhatsApp"
                                placeholder="Enter WhatsApp number">
                        </div>
                        <div class="col-12">
                            <label for="agentOfficeLocation" class="form-label">Office Location</label>
                            <input type="text" name="office_location" class="form-control" id="agentOfficeLocation"
                                placeholder="Enter office address or location">
                        </div>
                        <div class="col-12">
                            <label for="agentLanguages" class="form-label">Languages Spoken</label>
                            <input type="text" name="languages" class="form-control" id="agentLanguages"
                                placeholder="English, Spanish, etc.">
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-5">
                            <button type="reset" class="btn btn-light w-100">Cancel</button>
                            <button type="submit" class="btn btn-primary w-100">Create Agent</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</form>
@endsection