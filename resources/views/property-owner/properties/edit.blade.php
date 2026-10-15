@extends('layouts.propertyOwner.app')

@section('title', 'Edit Property')

@section('content')
    <div class="mb-4">
        <a href="{{ route('property-owner.properties.show', $property) }}"
           class="text-decoration-none">
            &larr; Back to Property
        </a>

        <h2 class="fw-bold mt-3 mb-1">Edit Property</h2>
        <p class="text-muted mb-0">
            Update the details for
            <strong>{{ $property->name }}</strong>.
        </p>
    </div>

    <form action="{{ route('property-owner.properties.update', $property) }}"
          method="POST">
        @csrf
        @method('PUT')

        @include('property-owner.properties._form', [
            'property' => $property,
        ])

    </form>
@endsection