@extends('layouts.app')
@section('title', 'Announcements')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Announcements</h1>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">Add Announcement</a>
    </div>

    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Created By</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($announcements as $announcement)
            <tr>
                <td>{{ $announcement->title }}</td>
                <td class="text-capitalize">{{ $announcement->status }}</td>
                <td>{{ $announcement->creator->name ?? 'N/A' }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this announcement?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $announcements->links() }}
    </div>
</div>
@endsection