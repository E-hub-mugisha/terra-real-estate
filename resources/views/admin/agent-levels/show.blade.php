@extends('layouts.app')

@section('title', 'View Agent Level')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:var(--terra-navy)">
                {{ $agentLevel->badge_emoji }} {{ $agentLevel->label }}
            </h1>
            <p class="text-muted mb-0" style="font-size:.9rem">Agent level details and commission bonus rate</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.agent-levels.edit', $agentLevel) }}"
                class="btn btn-sm fw-semibold text-white"
                style="background:var(--terra-orange);border:none">
                Edit Level
            </a>
            <a href="{{ route('admin.agent-levels.index') }}"
                class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-lg-7">

            {{-- Details --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Level Information</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="width:200px;font-size:.85rem">Level Name</td>
                                <td class="py-3">
                                    <span style="display:inline-flex;align-items:center;gap:6px;
                                        padding:6px 16px;border-radius:20px;font-weight:700;font-size:.88rem;
                                        {{ $agentLevel->badge_style }}">
                                        {{ $agentLevel->badge_emoji }} {{ ucfirst($agentLevel->level_name) }}
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Display Label</td>
                                <td class="py-3 fw-semibold" style="color:var(--terra-navy)">{{ $agentLevel->label }}</td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Badge Color</td>
                                <td class="py-3">
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <div style="width:28px;height:28px;border-radius:6px;
                                            background:{{ $agentLevel->badge_color }};
                                            border:1px solid rgba(0,0,0,.1)"></div>
                                        <span style="font-family:monospace;font-size:.88rem">{{ $agentLevel->badge_color }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Commission Bonus Rate</td>
                                <td class="py-3">
                                    <span class="fw-bold" style="font-size:1.2rem;color:var(--terra-navy)">
                                        {{ $agentLevel->commission_rate }}%
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Agents at this Level</td>
                                <td class="py-3">
                                    <span class="fw-bold" style="color:var(--terra-navy)">{{ $agentsCount }}</span>
                                    <span class="text-muted" style="font-size:.85rem"> agents currently assigned</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Requirements</td>
                                <td class="py-3" style="font-size:.88rem;color:var(--terra-muted)">
                                    {{ $agentLevel->requirements ?? '—' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Example payouts --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Example Bonus Payouts</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr style="background:var(--terra-cream)">
                                <th class="ps-4 py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Net Listing Amount</th>
                                <th class="py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Bonus Payout</th>
                                <th class="py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Total Agent Earns</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach([50000, 100000, 250000, 500000, 1000000] as $amount)
                            <tr style="border-bottom:1px solid #f5f5f5">
                                <td class="ps-4 py-3 fw-semibold" style="color:var(--terra-navy)">
                                    {{ number_format($amount) }} RWF
                                </td>
                                <td class="py-3" style="color:var(--terra-orange);font-weight:600">
                                    {{ number_format(round($amount * $agentLevel->commission_rate / 100)) }} RWF
                                </td>
                                <td class="py-3" style="color:#2d7a4f;font-weight:600">
                                    {{ number_format(round($amount + ($amount * $agentLevel->commission_rate / 100))) }} RWF
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-5">

            {{-- Badge card --}}
            <div class="card border-0 shadow-sm mb-4" style="background:var(--terra-navy)">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4" style="color:var(--terra-gold)">Level Badge</h6>

                    <div class="text-center mb-4">
                        <div style="display:inline-flex;align-items:center;gap:10px;
                            padding:12px 28px;border-radius:30px;font-size:1.1rem;font-weight:700;
                            {{ $agentLevel->badge_style }}">
                            {{ $agentLevel->badge_emoji }} {{ $agentLevel->label }}
                        </div>
                    </div>

                    {{-- Rate bar --}}
                    <div style="border-top:1px solid rgba(255,255,255,.1);padding-top:16px">
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px">
                            Commission Bonus Rate
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
                            <div style="flex:1;height:10px;border-radius:5px;overflow:hidden;background:rgba(255,255,255,.1)">
                                <div style="height:100%;width:{{ $agentLevel->commission_rate }}%;
                                    background:linear-gradient(90deg,var(--terra-orange),var(--terra-gold));
                                    border-radius:5px"></div>
                            </div>
                            <span style="font-size:1rem;color:var(--terra-gold);font-weight:700;min-width:40px">
                                {{ $agentLevel->commission_rate }}%
                            </span>
                        </div>
                        <div style="font-size:.78rem;color:rgba(255,255,255,.35)">
                            Applied to net listing amount on each payout
                        </div>
                    </div>

                </div>
            </div>

            {{-- Meta --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted" style="font-size:.82rem">Created</span>
                        <span style="font-size:.82rem;font-weight:500">{{ $agentLevel->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted" style="font-size:.82rem">Last Updated</span>
                        <span style="font-size:.82rem;font-weight:500">{{ $agentLevel->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="card border-0 shadow-sm" style="border:1px solid rgba(192,57,43,.2)!important">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-2" style="color:#c0392b;font-size:.88rem">Danger Zone</h6>
                    <p class="text-muted mb-3" style="font-size:.82rem">
                        @if($agentsCount > 0)
                            This level cannot be deleted — {{ $agentsCount }} {{ Str::plural('agent', $agentsCount) }} are currently assigned to it.
                        @else
                            Deleting this level is permanent and cannot be undone.
                        @endif
                    </p>
                    @if($agentsCount === 0)
                    <form method="POST" action="{{ route('admin.agent-levels.destroy', $agentLevel) }}"
                        onsubmit="return confirm('Delete level: {{ $agentLevel->label }}? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            Delete this Level
                        </button>
                    </form>
                    @else
                    <button class="btn btn-sm btn-outline-danger" disabled>
                        Cannot Delete — Agents Assigned
                    </button>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
@endsection