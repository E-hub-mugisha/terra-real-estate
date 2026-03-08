<div x-data="locationForm()" class="row" x-init="init()">
    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Province*</h5>
            <div class="space16"></div>
            <select x-model="province" @change="fetchDistricts" class="form-control" name="province" required>
                <option value="">-- Select Province --</option>
                @foreach($provinces as $province)
                <option value="{{ $province->name }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>District*</h5>
            <div class="space16"></div>
            <select x-model="district" @change="fetchSectors" class="form-control" name="district" required>
                <option value="">-- Select District --</option>
                <template x-for="item in districts" :key="item.id">
                    <option :value="item.name" x-text="item.name"></option>
                </template>
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Sector*</h5>
            <div class="space16"></div>
            <select x-model="sector" @change="fetchCells" class="form-control" name="sector" required>
                <option value="">-- Select Sector --</option>
                <template x-for="item in sectors" :key="item.id">
                    <option :value="item.name" x-text="item.name"></option>
                </template>
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Cell*</h5>
            <div class="space16"></div>
            <select x-model="cell" @change="fetchVillages" class="form-control" name="cell" required>
                <option value="">-- Select Cell --</option>
                <template x-for="item in cells" :key="item.id">
                    <option :value="item.name" x-text="item.name"></option>
                </template>
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5> Village*</h5>
            <div class="space16"></div>
            <select x-model="village" class="form-control" name="village" required>
                <option value="">-- Select Village --</option>
                <template x-for="item in villages" :key="item.id">
                    <option :value="item.name" x-text="item.name"></option>
                </template>
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Neighborhood*</h5>
            <div class="space16"></div>
            <input name="neighborhood" type="text" class="form-control" id="propertyNeighborhood"
                placeholder="Enter neighborhood" required>
        </div>
    </div>

</div>

<script>
function locationForm() {
    return {
        // Initial values (set from Blade if editing)
        province: '{{ old('province_id', $birthRecord->province_id ?? '') }}',
        district: '{{ old('district_id', $birthRecord->district_id ?? '') }}',
        sector: '{{ old('sector_id', $birthRecord->sector_id ?? '') }}',
        cell: '{{ old('cell_id', $birthRecord->cell_id ?? '') }}',
        village: '{{ old('village_id', $birthRecord->village_id ?? '') }}',

        // Data arrays
        districts: [],
        sectors: [],
        cells: [],
        villages: [],

        async init() {
            if (this.province) {
                await this.fetchDistricts();
                if (this.district) {
                    await this.fetchSectors();
                    if (this.sector) {
                        await this.fetchCells();
                        if (this.cell) {
                            await this.fetchVillages();
                        }
                    }
                }
            }
        },

        async fetchDistricts() {
            this.districts = [];
            this.sectors = [];
            this.cells = [];
            this.villages = [];
            if (!this.province) return;
            const res = await fetch(`/get-districts/${this.province}`);
            this.districts = await res.json();
        },

        async fetchSectors() {
            this.sectors = [];
            this.cells = [];
            this.villages = [];
            if (!this.district) return;
            const res = await fetch(`/get-sectors/${this.district}`);
            this.sectors = await res.json();
        },

        async fetchCells() {
            this.cells = [];
            this.villages = [];
            if (!this.sector) return;
            const res = await fetch(`/get-cells/${this.sector}`);
            this.cells = await res.json();
        },

        async fetchVillages() {
            this.villages = [];
            if (!this.cell) return;
            const res = await fetch(`/get-villages/${this.cell}`);
            this.villages = await res.json();
        }
    };
}
</script>