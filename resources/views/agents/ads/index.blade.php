@extends('layouts.app')
@section('title', 'Advertisements')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Advertisements</h1>
        <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">Add Advertisement</a>
    </div>

    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Status</th>
                <th>Created By</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ads as $ad)
            <tr>
                <td>{{ $ad->title }}</td>
                <td>${{ number_format($ad->price, 2) }}</td>
                <td class="text-capitalize">{{ $ad->status }}</td>
                <td>{{ $ad->creator->name ?? 'N/A' }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.ads.show', $ad->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('admin.ads.edit', $ad->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.ads.destroy', $ad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this advertisement?')">
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
        {{ $ads->links() }}
    </div>
</div>
@endsection