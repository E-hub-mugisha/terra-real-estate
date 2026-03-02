@extends('layouts.app')

@section('title','Design Details')

@section('content')
<div class="container">

    <h1 class="mb-4">{{ $architecturalDesign->title }}</h1>

    <div class="card shadow">
        <div class="card-body">

            <p><strong>Category:</strong> {{ $architecturalDesign->category->name }}</p>
            <p><strong>Author:</strong> {{ $architecturalDesign->user->name ?? 'Admin' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($architecturalDesign->status) }}</p>
            <p><strong>Price:</strong> {{ $architecturalDesign->is_free ? 'Free' : '$'.$architecturalDesign->price }}</p>
            <p><strong>Downloads:</strong> {{ $architecturalDesign->download_count }}</p>

            <hr>

            <p>{{ $architecturalDesign->description }}</p>

            @if($architecturalDesign->preview_image)
                <img src="{{ asset('storage/'.$architecturalDesign->preview_image) }}" class="img-fluid mb-3">
            @endif

            <a href="{{ asset('storage/'.$architecturalDesign->design_file) }}" class="btn btn-success" target="_blank">
                Download Design File
            </a>

        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.architectural-designs.edit',$architecturalDesign) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.architectural-designs.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
