@extends('layouts.auth')
@section('title', 'Sign Up')
@section('content')

<div class="container min-vh-100 py-10 d-flex align-items-center">
    <div class="w-100">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="text-center mb-8">
                    <a href="index.html" class="logos">
                        {{ config('app.name') }}
                            <!-- <img src="{{ asset('dashboard/assets/images/main-logo.png') }}" loading="lazy" alt="Logo" class="h-5 logo-dark">
                            <img src="{{ asset('dashboard/assets/images/logo-white.png') }}" loading="lazy" alt="Logo White" class="h-5 logo-light"> -->
                    </a>
                </div>
                <div class="card mb-0">
                    <div class="p-sm-8 px-md-10 card-body">
                        <h4 class="mb-2 text-gradient fw-bold text-center">Create a New Account</h4>
                        <p class="mb-7 text-center text-muted">Already have an account? <a href="{{ route('login') }}" class="link link-primary text-reset fw-medium">Sign In</a></p>
                        <!-- Social login buttons -->
                        <div class="d-flex flex-wrap flex-md-nowrap gap-4">
                            <a type="button" class="btn btn-light w-100">
                                <i class="bi bi-google-play me-1"></i>
                                Sign In Google
                            </a>
                            <a type="button" class="btn btn-light w-100">
                                <i class="bi bi-apple me-1"></i>
                                Sign In Apple
                            </a>
                        </div>
                        <div class="position-relative text-center my-3">
                            <div class="position-absolute top-50 start-0 border-top w-100 border-dashed"></div>
                            <p class="bg-body-secondary text-muted p-2 position-relative d-inline-block">OR</p>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="alert alert-success alert-dismissible d-none">
                                <span>Success Alerts</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <!-- Error Alert -->
                            <div class="alert alert-danger alert-dismissible d-none">
                                <span>Error Alerts</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="row g-4 mt-3">
                                <div class="col-12 col-md-6">
                                    <label for="name" class="form-label">Username</label>
                                    <input type="text" id="name" name="name" placeholder="Enter your username" class="form-control" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="emailInput" class="form-label">Email</label>
                                    <input type="email" id="emailInput" name="email" placeholder="Enter your email" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label for="passwordInput" class="form-label">Password</label>
                                    <div class="position-relative password">
                                        <input type="password" id="passwordInput" name="password" class="form-control pe-8" placeholder="Enter your password" required>
                                        <div class="position-absolute top-50 end-0 me-3 translate-middle-y text-muted cursor-pointer" id="passwordShowIcon">
                                            <i data-lucide="eye-off" class="size-4"></i>
                                            <i data-lucide="eye" class="size-4 d-none"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <div class="position-relative password">
                                        <input type="password" id="passwordInput" name="password_confirmation" class="form-control pe-8" placeholder="Enter your confirm password" required>
                                        <div class="position-absolute top-50 end-0 me-3 translate-middle-y text-muted cursor-pointer" id="passwordShowIcon">
                                            <i data-lucide="eye-off" class="size-4"></i>
                                            <i data-lucide="eye" class="size-4 d-none"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check check-primary">
                                        <input type="checkbox" id="rememberMe" class="form-check-input">
                                        <label for="rememberMe" class="form-check-label fs-sm">By creating an account, you agree to all of our terms condition & policies.</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-6">
                                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="link link-primary">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection