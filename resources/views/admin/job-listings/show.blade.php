@extends('layouts.app')
@section('title', 'Job Listing — ' . $jobListing->title)

@section('content')

<div class="container py-5">

    {{-- Header ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('admin.job-listings.index') }}"
                style="font-size:.82rem;color:#7A736B;text-decoration:none">
                ← Back to Job Listings
            </a>
            <h1 class="h3 fw-bold mb-1 mt-2" style="color:var(--terra-navy)">{{ $jobListing->title }}</h1>
            <p class="text-muted mb-0" style="font-size:.88rem">{{ $jobListing->company_name }}</p>
        </div>

        {{-- Status badges ── --}}
        <div class="d-flex gap-2 align-items-center flex-wrap">
            @php
            $payColors = ['pending'=>['#F57F17','#FFF8E1'],'paid'=>['#2E7D32','#E8F5E9'],'failed'=>['#C62828','#FFEBEE']];
            [$pc,$pb] = $payColors[$jobListing->payment_status] ?? ['#7A736B','#F5F5F5'];

            $stColors = ['draft'=>['#7A736B','#F5F5F5'],'pending_payment'=>['#F57F17','#FFF8E1'],'active'=>['#2E7D32','#E8F5E9'],'expired'=>['#C62828','#FFEBEE'],'rejected'=>['#C62828','#FFEBEE'],'paused'=>['#7A736B','#F5F5F5']];
            [$sc,$sb] = $stColors[$jobListing->status] ?? ['#7A736B','#F5F5F5'];
            @endphp

            <span style="font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px;background:{{ $pb }};color:{{ $pc }}">
                Payment: {{ ucfirst($jobListing->payment_status) }}
            </span>
            <span style="font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px;background:{{ $sb }};color:{{ $sc }}">
                {{ ucwords(str_replace('_',' ',$jobListing->status)) }}
            </span>
        </div>
    </div>

    {{-- Flash ── --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="row g-4">

        {{-- LEFT ── --}}
        <div class="col-lg-8">

            {{-- Job Info ── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">💼 Job Information</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3" style="font-size:.85rem">
                        <div class="col-md-6">
                            <div style="color:#7A736B;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Title</div>
                            <div class="fw-semibold" style="color:var(--terra-navy)">{{ $jobListing->title }}</div>
                        </div>
                        <div class="col-md-6">
                            <div style="color:#7A736B;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Job Type</div>
                            <span style="font-size:.75rem;font-weight:700;padding:3px 10px;border-radius:20px;background:#EBF5FB;color:#1a5276">
                                {{ $jobListing->job_type_label }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <div style="color:#7A736B;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Location</div>
                            <div>{{ $jobListing->location }}</div>
                        </div>
                        <div class="col-md-6">
                            <div style="color:#7A736B;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Category</div>
                            <div>{{ $jobListing->category ?? '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div style="color:#7A736B;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Salary</div>
                            <div class="fw-semibold" style="color:var(--terra-orange)">{{ $jobListing->salary_range }}</div>
                        </div>
                        <div class="col-md-6">
                            <div style="color:#7A736B;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Application Deadline</div>
                            <div>{{ $jobListing->application_deadline?->format('d M Y') ?? '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div style="color:#7A736B;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Application Email</div>
                            <div><a href="mailto:{{ $jobListing->application_email }}">{{ $jobListing->application_email }}</a></div>
                        </div>
                        @if($jobListing->application_url)
                        <div class="col-md-6">
                            <div style="color:#7A736B;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Application URL</div>
                            <div><a href="{{ $jobListing->application_url }}" target="_blank">{{ Str::limit($jobListing->application_url, 40) }} ↗</a></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Description ── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">📄 Job Description</h6>
                </div>
                <div class="card-body p-4" style="font-size:.85rem;color:#555;line-height:1.75">
                    {!! nl2br(e($jobListing->description)) !!}
                </div>
            </div>

            @if($jobListing->requirements)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">✅ Requirements</h6>
                </div>
                <div class="card-body p-4" style="font-size:.85rem;color:#555;line-height:1.75">
                    {!! nl2br(e($jobListing->requirements)) !!}
                </div>
            </div>
            @endif

            @if($jobListing->benefits)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">🎁 Benefits</h6>
                </div>
                <div class="card-body p-4" style="font-size:.85rem;color:#555;line-height:1.75">
                    {!! nl2br(e($jobListing->benefits)) !!}
                </div>
            </div>
            @endif

            @if($jobListing->status === 'rejected' && $jobListing->rejection_reason)
            <div class="alert alert-danger">
                <strong>Rejection Reason:</strong> {{ $jobListing->rejection_reason }}
            </div>
            @endif

        </div>

        {{-- RIGHT ── --}}
        <div class="col-lg-4">

            {{-- ── VIEW ANALYTICS CARD ─────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">👁 View Analytics</h6>
                    @if($jobListing->status !== 'active')
                    <span style="font-size:.68rem;color:#7A736B;background:#F5F5F5;padding:2px 8px;border-radius:10px">
                        Only tracked when active
                    </span>
                    @endif
                </div>

                {{-- Top counters ── --}}
                <div class="card-body p-0">
                    <div class="row g-0" style="border-bottom:1px solid #E8E3DC">

                        {{-- Total views --}}
                        <div class="col-6" style="padding:16px 20px;border-right:1px solid #E8E3DC">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Total Views</div>
                            <div style="font-size:1.6rem;font-weight:800;color:var(--terra-navy);line-height:1">
                                {{ number_format($viewStats['total']) }}
                            </div>
                            <div style="font-size:.7rem;color:#7A736B;margin-top:3px">all time</div>
                        </div>

                        {{-- Unique views --}}
                        <div class="col-6" style="padding:16px 20px">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Unique Visitors</div>
                            <div style="font-size:1.6rem;font-weight:800;color:#1a5276;line-height:1">
                                {{ number_format($viewStats['unique']) }}
                            </div>
                            <div style="font-size:.7rem;color:#7A736B;margin-top:3px">distinct IPs</div>
                        </div>
                    </div>

                    {{-- Period breakdown ── --}}
                    <div style="padding:12px 20px;border-bottom:1px solid #E8E3DC">
                        @php
                        $periods = [
                        ['label' => 'Today', 'value' => $viewStats['today']],
                        ['label' => 'This Week', 'value' => $viewStats['this_week']],
                        ['label' => 'This Month', 'value' => $viewStats['this_month']],
                        ];
                        // Compute the max for the tiny bar widths
                        $maxPeriod = max(max(array_column($periods, 'value')), 1);
                        @endphp

                        @foreach($periods as $period)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div style="width:72px;font-size:.72rem;color:#7A736B;flex-shrink:0">{{ $period['label'] }}</div>
                            <div style="flex:1;height:6px;background:#F0EDE8;border-radius:3px;overflow:hidden">
                                <div style="height:100%;width:{{ $maxPeriod > 0 ? round(($period['value'] / $maxPeriod) * 100) : 0 }}%;background:var(--terra-navy);border-radius:3px;transition:width .4s ease"></div>
                            </div>
                            <div style="width:28px;text-align:right;font-size:.78rem;font-weight:700;color:var(--terra-navy);flex-shrink:0">
                                {{ number_format($period['value']) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- 14-day sparkline ── --}}
                    <div style="padding:16px 20px">
                        <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px">
                            Last 14 Days
                        </div>

                        @php
                        $chartData = $viewStats['daily_chart']; // ['Y-m-d' => count]
                        $chartMax = max(array_values($chartData) ?: [1]);
                        $chartDates = array_keys($chartData);
                        $chartVals = array_values($chartData);
                        $barCount = count($chartVals);
                        @endphp

                        @if(array_sum($chartVals) === 0)
                        <div style="text-align:center;padding:20px 0;color:#7A736B;font-size:.78rem">
                            No views recorded in the last 14 days.
                        </div>
                        @else
                        {{-- SVG sparkline --}}
                        <svg viewBox="0 0 280 60" xmlns="http://www.w3.org/2000/svg"
                            style="width:100%;height:60px;overflow:visible"
                            aria-label="Daily views chart">

                            {{-- Grid lines --}}
                            <line x1="0" y1="0" x2="280" y2="0" stroke="#E8E3DC" stroke-width=".5" />
                            <line x1="0" y1="30" x2="280" y2="30" stroke="#E8E3DC" stroke-width=".5" stroke-dasharray="3,3" />
                            <line x1="0" y1="59" x2="280" y2="59" stroke="#E8E3DC" stroke-width=".5" />

                            @php
                            $barW = floor(280 / $barCount) - 2;
                            $barW = max($barW, 4);
                            $gap = (280 - ($barW * $barCount)) / ($barCount + 1);
                            @endphp

                            @foreach($chartVals as $i => $val)
                            @php
                            $barH = $chartMax > 0 ? max(2, round(($val / $chartMax) * 56)) : 2;
                            $x = round($gap + $i * ($barW + $gap));
                            $y = 58 - $barH;
                            $isLast = $i === $barCount - 1;
                            @endphp
                            <rect x="{{ $x }}" y="{{ $y }}"
                                width="{{ $barW }}" height="{{ $barH }}"
                                rx="2"
                                fill="{{ $isLast ? 'var(--terra-navy, #19265d)' : '#B8C5D6' }}"
                                opacity="{{ $isLast ? '1' : '0.6' }}">
                                <title>{{ $chartDates[$i] }}: {{ $val }} view{{ $val === 1 ? '' : 's' }}</title>
                            </rect>
                            @endforeach
                        </svg>

                        {{-- x-axis labels: first, mid, last --}}
                        <div style="display:flex;justify-content:space-between;margin-top:4px">
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse($chartDates[0])->format('d M') }}
                            </span>
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse($chartDates[floor($barCount/2)])->format('d M') }}
                            </span>
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse(end($chartDates))->format('d M') }}
                            </span>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            {{-- ── END VIEW ANALYTICS CARD ─────────────────────────────────── --}}

            {{-- Company ── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">🏢 Company</h6>
                </div>
                <div class="card-body p-4">
                    @if($jobListing->company_logo)
                    <img src="{{asset($jobListing->company_logo) }}"
                        alt="{{ $jobListing->company_name }}"
                        style="width:56px;height:56px;border-radius:10px;object-fit:cover;border:1px solid #E8E3DC;margin-bottom:12px;display:block">
                    @endif

                    @php
                    $companyFields = [
                    ['label'=>'Name', 'value'=>$jobListing->company_name],
                    ['label'=>'Email', 'value'=>$jobListing->company_email],
                    ['label'=>'Phone', 'value'=>$jobListing->company_phone ?? '—'],
                    ['label'=>'Website', 'value'=>$jobListing->company_website ?? '—'],
                    ];
                    @endphp

                    @foreach($companyFields as $f)
                    <div style="margin-bottom:10px">
                        <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:2px">{{ $f['label'] }}</div>
                        <div style="font-size:.83rem;font-weight:600;color:var(--terra-navy)">{{ $f['value'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Billing ── --}}
            <div class="card border-0 shadow-sm mb-4" style="background:var(--terra-navy)">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color:var(--terra-gold);font-size:.8rem;text-transform:uppercase;letter-spacing:.08em">
                        Billing Summary
                    </h6>

                    @php
                    $billingRows = [
                    ['label'=>'Package', 'value'=>$jobListing->package?->tier_label . ' plan'],
                    ['label'=>'Price / Day', 'value'=>number_format($jobListing->package?->price_per_day ?? 0) . ' RWF'],
                    ['label'=>'Days Purchased', 'value'=>$jobListing->days_purchased . ' days'],
                    ['label'=>'Agent Commission','value'=>number_format($jobListing->agent_commission_amount) . ' RWF'],
                    ['label'=>'Terra Share', 'value'=>number_format($jobListing->terra_share_amount) . ' RWF'],
                    ['label'=>'Total Charged', 'value'=>number_format($jobListing->total_amount) . ' RWF'],
                    ];
                    @endphp

                    @foreach($billingRows as $row)
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid rgba(255,255,255,.08)">
                        <span style="font-size:.78rem;color:rgba(255,255,255,.5)">{{ $row['label'] }}</span>
                        <span style="font-size:.78rem;font-weight:600;color:#fff">{{ $row['value'] }}</span>
                    </div>
                    @endforeach

                    @if($jobListing->payment_reference)
                    <div class="mt-3 p-2" style="background:rgba(255,255,255,.06);border-radius:6px">
                        <div style="font-size:.68rem;color:rgba(255,255,255,.4);margin-bottom:2px">Reference</div>
                        <div style="font-size:.78rem;color:#fff;font-weight:600">{{ $jobListing->payment_reference }}</div>
                        @if($jobListing->payment_method)
                        <div style="font-size:.72rem;color:rgba(255,255,255,.4);margin-top:2px">
                            via {{ ucwords(str_replace('_',' ',$jobListing->payment_method)) }}
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            {{-- Lifecycle ── --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">📅 Lifecycle</h6>
                </div>
                <div class="card-body p-4">
                    @php
                    $dates = [
                    ['label'=>'Submitted', 'value'=>$jobListing->created_at->format('d M Y H:i')],
                    ['label'=>'Paid At', 'value'=>$jobListing->paid_at?->format('d M Y H:i') ?? '—'],
                    ['label'=>'Published', 'value'=>$jobListing->published_at?->format('d M Y H:i') ?? '—'],
                    ['label'=>'Expires', 'value'=>$jobListing->expires_at?->format('d M Y H:i') ?? '—'],
                    ['label'=>'Days Left', 'value'=>$jobListing->status === 'active' ? $jobListing->days_remaining . ' days' : '—'],
                    ];
                    @endphp

                    @foreach($dates as $d)
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #E8E3DC;font-size:.82rem">
                        <span style="color:#7A736B">{{ $d['label'] }}</span>
                        <span style="font-weight:600;color:var(--terra-navy)">{{ $d['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Actions ── --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">⚙️ Actions</h6>
                </div>
                <div class="card-body p-4 d-flex flex-column gap-2">

                    <a href="{{ route('admin.job-listings.edit', $jobListing) }}"
                        class="btn btn-primary btn-sm">
                        Edit Listing ↗
                    </a>

                    @if($jobListing->payment_status !== 'paid')
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#activateModal">
                        ✓ Activate (Mark as Paid)
                    </button>
                    @endif

                    @if($jobListing->status === 'active')
                    <a href="{{ route('front.jobs.show', $jobListing->slug) }}" target="_blank"
                        class="btn btn-outline-primary btn-sm">
                        View Live Listing ↗
                    </a>
                    @endif

                    @if(!in_array($jobListing->status, ['rejected','expired']))
                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        ✕ Reject Listing
                    </button>
                    @endif

                    @if($jobListing->status === 'active')
                    <form method="POST" action="{{ route('admin.job-listings.expire', $jobListing) }}">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm w-100"
                            onclick="return confirm('Force expire this listing?')">
                            Force Expire
                        </button>
                    </form>
                    @endif

                    <form method="POST" action="{{ route('admin.job-listings.destroy', $jobListing) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                            onclick="return confirm('Delete permanently? This cannot be undone.')">
                            Delete Permanently
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- Activate Modal ── --}}
<div class="modal fade" id="activateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color:var(--terra-navy)">Activate Listing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.job-listings.activate', $jobListing) }}">
                @csrf
                <div class="modal-body pt-3">
                    <p style="font-size:.85rem;color:#7A736B">
                        Total amount: <strong>{{ number_format($jobListing->total_amount) }} RWF</strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.82rem">Payment Reference <span class="text-danger">*</span></label>
                        <input type="text" name="payment_reference" class="form-control" required placeholder="e.g. MTN-123456789">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.82rem">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select" required>
                            <option value="">— Select —</option>
                            <option value="momo">MTN MoMo</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm px-4">Confirm & Activate</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Reject Modal ── --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color:#C62828">Reject Listing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.job-listings.reject', $jobListing) }}">
                @csrf
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.82rem">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="4" required
                            placeholder="Explain why this listing is being rejected…"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm px-4">Reject Listing</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection