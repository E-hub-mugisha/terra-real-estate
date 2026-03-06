@extends('layouts.app')
@section('title', 'News')
@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-4">
        <h3>Blog Posts</h3>

        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
            + Create Blog
        </a>
    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($blogs as $blog)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if($blog->featured_image)
                            <img src="{{ asset('storage/'.$blog->featured_image) }}" width="60">
                            @endif
                        </td>

                        <td>{{ $blog->title }}</td>

                        <td>{{ $blog->category->name ?? '-' }}</td>

                        <td>{{ $blog->author->name ?? '-' }}</td>

                        <td>
                            @if($blog->is_published)
                            <span class="badge bg-success">Published</span>
                            @else
                            <span class="badge bg-warning">Draft</span>
                            @endif
                        </td>

                        <td>{{ $blog->views }}</td>

                        <td>

                            <a href="{{ route('admin.blogs.show',$blog) }}" class="btn btn-info btn-sm">
                                View
                            </a>

                            <a href="{{ route('admin.blogs.edit',$blog) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.blogs.destroy',$blog) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $blogs->links() }}

        </div>
    </div>

</div>

@endsection