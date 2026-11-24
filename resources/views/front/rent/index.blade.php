@extends('layouts.guest')
@section('title', 'Land for rent')

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($lands),
        'eyebrow'  => 'Rent',
        'title'    => 'Land for rent',
        'subtitle' => 'Lease plots for farming, storage or business.',
    ])
@endsection
