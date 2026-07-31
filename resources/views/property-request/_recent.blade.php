@if($recentPropertyRequests->isNotEmpty())
<style>
    .preq-section { background: var(--surface); }

    .preq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }

    .preq-card {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        transition: all var(--t);
    }

    .preq-card:hover {
        border-color: var(--gold-bd);
        transform: translateY(-3px);
    }

    .preq-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
    }

    .preq-tag {
        font-size: .64rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        padding: 4px 9px;
        border-radius: 999px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        color: var(--gold);
    }

    .preq-ref {
        font-size: .68rem;
        color: var(--dim);
        font-weight: 600;
    }

    .preq-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.3;
    }

    .preq-meta {
        font-size: .78rem;
        color: var(--muted);
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .preq-budget {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--gold);
    }

    .preq-actions {
        display: flex;
        gap: 8px;
        margin-top: 4px;
    }

    .preq-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 10px;
        border-radius: 8px;
        font-size: .78rem;
        font-weight: 600;
        transition: all var(--t);
    }

    .preq-btn-wa {
        background: rgba(37, 211, 102, .1);
        color: #1a9c50;
        border: 1px solid rgba(37, 211, 102, .3);
    }

    .preq-btn-wa:hover { background: rgba(37, 211, 102, .18); }

    .preq-btn-call {
        background: var(--gold-bg);
        color: var(--gold);
        border: 1px solid var(--gold-bd);
    }

    .preq-btn-call:hover { background: var(--gold); color: #fff; }

    .preq-btn svg { width: 14px; height: 14px; }

    .preq-viewall {
        text-align: center;
        margin-top: 28px;
    }
</style>

<section class="section preq-section">
    <div class="container-xl">
        <div style="display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:26px;">
            <div>
                <div class="eyebrow">Buyer Requests</div>
                <h2 class="section-title">People currently <em>looking to buy or rent</em></h2>
                <p class="section-sub">Have a matching property? Reach out directly — no listing fee, no middleman.</p>
            </div>
            <a href="{{ route('front.property-requests.index') }}" class="h-btn-primary" style="background: var(--gold); color:#fff;">
                View All Requests
            </a>
        </div>

        <div class="preq-grid">
            @foreach($recentPropertyRequests as $req)
            <div class="preq-card">
                <div class="preq-card-top">
                    <span class="preq-tag">{{ ucfirst($req->request_type ?? 'Buy') }} · {{ ucfirst($req->property_type ?? 'Property') }}</span>
                    <span class="preq-ref">{{ $req->reference_number }}</span>
                </div>
                <div class="preq-title">{{ $req->display_name }} is looking for a {{ $req->property_type ?? 'property' }}</div>
                <div class="preq-meta">
                    @if($req->location_summary)
                    <span>📍 {{ $req->location_summary }}</span>
                    @endif
                    @if($req->bedrooms_min)
                    <span>🛏 {{ $req->bedrooms_min }}+ bedrooms</span>
                    @endif
                </div>
                <div class="preq-budget">{{ $req->formatted_budget }}</div>
                <div class="preq-actions">
                    @if($req->whatsapp_number)
                    <a href="https://wa.me/{{ $req->whatsapp_number }}?text={{ urlencode('Hi ' . $req->display_name . ', I saw your property request ' . $req->reference_number . ' on Terra and I may have a match.') }}"
                       target="_blank" class="preq-btn preq-btn-wa">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" /><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" /></svg>
                        WhatsApp
                    </a>
                    @endif
                    @if($req->phone && ($req->preferred_contact === 'call' || !$req->whatsapp_number))
                    <a href="tel:+{{ $req->whatsapp_number ?? $req->phone }}" class="preq-btn preq-btn-call">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" /></svg>
                        Call
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
