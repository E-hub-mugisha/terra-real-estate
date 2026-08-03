{{-- resources/views/admin/material-products/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div data-h-scope="material-products">
@include('admin.material-products._styles')

<div class="mp-header">
    <h1 class="mp-title">Edit Product</h1>
    <div class="mp-actions">
        <a href="{{ route('admin.materials-products.show', $product) }}" class="mp-btn mp-btn-outline">View</a>
        <a href="{{ route('admin.materials-products.index') }}" class="mp-btn mp-btn-ghost">Back to Products</a>
    </div>
</div>

@if (session('success'))
    <div class="mp-alert mp-alert-success">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="mp-alert mp-alert-error">Please fix the errors below and try again.</div>
@endif

<form method="POST" action="{{ route('admin.materials-products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('admin.material-products._form', ['product' => $product])

    <div class="mp-form-actions">
        <a href="{{ route('admin.materials-products.index') }}" class="mp-btn mp-btn-ghost">Cancel</a>
        <button type="submit" class="mp-btn">Save Changes</button>
    </div>
</form>
</div>
@endsection