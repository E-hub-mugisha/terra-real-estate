@extends('layouts.guest')
@section('title', 'Announcements')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Announcements</h1>

        @if ($announcements->count())
            <div class="list-group">
                @foreach ($announcements as $announcement)
                    <a href="{{ route('front.announcements.show', $announcement->slug) }}"
                        class="list-group-item list-group-item-action shadow-sm mb-2">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $announcement->title }}</h5>
                            <small>{{ $announcement->created_at->format('d M Y') }}</small>
                        </div>
                        <p class="mb-1 text-truncate">{{ $announcement->content }}</p>
                    </a>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $announcements->links() }}
            </div>
        @else
            <div class="alert alert-info">No announcements available at the moment.</div>
        @endif
    </div>
@endsection
