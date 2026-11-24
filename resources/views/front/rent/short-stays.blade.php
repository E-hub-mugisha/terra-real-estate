@extends('layouts.guest')
@section('title', 'Short stays')

@section('content')
    @include('front.partials.listing-page', [
        'items'    => \App\Support\Listing::collect($homes),
        'eyebrow'  => 'Rent',
        'title'    => 'Short stays',
        'subtitle' => 'Furnished homes for a few nights, weeks or months.',
    ])
@endsection
