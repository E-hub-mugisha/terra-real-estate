@extends('layouts.guest')
@section('title', 'Sell Property')
@section('content')

<div class="container py-5">

    <h2 class="fw-bold mb-4">Sell or Request Service</h2>

    <!-- Tabs -->
    <ul class="nav nav-pills mb-4" id="sellTabs">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#houseTab">House</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#landTab">Land</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#designTab">Design</button>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade show active" id="houseTab">
            @include('front.properties.house-form')
        </div>

        <div class="tab-pane fade" id="landTab">
            @include('front.properties.land-form')
        </div>

        <div class="tab-pane fade" id="designTab">
            @include('front.properties.design-form')
        </div>

    </div>
</div>

@endsection