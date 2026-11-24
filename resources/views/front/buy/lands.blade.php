@extends('layouts.guest')
@section('title', 'Land for sale')

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($lands),
        'eyebrow'  => 'Buy',
        'title'    => 'Land for sale',
        'subtitle' => 'Residential, commercial and agricultural plots with UPI details from verified agents.',
    ])
@endsection
