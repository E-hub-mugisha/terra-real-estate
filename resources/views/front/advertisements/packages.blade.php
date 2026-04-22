@extends('layouts.app')

@section('title', 'Advertise Your Property — Terra Real Estate')

@section('content')


<style>
.ads-hero {
    background: #051321;
    padding: 80px 0 60px;
    text-align: center;
}
.ads-hero__label {
    display: inline-block;
    background: rgba(0,166,103,.15);
    color: #00a667;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 6px 16px;
    border-radius: 20px;
    margin-bottom: 18px;
}
.ads-hero__title {
    color: #fff;
    font-size: clamp(28px, 5vw, 48px);
    font-weight: 700;
    line-height: 1.15;
    margin-bottom: 16px;
}
.ads-hero__sub {
    color: rgba(255,255,255,.65);
    font-size: 17px;
    max-width: 540px;
    margin: 0 auto;
}

.section-pad { padding: 80px 0; }

.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    align-items: start;
    margin-bottom: 64px;
}

.pkg-card {
    position: relative;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    padding: 32px 28px 28px;
    transition: box-shadow .2s, transform .2s;
}
.pkg-card:hover { box-shadow: 0 8px 32px rgba(5,19,33,.1); transform: translateY(-2px); }
.pkg-card--popular {
    border-color: #00a667;
    box-shadow: 0 4px 24px rgba(0,166,103,.15);
}

.pkg-badge {
    position: absolute;
    top: -13px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    padding: 5px 18px;
    border-radius: 20px;
    white-space: nowrap;
}
.pkg-badge--green  { background: #00a667; color: #fff; }
.pkg-badge--amber  { background: #f59e0b; color: #fff; }

.pkg-card__head { text-align: center; margin-bottom: 20px; }
.pkg-name { font-size: 20px; font-weight: 700; color: #051321; margin-bottom: 10px; }
.pkg-price { display: flex; align-items: baseline; justify-content: center; gap: 4px; }
.pkg-price__amount { font-size: 38px; font-weight: 800; color: #051321; }
.pkg-price__currency { font-size: 15px; font-weight: 600; color: #6b7280; }
.pkg-price__duration { font-size: 14px; color: #9ca3af; margin-top: 4px; }

.pkg-desc { font-size: 14px; color: #6b7280; line-height: 1.6; margin-bottom: 24px; }

.pkg-features { list-style: none; padding: 0; margin: 0 0 28px; }
.pkg-features__item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    padding: 8px 0;
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
}
.pkg-features__item.no { color: #9ca3af; }
.pkg-icon { font-style: normal; font-size: 15px; }
.pkg-features__item.yes .pkg-icon { color: #00a667; }
.pkg-features__item.no  .pkg-icon { color: #d1d5db; }

.btn-block { width: 100%; text-align: center; display: block; padding: 13px; font-weight: 600; border-radius: 10px; font-size: 15px; }
.btn-primary { background: #00a667; color: #fff; border: none; text-decoration: none; }
.btn-primary:hover { background: #008f57; color: #fff; }
.btn-outline { background: transparent; color: #051321; border: 1.5px solid #d1d5db; text-decoration: none; }
.btn-outline:hover { border-color: #051321; }

.ads-faq {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 32px;
    padding: 40px;
    background: #f8fafc;
    border-radius: 16px;
}
.ads-faq__item strong { display: block; font-size: 15px; color: #051321; margin-bottom: 6px; }
.ads-faq__item p { font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6; }
</style>


<section class="ads-hero">
    <div class="container">
        <div class="ads-hero__inner">
            <span class="ads-hero__label">Reach More Buyers</span>
            <h1 class="ads-hero__title">Advertise Your Property<br>on Terra</h1>
            <p class="ads-hero__sub">Choose a package, upload your media, and go live in minutes. Images or video — land, house, or design.</p>
        </div>
    </div>
</section>

<section class="ads-packages section-pad">
    <div class="container">
        <div class="packages-grid">
            @foreach ($packages as $pkg)
            <div class="pkg-card {{ $loop->iteration === 2 ? 'pkg-card--popular' : '' }}">

                {{-- Badge --}}
                @if ($pkg->badge_label)
                <div class="pkg-badge pkg-badge--{{ $pkg->badge_label['color'] }}">
                    {{ $pkg->badge_label['text'] }}
                </div>
                @endif

                <div class="pkg-card__head">
                    <h3 class="pkg-name">{{ $pkg->name }}</h3>
                    <div class="pkg-price">
                        <span class="pkg-price__amount">{{ number_format($pkg->price) }}</span>
                        <span class="pkg-price__currency">RWF</span>
                    </div>
                    <p class="pkg-price__duration">{{ $pkg->duration_days }} days</p>
                </div>

                <p class="pkg-desc">{{ $pkg->description }}</p>

                <ul class="pkg-features">
                    <li class="pkg-features__item {{ $pkg->max_images > 0 ? 'yes' : 'no' }}">
                        <i class="pkg-icon">{{ $pkg->max_images > 0 ? '✓' : '✗' }}</i>
                        Up to {{ $pkg->max_images }} images
                    </li>
                    <li class="pkg-features__item {{ $pkg->allows_video ? 'yes' : 'no' }}">
                        <i class="pkg-icon">{{ $pkg->allows_video ? '✓' : '✗' }}</i>
                        Video upload
                    </li>
                    <li class="pkg-features__item {{ $pkg->featured_listings ? 'yes' : 'no' }}">
                        <i class="pkg-icon">{{ $pkg->featured_listings ? '✓' : '✗' }}</i>
                        Featured listings section
                    </li>
                    <li class="pkg-features__item {{ $pkg->featured_homepage ? 'yes' : 'no' }}">
                        <i class="pkg-icon">{{ $pkg->featured_homepage ? '✓' : '✗' }}</i>
                        Homepage spotlight
                    </li>
                    <li class="pkg-features__item {{ $pkg->priority_placement ? 'yes' : 'no' }}">
                        <i class="pkg-icon">{{ $pkg->priority_placement ? '✓' : '✗' }}</i>
                        Priority placement
                    </li>
                </ul>

                <a href="{{ route('advertisements.create', ['package' => $pkg->slug]) }}"
                   class="btn {{ $loop->iteration === 2 ? 'btn-primary' : 'btn-outline' }} btn-block">
                    Get Started
                </a>
            </div>
            @endforeach
        </div>

        {{-- FAQ strip --}}
        <div class="ads-faq">
            <div class="ads-faq__item">
                <strong>How long does activation take?</strong>
                <p>Usually within 2–4 hours after payment is confirmed by our team.</p>
            </div>
            <div class="ads-faq__item">
                <strong>What payment methods are accepted?</strong>
                <p>MTN Mobile Money and Airtel Money. We confirm manually and activate your ad.</p>
            </div>
            <div class="ads-faq__item">
                <strong>Can I advertise any listing type?</strong>
                <p>Yes — land, house, or architectural design. You can link an existing listing or create a standalone ad.</p>
            </div>
        </div>
    </div>
</section>
@endsection
