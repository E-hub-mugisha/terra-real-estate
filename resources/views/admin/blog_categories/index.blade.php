@extends('layouts.app')
@section('title', 'Blog Categories')
@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>Blog Categories</h4>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            Add Blog Category
        </button>
    </div>


    <table class="table table-bordered">

        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th width="150">Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach($categories as $category)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $category->name }}</td>


                <td>

                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">
                        Edit
                    </button>

                    <form action="{{ route('admin.blog-categories.destroy',$category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>

                </td>
            </tr>


            {{-- EDIT MODAL --}}
            <div class="modal fade" id="editModal{{ $category->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="{{ route('admin.blog-categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5>Edit Blog Category</h5>
                            </div>

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $category->name }}" class="form-control">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary">Update</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            @endforeach

        </tbody>
    </table>

</div>


{{-- CREATE MODAL --}}
<div class="modal fade" id="createModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{ route('admin.blog-categories.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-header">
                    <h5>Add Blog Category</h5>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection