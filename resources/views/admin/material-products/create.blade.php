{{-- resources/views/admin/material-products/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div data-h-scope="material-products">
@include('admin.material-products._styles')

<div class="mp-header">
    <h1 class="mp-title">Add Product</h1>
    <a href="{{ route('admin.materials-products.index') }}" class="mp-btn mp-btn-ghost">Back to Products</a>
</div>

@if ($errors->any())
    <div class="mp-alert mp-alert-error">Please fix the errors below and try again.</div>
@endif

<form method="POST" action="{{ route('admin.materials-products.store') }}" enctype="multipart/form-data">
    @csrf

    @include('admin.material-products._form', ['product' => $product])

    <div class="mp-form-actions">
        <a href="{{ route('admin.materials-products.index') }}" class="mp-btn mp-btn-ghost">Cancel</a>
        <button type="submit" class="mp-btn">Save Product</button>
    </div>
</form>
</div>
@endsection