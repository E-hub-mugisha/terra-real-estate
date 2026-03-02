@extends('layouts.app')

@section('title','Add Architectural Design')

@section('content')
<div class="container">

    <h1 class="mb-4">Add Architectural Design</h1>

    <form action="{{ route('admin.architectural-designs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Owner (optional)</label>
                    <select name="user_id" class="form-select">
                        <option value="">Admin Upload</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Service</label>
                    <select class="form-select" name="service_id" required>
                        <option value="">Select service</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}">
                            {{ $service->title }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Design File (PDF / ZIP / DWG) *</label>
                    <input type="file" name="design_file" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Preview Image</label>
                    <input type="file" name="preview_image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" step="0.01" class="form-control" value="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="featured">
                    <label class="form-check-label">Featured</label>
                </div>

            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary">Save Design</button>
                <a href="{{ route('admin.architectural-designs.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection