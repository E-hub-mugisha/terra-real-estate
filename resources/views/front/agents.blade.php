@extends('layouts.guest')
@section('title', 'Find an agent')

@section('content')
    @include('front.partials.agents-directory', [
        'title'       => request('q') ? 'Agents matching “' . request('q') . '”' : 'Find a trusted agent',
        'subtitle'    => 'Every Terra agent is reviewed by our team. Pick one who knows your area.',
        'searchValue' => request('q'),
    ])
@endsection
