@extends('layouts.propertyOwner.app')

@section('title', 'Create Rental Unit')

@section('content')
    <a href="{{ route('property-owner.units.index', [$property, $building]) }}">
        &larr; Back to Units
    </a>

    <h2 class="fw-bold mt-3">Add Rental Unit</h2>
    <p class="text-muted">
        {{ $property->name }} / {{ $building->name }}
    </p>

    <form method="POST"
          action="{{ route('property-owner.units.store', [$property, $building]) }}">
        @csrf
        @include('property-owner.units._form')
    </form>
@endsection