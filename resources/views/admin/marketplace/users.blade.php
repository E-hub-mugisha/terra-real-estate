@extends('layouts.app')
@section('title', 'Users')

@section('content')
@php $me = auth()->user(); $roleLabels = ['client' => 'Clients', 'owner' => 'Owners', 'agent' => 'Agents', 'partner' => 'Partners', 'staff' => 'Staff', 'admin' => 'Admins']; @endphp
<div class="tp-page-head">
    <div>
        <h1>Users</h1>
        <p>Everyone on Terra, by role. Change a role or deactivate an account; deactivated users are signed out.</p>
    </div>
    <a href="{{ route('admin.marketplace.export', 'users') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="download" /> Export CSV</a>
</div>

<div class="tp-toolbar">
    @include('admin.marketplace._tabs', ['param' => 'role', 'current' => request('role', ''), 'options' => ['' => 'All'] + $roleLabels, 'counts' => $roleCounts->all() + ['' => $roleCounts->sum()]])
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap">
        @if (request('role'))<input type="hidden" name="role" value="{{ request('role') }}">@endif
        <label class="tu-sr" for="uq">Search</label>
        <input id="uq" class="tu-input" name="q" value="{{ request('q') }}" placeholder="Name, email or phone" style="height:38px;min-width:220px">
        <label class="tu-check" style="margin:0"><input type="checkbox" name="state" value="inactive" @checked(request('state') === 'inactive') onchange="this.form.submit()"><span>Inactive only</span></label>
        <button class="tu-btn tu-btn-sm">Search</button>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>User</th><th>Phone</th><th>Role</th><th>Joined</th><th>Last seen</th><th>Status</th><th class="text-end">Access</th></tr></thead>
            <tbody>
                @forelse ($users as $u)
                    @php $locked = $u->id === $me->id || (in_array($u->role, ['admin', 'staff'], true) && $me->role !== 'admin'); @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <span class="tu-avatar">{{ strtoupper(mb_substr($u->name, 0, 1)) }}</span>
                                <span><strong style="color:var(--tu-ink);display:block">{{ $u->name }}</strong><span style="font-size:.76rem;color:var(--tu-muted)">{{ $u->email }}</span></span>
                            </div>
                        </td>
                        <td style="font-size:.84rem">{{ $u->phone ?: '—' }}</td>
                        <td>
                            @if ($locked)
                                <span class="tu-badge">{{ $u->roleLabel() }}</span>
                            @else
                                <form method="POST" action="{{ route('admin.marketplace.users.update', $u) }}">
                                    @csrf @method('PATCH')
                                    <label class="tu-sr" for="role{{ $u->id }}">Role</label>
                                    <select id="role{{ $u->id }}" name="role" class="tu-select" style="height:34px;padding:0 30px 0 10px;font-size:.8rem" onchange="if (confirm('Change role of {{ addslashes($u->name) }}?')) this.form.submit(); else this.value='{{ $u->role }}';">
                                        @foreach (\App\Models\User::ROLES as $r => $roleName)
                                            @if ($me->role === 'admin' || !in_array($r, ['admin', 'staff'], true))
                                                <option value="{{ $r }}" @selected($u->role === $r)>{{ $roleName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </form>
                            @endif
                        </td>
                        <td style="font-size:.82rem;color:var(--tu-muted)">{{ $u->created_at?->format('j M Y') }}</td>
                        <td style="font-size:.82rem;color:var(--tu-muted)">{{ $u->last_seen_at?->diffForHumans() ?? 'Never' }}</td>
                        <td>@include('room._status', ['status' => $u->is_active ? 'active' : 'suspended'])</td>
                        <td class="text-end">
                            @unless ($locked)
                                <form method="POST" action="{{ route('admin.marketplace.users.update', $u) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="is_active" value="{{ $u->is_active ? 0 : 1 }}">
                                    <button class="tu-btn tu-btn-sm {{ $u->is_active ? '' : 'tu-btn-primary' }}" @if ($u->is_active) onclick="return confirm('Deactivate {{ addslashes($u->name) }}? They will be signed out.')" @endif>{{ $u->is_active ? 'Deactivate' : 'Activate' }}</button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="tp-card-empty"><strong>No users found</strong>Try another search.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
