@extends('layouts.guest')
@section('title', 'Houses for sale')

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($homes),
        'eyebrow'  => 'Buy',
        'title'    => 'Houses for sale',
        'subtitle' => 'Verified homes across Rwanda — from city apartments to family villas.',
    ])
@endsection
