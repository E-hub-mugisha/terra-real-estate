@extends('layouts.app')

@section('title','Design Categories')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Design Categories</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            + Add Category
        </button>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Categories Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editCategory{{ $category->id }}">
                                    Edit
                                </button>

                                <button class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteCategory{{ $category->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('admin.design-categories.update',$category) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Category Name</label>
                                                <input type="text"
                                                    name="name"
                                                    class="form-control"
                                                    value="{{ $category->name }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Delete Modal --}}
                        <div class="modal fade" id="deleteCategory{{ $category->id }}" tabindex="-1">
                            <div class="modal-dialog modal-sm">
                                <form method="POST" action="{{ route('admin.design-categories.destroy',$category) }}">
                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body text-center">
                                            Are you sure you want to delete
                                            <strong>{{ $category->name }}</strong>?
                                        </div>

                                        <div class="modal-footer justify-content-center">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.design-categories.store') }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Design Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text"
                            name="name"
                            class="form-control"
                            placeholder="e.g. Residential, Commercial"
                            required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
