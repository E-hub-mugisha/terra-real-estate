{{--
    resources/views/front/testimonials/_section.blade.php

    Usage — include on any public page (e.g. homepage):
        @include('front.testimonials._section')

    Requires in the controller:
        $testimonials = \App\Models\Testimonial::approved()
                            ->orderByDesc('featured')
                            ->orderByDesc('approved_at')
                            ->take(6)
                            ->get();
--}}

@php
    $testimonials = $testimonials ?? \App\Models\Testimonial::approved()
        ->orderByDesc('featured')
        ->orderByDesc('approved_at')
        ->take(6)
        ->get();

    $avatarPalette = [
        ['bg' => '#e8f4ed', 'color' => '#D05208'],
        ['bg' => '#e6f1fb', 'color' => '#185fa5'],
        ['bg' => '#faeeda', 'color' => '#854f0b'],
        ['bg' => '#eeedfe', 'color' => '#534ab7'],
        ['bg' => '#fbeaf0', 'color' => '#993556'],
    ];

    $typeLabels = \App\Models\Testimonial::transactionLabels();
@endphp

<section class="testimonials-section" id="testimonials">
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap');

    .testimonials-section {
        font-family: 'DM Sans', sans-serif;
        padding: 5rem 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    .ts-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .ts-eyebrow {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #D05208;
        margin: 0 0 .35rem;
    }
    .ts-heading {
        font-family: 'DM Serif Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.1rem);
        line-height: 1.2;
        margin: 0;
        color: #19265d;
    }
    .ts-heading em { font-style: italic; color: #D05208; }
    .ts-nav { display: flex; gap: 8px; }
    .ts-nav-btn {
        width: 36px; height: 36px; border-radius: 50%;
        border: 1px solid #d3d1c7; background: #fff; cursor: pointer;
        font-size: 16px; display: flex; align-items: center; justify-content: center;
        transition: all .18s;
    }
    .ts-nav-btn:hover { background: #D05208; color: #fff; border-color: #D05208; }

    .ts-track-outer { overflow: hidden; }
    .ts-track {
        display: flex; gap: 16px;
        transition: transform .45s cubic-bezier(.4,0,.2,1);
    }
    .ts-card {
        flex: 0 0 calc(33.33% - 11px);
        background: #fff;
        border: 0.5px solid #d3d1c7;
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: .9rem;
        transition: border-color .2s, box-shadow .2s;
        min-width: 0;
    }
    .ts-card:hover { border-color: #b4b2a9; }
    .ts-card.featured { border: 1px solid #D05208; background: #f9fcfa; }

    .ts-stars { display: flex; gap: 3px; }
    .ts-star {
        width: 13px; height: 13px; background: #D05208;
        clip-path: polygon(50% 0%,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%);
    }
    .ts-star.off { background: #d3d1c7; }

    .ts-quote {
        font-size: 14px; line-height: 1.75;
        color: #5f5e5a; flex: 1; position: relative; padding-left: .25rem;
    }
    .ts-quote-mark {
        font-family: 'DM Serif Display', serif;
        font-size: 4rem; line-height: .4;
        color: rgba(74,124,89,.12);
        display: block; margin-bottom: .5rem;
    }
    .ts-author {
        display: flex; align-items: center; gap: 10px;
        padding-top: .75rem; border-top: 0.5px solid #eeecea;
    }
    .ts-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 500; flex-shrink: 0;
    }
    .ts-author-name { font-size: 13px; font-weight: 500; color: #2c2c2a; margin: 0; }
    .ts-author-meta { font-size: 11px; color: #888780; margin: 2px 0 0; }
    .ts-verified {
        margin-left: auto; font-size: 11px; font-weight: 600;
        background: #e8f4ed; color: #D05208;
        padding: 2px 8px; border-radius: 20px;
    }

    .ts-dots { display: flex; justify-content: center; gap: 6px; margin-top: 1.5rem; }
    .ts-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: #d3d1c7; cursor: pointer; border: none;
        padding: 0; transition: all .2s;
    }
    .ts-dot.active { width: 20px; border-radius: 3px; background: #D05208; }

    /* ── Submit form ── */
    .ts-cta {
        text-align: center; margin-top: 3rem; padding-top: 2.5rem;
        border-top: 0.5px solid #eeecea;
    }
    .ts-cta-label { font-size: 14px; color: #888780; margin: 0 0 1rem; }
    .ts-cta-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: #D05208; color: #fff; border: none;
        padding: 11px 24px; border-radius: 8px; font-size: 14px; font-weight: 500;
        cursor: pointer; font-family: inherit; transition: background .18s;
    }
    .ts-cta-btn:hover { background: #3a6347; }

    /* ── Inline review form ── */
    .ts-form-wrap {
        background: #f9fcfa; border: 1px solid #D05208;
        border-radius: 16px; padding: 1.75rem;
        margin-top: 1.5rem; max-width: 560px; margin-left: auto; margin-right: auto;
        text-align: left; display: none;
    }
    .ts-form-wrap.open { display: block; }
    .ts-form-title { font-size: 16px; font-weight: 500; color: #2c2c2a; margin: 0 0 1.25rem; }
    .ts-field { display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px; }
    .ts-field-label { font-size: 12px; font-weight: 500; color: #5f5e5a; }
    .ts-input, .ts-select, .ts-textarea {
        padding: 9px 11px; border-radius: 8px;
        border: 0.5px solid #d3d1c7; font-size: 13px; color: #2c2c2a;
        outline: none; font-family: inherit; background: #fff;
        transition: border-color .15s;
    }
    .ts-input:focus, .ts-select:focus, .ts-textarea:focus { border-color: #D05208; }
    .ts-textarea { min-height: 90px; resize: vertical; }
    .ts-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .ts-star-row { display: flex; gap: 7px; }
    .ts-spick {
        width: 22px; height: 22px; cursor: pointer; border: none; padding: 0;
        background: #d3d1c7;
        clip-path: polygon(50% 0%,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%);
        transition: background .12s;
    }
    .ts-spick.lit { background: #D05208; }
    .ts-form-footer { display: flex; gap: 8px; margin-top: 1rem; }
    .ts-cancel {
        flex: 1; padding: 9px; border-radius: 8px;
        border: 0.5px solid #d3d1c7; background: #fff;
        font-size: 13px; font-family: inherit; cursor: pointer; color: #5f5e5a;
    }
    .ts-submit {
        flex: 2; padding: 9px; border-radius: 8px; border: none;
        background: #D05208; color: #fff; font-size: 13px;
        font-weight: 500; font-family: inherit; cursor: pointer;
        transition: background .15s;
    }
    .ts-submit:hover { background: #3a6347; }
    .ts-success {
        text-align: center; padding: 1rem 1.5rem;
        background: #e8f4ed; color: #D05208; border-radius: 10px;
        font-size: 14px; margin-top: 1rem; display: none;
    }
    .ts-success.show { display: block; }
    .ts-errors { background: #fcebeb; color: #a32d2d; border-radius: 8px; padding: .75rem 1rem; font-size: 13px; margin-bottom: 1rem; }
    .ts-errors ul { margin: .25rem 0 0 1rem; padding: 0; }

    @media (max-width: 680px) {
        .ts-card { flex: 0 0 calc(100% - 0px); }
        .ts-2col  { grid-template-columns: 1fr; }
    }
</style>

    {{-- Section header --}}
    <div class="ts-header">
        <div>
            <p class="ts-eyebrow">Client stories</p>
            <h2 class="ts-heading">Trusted by families <em>across Rwanda</em></h2>
        </div>
        @if($testimonials->count() > 3)
        <div class="ts-nav">
            <button class="ts-nav-btn" onclick="tsSlide(-1)" aria-label="Previous">&#8592;</button>
            <button class="ts-nav-btn" onclick="tsSlide(1)" aria-label="Next">&#8594;</button>
        </div>
        @endif
    </div>

    @if($testimonials->isEmpty())
        <p style="text-align:center; color:#888780; font-size:14px; padding:2rem 0;">
            No testimonials yet. Be the first to share your experience!
        </p>
    @else
    {{-- Carousel --}}
    <div class="ts-track-outer">
        <div class="ts-track" id="tsTrack">
            @foreach($testimonials as $i => $t)
            @php
                $pal = $avatarPalette[$i % count($avatarPalette)];
            @endphp
            <div class="ts-card {{ $t->featured ? 'featured' : '' }}">
                <div class="ts-stars">
                    @for($s = 1; $s <= 5; $s++)
                        <div class="ts-star {{ $s <= $t->rating ? '' : 'off' }}"></div>
                    @endfor
                </div>

                <div class="ts-quote">
                    <span class="ts-quote-mark">"</span>
                    {{ $t->review }}
                </div>

                <div class="ts-author">
                    <div class="ts-avatar"
                         style="background:{{ $pal['bg'] }}; color:{{ $pal['color'] }};">
                        {{ $t->avatar_initials }}
                    </div>
                    <div>
                        <p class="ts-author-name">{{ $t->name }}</p>
                        <p class="ts-author-meta">
                            {{ $typeLabels[$t->transaction_type] ?? $t->transaction_type }}
                            @if($t->location) · {{ $t->location }} @endif
                        </p>
                    </div>
                    <span class="ts-verified">&#10003; Verified</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($testimonials->count() > 3)
    <div class="ts-dots" id="tsDots"></div>
    @endif
    @endif

    {{-- CTA: Submit your review --}}
    <div class="ts-cta">
        <p class="ts-cta-label">Had a great experience with Terra? Share your story.</p>
        <button class="ts-cta-btn" onclick="tsTgForm()">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                <path d="M8 1v14M1 8h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            Write a review
        </button>

        {{-- Validation errors --}}
        @if($errors->has('name') || $errors->has('review') || $errors->has('rating'))
        <div class="ts-form-wrap open">
        @else
        <div class="ts-form-wrap" id="tsFormWrap">
        @endif
            <p class="ts-form-title">Share your experience</p>

            @if($errors->any())
            <div class="ts-errors">
                Please fix the following:
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('testimonials.store') }}" id="tsForm">
                @csrf

                {{-- Rating --}}
                <div class="ts-field">
                    <span class="ts-field-label">Your rating *</span>
                    <input type="hidden" name="rating" id="tsRatingInput" value="{{ old('rating', 5) }}">
                    <div class="ts-star-row" id="tsStarRow">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="ts-spick {{ $i <= old('rating', 5) ? 'lit' : '' }}"
                                    data-val="{{ $i }}"
                                    onclick="tsSetRating({{ $i }})"></button>
                        @endfor
                    </div>
                </div>

                <div class="ts-2col">
                    <div class="ts-field">
                        <label class="ts-field-label">Full name *</label>
                        <input type="text" name="name" class="ts-input"
                               placeholder="Your name"
                               value="{{ old('name') }}" required maxlength="100">
                    </div>
                    <div class="ts-field">
                        <label class="ts-field-label">Email (optional)</label>
                        <input type="email" name="email" class="ts-input"
                               placeholder="you@email.com"
                               value="{{ old('email') }}" maxlength="150">
                    </div>
                </div>

                <div class="ts-2col">
                    <div class="ts-field">
                        <label class="ts-field-label">Location</label>
                        <input type="text" name="location" class="ts-input"
                               placeholder="e.g. Kigali"
                               value="{{ old('location') }}" maxlength="100">
                    </div>
                    <div class="ts-field">
                        <label class="ts-field-label">Transaction type *</label>
                        <select name="transaction_type" class="ts-select" required>
                            <option value="">Select...</option>
                            @foreach($typeLabels as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('transaction_type') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="ts-field">
                    <label class="ts-field-label">Your review *</label>
                    <textarea name="review" class="ts-textarea"
                              placeholder="Tell others about your experience with Terra..."
                              required minlength="20" maxlength="1000">{{ old('review') }}</textarea>
                    <div style="font-size:11px; color:#888780; margin-top:3px;">Minimum 20 characters. Your review will be published after admin approval.</div>
                </div>

                <div class="ts-form-footer">
                    <button type="button" class="ts-cancel" onclick="tsTgForm()">Cancel</button>
                    <button type="submit" class="ts-submit">Submit review &#8594;</button>
                </div>
            </form>
        </div>

        {{-- Success flash --}}
        @if(session('testimonial_submitted'))
        <div class="ts-success show">
            ✓ Thank you! Your review has been submitted and will appear after admin approval.
        </div>
        @else
        <div class="ts-success" id="tsSuccess"></div>
        @endif
    </div>

</section>

<script>
(function () {
    // ── Always-available globals (must be registered before any early return) ──

    // Form toggle — needed even when there are 0 approved testimonials
    window.tsTgForm = () => {
        const formWrap = document.getElementById('tsFormWrap');
        if (formWrap) formWrap.classList.toggle('open');
    };

    // Star picker
    window.tsSetRating = val => {
        const input = document.getElementById('tsRatingInput');
        if (input) input.value = val;
        document.querySelectorAll('#tsStarRow .ts-spick').forEach(btn => {
            btn.classList.toggle('lit', parseInt(btn.dataset.val) <= val);
        });
    };

    // ── Carousel (only when testimonial cards exist) ──────────────────────
    const track = document.getElementById('tsTrack');
    const dotsEl = document.getElementById('tsDots');
    if (!track) return;

    const VISIBLE = window.innerWidth <= 680 ? 1 : 3;
    const cards   = track.children;
    const MAX     = Math.max(0, cards.length - VISIBLE);
    let current   = 0;

    // Build dots
    if (dotsEl && MAX > 0) {
        for (let i = 0; i <= MAX; i++) {
            const d = document.createElement('button');
            d.className = 'ts-dot' + (i === 0 ? ' active' : '');
            d.onclick = () => goTo(i);
            dotsEl.appendChild(d);
        }
    }

    function goTo(n) {
        current = Math.max(0, Math.min(n, MAX));
        const w = cards[0].getBoundingClientRect().width + 16;
        track.style.transform = `translateX(-${current * w}px)`;
        if (dotsEl) {
            dotsEl.querySelectorAll('.ts-dot').forEach((d, i) => {
                d.className = 'ts-dot' + (i === current ? ' active' : '');
            });
        }
    }

    window.tsSlide = dir => goTo(current + dir);
})();
</script>