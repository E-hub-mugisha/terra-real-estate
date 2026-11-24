@extends('layouts.guest')
@section('title', 'Rentals near ' . ($area ?: 'you'))

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($homes),
        'eyebrow'  => 'Rent',
        'crumb'    => 'Rentals near you',
        'title'    => $area ? 'Rentals in ' . $area : 'Rentals near you',
        'subtitle' => 'Homes for rent in and around the area you searched.',
    ])
@endsection
