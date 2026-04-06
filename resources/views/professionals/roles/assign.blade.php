@extends('layouts.app')
@section('title', 'Assign Role — ' . $user->name)

@section('content')
<div class="container py-5" style="max-width:680px">

    {{-- Context banner shown only when arriving from staff creation --}}
    @if(session('new_staff'))
    <div class="d-flex align-items-start gap-3 p-4 mb-4 rounded-3" style="background:rgba(25,38,93,.05);border:1px solid rgba(25,38,93,.12)">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#19265d" style="flex-shrink:0;margin-top:2px">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
        </svg>
        <div>
            <div class="fw-semibold mb-1" style="color:#19265d;font-size:.88rem">One more step</div>
            <div style="font-size:.82rem;color:#7A736B;line-height:1.6">
                <strong>{{ $user->name }}</strong> has been created. Assign a role below to control what they can access in the platform.
            </div>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" style="font-size:.84rem">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show mb-4" style="font-size:.84rem">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- User card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4 d-flex align-items-center gap-3">
            <div style="width:48px;height:48px;border-radius:50%;background:#19265d;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:700;color:#fff;flex-shrink:0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="fw-bold" style="color:#19265d">{{ $user->name }}</div>
                <div style="font-size:.78rem;color:#7A736B">{{ $user->email }}</div>
            </div>
            @if($currentRole)
            <span class="ms-auto" style="padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:{{ $currentRole->color }}18;color:{{ $currentRole->color }}">
                {{ $currentRole->label }}
            </span>
            @else
            <span class="ms-auto" style="padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:600;background:#F5F3F0;color:#B0A89E">
                No role assigned
            </span>
            @endif
        </div>
    </div>

    {{-- Role selection --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold mb-0" style="color:#19265d;font-size:.88rem">Select a Role</h6>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.roles.assign', $user) }}">
                @csrf

                <div class="d-flex flex-column gap-3 mb-4">
                    @foreach($roles as $role)
                    <label style="display:flex;align-items:flex-start;gap:14px;padding:14px 16px;border:2px solid {{ $currentRole?->id === $role->id ? $role->color : '#E8E3DC' }};border-radius:10px;cursor:pointer;transition:border-color .18s;background:{{ $currentRole?->id === $role->id ? $role->color.'0d' : '#fff' }}">
                        <input type="radio" name="role_id" value="{{ $role->id }}"
                            {{ $currentRole?->id === $role->id ? 'checked' : '' }}
                            style="margin-top:3px;accent-color:{{ $role->color }}"
                            onchange="this.closest('form').querySelectorAll('label').forEach(l=>l.style.borderColor='#E8E3DC'); this.closest('label').style.borderColor='{{ $role->color }}'">
                        <div style="flex:1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $role->color }};flex-shrink:0;display:inline-block"></span>
                                <span class="fw-semibold" style="color:#19265d;font-size:.88rem">{{ $role->label }}</span>
                                <span style="font-size:.7rem;color:#7A736B">· {{ $role->department }}</span>
                            </div>
                            @if($role->description)
                            <div style="font-size:.78rem;color:#7A736B;line-height:1.5;margin-bottom:8px">{{ $role->description }}</div>
                            @endif
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($role->permissions as $perm)
                                <span style="padding:2px 7px;border-radius:20px;font-size:.65rem;font-weight:700;background:{{ $role->color }}14;color:{{ $role->color }}">{{ ucfirst($perm->name) }}</span>
                                @endforeach
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn px-4 fw-semibold text-white" style="background:#19265d;border:none">
                        Assign Role & Continue →
                    </button>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
                        Skip for now
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection