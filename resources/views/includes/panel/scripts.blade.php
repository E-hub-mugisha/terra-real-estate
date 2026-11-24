{{-- Panel behaviour: sidebar collapse / mobile drawer, groups, dropdowns, toasts --}}
<script>
    (function () {
        const body = document.body;
        const KEY = 'terra-panel-collapsed';
        try { if (localStorage.getItem(KEY) === '1') body.classList.add('tp-collapsed'); } catch (e) {}

        document.querySelector('[data-tp-collapse]')?.addEventListener('click', () => {
            body.classList.toggle('tp-collapsed');
            try { localStorage.setItem(KEY, body.classList.contains('tp-collapsed') ? '1' : '0'); } catch (e) {}
        });
        document.querySelector('[data-tp-open]')?.addEventListener('click', () => body.classList.add('tp-nav-open'));
        document.querySelectorAll('[data-tp-close]').forEach(el => el.addEventListener('click', () => body.classList.remove('tp-nav-open')));

        document.querySelectorAll('[data-tp-group]').forEach(btn => btn.addEventListener('click', () => {
            if (body.classList.contains('tp-collapsed') && window.innerWidth > 991) {
                body.classList.remove('tp-collapsed');
                try { localStorage.setItem(KEY, '0'); } catch (e) {}
            }
            const group = btn.closest('.tp-group');
            group.classList.toggle('is-open');
            btn.setAttribute('aria-expanded', group.classList.contains('is-open'));
        }));

        const dds = document.querySelectorAll('[data-tp-dd]');
        dds.forEach(dd => dd.querySelector('[data-tp-dd-toggle]').addEventListener('click', (e) => {
            e.stopPropagation();
            const open = !dd.classList.contains('is-open');
            dds.forEach(d => d.classList.remove('is-open'));
            dd.classList.toggle('is-open', open);
        }));
        document.addEventListener('click', (e) => { if (!e.target.closest('[data-tp-dd]')) dds.forEach(d => d.classList.remove('is-open')); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { dds.forEach(d => d.classList.remove('is-open')); body.classList.remove('tp-nav-open'); } });
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
<script>
    (function () {
        if (!window.Swal) return;
        const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3500, timerProgressBar: true });
        @foreach (['success', 'error', 'warning', 'info'] as $type)
            @if (session($type)) Toast.fire({ icon: @json($type), title: @json(session($type)) }); @endif
        @endforeach
    })();
</script>

@include('includes.panel.modal-js')
@include('includes.terra-account')
<script src="{{ asset('js/terra-ui.js') }}?v={{ @filemtime(public_path('js/terra-ui.js')) }}"></script>
