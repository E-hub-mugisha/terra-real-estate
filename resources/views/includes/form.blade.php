<div class="row">

    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Province*</h5>
            <div class="space16"></div>

            <select id="province" class="form-control" name="province" required>
                <option value="">-- Select Province --</option>
            </select>

        </div>
    </div>


    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>District*</h5>
            <div class="space16"></div>

            <select id="district" class="form-control" name="district" required>
                <option value="">-- Select District --</option>
            </select>

        </div>
    </div>


    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Sector*</h5>
            <div class="space16"></div>

            <select id="sector" class="form-control" name="sector" required>
                <option value="">-- Select Sector --</option>
            </select>

        </div>
    </div>


    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Cell*</h5>
            <div class="space16"></div>

            <select id="cell" class="form-control" name="cell" required>
                <option value="">-- Select Cell --</option>
            </select>

        </div>
    </div>


    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Village*</h5>
            <div class="space16"></div>

            <select id="village" class="form-control" name="village" required>
                <option value="">-- Select Village --</option>
            </select>

        </div>
    </div>


    <div class="col-lg-4 col-md-6">
        <div class="space28"></div>
        <div class="input-area">
            <h5>Neighborhood*</h5>
            <div class="space16"></div>

            <input name="neighborhood" type="text"
                class="form-control"
                placeholder="Enter neighborhood"
                required>

        </div>
    </div>

</div>

<script>

let locations = {}

const province = document.getElementById("province")
const district = document.getElementById("district")
const sector = document.getElementById("sector")
const cell = document.getElementById("cell")
const village = document.getElementById("village")

// Load JSON once
fetch("/data/locations.json")
.then(res => res.json())
.then(data => {

locations = data

Object.keys(locations).forEach(p => {
province.innerHTML += `<option value="${p}">${p}</option>`
})

})


// Province change
province.addEventListener("change", function(){

district.innerHTML = '<option value="">-- Select District --</option>'
sector.innerHTML = '<option value="">-- Select Sector --</option>'
cell.innerHTML = '<option value="">-- Select Cell --</option>'
village.innerHTML = '<option value="">-- Select Village --</option>'

if(!this.value) return

Object.keys(locations[this.value]).forEach(d => {

district.innerHTML += `<option value="${d}">${d}</option>`

})

})


// District change
district.addEventListener("change", function(){

sector.innerHTML = '<option value="">-- Select Sector --</option>'
cell.innerHTML = '<option value="">-- Select Cell --</option>'
village.innerHTML = '<option value="">-- Select Village --</option>'

if(!this.value) return

Object.keys(locations[province.value][this.value]).forEach(s => {

sector.innerHTML += `<option value="${s}">${s}</option>`

})

})


// Sector change
sector.addEventListener("change", function(){

cell.innerHTML = '<option value="">-- Select Cell --</option>'
village.innerHTML = '<option value="">-- Select Village --</option>'

if(!this.value) return

Object.keys(locations[province.value][district.value][this.value]).forEach(c => {

cell.innerHTML += `<option value="${c}">${c}</option>`

})

})


// Cell change
cell.addEventListener("change", function(){

village.innerHTML = '<option value="">-- Select Village --</option>'

if(!this.value) return

locations[province.value][district.value][sector.value][this.value]
.forEach(v => {

village.innerHTML += `<option value="${v}">${v}</option>`

})

})

</script>