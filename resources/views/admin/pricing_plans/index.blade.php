@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>Pricing Plans</h4>

        <a href="{{ route('admin.pricing-plans.create') }}" class="btn btn-primary">
            Add Plan
        </a>
    </div>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Name</th>
                <th>Price / Day</th>
                <th>Featured</th>
                <th>Priority</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach($plans as $plan)

            <tr>
                <td>{{ $plan->name }}</td>
                <td>${{ $plan->price_per_day }}</td>

                <td>{{ $plan->featured ? 'Yes' : 'No' }}</td>
                <td>{{ $plan->priority_listing ? 'Yes' : 'No' }}</td>

                <td>
                    {{ $plan->active ? 'Active' : 'Disabled' }}
                </td>

                <td>

                    <a href="{{ route('admin.pricing-plans.edit',$plan->id) }}"
                        class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form method="POST"
                        action="{{ route('admin.pricing-plans.destroy',$plan->id) }}"
                        style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    {{ $plans->links() }}

</div>

@endsection