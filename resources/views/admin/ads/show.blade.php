@extends('layouts.app')
@section('title', 'Advertisement Details')

@section('content')
<div class="container py-4">
    <h1>{{ $ad->title }}</h1>

    <div class="bg-white p-4 shadow-sm rounded mb-4">
        @if($ad->image)
            <img src="{{ asset('storage/'.$ad->image) }}" alt="{{ $ad->title }}" class="img-fluid mb-3" style="max-width:300px;">
        @endif

        <p><strong>Content:</strong> {{ $ad->content }}</p>
        <p><strong>Price:</strong> ${{ number_format($ad->price,2) }}</p>
        <p><strong>Status:</strong> {{ $ad->status }}</p>
        <p><strong>Created By:</strong> {{ $ad->creator->name ?? 'N/A' }}</p>
        <p><strong>Created At:</strong> {{ $ad->created_at->format('d M Y') }}</p>

        <a href="{{ route('admin.ads.edit', $ad->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection