@extends('layouts.propertyOwner.app')

@section('title', 'Add Floor')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a
            href="{{ route('property-owner.floors.index', [$property, $building]) }}"
            class="text-decoration-none"
        >
            <i class="bi bi-arrow-left"></i> Back to Floors
        </a>

        <h2 class="mt-3 mb-1">Add Floor</h2>

        <p class="text-muted mb-0">
            Add a floor to {{ $building->name }}.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            Please correct the errors below.
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form
                method="POST"
                action="{{ route('property-owner.floors.store', [$property, $building]) }}"
            >
                @include('property-owner.floors._form', [
                    'submitLabel' => 'Create Floor',
                ])
            </form>
        </div>
    </div>
</div>
@endsection