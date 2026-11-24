@extends('layouts.guest')
@section('title', 'All listings')

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($homes, $lands, $designs),
        'eyebrow'  => 'Marketplace',
        'title'    => 'All listings',
        'subtitle' => 'Every house, plot and architectural design on Terra in one place.',
    ])
@endsection
