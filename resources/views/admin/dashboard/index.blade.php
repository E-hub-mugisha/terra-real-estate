@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@php
use Carbon\Carbon;

/* ── Real counts from DB ── */
$totalLands      = \App\Models\Land::count();
$totalHouses     = \App\Models\House::count();
$totalDesigns    = \App\Models\ArchitecturalDesign::count();
$totalProperties = $totalLands + $totalHouses + $totalDesigns;

$totalAgents      = \App\Models\Agent::count();
$totalConsultants = \App\Models\Consultant::count();
$totalPros        = \App\Models\Professional::count();
$totalStaff       = \App\Models\Staff::count();
$totalUsers       = \App\Models\User::count();

$totalBlogs         = \App\Models\Blog::count();
$totalAnnouncements = \App\Models\Announcement::count();
$totalTenders       = \App\Models\Tender::count();
$totalAds           = \App\Models\TerraAdvertisement::count();
$totalJobs          = \App\Models\TerraJob::count();
$totalBookings      = \App\Models\ConsultantBooking::count();
$totalTasks         = \App\Models\TerraTask::count();

$pendingAds      = \App\Models\TerraAdvertisement::where('status','pending')->count();
$approvedAds     = \App\Models\TerraAdvertisement::where('status','approved')->count();
$pendingBookings = \App\Models\ConsultantBooking::where('status','pending')->count();
$pendingTasks    = \App\Models\TerraTask::where('status','pending')->count();

/* ── Monthly property listings (last 6 months) ── */
$months = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i));
$monthLabels = $months->map(fn($m) => $m->format('M'))->toArray();

$housesPerMonth = $months->map(fn($m) =>
    \App\Models\House::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count()
)->toArray();

$landsPerMonth = $months->map(fn($m) =>
    \App\Models\Land::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count()
)->toArray();

$designsPerMonth = $months->map(fn($m) =>
    \App\Models\ArchitecturalDesign::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count()
)->toArray();

/* ── User growth (last 6 months) ── */
$agentsPerMonth = $months->map(fn($m) =>
    \App\Models\Agent::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count()
)->toArray();

$consultantsPerMonth = $months->map(fn($m) =>
    \App\Models\Consultant::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count()
)->toArray();

/* ── Blog activity ── */
$blogsPublished = $months->map(fn($m) =>
    \App\Models\Blog::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->where('is_published', true)->count()
)->toArray();

$blogsDraft = $months->map(fn($m) =>
    \App\Models\Blog::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->where('is_published', false)->count()
)->toArray();

/* ── Booking status breakdown ── */
$bookingStatuses = \App\Models\ConsultantBooking::selectRaw('status, count(*) as total')
    ->groupBy('status')->pluck('total','status')->toArray();

/* ── Commission totals ── */
$totalCommissions = \App\Models\AgentCommission::sum('sale_price') ?? 0;
$paidCommissions  = \App\Models\AgentCommission::where('listing_commission_status','paid')->sum('sale_price') ?? 0;
$pendingComms     = \App\Models\AgentCommission::where('listing_commission_status','pending')->sum('sale_price') ?? 0;

/* ── Recent properties ── */
$recentHouses = \App\Models\House::latest()->take(3)->get();
$recentLands  = \App\Models\Land::latest()->take(3)->get();

$recentProps = collect()
    ->merge(
        $recentHouses->map(fn($h) => [
            'title'  => $h->title,
            'type'   => 'House',
            'status' => $h->status ?? 'active',
            'date'   => Carbon::parse($h->created_at)->diffForHumans(),
        ])
    )
    ->merge(
        $recentLands->map(fn($l) => [
            'title'  => $l->title,
            'type'   => 'Land',
            'status' => $l->status ?? 'active',
            'date'   => Carbon::parse($l->created_at)->diffForHumans(),
        ])
    )
    ->sortByDesc('date')
    ->values()   // ← resets keys and strips Eloquent model context
    ->take(6);

/* ── Recent activity logs ── */
$recentActivity = \App\Models\ActivityLog::with('user')->latest()->take(7)->get();

/* ── Tasks breakdown ── */
$tasksDone    = \App\Models\TerraTask::where('status','completed')->count();
$tasksOpen    = \App\Models\TerraTask::where('status','pending')->count();
$tasksReview  = \App\Models\TerraTask::where('status','review')->count();

/* ── Ad revenue ── */
$adRevenue = \App\Models\TerraAdvertisement::where('payment_status','paid')->sum('price_amount') ?? 0;

/* ── Job listings ── */
$activeJobs   = \App\Models\TerraJob::where('is_active',true)->count();
$expiredJobs  = \App\Models\TerraJob::where('is_active',false)->count();
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:wght@300;400;500&display=swap');

:root {
    --navy:   #19265d;
    --gold:   #D05208;
    --gold-lt:#e8722a;
    --gold-bg:rgba(208,82,8,0.08);
    --navy-bg:rgba(25,38,93,0.06);
    --border: rgba(25,38,93,0.09);
    --surface:#f5f4f0;
    --white:  #ffffff;
    --muted:  rgba(25,38,93,0.42);
    --text:   #19265d;
    --text-sm:rgba(25,38,93,0.65);
    --green:  #2a9d5c;
    --red:    #d94f4f;
    --blue:   #2563eb;
    --teal:   #0d9488;
    --amber:  #d97706;
    --purple: #7c3aed;
    --radius: 12px;
}

/* ─── Layout ─── */
.db { padding: 1.75rem 0 3rem; font-family: 'DM Sans', sans-serif; }

/* ─── Welcome bar ─── */
.db-welcome {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;
}
.db-welcome-text h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem; font-weight: 600; color: var(--navy); margin: 0; line-height: 1.1;
}
.db-welcome-text p { font-size: .83rem; color: var(--muted); margin: .3rem 0 0; }
.db-date-chip {
    display: flex; align-items: center; gap: .5rem;
    padding: .5rem 1.1rem; border-radius: 8px;
    border: 1px solid var(--border); background: var(--white);
    font-size: .78rem; color: var(--text-sm); font-weight: 500;
}

/* ─── KPI grid ─── */
.db-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem; margin-bottom: 1.5rem;
}
.db-kpi {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 1.2rem 1.3rem;
    position: relative; overflow: hidden; transition: transform .18s, box-shadow .18s;
    cursor: default;
}
.db-kpi:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(25,38,93,.07); }
.db-kpi::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0;
    height: 3px; background: var(--kpi-color, var(--gold));
}
.db-kpi-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: .85rem; }
.db-kpi-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.db-kpi-badge {
    display: inline-flex; align-items: center; gap: .2rem;
    padding: .18rem .5rem; border-radius: 100px; font-size: .68rem; font-weight: 600;
}
.db-kpi-badge.up   { background: rgba(42,157,92,.1);  color: var(--green); }
.db-kpi-badge.down { background: rgba(217,79,79,.1);  color: var(--red); }
.db-kpi-badge.neu  { background: var(--navy-bg);       color: var(--muted); }
.db-kpi-badge.warn { background: rgba(217,119,6,.1);  color: var(--amber); }
.db-kpi-val { font-size: 1.8rem; font-weight: 700; color: var(--navy); line-height: 1; font-family: 'Cormorant Garamond', serif; }
.db-kpi-label { font-size: .72rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--muted); margin-top: .25rem; }
.db-kpi-footer { display: flex; align-items: center; justify-content: space-between; margin-top: .85rem; }
.db-kpi-bar-track { flex: 1; height: 3px; border-radius: 100px; background: var(--border); overflow: hidden; }
.db-kpi-bar-fill  { height: 100%; border-radius: 100px; background: var(--kpi-color, var(--gold)); }
.db-kpi-pct { font-size: .68rem; color: var(--muted); margin-left: .6rem; flex-shrink: 0; }

/* ─── Row layouts ─── */
.db-row   { display: grid; gap: 1.1rem; margin-bottom: 1.5rem; }
.db-row-3 { grid-template-columns: 2fr 1fr; }
.db-row-2 { grid-template-columns: 1fr 1fr; }
.db-row-32{ grid-template-columns: 1.5fr 1fr 280px; }
.db-row-4 { grid-template-columns: repeat(4, 1fr); }

/* ─── Cards ─── */
.db-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
.db-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: .95rem 1.25rem; border-bottom: 1px solid var(--border);
    background: rgba(25,38,93,.018);
}
.db-card-head-l { display: flex; align-items: center; gap: .6rem; }
.db-card-ico {
    width: 28px; height: 28px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.db-card-title { font-size: .87rem; font-weight: 600; color: var(--navy); margin: 0; }
.db-card-sub   { font-size: .71rem; color: var(--muted); margin-top: .08rem; }
.db-card-body  { padding: 1.25rem; }
.db-card-body.np { padding: 0; }
.db-view-link  { font-size: .74rem; color: var(--gold); text-decoration: none; font-weight: 600; }
.db-view-link:hover { text-decoration: underline; }

/* ─── Period tabs ─── */
.db-tabs { display: flex; gap: .25rem; }
.db-tab {
    padding: .26rem .65rem; border-radius: 6px; font-size: .72rem; font-weight: 600;
    border: none; cursor: pointer; transition: all .14s; font-family: inherit;
    background: none; color: var(--muted);
}
.db-tab.active { background: var(--gold); color: #fff; }
.db-tab:hover:not(.active) { background: var(--navy-bg); color: var(--navy); }

/* ─── Chart wraps ─── */
.db-chart-wrap { padding: 1.1rem 1.25rem; position: relative; }
.db-chart-sm  { height: 190px; }
.db-chart-md  { height: 250px; }
.db-chart-lg  { height: 300px; }

/* ─── Donut center ─── */
.db-donut-center {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    text-align: center; pointer-events: none;
}
.db-donut-val { font-size: 1.5rem; font-weight: 700; color: var(--navy); line-height: 1; font-family: 'Cormorant Garamond', serif; }
.db-donut-sub { font-size: .67rem; color: var(--muted); margin-top: .2rem; }

/* ─── Stat rows ─── */
.db-stat-list { display: flex; flex-direction: column; }
.db-stat-row {
    display: flex; align-items: center; gap: .7rem;
    padding: .75rem 1.25rem; border-bottom: 1px solid var(--border);
}
.db-stat-row:last-child { border-bottom: none; }
.db-stat-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.db-stat-lbl  { font-size: .82rem; color: var(--text-sm); flex: 1; }
.db-stat-bar  { width: 64px; height: 4px; border-radius: 100px; background: var(--border); overflow: hidden; }
.db-stat-fill { height: 100%; border-radius: 100px; }
.db-stat-val  { font-size: .82rem; font-weight: 700; color: var(--navy); min-width: 24px; text-align: right; }
.db-stat-pct  { font-size: .68rem; color: var(--muted); min-width: 30px; text-align: right; }

/* ─── Mini table ─── */
.db-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
.db-table th {
    padding: .6rem 1.25rem; text-align: left; font-size: .66rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase; color: var(--muted);
    border-bottom: 1px solid var(--border); background: rgba(25,38,93,.018); white-space: nowrap;
}
.db-table td { padding: .78rem 1.25rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
.db-table tr:last-child td { border-bottom: none; }
.db-table tbody tr:hover { background: rgba(25,38,93,.018); }

/* ─── Badges ─── */
.db-badge {
    display: inline-flex; align-items: center; gap: .2rem;
    padding: .18rem .55rem; border-radius: 100px; font-size: .67rem; font-weight: 600;
}
.db-badge.active   { background: rgba(42,157,92,.1);  color: var(--green); }
.db-badge.pending  { background: rgba(217,119,6,.1);  color: var(--amber); }
.db-badge.inactive { background: var(--navy-bg);       color: var(--muted); }
.db-badge.rejected { background: rgba(217,79,79,.1);  color: var(--red); }
.db-badge.house    { background: var(--gold-bg);       color: var(--gold); }
.db-badge.land     { background: rgba(37,99,235,.1);   color: var(--blue); }
.db-badge.design   { background: rgba(13,148,136,.1);  color: var(--teal); }

/* ─── Activity feed ─── */
.db-feed { display: flex; flex-direction: column; }
.db-feed-item {
    display: flex; align-items: flex-start; gap: .85rem;
    padding: .85rem 1.25rem; border-bottom: 1px solid var(--border);
}
.db-feed-item:last-child { border-bottom: none; }
.db-feed-ico {
    width: 30px; height: 30px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: .1rem;
}
.db-feed-title { font-size: .82rem; font-weight: 500; color: var(--navy); margin: 0 0 .12rem; }
.db-feed-title strong { font-weight: 700; }
.db-feed-time { font-size: .7rem; color: var(--muted); }

/* ─── Quick actions ─── */
.db-quick-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; padding: 1.1rem; }
.db-quick-btn {
    display: flex; align-items: center; gap: .55rem;
    padding: .65rem .85rem; border-radius: 8px;
    border: 1.5px solid var(--border); background: var(--white);
    font-family: inherit; font-size: .79rem; font-weight: 500;
    cursor: pointer; text-decoration: none; color: var(--text-sm);
    transition: border-color .14s, background .14s, color .14s;
}
.db-quick-btn:hover { border-color: var(--gold); color: var(--navy); background: var(--gold-bg); }
.db-quick-ico { width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

/* ─── Finance summary cards ─── */
.db-finance-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; padding: 1.1rem 1.25rem; }
.db-finance-item { background: var(--surface); border-radius: 10px; padding: 1rem 1.1rem; }
.db-finance-label { font-size: .7rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--muted); margin-bottom: .4rem; }
.db-finance-val { font-size: 1.2rem; font-weight: 700; color: var(--navy); font-family: 'Cormorant Garamond', serif; }
.db-finance-sub { font-size: .7rem; color: var(--muted); margin-top: .2rem; }

/* ─── Task status pills ─── */
.db-task-bar { display: flex; gap: .5rem; padding: 1.1rem 1.25rem; flex-wrap: wrap; }
.db-task-pill {
    flex: 1; min-width: 80px; background: var(--surface); border-radius: 10px;
    padding: .9rem 1rem; text-align: center;
}
.db-task-pill-val { font-size: 1.4rem; font-weight: 700; color: var(--navy); font-family: 'Cormorant Garamond', serif; line-height: 1; }
.db-task-pill-lbl { font-size: .68rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: var(--muted); margin-top: .3rem; }

/* ─── Progress ring placeholder ─── */
.db-ring-wrap { position: relative; display: flex; align-items: center; justify-content: center; }

/* ─── Responsive ─── */
@media(max-width:1100px){ .db-row-32{ grid-template-columns: 1fr 1fr; } }
@media(max-width:960px){
    .db-row-3,.db-row-2,.db-row-32{ grid-template-columns: 1fr; }
    .db-row-4{ grid-template-columns: 1fr 1fr; }
}
@media(max-width:640px){
    .db-kpi-grid{ grid-template-columns: 1fr 1fr; }
    .db-row-4{ grid-template-columns: 1fr 1fr; }
}
@media(max-width:420px){
    .db-kpi-grid{ grid-template-columns: 1fr; }
}
</style>

<div class="db">

{{-- ── Welcome ─────────────────────────────────────────────────────── --}}
<div class="db-welcome">
    <div class="db-welcome-text">
        <h2>Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 18 ? 'Afternoon' : 'Evening') }}, {{ Auth::user()->name }}</h2>
        <p>Here's your Terra platform overview for today — {{ now()->format('l, F j Y') }}</p>
    </div>
    <div style="display:flex;align-items:center;gap:.7rem;">
        <a href="{{ route('admin.activity-logs.index') }}" class="db-date-chip" style="text-decoration:none;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Activity Logs
        </a>
        <div class="db-date-chip">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            {{ now()->format('d M Y') }}
        </div>
    </div>
</div>

{{-- ── KPI Row 1: Properties ─────────────────────────────────────── --}}
<div class="db-kpi-grid">

    <div class="db-kpi" style="--kpi-color:var(--gold)">
        <div class="db-kpi-top">
            <div class="db-kpi-icon" style="background:var(--gold-bg)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <span class="db-kpi-badge up">↑ Total</span>
        </div>
        <div class="db-kpi-val">{{ number_format($totalProperties) }}</div>
        <div class="db-kpi-label">All Properties</div>
        <div class="db-kpi-footer">
            <div class="db-kpi-bar-track"><div class="db-kpi-bar-fill" style="width:80%"></div></div>
            <span class="db-kpi-pct">Houses · Lands · Designs</span>
        </div>
    </div>

    <div class="db-kpi" style="--kpi-color:var(--blue)">
        <div class="db-kpi-top">
            <div class="db-kpi-icon" style="background:rgba(37,99,235,.08)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            </div>
            <span class="db-kpi-badge neu">Houses</span>
        </div>
        <div class="db-kpi-val" style="color:var(--blue)">{{ number_format($totalHouses) }}</div>
        <div class="db-kpi-label">House Listings</div>
        <div class="db-kpi-footer">
            <div class="db-kpi-bar-track"><div class="db-kpi-bar-fill" style="width:{{ $totalProperties > 0 ? round($totalHouses/$totalProperties*100) : 0 }}%;background:var(--blue)"></div></div>
            <span class="db-kpi-pct">{{ $totalProperties > 0 ? round($totalHouses/$totalProperties*100) : 0 }}%</span>
        </div>
    </div>

    <div class="db-kpi" style="--kpi-color:var(--teal)">
        <div class="db-kpi-top">
            <div class="db-kpi-icon" style="background:rgba(13,148,136,.08)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l4-8 4 5 3-3 4 6H3z"/></svg>
            </div>
            <span class="db-kpi-badge neu">Lands</span>
        </div>
        <div class="db-kpi-val" style="color:var(--teal)">{{ number_format($totalLands) }}</div>
        <div class="db-kpi-label">Land Listings</div>
        <div class="db-kpi-footer">
            <div class="db-kpi-bar-track"><div class="db-kpi-bar-fill" style="width:{{ $totalProperties > 0 ? round($totalLands/$totalProperties*100) : 0 }}%;background:var(--teal)"></div></div>
            <span class="db-kpi-pct">{{ $totalProperties > 0 ? round($totalLands/$totalProperties*100) : 0 }}%</span>
        </div>
    </div>

    <div class="db-kpi" style="--kpi-color:var(--purple)">
        <div class="db-kpi-top">
            <div class="db-kpi-icon" style="background:rgba(124,58,237,.08)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
            <span class="db-kpi-badge neu">Designs</span>
        </div>
        <div class="db-kpi-val" style="color:var(--purple)">{{ number_format($totalDesigns) }}</div>
        <div class="db-kpi-label">Arch. Designs</div>
        <div class="db-kpi-footer">
            <div class="db-kpi-bar-track"><div class="db-kpi-bar-fill" style="width:{{ $totalProperties > 0 ? round($totalDesigns/$totalProperties*100) : 0 }}%;background:var(--purple)"></div></div>
            <span class="db-kpi-pct">{{ $totalProperties > 0 ? round($totalDesigns/$totalProperties*100) : 0 }}%</span>
        </div>
    </div>

    <div class="db-kpi" style="--kpi-color:var(--green)">
        <div class="db-kpi-top">
            <div class="db-kpi-icon" style="background:rgba(42,157,92,.08)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#2a9d5c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span class="db-kpi-badge up">Agents</span>
        </div>
        <div class="db-kpi-val" style="color:var(--green)">{{ number_format($totalAgents) }}</div>
        <div class="db-kpi-label">Registered Agents</div>
        <div class="db-kpi-footer">
            <div class="db-kpi-bar-track"><div class="db-kpi-bar-fill" style="width:60%;background:var(--green)"></div></div>
            <span class="db-kpi-pct">+{{ $agentsPerMonth[5] ?? 0 }} this month</span>
        </div>
    </div>

    <div class="db-kpi" style="--kpi-color:var(--gold)">
        <div class="db-kpi-top">
            <div class="db-kpi-icon" style="background:var(--gold-bg)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <span class="db-kpi-badge neu">Staff</span>
        </div>
        <div class="db-kpi-val">{{ number_format($totalConsultants) }}</div>
        <div class="db-kpi-label">Consultants</div>
        <div class="db-kpi-footer">
            <div class="db-kpi-bar-track"><div class="db-kpi-bar-fill" style="width:45%"></div></div>
            <span class="db-kpi-pct">{{ $totalPros }} Pros · {{ $totalStaff }} Staff</span>
        </div>
    </div>

    <div class="db-kpi" style="--kpi-color:var(--amber)">
        <div class="db-kpi-top">
            <div class="db-kpi-icon" style="background:rgba(217,119,6,.08)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="14" height="11" rx="2"/><path d="M16 8a4 4 0 0 1 4 4v7H7v-3"/></svg>
            </div>
            @if($pendingBookings > 0)
                <span class="db-kpi-badge warn">{{ $pendingBookings }} pending</span>
            @else
                <span class="db-kpi-badge neu">All clear</span>
            @endif
        </div>
        <div class="db-kpi-val" style="color:var(--amber)">{{ number_format($totalBookings) }}</div>
        <div class="db-kpi-label">Bookings</div>
        <div class="db-kpi-footer">
            <div class="db-kpi-bar-track"><div class="db-kpi-bar-fill" style="width:55%;background:var(--amber)"></div></div>
            <a href="{{ route('admin.bookings.index') }}" class="db-kpi-pct" style="color:var(--gold);text-decoration:none;font-weight:600;">View →</a>
        </div>
    </div>

    <div class="db-kpi" style="--kpi-color:var(--red)">
        <div class="db-kpi-top">
            <div class="db-kpi-icon" style="background:rgba(217,79,79,.08)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#d94f4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
            </div>
            <span class="db-kpi-badge neu">Tenders</span>
        </div>
        <div class="db-kpi-val" style="color:var(--red)">{{ number_format($totalTenders) }}</div>
        <div class="db-kpi-label">Active Tenders</div>
        <div class="db-kpi-footer">
            <div class="db-kpi-bar-track"><div class="db-kpi-bar-fill" style="width:35%;background:var(--red)"></div></div>
            <a href="{{ route('admin.tenders.index') }}" class="db-kpi-pct" style="color:var(--gold);text-decoration:none;font-weight:600;">View →</a>
        </div>
    </div>

</div>

{{-- ── Row 1: Listings trend + Property type donut ─────────────── --}}
<div class="db-row db-row-3">

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:var(--gold-bg)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
                <div>
                    <div class="db-card-title">Property Listings Trend</div>
                    <div class="db-card-sub">Houses · Lands · Designs — last 6 months</div>
                </div>
            </div>
            <div class="db-tabs">
                <button class="db-tab active" onclick="switchChart('listings','6m',this)">6M</button>
                <button class="db-tab" onclick="switchChart('listings','1y',this)">1Y</button>
            </div>
        </div>
        <div class="db-chart-wrap db-chart-md">
            <canvas id="listingsChart"></canvas>
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:var(--navy-bg)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#19265d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="db-card-title">Property Types</div>
                    <div class="db-card-sub">Distribution by category</div>
                </div>
            </div>
        </div>
        <div class="db-chart-wrap db-chart-sm db-ring-wrap" style="padding-top:.5rem">
            <canvas id="typeDonut" style="max-width:170px;max-height:170px;"></canvas>
            <div class="db-donut-center">
                <div class="db-donut-val">{{ $totalProperties }}</div>
                <div class="db-donut-sub">Total</div>
            </div>
        </div>
        <div class="db-stat-list" style="border-top:1px solid var(--border)">
            <div class="db-stat-row">
                <div class="db-stat-dot" style="background:var(--blue)"></div>
                <span class="db-stat-lbl">Houses</span>
                <div class="db-stat-bar"><div class="db-stat-fill" style="width:{{ $totalProperties>0?round($totalHouses/$totalProperties*100):0 }}%;background:var(--blue)"></div></div>
                <span class="db-stat-val">{{ $totalHouses }}</span>
                <span class="db-stat-pct">{{ $totalProperties>0?round($totalHouses/$totalProperties*100):0 }}%</span>
            </div>
            <div class="db-stat-row">
                <div class="db-stat-dot" style="background:var(--teal)"></div>
                <span class="db-stat-lbl">Land</span>
                <div class="db-stat-bar"><div class="db-stat-fill" style="width:{{ $totalProperties>0?round($totalLands/$totalProperties*100):0 }}%;background:var(--teal)"></div></div>
                <span class="db-stat-val">{{ $totalLands }}</span>
                <span class="db-stat-pct">{{ $totalProperties>0?round($totalLands/$totalProperties*100):0 }}%</span>
            </div>
            <div class="db-stat-row">
                <div class="db-stat-dot" style="background:var(--purple)"></div>
                <span class="db-stat-lbl">Designs</span>
                <div class="db-stat-bar"><div class="db-stat-fill" style="width:{{ $totalProperties>0?round($totalDesigns/$totalProperties*100):0 }}%;background:var(--purple)"></div></div>
                <span class="db-stat-val">{{ $totalDesigns }}</span>
                <span class="db-stat-pct">{{ $totalProperties>0?round($totalDesigns/$totalProperties*100):0 }}%</span>
            </div>
        </div>
    </div>

</div>

{{-- ── Row 2: User growth + Blog + Booking status ─────────────── --}}
<div class="db-row db-row-3">

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:rgba(42,157,92,.08)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2a9d5c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <div class="db-card-title">User Growth</div>
                    <div class="db-card-sub">Agents & Consultants registered — 6 months</div>
                </div>
            </div>
        </div>
        <div class="db-chart-wrap db-chart-md">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:rgba(217,79,79,.08)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d94f4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </div>
                <div>
                    <div class="db-card-title">Blog Activity</div>
                    <div class="db-card-sub">Published vs drafts</div>
                </div>
            </div>
            <a href="{{ route('admin.blogs.index') }}" class="db-view-link">View all →</a>
        </div>
        <div class="db-chart-wrap db-chart-md">
            <canvas id="blogChart"></canvas>
        </div>
    </div>

</div>

{{-- ── Finance summary ──────────────────────────────────────────── --}}
<div class="db-row" style="grid-template-columns:1fr">
    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:var(--gold-bg)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v2M12 16v2M9.17 9.17a4 4 0 0 1 5.66 5.66"/></svg>
                </div>
                <div>
                    <div class="db-card-title">Finance Overview</div>
                    <div class="db-card-sub">Commissions · Ads · Jobs</div>
                </div>
            </div>
            <a href="{{ route('admin.commissions.index') }}" class="db-view-link">Commissions →</a>
        </div>
        <div class="db-finance-grid">
            <div class="db-finance-item">
                <div class="db-finance-label">Total Commissions</div>
                <div class="db-finance-val">RWF {{ number_format($totalCommissions) }}</div>
                <div class="db-finance-sub">All time earned</div>
            </div>
            <div class="db-finance-item" style="background:rgba(42,157,92,.06)">
                <div class="db-finance-label">Paid Out</div>
                <div class="db-finance-val" style="color:var(--green)">RWF {{ number_format($paidCommissions) }}</div>
                <div class="db-finance-sub">Cleared to agents</div>
            </div>
            <div class="db-finance-item" style="background:rgba(217,119,6,.06)">
                <div class="db-finance-label">Pending</div>
                <div class="db-finance-val" style="color:var(--amber)">RWF {{ number_format($pendingComms) }}</div>
                <div class="db-finance-sub">Awaiting approval</div>
            </div>
            <div class="db-finance-item" style="background:rgba(208,82,8,.06)">
                <div class="db-finance-label">Ad Revenue</div>
                <div class="db-finance-val" style="color:var(--gold)">RWF {{ number_format($adRevenue) }}</div>
                <div class="db-finance-sub">{{ $approvedAds }} ads approved · {{ $pendingAds }} pending</div>
            </div>
            <div class="db-finance-item">
                <div class="db-finance-label">Active Job Listings</div>
                <div class="db-finance-val">{{ $activeJobs }}</div>
                <div class="db-finance-sub">{{ $expiredJobs }} expired</div>
            </div>
            <div class="db-finance-item">
                <div class="db-finance-label">Platform Users</div>
                <div class="db-finance-val">{{ number_format($totalUsers) }}</div>
                <div class="db-finance-sub">Registered accounts</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Row 3: Tasks + Booking donut ─────────────────────────────── --}}
<div class="db-row db-row-2">

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:rgba(217,119,6,.08)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <div>
                    <div class="db-card-title">Task Status</div>
                    <div class="db-card-sub">Open · Review · Completed</div>
                </div>
            </div>
            <a href="{{ route('admin.tasks.index') }}" class="db-view-link">Manage →</a>
        </div>
        <div class="db-task-bar">
            <div class="db-task-pill">
                <div class="db-task-pill-val" style="color:var(--amber)">{{ $tasksOpen }}</div>
                <div class="db-task-pill-lbl">Open</div>
            </div>
            <div class="db-task-pill">
                <div class="db-task-pill-val" style="color:var(--blue)">{{ $tasksReview }}</div>
                <div class="db-task-pill-lbl">In Review</div>
            </div>
            <div class="db-task-pill">
                <div class="db-task-pill-val" style="color:var(--green)">{{ $tasksDone }}</div>
                <div class="db-task-pill-lbl">Completed</div>
            </div>
            <div class="db-task-pill">
                <div class="db-task-pill-val">{{ $totalTasks }}</div>
                <div class="db-task-pill-lbl">Total</div>
            </div>
        </div>
        <div class="db-chart-wrap" style="height:160px;padding-top:.5rem">
            <canvas id="taskChart"></canvas>
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:rgba(37,99,235,.08)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="14" height="11" rx="2"/><path d="M16 8a4 4 0 0 1 4 4v7H7v-3"/></svg>
                </div>
                <div>
                    <div class="db-card-title">Booking Status</div>
                    <div class="db-card-sub">Confirmed · Pending · Rejected</div>
                </div>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="db-view-link">View all →</a>
        </div>
        <div class="db-chart-wrap" style="height:220px;position:relative;display:flex;align-items:center;justify-content:center;">
            <canvas id="bookingDonut" style="max-width:180px;max-height:180px;"></canvas>
            <div class="db-donut-center">
                <div class="db-donut-val">{{ $totalBookings }}</div>
                <div class="db-donut-sub">Bookings</div>
            </div>
        </div>
        @php
            $bConfirmed = $bookingStatuses['confirmed'] ?? 0;
            $bPending   = $bookingStatuses['pending']   ?? 0;
            $bRejected  = $bookingStatuses['rejected']  ?? 0;
        @endphp
        <div class="db-stat-list" style="border-top:1px solid var(--border)">
            <div class="db-stat-row">
                <div class="db-stat-dot" style="background:var(--green)"></div>
                <span class="db-stat-lbl">Confirmed</span>
                <div class="db-stat-bar"><div class="db-stat-fill" style="width:{{ $totalBookings>0?round($bConfirmed/$totalBookings*100):0 }}%;background:var(--green)"></div></div>
                <span class="db-stat-val">{{ $bConfirmed }}</span>
            </div>
            <div class="db-stat-row">
                <div class="db-stat-dot" style="background:var(--amber)"></div>
                <span class="db-stat-lbl">Pending</span>
                <div class="db-stat-bar"><div class="db-stat-fill" style="width:{{ $totalBookings>0?round($bPending/$totalBookings*100):0 }}%;background:var(--amber)"></div></div>
                <span class="db-stat-val">{{ $bPending }}</span>
            </div>
            <div class="db-stat-row">
                <div class="db-stat-dot" style="background:var(--red)"></div>
                <span class="db-stat-lbl">Rejected</span>
                <div class="db-stat-bar"><div class="db-stat-fill" style="width:{{ $totalBookings>0?round($bRejected/$totalBookings*100):0 }}%;background:var(--red)"></div></div>
                <span class="db-stat-val">{{ $bRejected }}</span>
            </div>
        </div>
    </div>

</div>

{{-- ── Row 4: Recent properties + Activity + Quick actions ─────── --}}
<div class="db-row db-row-32">

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:var(--gold-bg)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                </div>
                <div><div class="db-card-title">Recent Properties</div></div>
            </div>
            <a href="{{ route('admin.properties.houses.index') }}" class="db-view-link">View all →</a>
        </div>
        <div class="db-card-body np">
            <table class="db-table">
                <thead><tr>
                    <th>Title</th><th>Type</th><th>Status</th><th>Listed</th>
                </tr></thead>
                <tbody>
                    @forelse($recentProps as $p)
                    <tr>
                        <td style="font-weight:500;color:var(--navy);max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $p['title'] }}</td>
                        <td><span class="db-badge {{ strtolower($p['type']) }}">{{ $p['type'] }}</span></td>
                        <td><span class="db-badge {{ $p['status'] }}">{{ ucfirst($p['status']) }}</span></td>
                        <td style="font-size:.75rem;color:var(--muted)">{{ $p['date'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;padding:1.5rem;color:var(--muted);font-size:.82rem;">No properties yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:rgba(13,148,136,.08)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div><div class="db-card-title">Recent Activity</div></div>
            </div>
            <a href="{{ route('admin.activity-logs.index') }}" class="db-view-link">All logs →</a>
        </div>
        <div class="db-feed">
            @forelse($recentActivity as $log)
            <div class="db-feed-item">
                <div class="db-feed-ico" style="background:var(--navy-bg)">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#19265d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="db-feed-content">
                    <p class="db-feed-title">{{ $log->description ?? 'Activity recorded' }}</p>
                    <span class="db-feed-time">{{ $log->user->name ?? 'System' }} · {{ Carbon::parse($log->created_at)->diffForHumans() }}</span>
                </div>
            </div>
            @empty
            {{-- Fallback static feed --}}
            <div class="db-feed-item">
                <div class="db-feed-ico" style="background:var(--gold-bg)">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                </div>
                <div class="db-feed-content">
                    <p class="db-feed-title"><strong>Property</strong> listed</p>
                    <span class="db-feed-time">Just now</span>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-head">
            <div class="db-card-head-l">
                <div class="db-card-ico" style="background:var(--gold-bg)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                </div>
                <div><div class="db-card-title">Quick Actions</div></div>
            </div>
        </div>
        <div class="db-quick-grid">
            <a href="{{ route('admin.properties.lands.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:rgba(13,148,136,.08)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg></div>
                Add Land
            </a>
            <a href="{{ route('admin.properties.houses.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:rgba(37,99,235,.08)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                Add House
            </a>
            <a href="{{ route('admin.agents.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:rgba(42,157,92,.08)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#2a9d5c" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                Add Agent
            </a>
            <a href="{{ route('admin.consultants.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:var(--gold-bg)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                Add Consultant
            </a>
            <a href="{{ route('admin.blogs.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:rgba(217,79,79,.08)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#d94f4f" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
                New Post
            </a>
            <a href="{{ route('admin.tenders.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:rgba(124,58,237,.08)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg></div>
                Post Tender
            </a>
            <a href="{{ route('admin.announcements.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:rgba(217,119,6,.08)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/></svg></div>
                Announce
            </a>
            <a href="{{ route('admin.staff.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:var(--navy-bg)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#19265d" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                Add Staff
            </a>
            <a href="{{ route('admin.professionals.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:rgba(13,148,136,.08)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M22 20V8l-10-6L2 8v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2z"/></svg></div>
                Add Pro
            </a>
            <a href="{{ route('admin.tasks.create') }}" class="db-quick-btn">
                <div class="db-quick-ico" style="background:rgba(217,119,6,.08)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M9 11l3 3L22 4"/></svg></div>
                New Task
            </a>
        </div>
    </div>

</div>

</div>{{-- /db --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.font.size   = 12;
Chart.defaults.color       = 'rgba(25,38,93,0.45)';

const grid  = 'rgba(25,38,93,0.07)';
const navy  = '#19265d';
const gold  = '#D05208';
const blue  = '#2563eb';
const teal  = '#0d9488';
const green = '#2a9d5c';
const red   = '#d94f4f';
const amber = '#d97706';
const purp  = '#7c3aed';

const months6  = @json($monthLabels);
const houses6  = @json($housesPerMonth);
const lands6   = @json($landsPerMonth);
const designs6 = @json($designsPerMonth);

/* ── Listings chart ── */
const lCtx = document.getElementById('listingsChart').getContext('2d');
const listingsChart = new Chart(lCtx, {
    type: 'line',
    data: {
        labels: months6,
        datasets: [
            { label:'Houses',  data:houses6,  borderColor:blue,  backgroundColor:'rgba(37,99,235,.07)',  borderWidth:2.2, pointBackgroundColor:blue,  pointRadius:4, pointHoverRadius:6, fill:true, tension:.4 },
            { label:'Land',    data:lands6,   borderColor:teal,  backgroundColor:'rgba(13,148,136,.07)', borderWidth:2.2, pointBackgroundColor:teal,  pointRadius:4, pointHoverRadius:6, fill:true, tension:.4 },
            { label:'Designs', data:designs6, borderColor:purp,  backgroundColor:'rgba(124,58,237,.07)', borderWidth:2.2, pointBackgroundColor:purp,  pointRadius:4, pointHoverRadius:6, fill:true, tension:.4 },
        ],
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins: {
            legend:{ position:'top', labels:{ boxWidth:10, padding:16, usePointStyle:true } },
            tooltip:{ mode:'index', intersect:false },
        },
        scales: {
            x:{ grid:{ color:grid }, border:{ display:false } },
            y:{ grid:{ color:grid }, border:{ display:false }, beginAtZero:true },
        },
    },
});

/* ── Type donut ── */
new Chart(document.getElementById('typeDonut').getContext('2d'), {
    type:'doughnut',
    data:{
        labels:['Houses','Land','Designs'],
        datasets:[{ data:[{{ $totalHouses }},{{ $totalLands }},{{ $totalDesigns }}], backgroundColor:[blue,teal,purp], borderWidth:3, borderColor:'#fff', hoverOffset:5 }],
    },
    options:{
        responsive:true, maintainAspectRatio:false, cutout:'72%',
        plugins:{ legend:{ display:false }, tooltip:{ callbacks:{ label:ctx=>` ${ctx.label}: ${ctx.parsed}` } } },
    },
});

/* ── User growth ── */
new Chart(document.getElementById('userGrowthChart').getContext('2d'), {
    type:'bar',
    data:{
        labels: months6,
        datasets:[
            { label:'Agents',      data: @json($agentsPerMonth),      backgroundColor:'rgba(42,157,92,.75)',  borderRadius:5, borderSkipped:false },
            { label:'Consultants', data: @json($consultantsPerMonth), backgroundColor:'rgba(208,82,8,.65)',   borderRadius:5, borderSkipped:false },
        ],
    },
    options:{
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'top', labels:{ boxWidth:10, padding:14, usePointStyle:true } } },
        scales:{
            x:{ grid:{ display:false }, border:{ display:false } },
            y:{ grid:{ color:grid }, border:{ display:false }, beginAtZero:true, ticks:{ stepSize:1 } },
        },
    },
});

/* ── Blog chart ── */
new Chart(document.getElementById('blogChart').getContext('2d'), {
    type:'bar',
    data:{
        labels: months6,
        datasets:[
            { label:'Published', data: @json($blogsPublished), backgroundColor:'rgba(217,79,79,.8)',  borderRadius:5, stack:'b' },
            { label:'Drafts',    data: @json($blogsDraft),     backgroundColor:'rgba(217,79,79,.2)', borderRadius:5, stack:'b' },
        ],
    },
    options:{
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'top', labels:{ boxWidth:10, padding:14, usePointStyle:true } } },
        scales:{
            x:{ stacked:true, grid:{ display:false }, border:{ display:false } },
            y:{ stacked:true, grid:{ color:grid }, border:{ display:false }, beginAtZero:true },
        },
    },
});

/* ── Task bar chart ── */
new Chart(document.getElementById('taskChart').getContext('2d'), {
    type:'bar',
    data:{
        labels:['Open','In Review','Completed'],
        datasets:[{
            data:[{{ $tasksOpen }},{{ $tasksReview }},{{ $tasksDone }}],
            backgroundColor:[amber, blue, green],
            borderRadius:6, borderSkipped:false,
        }],
    },
    options:{
        indexAxis:'y',
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ display:false } },
        scales:{
            x:{ grid:{ color:grid }, border:{ display:false }, beginAtZero:true },
            y:{ grid:{ display:false }, border:{ display:false } },
        },
    },
});

/* ── Booking donut ── */
new Chart(document.getElementById('bookingDonut').getContext('2d'), {
    type:'doughnut',
    data:{
        labels:['Confirmed','Pending','Rejected'],
        datasets:[{
            data:[{{ $bConfirmed }},{{ $bPending }},{{ $bRejected }}],
            backgroundColor:[green, amber, red],
            borderWidth:3, borderColor:'#fff', hoverOffset:5,
        }],
    },
    options:{
        responsive:true, maintainAspectRatio:false, cutout:'70%',
        plugins:{ legend:{ display:false } },
    },
});

/* ── Period switcher (stub for 1Y — wire up if you have the data) ── */
function switchChart(chart, period, btn) {
    btn.closest('.db-tabs').querySelectorAll('.db-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
}
</script>

@endsection