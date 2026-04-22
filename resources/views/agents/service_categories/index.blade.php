@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Service Categories</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategory">
            + Add Category
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->description }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                        data-bs-target="#edit{{ $cat->id }}">Edit</button>

                    <form method="POST" action="{{ route('service-categories.destroy', $cat) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Del</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="edit{{ $cat->id }}">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('service-categories.update', $cat) }}" class="modal-content">
                        @csrf @method('PUT')
                        <div class="modal-header"><h5>Edit Category</h5></div>
                        <div class="modal-body">
                            <input type="text" name="name" value="{{ $cat->name }}" class="form-control" required>
                            <textarea name="description" rows="5" class="form-control" required>{{ $cat->description }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createCategory">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('service-categories.store') }}" class="modal-content">
            @csrf
            <div class="modal-header"><h5>Add Category</h5></div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control" placeholder="Category name" required>
                <textarea name="description" rows="5" class="form-control" required></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection