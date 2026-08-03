@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Edit Product</h3>

    <form method="POST" action="{{ route('dashboard.products.update', $product) }}" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        @include('dashboard.products._form', ['product' => $product])
        <button class="btn btn-success mt-3">Save Changes</button>
    </form>
</div>
@endsection