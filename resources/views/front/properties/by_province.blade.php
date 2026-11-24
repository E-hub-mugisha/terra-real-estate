@extends('layouts.guest')
@section('title', 'Properties in ' . $province)

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($homes, $lands),
        'eyebrow'  => 'Browse by location',
        'title'    => 'Properties in ' . $province,
        'subtitle' => 'Houses and land currently available in ' . $province . '.',
    ])
@endsection
