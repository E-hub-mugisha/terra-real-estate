@extends('layouts.guest')
@section('title', 'Request Advice - Terra Consultancy')
@section('content')

<div class="container py-5 advice-page">

    <nav class="small mb-4 breadcrumb-nav">
        <a href="{{ route('front.home') }}" class="text-decoration-none">Home</a>
        <span class="mx-1">/</span>
        <span>Consultancy</span>
        <span class="mx-1">/</span>
        <span class="fw-medium current-crumb">Request Advice</span>
    </nav>

    <div class="row g-5">

        {{-- Context panel --}}
        <div class="col-lg-5">
            <span class="badge intro-badge mb-3">Talk to a consultant</span>
            <h1 class="fw-bold mb-3 advice-title">Tell us what you need advice on</h1>
            <p class="text-muted mb-4" style="line-height: 1.7;">
                Describe your situation below — buying, selling, valuation, legal, or anything else
                property-related — and we'll open WhatsApp with your message ready to send straight
                to Terra's consultancy team. No account needed.
            </p>

            @if (isset($consultancyItems) && count($consultancyItems))
            <div class="services-list">
                <span class="services-label">Areas we advise on</span>
                <ul class="list-unstyled d-flex flex-column gap-1 mt-2">
                    @foreach ($consultancyItems as $item)
                    <li class="services-item">{{ $item['name'] }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        {{-- Form panel --}}
        <div class="col-lg-7">
            <div class="advice-card">

                @if (!empty($selectedTopic))
                <div class="topic-banner mb-3">
                    Asking about: <strong>{{ $selectedTopic }}</strong>
                </div>
                @endif

                <form id="adviceForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label advice-label" for="advice_name">Full name</label>
                        <input type="text" id="advice_name" class="form-control advice-input" placeholder="e.g. Eric Uwimana" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label advice-label" for="advice_email">Email address</label>
                        <input type="email" id="advice_email" class="form-control advice-input" placeholder="e.g. eric@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label advice-label" for="advice_phone">Phone number</label>
                        <input type="tel" id="advice_phone" class="form-control advice-input" placeholder="e.g. 078 123 4567" required>
                    </div>

                    @if (isset($consultancyItems) && count($consultancyItems))
                    <div class="mb-3">
                        <label class="form-label advice-label" for="advice_topic">What is this about?</label>
                        <select id="advice_topic" class="form-select advice-input">
                            <option value="General consultancy" @selected(empty($selectedTopic))>General consultancy</option>
                            @foreach ($consultancyItems as $item)
                            <option value="{{ $item['name'] }}" @selected(($selectedTopic ?? null) === $item['name'])>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label advice-label" for="advice_message">What advice do you need?</label>
                        <textarea id="advice_message" class="form-control advice-input" rows="5"
                            placeholder="Describe your situation — e.g. I want to sell a plot in Kicukiro and need help pricing it fairly." required></textarea>
                    </div>

                    <button type="submit" class="btn d-flex align-items-center justify-content-center gap-2 w-100 text-white fw-semibold py-2 whatsapp-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px">
                            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39c1.45.79 3.08 1.21 4.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.15h-.01c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.14.82.84-3.06-.2-.32a8.19 8.19 0 0 1-1.25-4.35c0-4.52 3.68-8.2 8.2-8.2 2.19 0 4.25.86 5.8 2.4a8.14 8.14 0 0 1 2.4 5.8c0 4.53-3.68 8.24-8.14 8.24zm4.49-6.15c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.24-.64.8-.78.97-.14.17-.29.19-.53.06-.25-.12-1.04-.38-1.99-1.22-.73-.65-1.23-1.46-1.37-1.7-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.15.16-.25.24-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.42-.14-.01-.31-.01-.48-.01a.92.92 0 0 0-.67.31c-.23.25-.87.85-.87 2.08 0 1.22.89 2.4 1.02 2.57.12.17 1.75 2.67 4.24 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.11-.23-.17-.48-.29z" />
                        </svg>
                        Send via WhatsApp
                    </button>

                    <p class="text-muted text-center mt-3 mb-0 small">
                        This opens WhatsApp with your message pre-filled — you'll still need to hit send there.
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --navy-dark: #111a45;
        --navy: #19265d;
        --gold: #D05208;
        --gold-light: #fff3e9;
        --font-heading: 'Cormorant Garamond', serif;
        --font-body: 'DM Sans', sans-serif;
    }

    .advice-page {
        font-family: var(--font-body);
        color: var(--navy-dark);
    }

    .breadcrumb-nav {
        color: #6b7280;
    }

    .breadcrumb-nav a {
        color: #6b7280;
        transition: color .15s ease;
    }

    .breadcrumb-nav a:hover {
        color: var(--gold);
    }

    .current-crumb {
        color: var(--navy-dark);
    }

    .intro-badge {
        background-color: var(--gold-light);
        color: var(--gold);
        font-weight: 600;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        border-radius: 20px;
        padding: .4rem .8rem;
        width: fit-content;
    }

    .advice-title {
        font-family: var(--font-heading);
        color: var(--navy-dark);
        font-size: 2.4rem;
        line-height: 1.15;
    }

    .services-list {
        border-top: 1px solid #eef0f5;
        padding-top: 1.25rem;
        margin-top: 1.25rem;
    }

    .services-label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--navy);
    }

    .services-item {
        font-size: .9rem;
        color: #4b5563;
        padding-left: 1rem;
        position: relative;
    }

    .services-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: .55rem;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background-color: var(--gold);
    }

    .advice-card {
        background: #fff;
        border: 1px solid #eef0f5;
        border-radius: 14px;
        padding: 2rem;
        box-shadow: 0 6px 24px rgba(17, 26, 69, .08);
    }

    .topic-banner {
        background-color: var(--gold-light);
        color: var(--gold);
        border-radius: 8px;
        padding: .6rem .9rem;
        font-size: .85rem;
    }

    .advice-label {
        font-size: .82rem;
        font-weight: 600;
        color: var(--navy-dark);
    }

    .advice-input {
        border: 1px solid #e2e5ee;
        border-radius: 8px;
    }

    .advice-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .12);
    }

    .whatsapp-btn {
        background-color: #25D366;
        border: none;
        border-radius: 10px;
        transition: background-color .15s ease, transform .1s ease;
    }

    .whatsapp-btn:hover {
        background-color: #1ebc59;
        color: #fff;
        transform: translateY(-1px);
    }
</style>

@once
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@endonce

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const messageEl = document.getElementById('advice_message');
        const selectedTopic = @json($selectedTopic ?? null);

        // If a topic came in via the flyout link, focus the message box
        // so the person can start typing straight away.
        if (selectedTopic) {
            messageEl?.focus();
        }
    });

    document.getElementById('adviceForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('advice_name').value.trim();
        const phone = document.getElementById('advice_phone').value.trim();
        const email = document.getElementById('advice_email').value.trim();
        const topicEl = document.getElementById('advice_topic');
        const topic = topicEl ? topicEl.value : 'General consultancy';
        const message = document.getElementById('advice_message').value.trim();

        if (!name || !phone || !email || !message) {
            alert('Please fill in your name, phone number, email address, and what advice you need.');
            return;
        }

        const terraNumber = '{{ $terraWhatsappNumber ?? '250782390919' }}';

        const text = `Hello Terra, I'd like advice on: ${topic}.\n\n`
            + `Name: ${name}\n`
            + `Phone: ${phone}\n`
            + `Email: ${email}\n\n`
            + `Details: ${message}`;

        window.open('https://wa.me/' + terraNumber + '?text=' + encodeURIComponent(text), '_blank');
    });
</script>

@endsection