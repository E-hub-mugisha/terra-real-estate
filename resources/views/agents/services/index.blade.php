@extends('layouts.agents')
@section('title', 'Services')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Services</h2>
        <a href="{{ route('agents.services.edit') }}" class="btn btn-primary">
            + Add Service
        </a>
    </div>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $service->category->name ?? '-' }}</td>
                <td>{{ $service->subcategory?->name ?? '-' }}</td>
                <td>{{ $service->title ?? '-' }}</td>
                <td>{{ $service->description ?? '-' }}</td>
                <td>
                
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection