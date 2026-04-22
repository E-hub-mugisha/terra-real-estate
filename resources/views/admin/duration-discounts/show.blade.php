@extends('layouts.app')

@section('title', 'View Duration Discount')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:var(--terra-navy)">{{ $durationDiscount->label }}</h1>
            <p class="text-muted mb-0" style="font-size:.9rem">Duration discount details and savings breakdown</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.duration-discounts.edit', $durationDiscount) }}"
                class="btn btn-sm fw-semibold text-white"
                style="background:var(--terra-orange);border:none">
                Edit Discount
            </a>
            <a href="{{ route('admin.duration-discounts.index') }}"
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
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Discount Information</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="width:200px;font-size:.85rem">Label</td>
                                <td class="py-3 fw-semibold" style="color:var(--terra-navy)">{{ $durationDiscount->label }}</td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Duration Range</td>
                                <td class="py-3 fw-bold" style="color:var(--terra-navy)">
                                    {{ $durationDiscount->range_description }}
                                </td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Minimum Days</td>
                                <td class="py-3">{{ $durationDiscount->min_days }} days</td>
                            </tr>
                            <tr style="border-bottom:1px solid #f0f0f0">
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Maximum Days</td>
                                <td class="py-3">
                                    @if($durationDiscount->max_days)
                                        {{ $durationDiscount->max_days }} days
                                    @else
                                        <span class="text-muted">No upper limit</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 fw-semibold text-muted" style="font-size:.85rem">Discount Rate</td>
                                <td class="py-3">
                                    <span style="display:inline-flex;align-items:center;padding:5px 14px;
                                        border-radius:20px;font-size:.9rem;font-weight:700;
                                        background:rgba(212,96,26,.1);color:var(--terra-orange);
                                        border:1px solid rgba(212,96,26,.2)">
                                        {{ $durationDiscount->discount_pct }}% off
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Example savings table --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Example Savings</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr style="background:var(--terra-cream)">
                                <th class="ps-4 py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Gross Amount</th>
                                <th class="py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Discount Saved</th>
                                <th class="py-3" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--terra-muted)">Net Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach([50000, 100000, 200000, 500000, 1000000] as $amount)
                            <tr style="border-bottom:1px solid #f5f5f5">
                                <td class="ps-4 py-3 fw-semibold" style="color:var(--terra-navy)">
                                    {{ number_format($amount) }} RWF
                                </td>
                                <td class="py-3" style="color:var(--terra-orange);font-weight:600">
                                    -{{ number_format($durationDiscount->calculateDiscount($amount)) }} RWF
                                </td>
                                <td class="py-3" style="color:#2d7a4f;font-weight:600">
                                    {{ number_format($durationDiscount->calculateNet($amount)) }} RWF
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

            {{-- Visual card --}}
            <div class="card border-0 shadow-sm mb-4" style="background:var(--terra-navy)">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4" style="color:var(--terra-gold)">Discount Summary</h6>

                    {{-- Big discount % --}}
                    <div class="text-center mb-4">
                        <div style="font-family:var(--font-display);font-size:3.5rem;color:var(--terra-gold);line-height:1">
                            {{ $durationDiscount->discount_pct }}%
                        </div>
                        <div style="font-size:.85rem;color:rgba(255,255,255,.4);margin-top:4px">off gross listing amount</div>
                    </div>

                    {{-- Bar --}}
                    <div style="height:10px;border-radius:5px;overflow:hidden;background:rgba(255,255,255,.1);margin-bottom:16px">
                        <div style="height:100%;width:{{ min($durationDiscount->discount_pct * 5, 100) }}%;
                            background:linear-gradient(90deg,var(--terra-orange),var(--terra-gold));
                            border-radius:5px"></div>
                    </div>

                    {{-- Applies to --}}
                    <div style="background:rgba(255,255,255,.06);border-radius:10px;padding:14px 16px;margin-bottom:16px">
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px">Applies to listings of</div>
                        <div style="font-size:1.1rem;color:#fff;font-weight:600">{{ $durationDiscount->range_description }}</div>
                    </div>

                    {{-- Quick calc --}}
                    <div style="border-top:1px solid rgba(255,255,255,.1);padding-top:16px">
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px">
                            Quick Calc — 100,000 RWF
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="font-size:.82rem;color:rgba(255,255,255,.5)">You save</span>
                            <span style="font-size:.82rem;color:var(--terra-gold);font-weight:600">
                                {{ number_format($durationDiscount->calculateDiscount(100000)) }} RWF
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span style="font-size:.82rem;color:rgba(255,255,255,.5)">You pay</span>
                            <span style="font-size:.82rem;color:#5ddc8a;font-weight:600">
                                {{ number_format($durationDiscount->calculateNet(100000)) }} RWF
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Meta --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted" style="font-size:.82rem">Created</span>
                        <span style="font-size:.82rem;font-weight:500">{{ $durationDiscount->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted" style="font-size:.82rem">Last Updated</span>
                        <span style="font-size:.82rem;font-weight:500">{{ $durationDiscount->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="card border-0 shadow-sm" style="border:1px solid rgba(192,57,43,.2)!important">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-2" style="color:#c0392b;font-size:.88rem">Danger Zone</h6>
                    <p class="text-muted mb-3" style="font-size:.82rem">
                        Deleting this discount is permanent and cannot be undone.
                    </p>
                    <form method="POST" action="{{ route('admin.duration-discounts.destroy', $durationDiscount) }}"
                        onsubmit="return confirm('Delete discount: {{ $durationDiscount->label }}? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            Delete this Discount
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection