{{-- Shared behaviour for agent listing edit forms --}}
@push('scripts')
<script>
    (function () {
        const form = document.getElementById('editForm');
        if (!form) return;
        const saveBar = document.getElementById('saveBar');
        let dirty = false, submitting = false;

        // Number steppers
        form.querySelectorAll('[data-step]').forEach(btn => btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            const next = Math.min(Number(input.max || 99), Math.max(Number(input.min || 0), Number(input.value || 0) + Number(btn.dataset.step)));
            input.value = next;
            input.dispatchEvent(new Event('input', { bubbles: true }));
        }));

        // Description counter
        const desc = document.getElementById('description');
        const descCount = document.getElementById('descCount');
        if (desc && descCount) {
            const upd = () => { descCount.textContent = desc.value.trim().length + ' characters'; };
            desc.addEventListener('input', upd); upd();
        }

        // Price preview (e.g. "85.0M RWF")
        const price = document.getElementById('price');
        const preview = document.getElementById('pricePreview');
        const currency = form.querySelector('[name=currency]');
        if (price && preview) {
            const fmt = () => {
                const n = Number(price.value || 0);
                const cur = currency ? currency.value : '';
                preview.textContent = n > 0
                    ? 'Buyers will see: ' + new Intl.NumberFormat('en-US').format(n) + ' ' + cur + (n >= 1e6 ? '  (' + (n / 1e6).toFixed(n >= 1e7 ? 0 : 1) + 'M)' : '')
                    : '';
            };
            price.addEventListener('input', fmt); currency?.addEventListener('change', fmt); fmt();
        }

        // Unsaved-changes tracking
        const markDirty = () => { if (!dirty) { dirty = true; saveBar?.classList.add('is-dirty'); } };
        form.addEventListener('input', markDirty);
        form.addEventListener('change', markDirty);
        window.addEventListener('beforeunload', (e) => { if (dirty && !submitting) { e.preventDefault(); e.returnValue = ''; } });

        form.addEventListener('submit', (e) => {
            if (!form.checkValidity()) {
                e.preventDefault();
                const first = form.querySelector(':invalid');
                first?.classList.add('is-invalid');
                first?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                first?.focus({ preventScroll: true });
                return;
            }
            submitting = true;
            const btn = document.getElementById('saveBtn');
            if (btn) { btn.disabled = true; btn.textContent = 'Saving…'; }
        });
        form.querySelectorAll('input, select, textarea').forEach(el => el.addEventListener('input', () => el.classList.remove('is-invalid')));

        // Use current location
        document.getElementById('useMyLocation')?.addEventListener('click', (e) => {
            const btn = e.currentTarget;
            if (!navigator.geolocation) return;
            btn.disabled = true; btn.textContent = 'Locating…';
            navigator.geolocation.getCurrentPosition(pos => {
                document.getElementById('latitude').value = pos.coords.latitude.toFixed(7);
                document.getElementById('longitude').value = pos.coords.longitude.toFixed(7);
                btn.textContent = 'Location added'; markDirty();
            }, () => { btn.disabled = false; btn.textContent = 'Location unavailable — enter it manually'; }, { enableHighAccuracy: true, timeout: 10000 });
        });

        // Delete listing
        document.querySelector('[data-delete-listing]')?.addEventListener('click', () => {
            const go = () => { submitting = true; document.getElementById('deleteListingForm').submit(); };
            if (!window.Swal) { if (confirm('Delete this listing and all its photos? This cannot be undone.')) go(); return; }
            Swal.fire({
                icon: 'warning', title: 'Delete this listing?', text: 'The listing and all its photos will be removed. This cannot be undone.',
                showCancelButton: true, confirmButtonText: 'Yes, delete', confirmButtonColor: '#D05208', cancelButtonText: 'Keep it',
            }).then(r => { if (r.isConfirmed) go(); });
        });
    })();
</script>
@endpush
