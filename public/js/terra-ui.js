/* ==========================================================================
   Terra UI — public-site interactions
   1. Scroll animations (AOS) — attributes are added here, after AOS has loaded,
      so content never stays hidden if the library fails to load.
   2. Count-up numbers ([data-count])
   3. Saved listings (heart) — this browser, plus the account when signed in
   4. Back-to-top button
   ========================================================================== */
(function () {
    'use strict';

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── 1. AOS ──────────────────────────────────────────────────────────── */
    function tagForAOS() {
        const tag = (selector, anim, stagger) => {
            document.querySelectorAll(selector).forEach((el, i) => {
                if (el.hasAttribute('data-aos') || el.closest('[data-no-aos]')) return;
                el.setAttribute('data-aos', anim);
                if (stagger) el.setAttribute('data-aos-delay', String((i % 4) * stagger));
            });
        };
        // Hero: copy rises in sequence
        document.querySelectorAll('.tu-hero-copy > *, .tu-page-hero .tu-container > *').forEach((el, i) => {
            if (!el.hasAttribute('data-aos')) { el.setAttribute('data-aos', 'fade-up'); el.setAttribute('data-aos-delay', String(i * 80)); }
        });
        tag('.tu-section-head', 'fade-up');
        tag('.tu-cats > .tu-cat', 'zoom-in-up', 80);
        tag('.tu-feature', 'fade-up', 100);
        tag('.tu-step', 'fade-up', 100);
        tag('.tu-trust', 'fade-up');
        tag('.tu-result-bar', 'fade');
        tag('.tu-area', 'fade-up', 50);
        tag('.tu-cta', 'zoom-in');
        tag('.tu-gallery', 'fade');
        tag('.tu-detail-grid > div > .tu-panel', 'fade-up');
        tag('.tu-agent-card', 'fade-up', 70);
        // Cards: stagger within each row
        document.querySelectorAll('.tu-grid, .tu-scroller').forEach(grid => {
            Array.from(grid.children).forEach((card, i) => {
                if (card.hasAttribute('data-aos')) return;
                card.setAttribute('data-aos', 'fade-up');
                card.setAttribute('data-aos-delay', String((i % 4) * 70));
            });
        });
    }

    function initAOS() {
        if (!window.AOS || reduceMotion) return;
        tagForAOS();
        window.AOS.init({ once: true, duration: 650, easing: 'ease-out-cubic', offset: 40, anchorPlacement: 'top-bottom' });
    }
    window.TerraUI = { refresh: () => window.AOS && !reduceMotion && window.AOS.refresh() };

    /* ── 2. Count-up ─────────────────────────────────────────────────────── */
    function initCounters() {
        const els = document.querySelectorAll('[data-count]');
        if (!els.length) return;
        const fmt = new Intl.NumberFormat('en-US');
        const run = (el) => {
            const target = Number(el.dataset.count) || 0;
            if (reduceMotion || target === 0) { el.textContent = fmt.format(target); return; }
            const start = performance.now(), dur = 1200;
            const step = (now) => {
                const p = Math.min(1, (now - start) / dur);
                el.textContent = fmt.format(Math.round(target * (1 - Math.pow(1 - p, 3))));
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        };
        if (!('IntersectionObserver' in window)) { els.forEach(run); return; }
        const io = new IntersectionObserver((entries) => entries.forEach(e => {
            if (e.isIntersecting) { run(e.target); io.unobserve(e.target); }
        }), { threshold: .4 });
        els.forEach(el => io.observe(el));
    }

    /* ── 3. Saved listings ───────────────────────────────────────────────── */
    const KEY = 'terra.saved.v1';
    const readSaved = () => { try { return new Set(JSON.parse(localStorage.getItem(KEY) || '[]')); } catch (e) { return new Set(); } };
    const writeSaved = (set) => { try { localStorage.setItem(KEY, JSON.stringify([...set])); } catch (e) { /* storage unavailable */ } };

    function paintSaved() {
        const saved = readSaved();
        document.querySelectorAll('[data-save-id]').forEach(btn => {
            const on = saved.has(btn.dataset.saveId);
            btn.classList.toggle('is-saved', on);
            btn.setAttribute('aria-pressed', String(on));
            btn.setAttribute('aria-label', (on ? 'Remove from saved: ' : 'Save listing: ') + (btn.dataset.saveTitle || ''));
        });
        document.querySelectorAll('[data-saved-count]').forEach(el => {
            el.textContent = saved.size;
            el.hidden = saved.size === 0;
        });
        document.dispatchEvent(new CustomEvent('terra:saved', { detail: saved }));
    }
    window.TerraSaved = { all: readSaved };

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-save-id]');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        const saved = readSaved();
        const id = btn.dataset.saveId;
        const adding = !saved.has(id);
        adding ? saved.add(id) : saved.delete(id);
        writeSaved(saved);
        if (adding && !reduceMotion) { btn.classList.remove('pop'); void btn.offsetWidth; btn.classList.add('pop'); }
        paintSaved();
        if (account) post(account.toggle, { id }).then(r => r && adopt(r.ids));
    });

    /* Signed in: the account is the source of truth. Hearts saved before signing in are merged once. */
    const account = window.TerraAccount || null;
    const post = (url, data) => fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': account.csrf },
        body: JSON.stringify(data),
        credentials: 'same-origin',
    }).then(r => r.ok ? r.json() : null).catch(() => null);
    const adopt = (ids) => { if (Array.isArray(ids)) { writeSaved(new Set(ids)); paintSaved(); } };
    function syncAccount() {
        if (!account) return;
        const local = [...readSaved()];
        const server = new Set(account.ids || []);
        const missing = local.filter(id => !server.has(id));
        let merged = false;
        try { merged = sessionStorage.getItem('terra.saved.merged') === String(account.user); } catch (e) {}
        if (missing.length && !merged) {
            post(account.sync, { ids: missing }).then(r => r && adopt(r.ids));
            try { sessionStorage.setItem('terra.saved.merged', String(account.user)); } catch (e) {}
        } else {
            adopt([...server]);
        }
    }
    window.addEventListener('storage', (e) => { if (e.key === KEY) paintSaved(); });

    /* ── 4. Back to top ──────────────────────────────────────────────────── */
    function initBackToTop() {
        const btn = document.getElementById('tuToTop');
        if (!btn) return;
        const toggle = () => btn.classList.toggle('is-visible', window.scrollY > 900);
        window.addEventListener('scroll', toggle, { passive: true });
        toggle();
        btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' }));
    }

    const boot = () => {
        initAOS();
        syncAccount();
        paintSaved();
        initCounters();
        initBackToTop();
    };
    document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', boot) : boot();
    // Images change layout as they load; let AOS recalculate trigger points.
    window.addEventListener('load', () => window.TerraUI.refresh());
})();
