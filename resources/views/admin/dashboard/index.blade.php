@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<style>
    :root{
        --accent:#c9a96e;--accent-lt:#e4c990;--accent-dk:#a07840;
        --danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;
        --muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;
        --radius:12px;--green:#22c55e;--amber:#f59e0b;--blue:#3b82f6;
        --indigo:#4f46e5;--rose:#e11d48;--teal:#0d9488;--purple:#7c3aed;
    }

    .db-wrap{padding:1.75rem 0 3rem;}

    /* ── Welcome bar ── */
    .db-welcome{
        display:flex;align-items:center;justify-content:space-between;
        flex-wrap:wrap;gap:1rem;margin-bottom:2rem;
    }
    .db-welcome h3{font-size:1.4rem;font-weight:700;color:var(--text);margin:0;}
    .db-welcome p{font-size:.85rem;color:var(--muted);margin:.2rem 0 0;}
    .db-welcome-right{display:flex;align-items:center;gap:.75rem;}
    .db-date-chip{
        display:flex;align-items:center;gap:.4rem;
        padding:.5rem 1rem;border-radius:8px;border:1px solid var(--border);
        background:#fff;font-size:.8rem;color:var(--text-dim);font-weight:500;
    }

    /* ── KPI cards ── */
    .db-kpi-grid{
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
        gap:1.25rem;margin-bottom:1.75rem;
    }
    .db-kpi{
        background:#fff;border:1px solid var(--border);
        border-radius:var(--radius);padding:1.25rem 1.4rem;
        position:relative;overflow:hidden;transition:box-shadow .2s,transform .2s;
    }
    .db-kpi:hover{box-shadow:0 6px 24px rgba(0,0,0,.07);transform:translateY(-2px);}
    .db-kpi-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:.9rem;}
    .db-kpi-icon{
        width:42px;height:42px;border-radius:10px;
        display:flex;align-items:center;justify-content:center;flex-shrink:0;
    }
    .db-kpi-badge{
        display:inline-flex;align-items:center;gap:.25rem;
        padding:.2rem .55rem;border-radius:100px;font-size:.7rem;font-weight:600;
    }
    .db-kpi-badge.up{background:#f0fdf4;color:#166534;}
    .db-kpi-badge.down{background:#fef2f2;color:#991b1b;}
    .db-kpi-badge.neutral{background:var(--surface);color:var(--muted);}
    .db-kpi-val{font-size:1.75rem;font-weight:700;color:var(--text);line-height:1;margin-bottom:.25rem;}
    .db-kpi-label{font-size:.75rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--muted);}
    .db-kpi-bar{height:3px;border-radius:100px;margin-top:1rem;background:var(--bar-bg,#e2e8f0);}
    .db-kpi-bar-fill{height:100%;border-radius:100px;background:var(--bar-color,var(--accent));}

    /* ── Layout rows ── */
    .db-row{display:grid;gap:1.25rem;margin-bottom:1.75rem;}
    .db-row-2{grid-template-columns:1fr 1fr;}
    .db-row-3{grid-template-columns:2fr 1fr;}
    .db-row-full{grid-template-columns:1fr;}

    /* ── Cards ── */
    .db-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .db-card-header{
        display:flex;align-items:center;justify-content:space-between;
        padding:1rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);
    }
    .db-card-header-left{display:flex;align-items:center;gap:.65rem;}
    .db-card-header-icon{
        width:30px;height:30px;border-radius:8px;
        display:flex;align-items:center;justify-content:center;flex-shrink:0;
    }
    .db-card-title{font-size:.88rem;font-weight:600;color:var(--text);margin:0;}
    .db-card-subtitle{font-size:.73rem;color:var(--muted);margin-top:.1rem;}
    .db-card-body{padding:1.4rem;}
    .db-card-body.no-pad{padding:0;}

    /* ── Period tabs ── */
    .db-tabs{display:flex;gap:.3rem;}
    .db-tab{
        padding:.28rem .7rem;border-radius:6px;font-size:.74rem;font-weight:600;
        border:none;cursor:pointer;transition:all .15s;font-family:inherit;
        background:none;color:var(--muted);
    }
    .db-tab.active{background:var(--accent);color:#fff;}
    .db-tab:hover:not(.active){background:var(--surface);color:var(--text-dim);}

    /* ── Chart containers ── */
    .db-chart-wrap{padding:1.4rem;position:relative;}
    .db-chart-sm{height:200px;}
    .db-chart-md{height:260px;}
    .db-chart-lg{height:300px;}

    /* ── Activity feed ── */
    .db-feed{display:flex;flex-direction:column;}
    .db-feed-item{
        display:flex;align-items:flex-start;gap:.9rem;
        padding:.9rem 1.4rem;border-bottom:1px solid var(--border);
    }
    .db-feed-item:last-child{border-bottom:none;}
    .db-feed-icon{
        width:32px;height:32px;border-radius:50%;display:flex;align-items:center;
        justify-content:center;flex-shrink:0;margin-top:.1rem;
    }
    .db-feed-content{flex:1;min-width:0;}
    .db-feed-title{font-size:.84rem;font-weight:500;color:var(--text);margin:0 0 .15rem;}
    .db-feed-title strong{font-weight:700;}
    .db-feed-time{font-size:.72rem;color:var(--muted);}

    /* ── Stat list ── */
    .db-stat-list{display:flex;flex-direction:column;gap:0;}
    .db-stat-row{
        display:flex;align-items:center;gap:.75rem;
        padding:.8rem 1.4rem;border-bottom:1px solid var(--border);
    }
    .db-stat-row:last-child{border-bottom:none;}
    .db-stat-row-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .db-stat-row-label{font-size:.83rem;color:var(--text-dim);flex:1;}
    .db-stat-row-val{font-size:.83rem;font-weight:700;color:var(--text);}
    .db-stat-row-pct{font-size:.72rem;color:var(--muted);margin-left:.3rem;}
    .db-stat-bar-wrap{width:70px;height:5px;border-radius:100px;background:var(--border);overflow:hidden;}
    .db-stat-bar-fill{height:100%;border-radius:100px;}

    /* ── Recent table ── */
    .db-mini-table{width:100%;border-collapse:collapse;font-size:.83rem;}
    .db-mini-table th{
        padding:.65rem 1.4rem;text-align:left;font-size:.68rem;
        font-weight:700;letter-spacing:.07em;text-transform:uppercase;
        color:var(--muted);border-bottom:1px solid var(--border);
        background:var(--surface);white-space:nowrap;
    }
    .db-mini-table td{
        padding:.8rem 1.4rem;border-bottom:1px solid var(--border);
        vertical-align:middle;
    }
    .db-mini-table tr:last-child td{border-bottom:none;}
    .db-mini-table tbody tr:hover{background:#fafafa;}
    .db-badge{
        display:inline-flex;align-items:center;gap:.25rem;
        padding:.2rem .6rem;border-radius:100px;font-size:.68rem;font-weight:600;
    }

    /* ── Quick links ── */
    .db-quick-grid{display:grid;grid-template-columns:1fr 1fr;gap:.65rem;padding:1.4rem;}
    .db-quick-btn{
        display:flex;align-items:center;gap:.6rem;padding:.7rem .9rem;
        border-radius:8px;border:1.5px solid var(--border);background:#fff;
        font-family:inherit;font-size:.8rem;font-weight:500;cursor:pointer;
        text-decoration:none;color:var(--text-dim);transition:all .15s;
    }
    .db-quick-btn:hover{border-color:var(--accent);color:var(--text);background:#c9a96e06;}
    .db-quick-icon{width:26px;height:26px;border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}

    /* ── Progress ring (donut center) ── */
    .db-donut-center{
        position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
        text-align:center;pointer-events:none;
    }
    .db-donut-val{font-size:1.4rem;font-weight:700;color:var(--text);line-height:1;}
    .db-donut-sub{font-size:.68rem;color:var(--muted);margin-top:.2rem;}

    @media(max-width:960px){.db-row-2,.db-row-3{grid-template-columns:1fr;}}
    @media(max-width:640px){.db-kpi-grid{grid-template-columns:1fr 1fr;}}
    @media(max-width:420px){.db-kpi-grid{grid-template-columns:1fr;}}
</style>

<div class="db-wrap">

    {{-- ── Welcome ── --}}
    <div class="db-welcome">
        <div>
            <h3>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ Auth::user()->name }} 👋</h3>
            <p>Here's what's happening on your platform today.</p>
        </div>
        <div class="db-welcome-right">
            <div class="db-date-chip">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="db-kpi-grid">

        <div class="db-kpi">
            <div class="db-kpi-top">
                <div class="db-kpi-icon" style="background:#c9a96e18;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <span class="db-kpi-badge up">↑ 12%</span>
            </div>
            <div class="db-kpi-val">{{ $stats['properties'] ?? 284 }}</div>
            <div class="db-kpi-label">Properties</div>
            <div class="db-kpi-bar" style="--bar-bg:#c9a96e20">
                <div class="db-kpi-bar-fill" style="width:72%;--bar-color:var(--accent)"></div>
            </div>
        </div>

        <div class="db-kpi">
            <div class="db-kpi-top">
                <div class="db-kpi-icon" style="background:#3b82f618;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="db-kpi-badge up">↑ 8%</span>
            </div>
            <div class="db-kpi-val" style="color:var(--blue)">{{ $stats['agents'] ?? 47 }}</div>
            <div class="db-kpi-label">Agents</div>
            <div class="db-kpi-bar" style="--bar-bg:#3b82f620">
                <div class="db-kpi-bar-fill" style="width:55%;--bar-color:var(--blue)"></div>
            </div>
        </div>

        <div class="db-kpi">
            <div class="db-kpi-top">
                <div class="db-kpi-icon" style="background:#22c55e18;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
                <span class="db-kpi-badge up">↑ 23%</span>
            </div>
            <div class="db-kpi-val" style="color:var(--green)">{{ $stats['consultants'] ?? 19 }}</div>
            <div class="db-kpi-label">Consultants</div>
            <div class="db-kpi-bar" style="--bar-bg:#22c55e20">
                <div class="db-kpi-bar-fill" style="width:40%;--bar-color:var(--green)"></div>
            </div>
        </div>

        <div class="db-kpi">
            <div class="db-kpi-top">
                <div class="db-kpi-icon" style="background:#e11d4818;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                </div>
                <span class="db-kpi-badge neutral">→ 0%</span>
            </div>
            <div class="db-kpi-val" style="color:var(--rose)">{{ $stats['blogs'] ?? 36 }}</div>
            <div class="db-kpi-label">Blog Posts</div>
            <div class="db-kpi-bar" style="--bar-bg:#e11d4820">
                <div class="db-kpi-bar-fill" style="width:60%;--bar-color:var(--rose)"></div>
            </div>
        </div>

        <div class="db-kpi">
            <div class="db-kpi-top">
                <div class="db-kpi-icon" style="background:#7c3aed18;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <span class="db-kpi-badge up">↑ 5%</span>
            </div>
            <div class="db-kpi-val" style="color:var(--purple)">{{ $stats['announcements'] ?? 8 }}</div>
            <div class="db-kpi-label">Announcements</div>
            <div class="db-kpi-bar" style="--bar-bg:#7c3aed20">
                <div class="db-kpi-bar-fill" style="width:30%;--bar-color:var(--purple)"></div>
            </div>
        </div>

        <div class="db-kpi">
            <div class="db-kpi-top">
                <div class="db-kpi-icon" style="background:#0d948818;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                </div>
                <span class="db-kpi-badge down">↓ 3%</span>
            </div>
            <div class="db-kpi-val" style="color:var(--teal)">{{ $stats['tenders'] ?? 12 }}</div>
            <div class="db-kpi-label">Tenders</div>
            <div class="db-kpi-bar" style="--bar-bg:#0d948820">
                <div class="db-kpi-bar-fill" style="width:45%;--bar-color:var(--teal)"></div>
            </div>
        </div>

    </div>

    {{-- ── Row 1: Revenue chart + Donut ── --}}
    <div class="db-row db-row-3">

        {{-- Properties over time ── --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-header-icon" style="background:#c9a96e18;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                    </div>
                    <div>
                        <div class="db-card-title">Property Listings</div>
                        <div class="db-card-subtitle">New listings per month</div>
                    </div>
                </div>
                <div class="db-tabs">
                    <button class="db-tab active" onclick="switchPeriod('6m',this)">6M</button>
                    <button class="db-tab" onclick="switchPeriod('1y',this)">1Y</button>
                </div>
            </div>
            <div class="db-chart-wrap db-chart-md">
                <canvas id="listingsChart"></canvas>
            </div>
        </div>

        {{-- Property type donut ── --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-header-icon" style="background:#3b82f618;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    </div>
                    <div>
                        <div class="db-card-title">Property Types</div>
                        <div class="db-card-subtitle">Distribution</div>
                    </div>
                </div>
            </div>
            <div class="db-chart-wrap db-chart-md" style="position:relative;display:flex;align-items:center;justify-content:center;">
                <canvas id="typeDonut" style="max-width:200px;max-height:200px;"></canvas>
                <div class="db-donut-center">
                    <div class="db-donut-val">284</div>
                    <div class="db-donut-sub">Total</div>
                </div>
            </div>
            <div class="db-stat-list" style="border-top:1px solid var(--border)">
                <div class="db-stat-row">
                    <div class="db-stat-row-dot" style="background:var(--accent)"></div>
                    <span class="db-stat-row-label">Houses</span>
                    <div class="db-stat-bar-wrap"><div class="db-stat-bar-fill" style="width:65%;background:var(--accent)"></div></div>
                    <span class="db-stat-row-val">184</span><span class="db-stat-row-pct">65%</span>
                </div>
                <div class="db-stat-row">
                    <div class="db-stat-row-dot" style="background:var(--blue)"></div>
                    <span class="db-stat-row-label">Land</span>
                    <div class="db-stat-bar-wrap"><div class="db-stat-bar-fill" style="width:28%;background:var(--blue)"></div></div>
                    <span class="db-stat-row-val">80</span><span class="db-stat-row-pct">28%</span>
                </div>
                <div class="db-stat-row">
                    <div class="db-stat-row-dot" style="background:var(--teal)"></div>
                    <span class="db-stat-row-label">Commercial</span>
                    <div class="db-stat-bar-wrap"><div class="db-stat-bar-fill" style="width:7%;background:var(--teal)"></div></div>
                    <span class="db-stat-row-val">20</span><span class="db-stat-row-pct">7%</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Row 2: Bar + Line ── --}}
    <div class="db-row db-row-2">

        {{-- Staff by department ── --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-header-icon" style="background:#7c3aed18;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01M12 14h.01"/></svg>
                    </div>
                    <div>
                        <div class="db-card-title">Staff by Department</div>
                        <div class="db-card-subtitle">Headcount breakdown</div>
                    </div>
                </div>
            </div>
            <div class="db-chart-wrap db-chart-md">
                <canvas id="staffChart"></canvas>
            </div>
        </div>

        {{-- Blog posts trend ── --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-header-icon" style="background:#e11d4818;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    </div>
                    <div>
                        <div class="db-card-title">Blog Activity</div>
                        <div class="db-card-subtitle">Published vs drafts over time</div>
                    </div>
                </div>
            </div>
            <div class="db-chart-wrap db-chart-md">
                <canvas id="blogChart"></canvas>
            </div>
        </div>

    </div>

    {{-- ── Row 3: Activity + Recent + Quick links ── --}}
    <div class="db-row" style="grid-template-columns:1.4fr 1fr 280px;">

        {{-- Recent listings ── --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-header-icon" style="background:#c9a96e18;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <div><div class="db-card-title">Recent Properties</div></div>
                </div>
                <a href="{{ route('admin.properties.lands.index') ?? '#' }}"
                   style="font-size:.75rem;color:var(--accent);text-decoration:none;font-weight:600;">
                    View all →
                </a>
            </div>
            <div class="db-card-body no-pad">
                <table class="db-mini-table">
                    <thead><tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr></thead>
                    <tbody>
                        @php
                            $demoProps = [
                                ['title'=>'Kacyiru Residential Plot','type'=>'Land','status'=>'active','date'=>'2 hrs ago'],
                                ['title'=>'3-Bed House Kimironko','type'=>'House','status'=>'active','date'=>'5 hrs ago'],
                                ['title'=>'Gikondo Commercial Plot','type'=>'Land','status'=>'pending','date'=>'Yesterday'],
                                ['title'=>'Nyamirambo Villa','type'=>'House','status'=>'active','date'=>'2 days ago'],
                                ['title'=>'Gasabo Office Space','type'=>'Commercial','status'=>'inactive','date'=>'3 days ago'],
                            ];
                        @endphp
                        @foreach($demoProps as $p)
                        <tr>
                            <td style="font-weight:500;color:var(--text);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $p['title'] }}</td>
                            <td>
                                <span class="db-badge" style="
                                    {{ $p['type']==='House' ? 'background:#c9a96e12;color:var(--accent-dk);' : ($p['type']==='Land' ? 'background:#bfdbfe;color:#1e40af;' : 'background:#d1fae5;color:#065f46;') }}
                                ">{{ $p['type'] }}</span>
                            </td>
                            <td>
                                <span class="db-badge" style="
                                    {{ $p['status']==='active' ? 'background:#f0fdf4;color:#166534;' : ($p['status']==='pending' ? 'background:#fffbeb;color:#92400e;' : 'background:var(--surface);color:var(--muted);') }}
                                ">{{ ucfirst($p['status']) }}</span>
                            </td>
                            <td style="font-size:.75rem;color:var(--muted)">{{ $p['date'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Activity feed ── --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-header-icon" style="background:#0d948818;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div><div class="db-card-title">Recent Activity</div></div>
                </div>
            </div>
            <div class="db-feed">
                <div class="db-feed-item">
                    <div class="db-feed-icon" style="background:#c9a96e18;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                    <div class="db-feed-content">
                        <p class="db-feed-title"><strong>New property</strong> listed in Kigali</p>
                        <span class="db-feed-time">2 minutes ago</span>
                    </div>
                </div>
                <div class="db-feed-item">
                    <div class="db-feed-icon" style="background:#3b82f618;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                    <div class="db-feed-content">
                        <p class="db-feed-title"><strong>Agent</strong> account created</p>
                        <span class="db-feed-time">18 minutes ago</span>
                    </div>
                </div>
                <div class="db-feed-item">
                    <div class="db-feed-icon" style="background:#e11d4818;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
                    <div class="db-feed-content">
                        <p class="db-feed-title"><strong>Blog post</strong> published</p>
                        <span class="db-feed-time">1 hour ago</span>
                    </div>
                </div>
                <div class="db-feed-item">
                    <div class="db-feed-icon" style="background:#0d948818;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                    <div class="db-feed-content">
                        <p class="db-feed-title">New <strong>tender</strong> posted</p>
                        <span class="db-feed-time">3 hours ago</span>
                    </div>
                </div>
                <div class="db-feed-item">
                    <div class="db-feed-icon" style="background:#7c3aed18;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
                    <div class="db-feed-content">
                        <p class="db-feed-title"><strong>Announcement</strong> set to Paid</p>
                        <span class="db-feed-time">5 hours ago</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick links ── --}}
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-header-left">
                    <div class="db-card-header-icon" style="background:#f59e0b18;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                    </div>
                    <div><div class="db-card-title">Quick Actions</div></div>
                </div>
            </div>
            <div class="db-quick-grid">
                <a href="{{ route('admin.properties.lands.create') ?? '#' }}" class="db-quick-btn">
                    <div class="db-quick-icon" style="background:#c9a96e18;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></div>
                    Add Land
                </a>
                <a href="{{ route('admin.properties.houses.create') ?? '#' }}" class="db-quick-btn">
                    <div class="db-quick-icon" style="background:#3b82f618;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                    Add House
                </a>
                <a href="{{ route('admin.agents.create') ?? '#' }}" class="db-quick-btn">
                    <div class="db-quick-icon" style="background:#22c55e18;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
                    Add Agent
                </a>
                <a href="{{ route('admin.blogs.create') ?? '#' }}" class="db-quick-btn">
                    <div class="db-quick-icon" style="background:#e11d4818;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
                    New Post
                </a>
                <a href="{{ route('admin.tenders.create') ?? '#' }}" class="db-quick-btn">
                    <div class="db-quick-icon" style="background:#0d948818;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg></div>
                    Post Tender
                </a>
                <a href="{{ route('admin.announcements.create') ?? '#' }}" class="db-quick-btn">
                    <div class="db-quick-icon" style="background:#7c3aed18;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/></svg></div>
                    Announce
                </a>
                <a href="{{ route('admin.professionals.create') ?? '#' }}" class="db-quick-btn">
                    <div class="db-quick-icon" style="background:#7c3aed18;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><path d="M22 20V8l-10-6L2 8v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2z"/></svg></div>
                    Add Pro
                </a>
                <a href="{{ route('admin.staff.create') ?? '#' }}" class="db-quick-btn">
                    <div class="db-quick-icon" style="background:#f59e0b18;"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                    Add Staff
                </a>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
/* ── Shared defaults ── */
Chart.defaults.font.family = "'Inter','Segoe UI',sans-serif";
Chart.defaults.font.size   = 12;
Chart.defaults.color       = '#94a3b8';

const gridColor   = 'rgba(226,232,240,0.8)';
const accentColor = '#c9a96e';

/* ── Listings chart (line) ── */
const listingsData = {
    '6m': {
        labels : ['Oct','Nov','Dec','Jan','Feb','Mar'],
        houses : [18,22,19,27,31,25],
        land   : [8,10,7,12,9,14],
    },
    '1y': {
        labels : ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'],
        houses : [12,15,14,18,22,19,18,22,19,27,31,25],
        land   : [5,6,8,7,9,8,8,10,7,12,9,14],
    },
};
const listingsCtx = document.getElementById('listingsChart').getContext('2d');
const listingsChart = new Chart(listingsCtx, {
    type: 'line',
    data: {
        labels: listingsData['6m'].labels,
        datasets: [
            {
                label: 'Houses',
                data: listingsData['6m'].houses,
                borderColor: accentColor,
                backgroundColor: 'rgba(201,169,110,0.1)',
                borderWidth: 2.5,
                pointBackgroundColor: accentColor,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
            },
            {
                label: 'Land',
                data: listingsData['6m'].land,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.07)',
                borderWidth: 2.5,
                pointBackgroundColor: '#3b82f6',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top', labels: { boxWidth: 10, padding: 16, usePointStyle: true } },
            tooltip: { mode: 'index', intersect: false },
        },
        scales: {
            x: { grid: { color: gridColor }, border: { display: false } },
            y: {
                grid: { color: gridColor }, border: { display: false },
                ticks: { stepSize: 5 },
                beginAtZero: true,
            },
        },
    },
});

function switchPeriod(period, btn) {
    document.querySelectorAll('.db-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    const d = listingsData[period];
    listingsChart.data.labels          = d.labels;
    listingsChart.data.datasets[0].data = d.houses;
    listingsChart.data.datasets[1].data = d.land;
    listingsChart.update();
}

/* ── Type donut ── */
new Chart(document.getElementById('typeDonut').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Houses','Land','Commercial'],
        datasets: [{
            data: [184, 80, 20],
            backgroundColor: ['#c9a96e','#3b82f6','#0d9488'],
            hoverBackgroundColor: ['#b8915a','#2563eb','#0f766e'],
            borderWidth: 3,
            borderColor: '#fff',
            hoverOffset: 6,
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed} (${Math.round(ctx.parsed/284*100)}%)`,
                },
            },
        },
    },
});

/* ── Staff bar chart ── */
new Chart(document.getElementById('staffChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: ['Sales','Marketing','Tech','Finance','Admin','HR'],
        datasets: [{
            label: 'Headcount',
            data: [12, 8, 15, 6, 9, 5],
            backgroundColor: [
                'rgba(201,169,110,.8)','rgba(59,130,246,.8)',
                'rgba(124,58,237,.8)','rgba(16,185,129,.8)',
                'rgba(245,158,11,.8)','rgba(239,68,68,.8)',
            ],
            borderRadius: 6,
            borderSkipped: false,
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} people` } },
        },
        scales: {
            x: { grid: { display: false }, border: { display: false } },
            y: {
                grid: { color: gridColor }, border: { display: false },
                ticks: { stepSize: 3 }, beginAtZero: true,
            },
        },
    },
});

/* ── Blog activity ── */
new Chart(document.getElementById('blogChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: ['Oct','Nov','Dec','Jan','Feb','Mar'],
        datasets: [
            {
                label: 'Published',
                data: [4, 6, 3, 8, 5, 7],
                backgroundColor: 'rgba(225,29,72,0.8)',
                borderRadius: 5,
                stack: 'blog',
            },
            {
                label: 'Drafts',
                data: [2, 3, 4, 2, 3, 1],
                backgroundColor: 'rgba(225,29,72,0.2)',
                borderRadius: 5,
                stack: 'blog',
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top', labels: { boxWidth: 10, padding: 16, usePointStyle: true } },
        },
        scales: {
            x: { stacked: true, grid: { display: false }, border: { display: false } },
            y: { stacked: true, grid: { color: gridColor }, border: { display: false }, beginAtZero: true },
        },
    },
});
</script>

@endsection