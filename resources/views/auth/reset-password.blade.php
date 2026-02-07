@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')

<div class="container min-vh-100 py-10 d-flex align-items-center">
    <div class="w-100">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="text-center mb-8">
                    <a href="index.html" class="logos">
                        <img src="{{ asset('dashboard/assets/images/main-logo.png') }}" loading="lazy" alt="Logo" class="h-5 logo-dark">
                        <img src="{{ asset('dashboard/assets/images/logo-white.png') }}" loading="lazy" alt="Logo White" class="h-5 logo-light">
                    </a>
                </div>
                <div class="card mb-0">
                    <div class="p-sm-8 px-md-10 card-body">
                        <h4 class="text-gradient fw-bold text-center">Set your new password</h4>
                        <p class="mb-5 text-center text-muted">Ensure that your new password is different from any passwords you've previously used.</p>
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <!-- Success Alert -->
                            <div class="alert alert-success alert-dismissible d-none mb-1">
                                <span>Success Alerts</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <!-- Error Alert -->
                            <div class="alert alert-danger alert-dismissible d-none mb-1">
                                <span>Error Alerts</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="position-relative">
                                        <input type="email" id="email" name="email" class="form-control pe-8" placeholder="Enter your email" required>
                                        
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" id="password" name="password" class="form-control pe-8" placeholder="Enter your password" required>
                                        <div class="position-absolute top-50 end-0 me-3 translate-middle-y text-muted cursor-pointer password-show-icon">
                                            <i data-lucide="eye-off" class="size-4"></i>
                                            <i data-lucide="eye" class="size-4 d-none"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <div class="position-relative password">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pe-8" placeholder="Enter your confirm password" required>
                                        <div class="position-absolute top-50 end-0 me-3 translate-middle-y text-muted cursor-pointer password-show-icon">
                                            <i data-lucide="eye-off" class="size-4"></i>
                                            <i data-lucide="eye" class="size-4 d-none"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100">Set Password</button>
                                </div>
                                <p class="mt-3 text-center text-muted">Return to the
                                    <a href="{{ route('login') }}" class="fw-medium text-reset">Sign In<i data-lucide="move-right" class="size-4 ms-1"></i> </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
