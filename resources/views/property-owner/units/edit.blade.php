@extends('layouts.propertyOwner.app')

@section('title', 'Edit Rental Unit')

@section('content')
    <a href="{{ route('property-owner.units.index', [$property, $building]) }}">
        &larr; Back to Units
    </a>

    <h2 class="fw-bold mt-3">Edit Unit {{ $unit->unit_number }}</h2>
    <p class="text-muted">{{ $property->name }} / {{ $building->name }}</p>

    <form method="POST"
          action="{{ route('property-owner.units.update', [$property, $building, $unit]) }}">
        @csrf
        @method('PUT')

        @include('property-owner.units._form', ['unit' => $unit])
    </form>
@endsection