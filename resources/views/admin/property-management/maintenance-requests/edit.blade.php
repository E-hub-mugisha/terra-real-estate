@extends('layouts.property-management.app')

@section('title', 'Edit Maintenance Request')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <h1 class="h3 mb-1">Edit maintenance request</h1>
        <p class="text-muted mb-0">
            {{ $maintenanceRequest->request_number }}
        </p>
    </div>

    <form method="POST"
          action="{{ route('admin.property-management.maintenance-requests.update', $maintenanceRequest) }}">
        @csrf
        @method('PUT')

        @include('admin.property-management.maintenance-requests._form')
    </form>
</div>
@endsection