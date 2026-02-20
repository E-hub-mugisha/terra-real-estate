@extends('layouts.app')
@section('title', 'Edit Announcement')

@section('content')
    <div class="container py-4">
        <h1>Edit Announcement</h1>

        <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST"
            class="bg-white p-4 shadow-sm rounded">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $announcement->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" rows="5" class="form-control" required>{{ $announcement->content }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending" {{ $announcement->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="published" {{ $announcement->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Announcement</button>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
