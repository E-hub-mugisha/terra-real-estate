@extends('layouts.app')
@section('title', 'Services')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Services</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createServiceModal">
            + Add Service
        </button>
    </div>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $service->category->name }}</td>
                <td>{{ $service->subcategory?->name ?? '-' }}</td>
                <td>{{ $service->title }}</td>
                <td>{{ $service->description }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">Edit</button>

                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('services.update', $service->id) }}" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Category</label>
                                <select class="form-select categorySelect" data-target="#subcategorySelect{{ $service->id }}" name="service_category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $service->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Subcategory</label>
                                <select id="subcategorySelect{{ $service->id }}" name="service_subcategory_id" class="form-select" required>
                                    <option value="">Select Subcategory</option>
                                    @if($service->category_id)
                                    @foreach($service->category->subcategories as $sub)
                                    <option value="{{ $sub->id }}" {{ $service->subcategory_id == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="title" value="{{ $service->title }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" rows="5" class="form-control" required>{{ $service->description }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('services.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Category</label>
                    <select class="form-select categorySelect" data-target="#subcategorySelectCreate" name="service_category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Subcategory</label>
                    <select id="subcategorySelectCreate" name="service_subcategory_id" class="form-select" required>
                        <option value="">Select Subcategory</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" rows="5" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        function loadSubcategories(categorySelect, preselected = null) {
            const categoryId = categorySelect.value;
            const subcategorySelectId = categorySelect.dataset.target;
            const subcategorySelect = document.querySelector(subcategorySelectId);

            subcategorySelect.innerHTML = '<option value="">Loading...</option>';

            if (!categoryId) {
                subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                return;
            }

            fetch(`/subcategories/${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        subcategorySelect.innerHTML = '<option value="">No subcategories available</option>';
                    } else {
                        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                        data.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.text = sub.name;
                            if (preselected && preselected == sub.id) {
                                option.selected = true;
                            }
                            subcategorySelect.appendChild(option);
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                });
        }

        // Attach change event to all category selects
        document.querySelectorAll('.categorySelect').forEach(select => {
            select.addEventListener('change', function() {
                loadSubcategories(this);
            });
        });

        // For Edit modals: load subcategories when modal opens with preselected value
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('show.bs.modal', function() {
                const categorySelect = this.querySelector('.categorySelect');
                if (categorySelect && categorySelect.value) {
                    const subcategorySelect = document.querySelector(categorySelect.dataset.target);
                    const preselected = subcategorySelect.dataset.selected ?? null;
                    loadSubcategories(categorySelect, preselected);
                }
            });
        });

    });
</script>
@endsection