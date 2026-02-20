@extends('layouts.guest')
@section('title', 'Advertisements')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Advertisements</h1>

    @if($ads->count())
        <div class="row g-4">
            @foreach($ads as $ad)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        @if($ad->image)
                        <img src="{{ asset('storage/'.$ad->image) }}" class="card-img-top" alt="{{ $ad->title }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $ad->title }}</h5>
                            <p class="card-text text-truncate">{{ $ad->description }}</p>
                            <a href="{{ $ad->link }}" target="_blank" class="btn btn-primary mt-auto">Visit</a>
                        </div>
                        <div class="card-footer text-muted">
                            Posted on {{ $ad->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $ads->links() }}
        </div>
    @else
        <div class="alert alert-info">No advertisements available at the moment.</div>
    @endif
</div>
@endsection