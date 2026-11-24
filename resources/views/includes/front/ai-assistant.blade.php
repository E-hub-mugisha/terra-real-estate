{{-- Terra AI panel: plain-language property search and questions. Opened by [data-tu-ai-open] or the "/" key. --}}
@php
    $aiOn = \App\Services\Marketplace\AiAssistant::enabled();
    $suggestions = [
        __('3 bedroom house for rent in Kicukiro'),
        __('Plot for sale in Gasabo under 30M'),
        __('Modern villa with a garden'),
        __('Residential house designs'),
        __('How do I list my property?'),
    ];
@endphp
<div class="tu-oc-backdrop" data-tu-ai-close></div>
<aside class="tu-oc tu-oc-right tu-ai" id="tuAi" role="dialog" aria-modal="true" aria-labelledby="tuAiTitle" aria-hidden="true" tabindex="-1">
    <div class="tu-oc-head">
        <div style="display:flex;align-items:center;gap:12px">
            <span class="tu-ai-mark" aria-hidden="true"><x-tu-icon name="sparkle" /></span>
            <div>
                <h2 id="tuAiTitle">{{ __('Terra AI') }}</h2>
                <small>{{ $aiOn ? __('Describe what you want, in your own words') : __('Smart search · describe what you want') }}</small>
            </div>
        </div>
        <div style="display:flex;gap:4px">
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost" data-tu-ai-reset aria-label="{{ __('New conversation') }}" title="{{ __('New conversation') }}"><x-tu-icon name="plus" /></button>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost" data-tu-ai-close aria-label="{{ __('Close') }}"><x-tu-icon name="x" /></button>
        </div>
    </div>

    <div class="tu-ai-thread" id="tuAiThread" aria-live="polite">
        @include('includes.front.ai-welcome', ['suggestions' => $suggestions])
    </div>

    <form class="tu-ai-form" id="tuAiForm" autocomplete="off">
        <label for="tuAiInput" class="tu-sr">{{ __('Ask Terra AI') }}</label>
        <textarea id="tuAiInput" rows="1" maxlength="500" placeholder="{{ __('e.g. 2 bedroom apartment in Kigali under 600k') }}"></textarea>
        <button type="submit" class="tu-btn tu-btn-primary tu-btn-icon" aria-label="{{ __('Send') }}"><x-tu-icon name="arrow-right" /></button>
    </form>
    <p class="tu-ai-note">{{ $aiOn ? __('AI answers can be wrong. Listings shown are real and live on Terra.') : __('Listings shown are real and live on Terra.') }}</p>
</aside>

@push('scripts')
<script>
    (function () {
        const panel = document.getElementById('tuAi');
        const explore = document.getElementById('tuExplore');
        if (!panel) return;
        const thread = document.getElementById('tuAiThread');
        const form = document.getElementById('tuAiForm');
        const input = document.getElementById('tuAiInput');
        const endpoint = @json(route('front.ai.assistant'));
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || @json(csrf_token());
        const KEY = 'terra.ai.v1';
        let history = [];
        let busy = false;
        let lastFocus = null;

        // ── Open / close (shared by both offcanvases) ──
        const setOpen = (el, open, cls) => {
            if (!el) return;
            el.classList.toggle('is-open', open);
            el.setAttribute('aria-hidden', String(!open));
            document.body.classList.toggle(cls, open);
            if (open) { lastFocus = document.activeElement; setTimeout(() => (el === panel ? input : el).focus(), 60); }
            else if (lastFocus) lastFocus.focus?.();
        };
        const openAi = (prefill) => {
            setOpen(explore, false, 'tu-explore-open');
            document.body.classList.remove('tu-drawer-open');
            setOpen(panel, true, 'tu-ai-open');
            if (prefill) { input.value = prefill; send(); }
        };
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-tu-ai-open]')) { e.preventDefault(); openAi(e.target.closest('[data-tu-ai-open]').dataset.prompt); }
            else if (e.target.closest('[data-tu-ai-close]')) setOpen(panel, false, 'tu-ai-open');
            if (e.target.closest('[data-tu-explore-open]')) { e.preventDefault(); document.body.classList.remove('tu-drawer-open'); setOpen(explore, true, 'tu-explore-open'); }
            else if (e.target.closest('[data-tu-explore-close]')) setOpen(explore, false, 'tu-explore-open');
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') { setOpen(panel, false, 'tu-ai-open'); setOpen(explore, false, 'tu-explore-open'); }
            const typing = /input|textarea|select/i.test(document.activeElement?.tagName) || document.activeElement?.isContentEditable;
            if (!typing && (e.key === '/' || ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k'))) { e.preventDefault(); openAi(); }
        });

        // ── Explore filter ──
        const filter = explore?.querySelector('[data-tu-explore-filter]');
        filter?.addEventListener('input', () => {
            const term = filter.value.trim().toLowerCase();
            let any = false;
            explore.querySelectorAll('[data-ex-section]').forEach(sec => {
                let shown = 0;
                sec.querySelectorAll('[data-ex-item]').forEach(a => { const ok = !term || a.dataset.exItem.includes(term); a.hidden = !ok; if (ok) shown++; });
                sec.hidden = shown === 0; any ||= shown > 0;
            });
            explore.querySelector('[data-ex-empty]').hidden = any;
        });

        // ── Chat ──
        const esc = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        const fallbackImg = @json(asset('front/assets/img/all-images/properties/property-img1.png'));
        const bubble = (role, html) => {
            thread.querySelector('[data-tu-ai-welcome]')?.remove();
            const el = document.createElement('div');
            el.className = 'tu-ai-msg tu-ai-' + role;
            el.innerHTML = html;
            thread.appendChild(el);
            thread.scrollTop = thread.scrollHeight;
            return el;
        };
        const renderResult = (r) => {
            let html = '<p>' + esc(r.reply) + '</p>';
            if (r.items?.length) {
                html += '<div class="tu-ai-results">' + r.items.map(i =>
                    '<a class="tu-ai-card" href="' + esc(i.url) + '">'
                    + '<img src="' + esc(i.image || fallbackImg) + '" alt="" loading="lazy" onerror="this.onerror=null;this.src=\'' + fallbackImg + '\'">'
                    + '<span><small>' + esc(i.kind_label) + (i.condition ? ' · ' + esc(i.condition) : '') + (i.featured ? ' · ★' : '') + '</small>'
                    + '<strong>' + esc(i.title) + '</strong>'
                    + '<em>' + esc(i.price) + '</em>'
                    + '<span class="tu-ai-loc">' + esc(i.location) + (i.meta?.length ? ' · ' + esc(i.meta.join(' · ')) : '') + '</span></span></a>'
                ).join('') + '</div>';
            }
            if (r.see_all) html += '<a class="tu-link-arrow tu-ai-all" href="' + esc(r.see_all.url) + '">' + esc(r.see_all.label) + ' →</a>';
            return html;
        };
        const save = () => { try { sessionStorage.setItem(KEY, JSON.stringify({ history, html: thread.innerHTML })); } catch (e) {} };
        const restore = () => {
            try {
                const s = JSON.parse(sessionStorage.getItem(KEY) || 'null');
                if (s && Array.isArray(s.history) && s.history.length) { history = s.history; thread.innerHTML = s.html; }
            } catch (e) {}
        };

        async function send() {
            const text = input.value.trim();
            if (!text || busy) return;
            busy = true;
            input.value = ''; input.style.height = '';
            bubble('user', '<p>' + esc(text) + '</p>');
            const typing = bubble('bot', '<span class="tu-ai-typing" aria-label="Thinking"><i></i><i></i><i></i></span>');
            try {
                const res = await fetch(endpoint, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    credentials: 'same-origin',
                    body: JSON.stringify({ message: text, history: history.slice(-10) }),
                });
                if (res.status === 429) throw new Error(@json(__('You are sending messages too fast. Please wait a minute.')));
                if (!res.ok) throw new Error(@json(__('Something went wrong. Please try again.')));
                const data = await res.json();
                typing.innerHTML = renderResult(data);
                history.push({ role: 'user', content: text }, { role: 'assistant', content: data.reply || '…' });
                save();
            } catch (err) {
                typing.innerHTML = '<p class="tu-ai-err">' + esc(err.message) + '</p>';
                input.value = text;
            } finally {
                busy = false;
                thread.scrollTop = thread.scrollHeight;
                input.focus();
            }
        }

        form.addEventListener('submit', (e) => { e.preventDefault(); send(); });
        input.addEventListener('keydown', (e) => { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); } });
        input.addEventListener('input', () => { input.style.height = 'auto'; input.style.height = Math.min(input.scrollHeight, 120) + 'px'; });
        thread.addEventListener('click', (e) => { const b = e.target.closest('[data-tu-ai-suggest]'); if (b) { input.value = b.textContent.trim(); send(); } });
        panel.querySelector('[data-tu-ai-reset]').addEventListener('click', () => {
            history = [];
            try { sessionStorage.removeItem(KEY); } catch (e) {}
            thread.innerHTML = @json(view('includes.front.ai-welcome', ['suggestions' => $suggestions])->render());
            input.focus();
        });
        restore();
        // Deep links: /#ai opens the panel, /#ai=3%20bedroom%20house%20in%20Kicukiro also runs the search.
        if (location.hash === '#ai' || location.hash.startsWith('#ai=')) {
            const q = location.hash.startsWith('#ai=') ? decodeURIComponent(location.hash.slice(4)).slice(0, 500) : '';
            openAi(q || undefined);
        }
        if (location.hash === '#explore') document.querySelector('[data-tu-explore-open]')?.click();
    })();
</script>
@endpush
