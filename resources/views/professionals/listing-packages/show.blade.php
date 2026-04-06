@extends('layouts.app')

@section('title', 'View Listing Package')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:var(--terra-navy)">
                {{ $listingPackage->type_label }} — {{ $listingPackage->tier_label }}
            </h1>
            <p class="text-muted mb-0" style="font-size:.9rem">Package details and commission breakdown</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.listing-packages.edit', $listingPackage) }}"
                class="btn btn-sm fw-semibold text-white" style="background:var(--terra-orange);border:none">
                Edit Package
            </a>
            <a href="{{ route('admin.listing-packages.index') }}" class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT — Details --}}
        <div class="col-lg-8">

            {{-- Package Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Package Information</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="width:200px;font-size:.85rem">Listing Type</td>
                                <td class="py-3 fw-semibold" style="color:var(--terra-navy)">{{ $listingPackage->type_label }}</td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Package Tier</td>
                                <td class="py-3">
                                    <span class="badge rounded-pill px-3 py-2"
                                        style="background:rgba(212,96,26,.12);color:var(--terra-orange);font-size:.78rem">
                                        {{ $listingPackage->tier_label }}
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Price Per Day</td>
                                <td class="py-3 fw-bold" style="font-size:1.1rem;color:var(--terra-navy)">
                                    {{ number_format($listingPackage->price_per_day) }} RWF
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Agent Commission</td>
                                <td class="py-3">
                                    <span class="fw-bold" style="color:#2d7a4f">
                                        {{ $listingPackage->agent_commission_pct }}%
                                    </span>
                                    <span class="text-muted ms-2" style="font-size:.85rem">
                                        ({{ number_format($listingPackage->price_per_day * $listingPackage->agent_commission_pct / 100) }} RWF per day)
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Terra Share</td>
                                <td class="py-3">
                                    <span class="fw-bold" style="color:var(--terra-navy)">
                                        {{ $listingPackage->terra_share_pct }}%
                                    </span>
                                    <span class="text-muted ms-2" style="font-size:.85rem">
                                        ({{ number_format($listingPackage->price_per_day * $listingPackage->terra_share_pct / 100) }} RWF per day)
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Status</td>
                                <td class="py-3">
                                    @if($listingPackage->is_active)
                                    <span class="badge rounded-pill px-3 py-2"
                                        style="background:rgba(45,122,79,.1);color:#1e5a35;font-size:.78rem">
                                        ● Active
                                    </span>
                                    @else
                                    <span class="badge rounded-pill px-3 py-2"
                                        style="background:rgba(192,57,43,.1);color:#c0392b;font-size:.78rem">
                                        ● Inactive
                                    </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Features --}}
            @php
            $features = is_array($listingPackage->features)
            ? $listingPackage->features
            : (json_decode($listingPackage->features, true) ?? []);
            @endphp
            @if(count($features) > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Features</h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        @foreach($features as $feature)
                        <li class="d-flex align-items-start gap-2 mb-2">
                            <span style="color:var(--terra-orange);font-weight:700;margin-top:2px">✓</span>
                            <span style="font-size:.9rem">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT — Commission Summary --}}
        <div class="col-lg-4">

            {{-- Commission card --}}
            <div class="card border-0 shadow-sm mb-4" style="background:var(--terra-navy)">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4" style="color:var(--terra-gold)">Daily Commission Split</h6>

                    <div class="text-center mb-4">
                        <div style="font-family:var(--font-display);font-size:2.2rem;color:#fff;line-height:1">
                            {{ number_format($listingPackage->price_per_day) }}
                        </div>
                        <div style="font-size:.8rem;color:rgba(255,255,255,.4);margin-top:4px">RWF per day</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3"
                        style="border-top:1px solid rgba(255,255,255,.1);border-bottom:1px solid rgba(255,255,255,.1)">
                        <div>
                            <div style="font-size:.72rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.08em">Agent Earns</div>
                            <div style="font-size:1.3rem;font-weight:700;color:#5ddc8a">
                                {{ number_format($listingPackage->price_per_day * $listingPackage->agent_commission_pct / 100) }} RWF
                            </div>
                            <div style="font-size:.75rem;color:rgba(255,255,255,.35)">{{ $listingPackage->agent_commission_pct }}% of daily rate</div>
                        </div>
                        <div style="font-size:1.5rem;color:rgba(255,255,255,.15)">|</div>
                        <div class="text-end">
                            <div style="font-size:.72rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.08em">Terra Earns</div>
                            <div style="font-size:1.3rem;font-weight:700;color:var(--terra-gold)">
                                {{ number_format($listingPackage->price_per_day * $listingPackage->terra_share_pct / 100) }} RWF
                            </div>
                            <div style="font-size:.75rem;color:rgba(255,255,255,.35)">{{ $listingPackage->terra_share_pct }}% of daily rate</div>
                        </div>
                    </div>

                    {{-- 30 day example --}}
                    <div class="mt-3">
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px">
                            30-Day Example
                        </div>
                        <div class="d-flex justify-content-between">
                            <span style="font-size:.82rem;color:rgba(255,255,255,.5)">Gross (30 days)</span>
                            <span style="font-size:.82rem;color:#fff;font-weight:600">
                                {{ number_format($listingPackage->price_per_day * 30) }} RWF
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span style="font-size:.82rem;color:#5ddc8a">Agent payout</span>
                            <span style="font-size:.82rem;color:#5ddc8a;font-weight:600">
                                {{ number_format($listingPackage->price_per_day * 30 * $listingPackage->agent_commission_pct / 100) }} RWF
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span style="font-size:.82rem;color:var(--terra-gold)">Terra revenue</span>
                            <span style="font-size:.82rem;color:var(--terra-gold);font-weight:600">
                                {{ number_format($listingPackage->price_per_day * 30 * $listingPackage->terra_share_pct / 100) }} RWF
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Meta --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted" style="font-size:.82rem">Created</span>
                        <span style="font-size:.82rem;font-weight:500">{{ $listingPackage->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted" style="font-size:.82rem">Last Updated</span>
                        <span style="font-size:.82rem;font-weight:500">{{ $listingPackage->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Delete --}}
    <div class="mt-4 pt-4" style="border-top:1px solid #eee">
        <form method="POST" action="{{ route('admin.listing-packages.destroy', $listingPackage) }}"
            onsubmit="return confirm('Are you sure you want to delete this package? This cannot be undone.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">
                Delete this Package
            </button>
        </form>
    </div>

</div>
@endsection