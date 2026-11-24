{{-- Coloured status badge. Expects $status --}}
@php
    $tone = match ($status) {
        'new', 'requested', 'pending', 'countered', 'contacted' => 'warn',
        'confirmed', 'accepted', 'replied', 'approved', 'paid', 'completed', 'converted', 'live', 'verified', 'qualified', 'active' => 'success',
        'declined', 'rejected', 'cancelled', 'lost', 'suspended' => 'danger',
        default => '',
    };
    $labels = ['live' => 'Live', 'pending' => 'Pending', 'requested' => 'Awaiting reply', 'countered' => 'Counter offer', 'new' => 'New'];
@endphp
<span class="tu-badge {{ $tone ? 'tu-badge-' . $tone : '' }}">{{ $labels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}</span>
