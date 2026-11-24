{{--
    Cascading Province → District → Sector → Cell → Village selects, pre-filled from saved values.
    Saved values that are not in /data/locations.json are kept as a selectable option, so editing
    a listing never silently drops its location.
    Expects: $value = ['province' => .., 'district' => .., 'sector' => .., 'cell' => .., 'village' => ..]
    Optional: $required (array of level names that are required)
--}}
@php
    $levels = ['province' => 'Province', 'district' => 'District', 'sector' => 'Sector', 'cell' => 'Cell', 'village' => 'Village'];
    $required = $required ?? ['province', 'district', 'sector', 'cell'];
@endphp
<div class="row g-3" data-location-picker>
    @foreach ($levels as $key => $label)
        <div class="col-md-4 col-lg">
            <label class="form-label" for="loc_{{ $key }}">{{ $label }} @if (in_array($key, $required))<span class="text-danger">*</span>@endif</label>
            <select class="form-select @error($key) is-invalid @enderror" id="loc_{{ $key }}" name="{{ $key }}"
                data-level="{{ $key }}" data-current="{{ old($key, $value[$key] ?? '') }}" @if (in_array($key, $required)) required @endif>
                <option value="">{{ old($key, $value[$key] ?? '') ?: 'Select ' . strtolower($label) }}</option>
            </select>
            @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    @endforeach
</div>

@push('scripts')
<script>
    (function () {
        const root = document.querySelector('[data-location-picker]');
        if (!root) return;
        const order = ['province', 'district', 'sector', 'cell', 'village'];
        const sel = Object.fromEntries(order.map(k => [k, root.querySelector(`[data-level="${k}"]`)]));
        const norm = (v) => String(v || '').toLowerCase().replace(/\s+city$/, '').replace(/\s+province$/, '').trim();
        let data = {};

        // Options for a level given the chosen parents (object keys, or the village array).
        function optionsFor(level) {
            let node = data;
            for (const k of order.slice(0, order.indexOf(level))) {
                if (!node || Array.isArray(node)) return [];
                const key = Object.keys(node).find(x => norm(x) === norm(sel[k].value));
                node = key ? node[key] : null;
            }
            if (!node) return [];
            return Array.isArray(node) ? node : Object.keys(node);
        }

        function fill(level, keepCurrent) {
            const s = sel[level];
            const current = keepCurrent ? s.dataset.current : '';
            const opts = optionsFor(level);
            const label = s.closest('div').querySelector('label').textContent.replace('*', '').trim().toLowerCase();
            s.innerHTML = `<option value="">Select ${label}</option>`;
            let matched = '';
            opts.forEach(o => {
                const opt = new Option(o, o);
                if (current && norm(o) === norm(current)) { opt.selected = true; matched = o; }
                s.add(opt);
            });
            // Keep a saved value that isn't in the dataset.
            if (current && !matched) {
                s.add(new Option(current + ' (saved)', current, true, true), 1);
            }
            s.disabled = level !== 'province' && opts.length === 0 && !current;
        }

        function cascadeFrom(level, keepCurrent) {
            order.slice(order.indexOf(level) + 1).forEach(l => fill(l, keepCurrent));
        }

        order.forEach(level => sel[level].addEventListener('change', () => cascadeFrom(level, false)));

        fetch(@json(asset('data/locations.json')))
            .then(r => r.json())
            .then(json => { data = json; fill('province', true); cascadeFrom('province', true); })
            .catch(() => order.forEach(l => {
                const s = sel[l];
                if (s.dataset.current) s.innerHTML = `<option value="${s.dataset.current}" selected>${s.dataset.current}</option>`;
            }));
    })();
</script>
@endpush
