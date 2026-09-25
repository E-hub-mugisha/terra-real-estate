@extends('layouts.guest')
@section('title', 'Brokerage Services')
@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root{
            --terra-navy: #142850;
            --terra-navy-deep: #0d1c38;
            --terra-orange: #F4801F;
            --terra-orange-dark: #d96c10;
            --terra-ink: #1c2b45;
            --terra-muted: #5f6b81;
            --terra-bg: #ffffff;
            --terra-panel: #f7f9fc;
            --terra-border: #e7eaf1;
            --terra-radius: 16px;
            --terra-max: 1240px;
            --terra-font-display: 'Poppins', 'Segoe UI', sans-serif;
            --terra-font-body: 'Inter', 'Segoe UI', sans-serif;
        }

        .terra-page *{ box-sizing: border-box; }
        .terra-page{
            font-family: var(--terra-font-body);
            color: var(--terra-ink);
            background: var(--terra-bg);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        .terra-page img{ max-width:100%; display:block; }
        .terra-page a{ color: inherit; text-decoration:none; }
        .terra-container{
            max-width: var(--terra-max);
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ---------- Banner ---------- */
        .terra-banner{
            position: relative;
            background:
                linear-gradient(115deg, rgba(13,28,56,.94) 0%, rgba(20,40,80,.88) 45%, rgba(20,40,80,.55) 100%),
                url('{{ asset('images/terra-banner.jpg') }}') center / cover no-repeat;
            padding: 96px 0 84px;
            overflow: hidden;
        }
        .terra-banner::after{
            content: "";
            position: absolute;
            right: -80px;
            bottom: -140px;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(244,128,31,.35), transparent 70%);
            pointer-events: none;
        }
        .terra-breadcrumb{
            display:flex;
            align-items:center;
            gap: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255,255,255,.65);
            margin-bottom: 18px;
            letter-spacing: .2px;
        }
        .terra-breadcrumb i{ font-size: 10px; opacity:.7; }
        .terra-breadcrumb .current{ color: var(--terra-orange); font-weight: 600; }
        .terra-banner h1{
            font-family: var(--terra-font-display);
            font-weight: 700;
            font-size: clamp(30px, 4vw, 46px);
            color: #fff;
            margin: 0 0 14px;
            max-width: 620px;
            position: relative;
            z-index: 1;
        }
        .terra-banner p{
            color: rgba(255,255,255,.78);
            font-size: 16px;
            max-width: 560px;
            margin: 0;
            position: relative;
            z-index: 1;
        }
        .terra-banner .rule{
            width: 56px;
            height: 3px;
            background: var(--terra-orange);
            margin: 20px 0 22px;
            position: relative;
            z-index: 1;
        }

        /* ---------- Section intro ---------- */
        .terra-services{
            background: var(--terra-bg);
            padding: 84px 0 96px;
        }
        .terra-section-head{
            display:flex;
            align-items:flex-end;
            justify-content: space-between;
            gap: 32px;
            margin-bottom: 52px;
            flex-wrap: wrap;
        }
        .terra-eyebrow{
            display:flex;
            align-items:center;
            gap: 10px;
            font-family: var(--terra-font-display);
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 1.6px;
            color: var(--terra-orange-dark);
            margin-bottom: 12px;
        }
        .terra-eyebrow .dot{
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--terra-orange);
        }
        .terra-section-head h2{
            font-family: var(--terra-font-display);
            font-weight: 700;
            font-size: clamp(24px, 2.6vw, 32px);
            color: var(--terra-navy);
            margin: 0;
            max-width: 560px;
        }
        .terra-section-head .lede{
            color: var(--terra-muted);
            font-size: 15px;
            max-width: 320px;
        }

        /* ---------- Services grid ---------- */
        .terra-services-grid{
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }
        .terra-service{
            background: var(--terra-panel);
            border: 1px solid var(--terra-border);
            border-radius: var(--terra-radius);
            padding: 30px 24px;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .terra-service:hover{
            transform: translateY(-4px);
            box-shadow: 0 16px 32px -18px rgba(20,40,80,.28);
            border-color: rgba(244,128,31,.35);
        }
        .terra-service-icon{
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: var(--terra-navy);
            color: var(--terra-orange);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size: 20px;
            margin-bottom: 18px;
        }
        .terra-service h4{
            font-family: var(--terra-font-display);
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.2px;
            color: var(--terra-navy);
            margin: 0 0 8px;
        }
        .terra-service p{
            font-size: 13.5px;
            color: var(--terra-muted);
            margin: 0;
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 980px){
            .terra-services-grid{ grid-template-columns: repeat(2, 1fr); }
            .terra-banner{ padding: 76px 0 64px; }
        }
        @media (max-width: 560px){
            .terra-services-grid{ grid-template-columns: 1fr; }
            .terra-section-head{ align-items:flex-start; }
            .terra-services{ padding: 64px 0 72px; }
        }
    </style>

<div class="terra-page">

    {{-- ============ BANNER ============ --}}
    <section class="terra-banner">
        <div class="terra-container">
            <div class="terra-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-angle-right"></i>
                <span class="current">Brokerage Services</span>
            </div>
            <h1>Real Estate &amp; Brokerage Services</h1>
            <div class="rule"></div>
            <p>From first search to final handover, Terra Real Estate guides every step of your property journey with clear advice, verified information and a trusted local team.</p>
        </div>
    </section>

    {{-- ============ SERVICES ============ --}}
    <section class="terra-services">
        <div class="terra-container">

            <div class="terra-section-head">
                <div>
                    <div class="terra-eyebrow"><span class="dot"></span>OUR SERVICES</div>
                    <h2>What we offer, at every stage of your property journey</h2>
                </div>
                <p class="lede">Twelve services built around one goal: a lasting, well-informed real estate decision.</p>
            </div>

            <div class="terra-services-grid">

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <h4>Property Discovery</h4>
                    <p>Find the right property and investment opportunities.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-comments"></i></div>
                    <h4>Property Advisory</h4>
                    <p>Professional guidance for property and real-estate decisions.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-file-shield"></i></div>
                    <h4>Property Due Diligence</h4>
                    <p>Verification of ownership, documentation and property information.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-bullhorn"></i></div>
                    <h4>Property Exposure</h4>
                    <p>Strategic marketing and promotion to reach potential buyers and investors.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-key"></i></div>
                    <h4>Property Tours</h4>
                    <p>Organized site visits and guided property experiences.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-handshake"></i></div>
                    <h4>Deal Structuring</h4>
                    <p>Support in pricing, negotiation and transaction terms.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-house-laptop"></i></div>
                    <h4>Property Marketplace</h4>
                    <p>Browse, buy, sell or rent properties easily and securely on our platform.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-file-contract"></i></div>
                    <h4>Transaction Management</h4>
                    <p>Coordination from initial agreement through completion.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-chart-line"></i></div>
                    <h4>Market Intelligence</h4>
                    <p>Research, valuation insights and market information.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-gears"></i></div>
                    <h4>Development Facilitation</h4>
                    <p>Connecting land, investors, professionals and development opportunities.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-people-group"></i></div>
                    <h4>Client Aftercare</h4>
                    <p>Continued support and connection beyond the transaction.</p>
                </div>

                <div class="terra-service">
                    <div class="terra-service-icon"><i class="fa-solid fa-house-chimney-window"></i></div>
                    <h4>Property Management</h4>
                    <p>Professional management of rental properties, tenants and property operations.</p>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection