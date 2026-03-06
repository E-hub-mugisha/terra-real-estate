@extends('layouts.app')
@section('title', 'Partners')
@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>Partners</h4>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            Add Partner
        </button>
    </div>


    <table class="table table-bordered">

        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Link</th>
                <th width="150">Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach($partners as $partner)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    @if($partner->image)
                    <img src="{{ asset('storage/'.$partner->image) }}" width="60">
                    @endif
                </td>

                <td>{{ $partner->name }}</td>

                <td>
                    <a href="{{ $partner->link }}" target="_blank">{{ $partner->link }}</a>
                </td>

                <td>

                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $partner->id }}">
                        Edit
                    </button>

                    <form action="{{ route('admin.partners.destroy',$partner->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>

                </td>
            </tr>


            {{-- EDIT MODAL --}}
            <div class="modal fade" id="editModal{{ $partner->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="{{ route('admin.partners.update',$partner->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5>Edit Partner</h5>
                            </div>

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $partner->name }}" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Link</label>
                                    <input type="text" name="link" value="{{ $partner->link }}" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control">
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

            <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-header">
                    <h5>Add Partner</h5>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
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