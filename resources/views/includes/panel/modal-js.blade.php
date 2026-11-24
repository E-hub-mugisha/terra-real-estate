{{--
    Generic modal behaviour (panel + public pages).
    Opener:  <button data-modal-open="modalId" data-action="/url" data-title="…" data-field-name="value">
             data-action  → sets the modal form's action
             data-title   → fills [data-modal-title] inside the modal
             data-field-* → fills form inputs whose name matches (data-field-counter_amount="…")
    Closer:  [data-modal-close] inside the modal, the backdrop, or Escape.
    Add data-autoopen to a .tu-modal to open it on load (e.g. after validation errors).
--}}
<script>
    (function () {
        if (window.TerraModal) return;
        let last = null;
        const open = (modal, opener) => {
            if (!modal) return;
            if (opener) {
                const form = modal.querySelector('form');
                if (form && opener.dataset.action) form.action = opener.dataset.action;
                const title = modal.querySelector('[data-modal-title]');
                if (title && opener.dataset.title) title.textContent = opener.dataset.title;
                Object.keys(opener.dataset).filter(k => k.startsWith('field')).forEach(k => {
                    const name = k.slice(5).replace(/^./, c => c.toLowerCase()).replace(/[A-Z]/g, c => '_' + c.toLowerCase());
                    const input = form?.querySelector('[name="' + name + '"]');
                    if (input) input.value = opener.dataset[k];
                });
            }
            last = opener || document.activeElement;
            modal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            setTimeout(() => modal.querySelector('textarea, input:not([type=hidden]):not([type=radio]), select, button')?.focus(), 40);
        };
        const close = (modal) => {
            modal.classList.remove('is-open');
            if (!document.querySelector('.tu-modal.is-open')) document.body.style.overflow = '';
            last?.focus?.();
        };
        document.addEventListener('click', (e) => {
            const opener = e.target.closest('[data-modal-open]');
            if (opener) { e.preventDefault(); open(document.getElementById(opener.dataset.modalOpen), opener); return; }
            const closer = e.target.closest('[data-modal-close]');
            if (closer) { close(closer.closest('.tu-modal')); return; }
            if (e.target.classList?.contains('tu-modal') && e.target.classList.contains('is-open')) close(e.target);
        });
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            const modal = [...document.querySelectorAll('.tu-modal.is-open')].pop();
            if (modal) close(modal);
        });
        const boot = () => document.querySelectorAll('.tu-modal[data-autoopen]').forEach(m => open(m));
        document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', boot) : boot();
        window.TerraModal = { open: (id) => open(document.getElementById(id)), close: (id) => close(document.getElementById(id)) };
    })();
</script>
