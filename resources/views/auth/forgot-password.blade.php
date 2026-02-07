@extends('layouts.auth')
@section('title', 'Forgot Password')
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
                        <h4 class="text-gradient fw-bold text-center">Forgot your Password?</h4>
                        <p class="mb-5 text-center text-muted">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <label for="emailOrUsername" class="form-label">Email or Username</label>
                                    <input type="email" id="emailOrUsername" name="email" placeholder="Enter your email or username" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                </div>
                            </div>
                        </form>
                        <p class="mt-3 text-center text-muted">
                            Return to the
                            <a href="{{ route('login') }}" class="link link-primary">Sign In
                                <i data-lucide="move-right" class="size-4 "></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
