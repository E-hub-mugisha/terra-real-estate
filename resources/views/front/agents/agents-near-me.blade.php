@extends('layouts.guest')
@section('title', 'Agents near ' . ($area ?: 'you'))

@section('content')
    @include('front.partials.agents-directory', [
        'title'       => $area ? 'Agents in ' . $area : 'Agents near you',
        'subtitle'    => 'Verified agents with offices in or around the area you searched.',
        'searchValue' => $area,
    ])
@endsection
