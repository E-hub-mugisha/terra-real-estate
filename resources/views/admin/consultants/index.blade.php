@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Consultants</h4>
    <a href="{{ route('admin.consultants.create') }}" class="btn btn-primary">Add Consultant</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Title</th>
            <th>Status</th>
            <th width="150">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($consultants as $consultant)
        <tr>
            <td>
                @if($consultant->photo)
                    <img src="{{ asset('storage/'.$consultant->photo) }}" width="60">
                @endif
            </td>
            <td>{{ $consultant->name }}</td>
            <td>{{ $consultant->title }}</td>
            <td>
                <span class="badge bg-{{ $consultant->is_active ? 'success' : 'secondary' }}">
                    {{ $consultant->is_active ? 'Active' : 'Inactive' }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.consultants.edit', $consultant) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.consultants.destroy', $consultant) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $consultants->links() }}
@endsection