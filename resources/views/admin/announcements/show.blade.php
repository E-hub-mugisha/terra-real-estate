@extends('layouts.app')
@section('title', 'Announcement Details')

@section('content')
    <div class="container py-4">
        <h1>{{ $announcement->title }}</h1>

        <div class="bg-white p-4 shadow-sm rounded mb-4">
            <p><strong>Content:</strong> {{ $announcement->content }}</p>
            <p><strong>Status:</strong> {{ $announcement->status }}</p>
            <p><strong>Created By:</strong> {{ $announcement->creator->name ?? 'N/A' }}</p>
            <p><strong>Created At:</strong> {{ $announcement->created_at->format('d M Y') }}</p>

            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
