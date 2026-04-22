@extends('layouts.app')
@section('title', 'Edit Advertisement')

@section('content')
<div class="container py-4">
    <h1>Edit Advertisement</h1>

    <form action="{{ route('admin.ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow-sm rounded">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $ad->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" rows="4" class="form-control">{{ $ad->content }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ $ad->price }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Image (optional)</label>
            @if($ad->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$ad->image) }}" alt="Current Image" class="img-thumbnail" style="max-width:150px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Advertisement</button>
        <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection