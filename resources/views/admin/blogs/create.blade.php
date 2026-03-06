@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Create Blog</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Category</label>
                    <select name="blog_category_id" class="form-control">
                        <option value="">Select Category</option>

                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label>Featured Image</label>
                    <input type="file" name="featured_image" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Content</label>

                    <textarea name="content" id="editor" class="form-control"></textarea>

                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_published" class="form-check-input">
                    <label class="form-check-label">Publish</label>
                </div>

                <button class="btn btn-primary">
                    Create Blog
                </button>

            </form>

        </div>
    </div>

</div>

@endsection


@section('scripts')

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection