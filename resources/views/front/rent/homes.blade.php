@extends('layouts.guest')
@section('title', 'Houses for rent')

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($homes),
        'eyebrow'  => 'Rent',
        'title'    => 'Houses for rent',
        'subtitle' => 'Long-term rentals for families and professionals.',
    ])
@endsection
