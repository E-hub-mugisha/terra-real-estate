@extends('layouts.guest')
@section('title', 'Apartments for rent')

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($homes),
        'eyebrow'  => 'Rent',
        'title'    => 'Apartments for rent',
        'subtitle' => 'Flats and serviced apartments close to work, schools and transport.',
    ])
@endsection
