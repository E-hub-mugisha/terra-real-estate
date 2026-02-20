@extends('layouts.app')
@section('title', 'Add Advertisement')

@section('content')
<div class="container py-4">
    <h1>Add Advertisement</h1>

    <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow-sm rounded">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" rows="4" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Advertisement</button>
        <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection