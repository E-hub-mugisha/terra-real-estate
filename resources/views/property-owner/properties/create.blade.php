@extends('layouts.propertyOwner.app')

@section('title', 'Register Property')

@section('content')
    <div class="mb-4">
        <a href="{{ route('property-owner.properties.index') }}"
           class="text-decoration-none">
            &larr; Back to My Properties
        </a>

        <h2 class="fw-bold mt-3 mb-1">Register a Property</h2>
        <p class="text-muted mb-0">
            Add a property to your Terra owner portfolio.
        </p>
    </div>

    <form action="{{ route('property-owner.properties.store') }}"
          method="POST">
        @csrf

        @include('property-owner.properties._form')

    </form>
@endsection