@extends('layouts.guest')
@section('title', 'Architectural designs')

@section('content')
    @php
        $categoryFilter = '<select class="tu-select" name="category" aria-label="Category" onchange="this.form.submit()">'
            . '<option value="">All categories</option>'
            . $categories->map(fn ($c) => '<option value="' . $c->id . '"' . (request('category') == $c->id ? ' selected' : '') . '>' . e($c->name) . '</option>')->implode('')
            . '</select>';
    @endphp
    @include('front.partials.listing-page', [
        'items'        => \App\Support\Listing::collect($designs->getCollection()),
        'paginator'    => $designs,
        'serverSearch' => true,
        'filters'      => $categoryFilter,
        'eyebrow'      => 'Designs',
        'title'        => 'Architectural designs',
        'subtitle'     => 'Ready-made house plans from Rwandan architects — download free designs or buy complete drawing sets.',
    ])
@endsection
