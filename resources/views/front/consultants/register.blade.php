@extends('layouts.base')

@section('title', 'Consultant Registration')

@section('content')
<div class="hero4-section-area sp1  d-flex align-items-center" style="background-image: url({{ asset('front/assets/img/all-images/hero/hero4-img1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-lg-5 d-flex justify-content-center">
                <div class="hero-header">
                    <h5 data-aos="fade-left" data-aos-duration="800" class="aos-init aos-animate">Discover Your Ideal Property Today!</h5>
                    <div class="space20"></div>
                    <h1 class="text-anime-style-3" style="perspective: 400px;">
                        Become a Terra Consultant
                    </h1>
                    <div class="space20"></div>
                    <div class="btn-are1 aos-init aos-animate" data-aos="fade-left" data-aos-duration="1000">
                        <a href="sidebar-grid.html" class="theme-btn5">Create account next!<span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 justify-content-center">
                <div class="property-tab-section4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="mb-0">Become a Terra Consultant</h4>
                            <small>Step <span id="currentStep">1</span> of 4</small>
                        </div>

                        <div class="card-body">

                            {{-- Errors --}}
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('consultant.register.store') }}">
                                @csrf

                                {{-- STEP 1: PERSONAL INFO --}}
                                <div class="step">
                                    <h5 class="mb-3">Personal Information</h5>

                                    <div class="mb-3">
                                        <label class="form-label">What is your full name?</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                                    </div>
                                </div>

                                {{-- STEP 2: PROFESSIONAL --}}
                                <div class="step d-none">
                                    <h5 class="mb-3">Professional Profile</h5>
                                    <div class="mb-3">
                                        <label class="form-label">Reg Number</label>
                                        <input type="text" name="reg_number" class="form-control" value="{{ old('reg_number') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Company / Organization (Optional)</label>
                                        <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Upload CV </label>
                                        <input type="file" name="cv" class="form-control" value="{{ old('cv') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tell us about yourself</label>
                                        <textarea name="bio" class="form-control" rows="4">{{ old('bio') }}</textarea>
                                        <small class="text-muted">Your experience, background, or expertise</small>
                                    </div>
                                </div>

                                {{-- STEP 3: SERVICES --}}
                                <div class="step d-none">
                                    <h5 class="mb-3">Services You Offer</h5>
                                    <p class="text-muted">Select one or more service categories</p>

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

                                {{-- STEP 4: SECURITY --}}
                                <div class="step d-none">
                                    <h5 class="mb-3">Account Security</h5>

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

                                    <div class="alert alert-info">
                                        Your account will be reviewed before approval.
                                    </div>
                                </div>

                                {{-- NAVIGATION --}}
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="theme-btn1" id="prevBtn" onclick="nextPrev(-1)">
                                        Back
                                    </button>

                                    <button type="button" class="theme-btn1" id="nextBtn" onclick="nextPrev(1)">
                                        Next
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- MULTI STEP SCRIPT --}}
<script>
    let currentStep = 0;
    const steps = document.querySelectorAll('.step');
    const currentStepLabel = document.getElementById('currentStep');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');

    showStep(currentStep);

    function showStep(n) {
        steps.forEach(step => step.classList.add('d-none'));
        steps[n].classList.remove('d-none');

        prevBtn.style.display = n === 0 ? 'none' : 'inline-block';
        nextBtn.innerHTML = (n === steps.length - 1) ? 'Submit' : 'Next';

        currentStepLabel.innerText = n + 1;
    }

    function nextPrev(n) {
        if (n === 1 && currentStep === steps.length - 1) {
            document.querySelector('form').submit();
            return;
        }

        currentStep += n;
        showStep(currentStep);
    }
</script>
@endsection