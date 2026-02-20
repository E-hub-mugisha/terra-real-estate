@extends('layouts.app')
@section('title', 'Add Announcement')

@section('content')
    <div class="container py-4">
        <h1>Add Announcement</h1>

        <form action="{{ route('admin.announcements.store') }}" method="POST" class="bg-white p-4 shadow-sm rounded">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" rows="5" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending">Pending</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save Announcement</button>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
