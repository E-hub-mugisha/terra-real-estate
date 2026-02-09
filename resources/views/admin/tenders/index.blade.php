@extends('layouts.app')
@section('title', 'Tenders Lists')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">Hover Effect</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Datatables</a></li>
        <li class="breadcrumb-item active">Hover Effect</li>
    </ul>
</div>
<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">Hover Effect</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="basicTable" class="table table-hover text-nowrap">
                <thead>
                    <tr class="bg-light">
                        <th>Title</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Budget</th>
                        <th>Submission Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenders as $tender)
                    <tr>
                        <td>{{ $tender->title }}</td>
                        <td>{{ $tender->description }}</td>
                        <td>{{ $tender->location }}</td>
                        <td>{{ $tender->budget }}</td>
                        <td>{{ $tender->submission_deadline }}</td>
                        <td>
                            <a href="{{ route('admin.tenders.show', $tender) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.tenders.edit', $tender) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.tenders.destroy', $tender) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Budget</th>
                        <th>Submission Deadline</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection