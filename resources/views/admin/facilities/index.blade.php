@extends('layouts.app')
@section('title', 'Facilities')
@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-4">
        <h4>Facilities</h4>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFacility">
            Add Facility
        </button>
    </div>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th width="200">Actions</th>
            </tr>
        </thead>

        <tbody>

            @foreach($facilities as $facility)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $facility->name }}</td>
                <td>{{ $facility->slug }}</td>

                <td>

                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editFacility{{ $facility->id }}">
                        Edit
                    </button>

                    <button class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteFacility{{ $facility->id }}">
                        Delete
                    </button>

                </td>
            </tr>


            {{-- Edit Modal --}}
            <div class="modal fade" id="editFacility{{ $facility->id }}">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.facilities.update',$facility->id) }}" class="modal-content">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Facility</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <label>Name</label>
                            <input type="text"
                                name="name"
                                value="{{ $facility->name }}"
                                class="form-control"
                                required>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button class="btn btn-primary">
                                Update
                            </button>

                        </div>

                    </form>
                </div>
            </div>


            {{-- Delete Modal --}}
            <div class="modal fade" id="deleteFacility{{ $facility->id }}">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.facilities.destroy',$facility->id) }}" class="modal-content">

                        @csrf
                        @method('DELETE')

                        <div class="modal-header">
                            <h5>Delete Facility</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            Are you sure you want to delete
                            <strong>{{ $facility->name }}</strong> ?

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button class="btn btn-danger">
                                Delete
                            </button>

                        </div>

                    </form>
                </div>
            </div>

            @endforeach

        </tbody>
    </table>

</div>



{{-- Create Modal --}}
<div class="modal fade" id="createFacility">
    <div class="modal-dialog">

        <form method="POST" action="{{ route('admin.facilities.store') }}" class="modal-content">

            @csrf

            <div class="modal-header">
                <h5>Add Facility</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <label>Name</label>
                <input type="text"
                    name="name"
                    class="form-control"
                    placeholder="Gym, Pool, Parking"
                    required>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-success">
                    Create
                </button>

            </div>

        </form>

    </div>
</div>

@endsection