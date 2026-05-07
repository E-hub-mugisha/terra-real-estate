import { c as o, i as l } from "../../admin.bundle-CEbNEZ37.js"; import "../../main-O_SKZbQk.js"; const p = [{ id: "1", name: "Samantha Peterson", email: "samantha.peterson@example.com", phone: "+1 555 123 4567", role: "Senior Property Agent", sales: 120, clients: 98, experience: 5, rating: 4.5, properties: 42, avatar: "assets/images/avatar/user-2.png", city: "New York" }, { id: "2", name: "Michael Brown", email: "michael.brown@example.com", phone: "+1 555 987 6543", role: "Property Consultant", sales: 98, clients: 87, experience: 4, rating: 4.7, properties: 38, avatar: "assets/images/avatar/user-3.png", city: "Los Angeles" }, { id: "3", name: "Emily Johnson", email: "emily.johnson@example.com", phone: "+1 555 456 7890", role: "Real Estate Specialist", sales: 145, clients: 112, experience: 6, rating: 4.9, properties: 56, avatar: "assets/images/avatar/user-4.png", city: "Chicago" }, { id: "4", name: "Daniel Cooper", email: "daniel.cooper@example.com", phone: "+1 555 321 0987", role: "Associate Agent", sales: 75, clients: 60, experience: 3, rating: 4.3, properties: 27, avatar: "assets/images/avatar/user-30.png", city: "Houston" }, { id: "5", name: "Olivia Smith", email: "olivia.smith@example.com", phone: "+1 555 654 3210", role: "Senior Property Agent", sales: 130, clients: 102, experience: 5, rating: 4.6, properties: 50, avatar: "assets/images/avatar/user-6.png", city: "Miami" }, { id: "6", name: "Liam Johnson", email: "liam.johnson@example.com", phone: "+1 555 789 0123", role: "Property Consultant", sales: 112, clients: 90, experience: 4, rating: 4.8, properties: 36, avatar: "assets/images/avatar/user-20.png", city: "New York" }, { id: "7", name: "Sophia Williams", email: "sophia.williams@example.com", phone: "+1 555 234 5678", role: "Real Estate Specialist", sales: 85, clients: 75, experience: 3, rating: 4.4, properties: 28, avatar: "assets/images/avatar/user-8.png", city: "Los Angeles" }, { id: "8", name: "Noah Davis", email: "noah.davis@example.com", phone: "+1 555 876 5432", role: "Senior Property Agent", sales: 152, clients: 125, experience: 7, rating: 4.9, properties: 61, avatar: "assets/images/avatar/user-9.png", city: "Chicago" }, { id: "9", name: "Ava Martinez", email: "ava.martinez@example.com", phone: "+1 555 345 6789", role: "Property Consultant", sales: 102, clients: 88, experience: 4, rating: 4.2, properties: 47, avatar: "assets/images/avatar/user-10.png", city: "Houston" }, { id: "10", name: "William Lee", email: "william.lee@example.com", phone: "+1 555 012 3456", role: "Associate Agent", sales: 70, clients: 55, experience: 3, rating: 4, properties: 33, avatar: "assets/images/avatar/user-11.png", city: "Miami" }, { id: "11", name: "Isabella Harris", email: "isabella.harris@example.com", phone: "+1 555 567 8901", role: "Senior Property Agent", sales: 135, clients: 105, experience: 6, rating: 4.7, properties: 45, avatar: "assets/images/avatar/user-12.png", city: "New York" }, { id: "12", name: "James Clark", email: "james.clark@example.com", phone: "+1 555 890 1234", role: "Property Consultant", sales: 95, clients: 80, experience: 4, rating: 4.5, properties: 40, avatar: "assets/images/avatar/user-13.png", city: "Los Angeles" }, { id: "13", name: "Mia Rodriguez", email: "mia.rodriguez@example.com", phone: "+1 555 678 9012", role: "Real Estate Specialist", sales: 140, clients: 110, experience: 5, rating: 4.8, properties: 52, avatar: "assets/images/avatar/user-14.png", city: "Chicago" }, { id: "14", name: "Benjamin Lewis", email: "benjamin.lewis@example.com", phone: "+1 555 901 2345", role: "Associate Agent", sales: 80, clients: 65, experience: 3, rating: 4.1, properties: 30, avatar: "assets/images/avatar/user-15.png", city: "Houston" }, { id: "15", name: "Charlotte Walker", email: "charlotte.walker@example.com", phone: "+1 555 456 7890", role: "Senior Property Agent", sales: 125, clients: 100, experience: 5, rating: 4.6, properties: 48, avatar: "assets/images/avatar/user-16.png", city: "Miami" }, { id: "16", name: "Elijah Hall", email: "elijah.hall@example.com", phone: "+1 555 234 5678", role: "Property Consultant", sales: 110, clients: 92, experience: 4, rating: 4.4, properties: 35, avatar: "assets/images/avatar/user-17.png", city: "New York" }]; function d(n, e) { let a; return function (...i) { clearTimeout(a), a = setTimeout(() => n.apply(this, i), e) } } class m {
    constructor(e) { this.data = e.data || [], this.container = document.getElementById(e.containerId), this.itemsPerPage = e.itemsPerPage || 10, this.currentPage = 1, this.searchFields = e.searchFields || [], this.filteredData = [...this.data], this.renderTable = this.renderTable.bind(this), this.renderPagination = this.renderPagination.bind(this), this.handleSearch = this.handleSearch.bind(this), this.goToPage = this.goToPage.bind(this), this.setupEventListeners(), this.renderTable(), this.renderPagination() } setupEventListeners() { const e = document.getElementById("searchAgentInput"); e && e.addEventListener("input", d(this.handleSearch, 300)), this.initializeTooltips() } initializeTooltips() { [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).forEach(a => { new bootstrap.Tooltip(a) }) } renderTable() {
        if (!this.container) return; const e = (this.currentPage - 1) * this.itemsPerPage, a = this.currentPage === 1 ? e + this.itemsPerPage : e + 6, i = this.filteredData.slice(e, a), s = document.getElementById("agentTable"); if (s.innerHTML = "", i.length === 0) {
            s.innerHTML = `
                <div class="col-12 text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto size-12" viewBox="0 0 48 48">
                        <linearGradient id="SVGID_1" x1="34.598" x2="15.982" y1="15.982" y2="34.598" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#60e8fe"></stop>
                            <stop offset=".033" stop-color="#6ae9fe"></stop>
                            <stop offset=".197" stop-color="#97f0fe"></stop>
                            <stop offset=".362" stop-color="#bdf5ff"></stop>
                            <stop offset=".525" stop-color="#dafaff"></stop>
                            <stop offset=".687" stop-color="#eefdff"></stop>
                            <stop offset=".846" stop-color="#fbfeff"></stop>
                            <stop offset="1" stop-color="#ffffff"></stop>
                        </linearGradient>
                        <path fill="url(#SVGID_1)" d="M40.036,33.826L31.68,25.6c0.847-1.739,1.335-3.684,1.335-5.748
                            c0-7.27-5.894-13.164-13.164-13.164S6.688,12.582,6.688,19.852c0,7.27,5.894,13.164,13.164,13.164
                            c2.056,0,3.995-0.485,5.728-1.326l3.914,4.015l4.331,4.331c1.715,1.715,4.496,1.715,6.211,0
                            C41.751,38.321,41.751,35.541,40.036,33.826z"></path>
                        <path fill="none" stroke="#10cfe3" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"
                            d="M31.95,25.739l8.086,8.086c1.715,1.715,1.715,4.496,0,6.211l0,0c-1.715,1.715-4.496,1.715-6.211,0l-4.331-4.331"></path>
                        <path fill="none" stroke="#10cfe3" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"
                            d="M7.525,24.511c-1.771-4.694-0.767-10.196,3.011-13.975c3.847-3.847,9.48-4.817,14.228-2.912"></path>
                        <path fill="none" stroke="#10cfe3" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="3"
                            d="M30.856,12.603c3.376,5.114,2.814,12.063-1.688,16.565c-4.858,4.858-12.565,5.129-17.741,0.814"></path>
                    </svg>
                    <p class="mt-2 text-center text-gray-500">No matching records found</p>
                    <p class="text-muted mb-0">We couldn't find any agents matching your criteria.</p>
                </div>
            `; return
        } i.forEach(t => {
            const r = document.createElement("div"); r.className = "col", r.innerHTML = `
                <div class="card" data-id="${t.id}">
                    <div class="card-header d-flex gap-4 align-items-center">
                        <div class="flex-grow-1">
                            <button type="button" class="btn btn-secondary btn-icon size-8 rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="${t.properties} Properties">
                                <i data-lucide="house" class="size-4"></i>
                            </button>
                        </div>
                        <div class="dropdown flex-shrink-0">
                            <a href="#!" class="link link-custom-primary" aria-label="dropdown link" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-lucide="ellipsis-vertical" class="size-4"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#!">View Profile</a></li>
                                <li><a class="dropdown-item" href="#!">View Performance</a></li>
                                <li><a class="dropdown-item" href="#!">View Listings</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body pt-4 position-relative">
                        <span class="bg-warning-subtle lh-sm text-warning py-2 px-4 position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-10 fs-12 fw-semibold">
                            <i class="bi bi-star-fill me-1 fs-11"></i> ${t.rating}
                        </span>
                        <div class="text-center">
                            <div class="profile-avatar position-relative d-inline-block">
                                <img src="${t.avatar}" loading="lazy" alt="${t.name}" class="rounded-circle flex-shrink-0 size-16">
                                <div class="status-indicator bg-success rounded-circle size-3"></div>
                            </div>
                            <div class="mt-5">
                                <a href="#!" class="fs-16 text-reset fw-medium d-block mb-1">${t.name}</a>
                                <p class="text-muted fs-sm">${t.role}</p>
                            </div>
                        </div>
                        <div class="row text-center mt-6">
                            <div class="col-4">
                                <h6 class="mb-1">${t.sales}</h6>
                                <p class="mb-0 fs-13 text-muted">Sales</p>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-1">${t.clients}</h6>
                                <p class="mb-0 fs-13 text-muted">Clients</p>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-1">${t.experience}</h6>
                                <p class="mb-0 fs-13 text-muted">Years Exp.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-7">
                            <button type="button" class="btn btn-outline-light w-100"><i data-lucide="mail" class="me-1 size-4"></i> Email</button>
                            <button type="button" class="btn btn-sub-primary w-100"><i data-lucide="phone-outgoing" class="me-1 size-4"></i> Call</button>
                        </div>
                    </div>
                </div>
            `, s.appendChild(r)
        }), this.updateResultsCount(), o({ icons: l }), this.initializeTooltips()
    } updateResultsCount() { const e = document.querySelector("#showingResults"); if (e) { const a = (this.currentPage - 1) * this.itemsPerPage + 1, i = Math.min(this.currentPage === 1 ? a + this.itemsPerPage - 1 : a + 5, this.filteredData.length); e.innerHTML = `Showing <b class="me-1">${a}-${i}</b> of <b class="ms-1">${this.filteredData.length}</b> Results` } } renderPagination() { const e = Math.ceil(this.filteredData.length / this.itemsPerPage) || 1, a = document.querySelector(".pagination"); if (!a) return; a.innerHTML = ""; const i = document.createElement("li"); i.className = `page-item ${this.currentPage === 1 ? "disabled" : ""}`, i.innerHTML = '<a class="page-link" href="#!" aria-label="Previous"><i data-lucide="chevron-left" class="size-4"></i> Previous</a>', i.addEventListener("click", t => { t.preventDefault(), this.currentPage > 1 && this.goToPage(this.currentPage - 1) }), a.appendChild(i); for (let t = 1; t <= e; t++) { const r = document.createElement("li"); r.className = `page-item ${this.currentPage === t ? "active" : ""}`, r.innerHTML = `<a class="page-link" href="#!" aria-label="Page ${t}">${t}</a>`, r.addEventListener("click", c => { c.preventDefault(), this.goToPage(t) }), a.appendChild(r) } const s = document.createElement("li"); s.className = `page-item ${this.currentPage === e ? "disabled" : ""}`, s.innerHTML = '<a class="page-link" href="#!" aria-label="Next">Next <i data-lucide="chevron-right" class="size-4"></i></a>', s.addEventListener("click", t => { t.preventDefault(), this.currentPage < e && this.goToPage(this.currentPage + 1) }), a.appendChild(s), o({ icons: l }) } handleSearch(e) { const a = e.target.value.toLowerCase().trim(); a ? this.filteredData = this.data.filter(i => this.searchFields.some(s => String(i[s]).toLowerCase().includes(a))) : this.filteredData = [...this.data], this.currentPage = 1, this.renderTable(), this.renderPagination() } goToPage(e) { this.currentPage = e, this.renderTable(), this.renderPagination(), this.container && this.container.scrollIntoView({ behavior: "smooth" }) }
} document.addEventListener("DOMContentLoaded", () => { const n = new m({ data: p, containerId: "agentTableContainer", itemsPerPage: 10, searchFields: ["name", "email", "phone", "role"] }); window.tableManager = n });
