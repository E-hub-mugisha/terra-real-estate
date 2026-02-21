@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Service Subcategories</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSub">
            + Add Subcategory
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Subcategory</th>
                <th>Category</th>
                <th>Description</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $sub)
            <tr>
                <td>{{ $sub->name }}</td>
                <td>{{ $sub->category->name }}</td>
                <td>{{ $sub->description }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                        data-bs-target="#edit{{ $sub->id }}">Edit</button>

                    <form method="POST" action="{{ route('service-subcategories.destroy', $sub) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Del</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="edit{{ $sub->id }}">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('service-subcategories.update', $sub) }}" class="modal-content">
                        @csrf @method('PUT')
                        <div class="modal-header"><h5>Edit Subcategory</h5></div>
                        <div class="modal-body">
                            <select name="service_category_id" class="form-select mb-2">
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected($cat->id == $sub->service_category_id)>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                            <input type="name" name="name" value="{{ $sub->name }}" class="form-control" required>
                            <textarea name="description" rows="5" class="form-control" required>{{ $sub->description }}</textarea>
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
<div class="modal fade" id="createSub">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('service-subcategories.store') }}" class="modal-content">
            @csrf
            <div class="modal-header"><h5>Add Subcategory</h5></div>
            <div class="modal-body">
                <select name="service_category_id" class="form-select mb-2" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <input name="name" class="form-control" placeholder="Subcategory name" required>
                <textarea name="description" rows="5" class="form-control" required></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection