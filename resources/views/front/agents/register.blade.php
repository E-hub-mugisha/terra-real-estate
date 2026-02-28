@extends('layouts.base')

@section('title', 'Agent Registration')

@section('content')
<div class="hero4-section-area sp1 vh-100  d-flex align-items-center" style="background-image: url({{ asset('front/assets/img/all-images/hero/hero4-img1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-lg-5 d-flex justify-content-center">
                <div class="hero-header">
                    <h5 data-aos="fade-left" data-aos-duration="800" class="aos-init aos-animate">Discover Your Ideal Property Today!</h5>
                    <div class="space20"></div>
                    <h1 class="text-anime-style-3" style="perspective: 400px;">
                        Become a Terra Agent
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
                            <h4 class="mb-0">Become a Terra Agent</h4>
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

                            <form method="POST" action="{{ route('front.agents.register.store') }}" enctype="multipart/form-data">
                                @csrf

                                {{-- STEP 1: PERSONAL INFO --}}
                                <div class="step">
                                    <h5 class="mb-3">Personal Information</h5>

                                    <div class="mb-3">
                                        <label class="form-label">What is your full name?</label>
                                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
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
                                        <label class="form-label">Years of experience</label>
                                        <input type="text" name="years_experience" class="form-control" value="{{ old('years_experience') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tell us about yourself</label>
                                        <textarea name="bio" class="form-control" rows="4">{{ old('bio') }}</textarea>
                                        <small class="text-muted">Your experience, background, or expertise</small>
                                    </div>
                                </div>

                                {{-- STEP 3: SERVICES --}}
                                <div class="step d-none">
                                    <h5 class="mb-3">Contact & Social</h5>

                                    <div class="row g-5">
                                        <div class="col-md-6">
                                            <label for="agentLinkedIn" class="form-label">LinkedIn</label>
                                            <input type="url" name="linkedin" class="form-control" id="agentLinkedIn"
                                                placeholder="Enter LinkedIn profile URL">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="agentFacebook" class="form-label">Facebook</label>
                                            <input type="url" name="facebook" class="form-control" id="agentFacebook"
                                                placeholder="Enter Facebook profile URL">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="agentInstagram" class="form-label">Instagram</label>
                                            <input type="url" name="instagram" class="form-control" id="agentInstagram"
                                                placeholder="Enter Instagram profile URL">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="agentTwitter" class="form-label">Twitter</label>
                                            <input type="url" name="twitter" class="form-control" id="agentTwitter"
                                                placeholder="Enter Twitter profile URL">
                                        </div>
                                    </div>
                                </div>

                                {{-- STEP 4: SECURITY --}}
                                <div class="step d-none">
                                    <h5 class="mb-3">Additional Info</h5>

                                    <div class="row g-5">
                                        <div class="col-12">
                                            <input type="file" name="profile_image" id="agentImageUpload" class="d-none">
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