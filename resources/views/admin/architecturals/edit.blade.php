@extends('layouts.app')

@section('title','Edit Architectural Design')

@section('content')
<div class="container">

    <h1 class="mb-4">Edit Architectural Design</h1>

    <form action="{{ route('admin.architectural-designs.update',$architecturalDesign) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="card shadow">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" value="{{ $architecturalDesign->title }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Owner</label>
                    <select name="user_id" class="form-select">
                        <option value="">Admin Upload</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected($architecturalDesign->user_id == $user->id)>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($architecturalDesign->category_id == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ $architecturalDesign->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Replace Design File</label>
                    <input type="file" name="design_file" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Replace Preview Image</label>
                    <input type="file" name="preview_image" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" value="{{ $architecturalDesign->price }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        @foreach(['pending','approved','rejected'] as $status)
                            <option value="{{ $status }}" @selected($architecturalDesign->status == $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="featured" class="form-check-input" @checked($architecturalDesign->featured)>
                    <label class="form-check-label">Featured</label>
                </div>

            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.architectural-designs.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
@endsection
