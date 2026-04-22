{{-- ── Location partial — includes/form.blade.php ── --}}
<style>
    /* Only needed if not already in parent page */
    .loc-section-label {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 20px 0 16px;
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: #9E9890;
        font-family: 'DM Sans', sans-serif;
    }

    .loc-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(0, 0, 0, .08);
    }

    .loc-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    @media (max-width: 720px) {
        .loc-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .loc-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Field — reuses .ah-field if parent has it, otherwise self-contained */
    .loc-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .loc-field label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #6B6560;
        font-family: 'DM Sans', sans-serif;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .loc-field label .req {
        color: #dc2626;
    }

    .loc-field label svg {
        width: 11px;
        height: 11px;
        color: #C8873A;
        flex-shrink: 0;
    }

    /* Select wrapper with pin icon */
    .loc-select-wrap {
        position: relative;
    }

    .loc-select-wrap svg.loc-pin {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        width: 13px;
        height: 13px;
        color: #9E9890;
        pointer-events: none;
        transition: color .18s ease;
    }

    .loc-select-wrap select,
    .loc-select-wrap input {
        width: 100%;
        padding: 10px 13px 10px 32px;
        background: #F7F5F2;
        border: 1.5px solid rgba(0, 0, 0, .08);
        border-radius: 9px;
        font-size: .84rem;
        font-family: 'DM Sans', sans-serif;
        color: #19265d;
        appearance: none;
        cursor: pointer;
        transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-position: right 10px center;
        background-repeat: no-repeat;
        padding-right: 28px;
    }

    .loc-select-wrap input {
        background-image: none;
        cursor: text;
    }

    .loc-select-wrap select:focus,
    .loc-select-wrap input:focus {
        outline: none;
        border-color: #C8873A;
        box-shadow: 0 0 0 3px rgba(200, 135, 58, .1);
        background-color: #FFFFFF;
    }

    .loc-select-wrap select:focus+svg.loc-pin,
    .loc-select-wrap input:focus+svg.loc-pin,
    .loc-select-wrap:focus-within svg.loc-pin {
        color: #C8873A;
    }

    /* Disabled state */
    .loc-select-wrap select:disabled {
        opacity: .45;
        cursor: not-allowed;
        background-color: #F7F5F2;
    }

    /* Chain indicator — shows active step */
    .loc-chain {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .loc-chain-step {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: .7rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        color: #9E9890;
        transition: color .18s;
    }

    .loc-chain-step.filled {
        color: #1E7A5A;
    }

    .loc-chain-step.active {
        color: #C8873A;
    }

    .loc-chain-step svg {
        width: 10px;
        height: 10px;
    }

    .loc-chain-sep {
        font-size: .65rem;
        color: rgba(0, 0, 0, .18);
    }
</style>

{{-- Section label --}}
<div class="loc-section-label">
    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#C8873A">
        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
    </svg>
    Property Location
</div>

{{-- Breadcrumb chain ── updates via JS --}}
<div class="loc-chain" id="loc-chain">
    <span class="loc-chain-step active" id="lc-province">
        <svg viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="4" />
        </svg>
        Province
    </span>
    <span class="loc-chain-sep">›</span>
    <span class="loc-chain-step" id="lc-district">District</span>
    <span class="loc-chain-sep">›</span>
    <span class="loc-chain-step" id="lc-sector">Sector</span>
    <span class="loc-chain-sep">›</span>
    <span class="loc-chain-step" id="lc-cell">Cell</span>
    <span class="loc-chain-sep">›</span>
    <span class="loc-chain-step" id="lc-village">Village</span>
</div>

{{-- 3-column responsive grid --}}
<div class="loc-grid">

    {{-- Province --}}
    <div class="loc-field">
        <label>
            Province <span class="req">*</span>
        </label>
        <div class="loc-select-wrap">
            <select id="province" name="province" required>
                <option value="">Select province</option>
            </select>
            <svg class="loc-pin" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
            </svg>
        </div>
    </div>

    {{-- District --}}
    <div class="loc-field">
        <label>District <span class="req">*</span></label>
        <div class="loc-select-wrap">
            <select id="district" name="district" required disabled>
                <option value="">Select district</option>
            </select>
            <svg class="loc-pin" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
            </svg>
        </div>
    </div>

    {{-- Sector --}}
    <div class="loc-field">
        <label>Sector <span class="req">*</span></label>
        <div class="loc-select-wrap">
            <select id="sector" name="sector" required disabled>
                <option value="">Select sector</option>
            </select>
            <svg class="loc-pin" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
            </svg>
        </div>
    </div>

    {{-- Cell --}}
    <div class="loc-field">
        <label>Cell <span class="req">*</span></label>
        <div class="loc-select-wrap">
            <select id="cell" name="cell" required disabled>
                <option value="">Select cell</option>
            </select>
            <svg class="loc-pin" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
            </svg>
        </div>
    </div>

    {{-- Village --}}
    <div class="loc-field">
        <label>Village <span class="req">*</span></label>
        <div class="loc-select-wrap">
            <select id="village" name="village" required disabled>
                <option value="">Select village</option>
            </select>
            <svg class="loc-pin" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
            </svg>
        </div>
    </div>

    {{-- Neighborhood --}}
    <div class="loc-field">
        <label>Neighborhood <span class="req">*</span></label>
        <div class="loc-select-wrap">
            <input type="text" name="neighborhood"
                value="{{ old('neighborhood') }}"
                placeholder="e.g. Kimihurura" required>
            <svg class="loc-pin" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
            </svg>
        </div>
    </div>

</div>

<script>
    (function() {
        let locations = {};

        const selProvince = document.getElementById('province');
        const selDistrict = document.getElementById('district');
        const selSector = document.getElementById('sector');
        const selCell = document.getElementById('cell');
        const selVillage = document.getElementById('village');

        /* Breadcrumb chain elements */
        const lcProv = document.getElementById('lc-province');
        const lcDist = document.getElementById('lc-district');
        const lcSect = document.getElementById('lc-sector');
        const lcCell = document.getElementById('lc-cell');
        const lcVill = document.getElementById('lc-village');

        function resetSelect(el, placeholder) {
            el.innerHTML = `<option value="">${placeholder}</option>`;
            el.disabled = true;
        }

        function populateSelect(el, keys, placeholder) {
            el.innerHTML = `<option value="">${placeholder}</option>`;
            keys.forEach(k => el.innerHTML += `<option value="${k}">${k}</option>`);
            el.disabled = false;
        }

        function setChain(prov, dist, sect, cellVal, vill) {
            const setStep = (el, val, defaultLabel) => {
                el.textContent = val || defaultLabel;
                el.className = 'loc-chain-step' + (val ? ' filled' : '');
            };
            lcProv.textContent = prov || 'Province';
            lcProv.className = 'loc-chain-step' + (prov ? ' filled' : ' active');
            setStep(lcDist, dist, 'District');
            setStep(lcSect, sect, 'Sector');
            setStep(lcCell, cellVal, 'Cell');
            setStep(lcVill, vill, 'Village');

            /* Highlight the next step to fill */
            if (!prov) {
                lcProv.classList.add('active');
                return;
            }
            if (!dist) {
                lcDist.classList.add('active');
                return;
            }
            if (!sect) {
                lcSect.classList.add('active');
                return;
            }
            if (!cellVal) {
                lcCell.classList.add('active');
                return;
            }
            if (!vill) {
                lcVill.classList.add('active');
                return;
            }
        }

        /* Load location data */
        fetch('/data/locations.json')
            .then(res => res.json())
            .then(data => {
                locations = data;
                populateSelect(selProvince, Object.keys(locations), 'Select province');
            });

        /* Province change */
        selProvince.addEventListener('change', function() {
            resetSelect(selDistrict, 'Select district');
            resetSelect(selSector, 'Select sector');
            resetSelect(selCell, 'Select cell');
            resetSelect(selVillage, 'Select village');
            setChain(this.value, '', '', '', '');
            if (!this.value) return;
            populateSelect(selDistrict, Object.keys(locations[this.value]), 'Select district');
        });

        /* District change */
        selDistrict.addEventListener('change', function() {
            resetSelect(selSector, 'Select sector');
            resetSelect(selCell, 'Select cell');
            resetSelect(selVillage, 'Select village');
            setChain(selProvince.value, this.value, '', '', '');
            if (!this.value) return;
            populateSelect(selSector, Object.keys(locations[selProvince.value][this.value]), 'Select sector');
        });

        /* Sector change */
        selSector.addEventListener('change', function() {
            resetSelect(selCell, 'Select cell');
            resetSelect(selVillage, 'Select village');
            setChain(selProvince.value, selDistrict.value, this.value, '', '');
            if (!this.value) return;
            populateSelect(selCell, Object.keys(locations[selProvince.value][selDistrict.value][this.value]), 'Select cell');
        });

        /* Cell change */
        selCell.addEventListener('change', function() {
            resetSelect(selVillage, 'Select village');
            setChain(selProvince.value, selDistrict.value, selSector.value, this.value, '');
            if (!this.value) return;
            const villages = locations[selProvince.value][selDistrict.value][selSector.value][this.value];
            populateSelect(selVillage, villages, 'Select village');
        });

        /* Village change */
        selVillage.addEventListener('change', function() {
            setChain(selProvince.value, selDistrict.value, selSector.value, selCell.value, this.value);
        });

        /* Init chain */
        setChain('', '', '', '', '');
    })();
</script>