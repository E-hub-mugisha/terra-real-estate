@extends('layouts.propertyOwner.app')

@section('title', 'Create Building')

@section('content')
    <a href="{{ route('property-owner.buildings.index', $property) }}">
        &larr; Back to Buildings
    </a>

    <h2 class="fw-bold mt-3">Add Building</h2>
    <p class="text-muted">
        Property: {{ $property->name }}
    </p>

    <form method="POST"
          action="{{ route('property-owner.buildings.store', $property) }}">
        @csrf
        @include('property-owner.buildings._form')
    </form>
@endsection