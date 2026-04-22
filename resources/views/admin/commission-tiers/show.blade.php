@extends('layouts.app')

@section('title', 'View Commission Tier')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:var(--terra-navy)">{{ $commissionTier->label }}</h1>
            <p class="text-muted mb-0" style="font-size:.9rem">Commission tier details and payout breakdown</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.commission-tiers.edit', $commissionTier) }}"
                class="btn btn-sm fw-semibold text-white"
                style="background:var(--terra-orange);border:none">
                Edit Tier
            </a>
            <a href="{{ route('admin.commission-tiers.index') }}"
                class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-lg-7">

            {{-- Details card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Tier Information</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="width:200px;font-size:.85rem">Label</td>
                                <td class="py-3 fw-semibold" style="color:var(--terra-navy)">{{ $commissionTier->label }}</td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Service Value Range</td>
                                <td class="py-3 fw-bold" style="color:var(--terra-navy);font-size:1rem">
                                    {{ $commissionTier->range_description }}
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Minimum Value</td>
                                <td class="py-3">{{ number_format($commissionTier->min_value) }} RWF</td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Maximum Value</td>
                                <td class="py-3">
                                    @if($commissionTier->max_value)
                                        {{ number_format($commissionTier->max_value) }} RWF
                                    @else
                                        <span class="text-muted">No upper limit</span>
                                    @endif
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Terra Commission</td>
                                <td class="py-3">
                                    <span class="fw-bold" style="color:var(--terra-navy)">
                                        {{ $commissionTier->terra_commission_pct }}%
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Consultant Payout</td>
                                <td class="py-3">
                                    <span class="fw-bold" style="color:#2d7a4f">
                                        {{ $commissionTier->consultant_payout_pct }}%
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Example calculations --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Example Calculations</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr style="background:var(--terra-cream)">
                                <th class="ps-4 py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Service Value</th>
                                <th class="py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Terra Gets</th>
                                <th class="py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Consultant Gets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $examples = [];
                                $min = $commissionTier->min_value;
                                $max = $commissionTier->max_value;

                                if ($max) {
                                    $examples[] = $min;
                                    $examples[] = (int)(($min + $max) / 2);
                                    $examples[] = $max;
                                } else {
                                    $examples[] = $min;
                                    $examples[] = $min * 2;
                                    $examples[] = $min * 5;
                                }
                            @endphp
                            @foreach($examples as $example)
                            <tr style="border-bottom:1px solid #f5f5f5">
                                <td class="ps-4 py-3 fw-semibold" style="color:var(--terra-navy)">
                                    {{ number_format($example) }} RWF
                                </td>
                                <td class="py-3" style="color:var(--terra-orange);font-weight:600">
                                    {{ number_format($commissionTier->calculateTerraCut($example)) }} RWF
                                    <small class="text-muted fw-normal">({{ $commissionTier->terra_commission_pct }}%)</small>
                                </td>
                                <td class="py-3" style="color:#2d7a4f;font-weight:600">
                                    {{ number_format($commissionTier->calculateConsultantPayout($example)) }} RWF
                                    <small class="text-muted fw-normal">({{ $commissionTier->consultant_payout_pct }}%)</small>
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

            {{-- Split visual --}}
            <div class="card border-0 shadow-sm mb-4" style="background:var(--terra-navy)">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4" style="color:var(--terra-gold)">Commission Split</h6>

                    {{-- Bar --}}
                    <div style="height:14px;border-radius:7px;overflow:hidden;display:flex;margin-bottom:10px">
                        <div style="width:{{ $commissionTier->terra_commission_pct }}%;background:linear-gradient(90deg,var(--terra-orange),var(--terra-gold));transition:width .3s"></div>
                        <div style="width:{{ $commissionTier->consultant_payout_pct }}%;background:linear-gradient(90deg,#2d7a4f,#5ddc8a)"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <div style="font-size:.72rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.08em">Terra</div>
                            <div style="font-size:1.8rem;font-family:var(--font-display);color:var(--terra-gold)">{{ $commissionTier->terra_commission_pct }}%</div>
                        </div>
                        <div style="font-size:1.5rem;color:rgba(255,255,255,.1)">|</div>
                        <div class="text-end">
                            <div style="font-size:.72rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.08em">Consultant</div>
                            <div style="font-size:1.8rem;font-family:var(--font-display);color:#5ddc8a">{{ $commissionTier->consultant_payout_pct }}%</div>
                        </div>
                    </div>

                    {{-- Range --}}
                    <div style="background:rgba(255,255,255,.06);border-radius:10px;padding:14px 16px">
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px">Applies to</div>
                        <div style="font-size:1rem;color:#fff;font-weight:600">{{ $commissionTier->range_description }}</div>
                    </div>

                </div>
            </div>

            {{-- Meta --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted" style="font-size:.82rem">Created</span>
                        <span style="font-size:.82rem;font-weight:500">{{ $commissionTier->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted" style="font-size:.82rem">Last Updated</span>
                        <span style="font-size:.82rem;font-weight:500">{{ $commissionTier->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Delete --}}
            <div class="card border-0 shadow-sm border-danger" style="border-color:rgba(192,57,43,.2)!important">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-2" style="color:#c0392b;font-size:.88rem">Danger Zone</h6>
                    <p class="text-muted mb-3" style="font-size:.82rem">
                        Deleting this tier is permanent and cannot be undone.
                    </p>
                    <form method="POST" action="{{ route('admin.commission-tiers.destroy', $commissionTier) }}"
                        onsubmit="return confirm('Delete tier: {{ $commissionTier->label }}? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            Delete this Tier
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection