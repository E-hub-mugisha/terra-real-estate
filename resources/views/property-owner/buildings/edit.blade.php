@extends('layouts.propertyOwner.app')

@section('title', 'Edit Building')

@section('content')
    <a href="{{ route('property-owner.buildings.show', [$property, $building]) }}">
        &larr; Back to Building
    </a>

    <h2 class="fw-bold mt-3">Edit Building</h2>
    <p class="text-muted">{{ $property->name }}</p>

    <form method="POST"
          action="{{ route('property-owner.buildings.update', [$property, $building]) }}">
        @csrf
        @method('PUT')

        @include('property-owner.buildings._form', [
            'building' => $building,
        ])
    </form>
@endsection