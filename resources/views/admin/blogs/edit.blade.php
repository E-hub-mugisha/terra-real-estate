@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Edit Blog</h3>

    <div class="card">

        <div class="card-body">

            <form action="{{ route('admin.blogs.update',$blog) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $blog->title }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Category</label>
                    <select name="blog_category_id" class="form-control">

                        @foreach($categories as $category)

                        <option value="{{ $category->id }}"
                            @if($blog->blog_category_id == $category->id) selected @endif>

                            {{ $category->name }}

                        </option>

                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label>Featured Image</label>

                    @if($blog->featured_image)
                    <br>
                    <img src="{{ asset('storage/'.$blog->featured_image) }}" width="120">
                    @endif

                    <input type="file" name="featured_image" class="form-control mt-2">
                </div>

                <div class="mb-3">
                    <label>Content</label>

                    <textarea name="content" id="editor" class="form-control">
                        {!! $blog->content !!}
                    </textarea>

                </div>

                <div class="form-check mb-3">

                    <input type="checkbox" name="is_published"
                        class="form-check-input"
                        {{ $blog->is_published ? 'checked' : '' }}>

                    <label class="form-check-label">
                        Published
                    </label>

                </div>

                <button class="btn btn-primary">
                    Update Blog
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