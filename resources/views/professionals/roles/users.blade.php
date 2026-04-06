@extends('layouts.app')
@section('title', 'Assign Roles to Users')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-1" style="color:var(--terra-navy)">User Role Assignment</h5>
            <p class="text-muted mb-0" style="font-size:.82rem">Assign department roles to team members</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">← Back to Roles</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" style="font-size:.84rem">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">All Users</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:.84rem">
                    <thead>
                        <tr style="background:#F7F5F2;border-bottom:2px solid #E8E3DC">
                            <th class="px-4 py-3 fw-semibold" style="color:var(--terra-navy)">User</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Current Role</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Permissions</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Assign Role</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        @php $userRole = $user->roles->first(); @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-semibold" style="color:var(--terra-navy)">{{ $user->name }}</div>
                                <div style="font-size:.75rem;color:#7A736B">{{ $user->email }}</div>
                            </td>

                            <td class="py-3">
                                @if($userRole)
                                <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:{{ $userRole->color }}18;color:{{ $userRole->color }}">
                                    <span style="width:6px;height:6px;border-radius:50%;background:{{ $userRole->color }};flex-shrink:0;display:inline-block"></span>
                                    {{ $userRole->label }}
                                </span>
                                @else
                                <span style="font-size:.75rem;color:#B0A89E;font-style:italic">No role</span>
                                @endif
                            </td>

                            <td class="py-3">
                                <div class="d-flex flex-wrap gap-1">
                                    @if($userRole)
                                        @foreach($userRole->permissions->pluck('name') as $perm)
                                        <span style="padding:2px 7px;border-radius:20px;font-size:.65rem;font-weight:700;background:rgba(25,38,93,.06);color:#19265d">{{ ucfirst($perm) }}</span>
                                        @endforeach
                                    @else
                                    <span style="font-size:.72rem;color:#B0A89E">—</span>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3">
                                <form method="POST" action="{{ route('admin.roles.assign', $user) }}" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    <select name="role_id" class="form-select form-select-sm" style="max-width:180px;font-size:.8rem">
                                        <option value="">— Select Role —</option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $userRole?->id === $role->id ? 'selected' : '' }}>
                                            {{ $role->label }} ({{ $role->department }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm text-white px-3" style="background:var(--terra-navy);border:none;font-size:.78rem">Assign</button>
                                </form>
                            </td>

                            <td class="py-3">
                                @if($userRole)
                                <form method="POST" action="{{ route('admin.roles.remove', $user) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size:.75rem"
                                        onclick="return confirm('Remove role from {{ $user->name }}?')">
                                        Remove
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>

@endsection