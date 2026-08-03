@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Add Product</h3>

    <form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @include('dashboard.products._form', ['product' => null, 'subcategories' => collect()])
        <button class="btn btn-success mt-3">Create Product</button>
    </form>
</div>
@endsection