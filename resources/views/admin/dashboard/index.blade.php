@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')


<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">Main</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Dashboards</a></li>
        <li class="breadcrumb-item active">Main</li>
    </ul>
</div>
<div class="row">
    <div class="col-xxl-6">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-h-100 welcome-card">
                    <div class="card-body">
                        <div class="row h-100">
                            <div class="col-md-10 col-lg-9">
                                <div class="d-flex flex-column h-100 justify-content-between">
                                    <div>
                                        <h5 class="mb-2">Welcome Back, Sophia!</h5>
                                        <p class="text-muted mb-4 fs-15 lh-base">You have 8 new property
                                            leads and 3 deals.</p>
                                        <h6 class="fs-15 mb-6">
                                            <i data-lucide="trending-up"
                                                class="text-success size-4 me-1"></i>
                                            <span class="font-monospace me-2"><span class="counter"
                                                    data-start="0" data-end="2158"
                                                    data-duration="1000"></span></span>
                                            <span class="text-muted fw-normal">/ Total Properties</span>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="#" class="btn btn-primary">View Profile</a>
                                    </div>
                                </div>
                            </div>
                            <img src="assets/images/welcome-vector.png" alt="Welcome Vector"
                                class="img-fluid position-absolute welcome-vector">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-4">
                        <div class="d-flex mb-3 gap-3">
                            <div class="flex-grow-1">
                                <h5 class="font-monospace mb-2 d-flex align-items-center gap-2">
                                    <span class="counter" data-start="0" data-end="1150"
                                        data-duration="1000"></span>
                                    <span class="text-success fs-13">+5.6%</span>
                                </h5>
                                <p class="text-muted mb-0 text-truncate w-100">New Lead this month</p>
                            </div>
                            <div
                                class="avatar size-9 flex-shrink-0 rounded-3 bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center">
                                <i class="ri-line-chart-fill"></i>
                            </div>
                        </div>
                        <div id="activeListingsChart" dir="ltr"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-6">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-5">
                            <div class="flex-grow-1">
                                <h5 class="font-monospace mb-2"><span class="counter" data-start="0"
                                        data-end="2500" data-duration="1000"></span></h5>
                                <p class="text-muted">This Month Sales</p>
                            </div>
                            <div
                                class="avatar size-9 flex-shrink-0 rounded-3 bg-danger-subtle text-danger">
                                <i class="ri-home-4-fill"></i>
                            </div>
                        </div>
                        <div id="totalSales" dir="ltr"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-2">
                            <div class="flex-grow-1">
                                <h5 class="mb-2 fs-15">Listings Added per Month</h5>
                                <p class="text-muted">Monthly new property listings and trends.</p>
                            </div>
                            <span
                                class="badge bg-info-subtle text-info border border-info-subtle fs-12"><i
                                    data-lucide="trending-up" class="size-3 me-1"></i>2.5%</span>
                        </div>
                        <div id="listingsAdded" dir="ltr" class="mt-n3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header d-flex flex-wrap gap-3 align-items-center">
                <div class="flex-grow-1">
                    <h5 class="card-title mb-2">Total Properties</h5>
                    <p class="text-muted">Insight into your total property portfolio distribution.</p>
                </div>
                <ul class="nav nav-pills custom-nav bg-body-tertiary p-1 rounded" id="properties"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fs-13 active" id="monthly-property-tab"
                            data-bs-toggle="pill" data-bs-target="#monthly-property"
                            type="button">Monthly</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fs-13" id="weekly-property-tab" data-bs-toggle="pill"
                            data-bs-target="#weekly-property" type="button">Weekly</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="propertiesTabContent">
                    <div class="tab-pane fade show active" id="monthly-property">
                        <div id="totalPropertiesMonthly" class="apex-chart"></div>
                    </div>
                    <div class="tab-pane fade" id="weekly-property">
                        <div id="totalPropertiesWeekly" class="apex-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-3">
        <div class="card card-h-100">
            <div class="card-header d-flex flex-wrap gap-3 justify-content-between align-items-center">
                <h5 class="card-title mb-0">Property Status Breakdown</h5>
                <span
                    class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">This
                    Month</span>
            </div>
            <div class="card-body pt-6">
                <div class="border rounded-3 shadow">
                    <div class="row g-0">
                        <div class="col-6">
                            <div class="p-3 p-md-6 border-end border-bottom">
                                <h5 class="mb-4 font-monospace"><span class="counter" data-start="0"
                                        data-end="1280" data-duration="1000"></span></h5>
                                <p class="text-muted mb-2 text-truncate">Total For Sale</p>
                                <span class="text-success fw-medium fs-13">
                                    <i data-lucide="trending-down" class="me-1 size-3"></i>+6.2%
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 p-md-6 border-bottom">
                                <h5 class="mb-4 font-monospace"><span class="counter" data-start="0"
                                        data-end="980" data-duration="1000"></span></h5>
                                <p class="text-muted mb-2 text-truncate">Active For Rent</p>
                                <span class="text-success fw-medium fs-13">
                                    <i data-lucide="trending-up" class="me-1 size-3"></i>+3.8%
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 p-md-6 border-end">
                                <h5 class="mb-4 font-monospace"><span class="counter" data-start="0"
                                        data-end="745" data-duration="1000"></span></h5>
                                <p class="text-muted mb-2 text-truncate">Properties Sold</p>
                                <span class="text-success fw-medium fs-13">
                                    <i data-lucide="trending-up" class="me-1 size-3"></i>+1.5%
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 p-md-6">
                                <h5 class="mb-4 font-monospace"><span class="counter" data-start="0"
                                        data-end="210" data-duration="1000"></span></h5>
                                <p class="text-muted mb-2 text-truncate">Deal Still Pending</p>
                                <span class="text-danger fw-medium fs-13">
                                    <i data-lucide="trending-up" class="me-1 size-3"></i>-2.4%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-muted mt-2 mb-0 text-center">
                        64% properties available for sale, 23% for rent, 10% sold, 3% pending approval.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xxl-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 flex-grow-1">Top Performing Locations</h5>
            </div>
            <div class="card-body">
                <div class="px-5 mx-n5" data-simplebar style="max-height: 353px;">
                    <div class="d-flex flex-column gap-5">
                        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img src="assets/images/property-1.jpg" alt="property"
                                    class="rounded-2 size-11">
                                <div>
                                    <a href="apps-property-details.html"
                                        class="text-reset fw-medium d-block mb-1">Ocean View
                                        Apartment</a>
                                    <span class="text-muted"><i class="ri-map-pin-line me-1"></i>Miami,
                                        FL</span>
                                </div>
                            </div>
                            <span class="px-2 py-1 border rounded fs-13 ms-auto"><i
                                    class="ri-star-fill me-1 text-warning"></i>4.9</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img src="assets/images/property-2.jpg" alt="property"
                                    class="rounded-2 size-11">
                                <div>
                                    <a href="apps-property-details.html"
                                        class="text-reset fw-medium d-block mb-1">Palm Residency</a>
                                    <span class="text-muted"><i class="ri-map-pin-line me-1"></i>Los
                                        Angeles, CA</span>
                                </div>
                            </div>
                            <span class="px-2 py-1 border rounded fs-13 ms-auto"><i
                                    class="ri-star-fill me-1 text-warning"></i>4.7</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img src="assets/images/property-3.jpg" alt="property"
                                    class="rounded-2 size-11">
                                <div>
                                    <a href="apps-property-details.html"
                                        class="text-reset fw-medium d-block mb-1">Skyline Towers</a>
                                    <span class="text-muted"><i class="ri-map-pin-line me-1"></i>New
                                        York, NY</span>
                                </div>
                            </div>
                            <span class="px-2 py-1 border rounded fs-13 ms-auto"><i
                                    class="ri-star-fill me-1 text-warning"></i>4.8</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img src="assets/images/property-4.jpg" alt="property"
                                    class="rounded-2 size-11">
                                <div>
                                    <a href="apps-property-details.html"
                                        class="text-reset fw-medium d-block mb-1">Greenfield Villa</a>
                                    <span class="text-muted"><i class="ri-map-pin-line me-1"></i>Austin,
                                        TX</span>
                                </div>
                            </div>
                            <span class="px-2 py-1 border rounded fs-13 ms-auto"><i
                                    class="ri-star-fill me-1 text-warning"></i>4.6</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img src="assets/images/property-5.jpg" alt="property"
                                    class="rounded-2 size-11">
                                <div>
                                    <a href="apps-property-details.html"
                                        class="text-reset fw-medium d-block mb-1">Lakeside Manor</a>
                                    <span class="text-muted"><i
                                            class="ri-map-pin-line me-1"></i>Chicago, IL</span>
                                </div>
                            </div>
                            <span class="px-2 py-1 border rounded fs-13 ms-auto"><i
                                    class="ri-star-fill me-1 text-warning"></i>4.5</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img src="assets/images/property-6.jpg" alt="property"
                                    class="rounded-2 size-11">
                                <div>
                                    <a href="apps-property-details.html"
                                        class="text-reset fw-medium d-block mb-1">Hilltop Estate</a>
                                    <span class="text-muted"><i class="ri-map-pin-line me-1"></i>Denver,
                                        CO</span>
                                </div>
                            </div>
                            <span class="px-2 py-1 border rounded fs-13 ms-auto"><i
                                    class="ri-star-fill me-1 text-warning"></i>4.4</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-8">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-h-100">
                    <div class="card-header d-flex flex-wrap gap-2 align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Team Insights</h5>
                        <a href="#!" class="flex-shrink-0 link link-custom-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-card table-responsive">
                            <table class="table table-borderless align-middle text-nowrap mb-0">
                                <thead class="bg-light">
                                    <tr class="border-bottom border-top">
                                        <th class="fw-medium text-muted">Member</th>
                                        <th class="fw-medium text-muted">Role</th>
                                        <th class="fw-medium text-muted">Sold</th>
                                        <th class="fw-medium text-muted">Revenue</th>
                                        <th class="fw-medium text-muted">Client Rating</th>
                                        <th class="fw-medium text-muted">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="assets/images/user-1.png" alt="User"
                                                    class="rounded-circle size-9">
                                                <a href="apps-agents-profile.html"
                                                    class="link link-custom fw-medium">Amit Sharma</a>
                                            </div>
                                        </td>
                                        <td>Senior Agent</td>
                                        <td>42</td>
                                        <td>₹3.6 Cr</td>
                                        <td><span class="px-2 py-1 border rounded"><i
                                                    class="ri-star-fill me-1 text-warning"></i>4.9</span>
                                        </td>
                                        <td><span
                                                class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="assets/images/user-2.png" alt="User"
                                                    class="rounded-circle size-9">
                                                <a href="apps-agents-profile.html"
                                                    class="link link-custom fw-medium">Priya Nair</a>
                                            </div>
                                        </td>
                                        <td>Sales Executive</td>
                                        <td>37</td>
                                        <td>₹2.9 Cr</td>
                                        <td><span class="px-2 py-1 border rounded"><i
                                                    class="ri-star-fill me-1 text-warning"></i>4.8</span>
                                        </td>
                                        <td><span
                                                class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="assets/images/user-3.png" alt="User"
                                                    class="rounded-circle size-9">
                                                <a href="apps-agents-profile.html"
                                                    class="link link-custom fw-medium">Rahul Mehta</a>
                                            </div>
                                        </td>
                                        <td>Property Consultant</td>
                                        <td>29</td>
                                        <td>₹2.3 Cr</td>
                                        <td><span class="px-2 py-1 border rounded"><i
                                                    class="ri-star-fill me-1 text-warning"></i>4.7</span>
                                        </td>
                                        <td><span
                                                class="badge bg-warning-subtle text-warning border border-warning-subtle">On
                                                Leave</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="assets/images/user-4.png" alt="User"
                                                    class="rounded-circle size-9">
                                                <a href="apps-agents-profile.html"
                                                    class="link link-custom fw-medium">Sneha Patel</a>
                                            </div>
                                        </td>
                                        <td>Marketing Lead</td>
                                        <td>21</td>
                                        <td>₹1.8 Cr</td>
                                        <td><span class="px-2 py-1 border rounded"><i
                                                    class="ri-star-fill me-1 text-warning"></i>4.6</span>
                                        </td>
                                        <td><span
                                                class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center g-3 mt-2">
                            <div class="col-md-5">
                                <p class="text-muted text-center text-md-start mb-0"
                                    id="paginationInfo">Showing <b class="me-1">1-4</b> of <b
                                        class="ms-1">13</b> Results</p>
                            </div>
                            <div class="col-md-7">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center justify-content-md-end mb-0"
                                        id="pagination">
                                        <li class="page-item disabled"><a class="page-link" href="#!"><i
                                                    data-lucide="chevron-left" class="size-4"></i>
                                                Previous</a></li>
                                        <li class="page-item active"><a class="page-link"
                                                href="#!">1</a></li>
                                        <li class="page-item "><a class="page-link" href="#!">2</a></li>
                                        <li class="page-item "><a class="page-link" href="#!">Next <i
                                                    data-lucide="chevron-right" class="size-4"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-h-100">
                    <div class="card-header d-flex flex-wrap gap-3 align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Top Performing Agent</h6>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <button href="#!"
                                class="btn btn-outline-light btn-icon rounded-circle size-9"><i
                                    data-lucide="message-square-more" class="size-4"></i></button>
                            <button href="#!"
                                class="btn btn-outline-light btn-icon rounded-circle size-9"><i
                                    data-lucide="phone-outgoing" class="size-4"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="position-relative d-inline-block mx-auto profile-avatar">
                                <div class="profile-avatar-wrapper">
                                    <img src="assets/images/user-48.png" loading="lazy" alt="user-45"
                                        class="mx-auto profile-avatar-img size-32">
                                </div>
                                <a href="#!"
                                    class="avatar bg-indigo bg-opacity-25 backdrop-blur-md size-8 rounded-circle position-absolute top-0 end-0 text-body"><i
                                        data-lucide="arrow-up-right" class="size-4"></i></a>
                            </div>
                            <div class="mt-4">
                                <h5 class="mb-1 fs-16"><a href="apps-agents-profile.html"
                                        class="text-reset">Alexis Clarke</a></h5>
                                <a href="#!" class="link link-custom-primary">alexisclarke@gmail.com</a>
                            </div>
                        </div>
                        <div class="row text-center mt-6 g-2">
                            <div class="col-4">
                                <h6 class="mb-1">12</h6>
                                <p class="fs-sm text-muted">Properties</p>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-1">5</h6>
                                <p class="fs-sm text-muted">Visits</p>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-1">3</h6>
                                <p class="fs-sm text-muted">Deal Close</p>
                            </div>
                        </div>
                        <div
                            class="position-relative mt-6 p-md-4 p-3 bg-black bg-opacity-25 overflow-hidden goal-achieved-poster rounded">
                            <div class="position-relative z-1 text-white">
                                <span>78% of monthly goal achieved </span>
                                <img src="assets/images/fire-crackers.png" alt="Fire Cracker"
                                    class="img-fluid h-16 d-none d-md-block position-absolute top-50 translate-middle-y fire-cracker">
                            </div>
                            <div class="position-absolute top-0 start-0 h-100 w-100 bg-dark bg-overlay">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xxl-4">
        <div class="card card-h-100">
            <div class="card-header d-flex align-items-center flex-wrap gap-2">
                <h5 class="card-title mb-0 flex-grow-1">Smart Quick Actions</h5>
                <div class="dropdown flex-shrink-0">
                    <a href="#!" class="link link-custom-primary" id="onBoardingCapaignDropdown"
                        aria-label="dropdown link" data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-lucide="ellipsis-vertical" class="size-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="onBoardingCapaignDropdown">
                        <li><a class="dropdown-item" href="#!">Weekly</a></li>
                        <li><a class="dropdown-item" href="#!">Monthly</a></li>
                        <li><a class="dropdown-item" href="#!">Yearly</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="bg-light p-5 rounded mb-5">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-2">Total Commission Earned</p>
                            <h4 class="font-monospace mb-0">$<span class="counter" data-start="0"
                                    data-end="12480.25" data-duration="1000"></span></h4>
                        </div>
                        <div class="dropdown flex-shrink-0">
                            <a href="#!"
                                class="link link-custom-primary badge bg-body-secondary d-flex align-items-center fs-13 py-2 px-3 dropdown-toggle"
                                aria-label="Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Weekly
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#!">Weekly</a>
                                <a class="dropdown-item" href="#!">Monthly</a>
                                <a class="dropdown-item" href="#!">Yearly</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Monthly Target</span>
                        <h6 class="fw-medium mb-0">$15,000</h6>
                    </div>
                    <div class="progress progress-2" role="progressbar" aria-label="New York agents"
                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 60%"></div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-3 align-items-center mb-5">
                    <img src="assets/images/user-48.png" class="rounded-2 size-11" alt="Agent">
                    <div>
                        <h6 class="mb-1">Alexis Clarke</h6>
                        <p class="text-muted">Top Performing Agent</p>
                    </div>
                    <div class="ms-auto text-end">
                        <h6 class="mb-1">12% Gain</h6>
                        <span class="text-muted">vs last month</span>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <button type="button"
                            class="btn w-100 p-4 btn-outline-light border text-reset rounded-3">
                            <i class="ri-building-4-line fs-4"></i>
                            <p class="fw-medium mt-1">Add Property</p>
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="button"
                            class="btn w-100 p-4 btn-outline-light border text-reset rounded-3">
                            <i class="ri-user-add-line fs-4"></i>
                            <p class="fw-medium mt-1">Add Client</p>
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button type="button"
                            class="btn w-100 p-4 btn-outline-light border text-reset rounded-3">
                            <i class="ri-calendar-event-line fs-4"></i>
                            <p class="fw-medium mt-1">Schedule</p>
                        </button>
                    </div>
                    <p class="text-muted mt-3 text-center">Steady growth across all regions this month.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xxl-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body py-7">
                        <div class="row g-10 g-md-4">
                            <div class="col-md-4 col-sm-6 border-end-md-0">
                                <div class="text-center">
                                    <h5 class="fw-medium mb-3 font-monospace"><span class="counter"
                                            data-start="0" data-end="1248"
                                            data-duration="1000"></span><i data-lucide="trending-up"
                                            class="size-4 ms-1 text-success"></i></h5>
                                    <p class="text-muted">Total Properties</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 border-end-md-0">
                                <div class="text-center">
                                    <h5 class="fw-medium mb-3 font-monospace"><span class="counter"
                                            data-start="0" data-end="526" data-duration="1000"></span><i
                                            data-lucide="trending-up"
                                            class="size-4 ms-1 text-success"></i></h5>
                                    <p class="text-muted">New Clients</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="text-center">
                                    <h5 class="fw-medium mb-3 font-monospace">$<span class="counter"
                                            data-start="0" data-end="48320"
                                            data-duration="1000"></span><i data-lucide="trending-down"
                                            class="size-4 ms-1 text-danger"></i></h5>
                                    <p class="text-muted">Total Revenue</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-muted mb-1">Total Income by</p>
                        <h5 class="card-title mb-6">Sales and Rent Insights</h5>
                        <div
                            class="size-36 bg-primary font-monospace rounded-circle mx-auto avatar text-white circular-progress flex-column">
                            <h4 class="fw-medium mb-2"><span class="counter" data-start="0"
                                    data-end="74" data-duration="1000"></span>%</h4>
                            <p>$2,485.36</p>
                            <img src="assets/images/circular.png" alt=""
                                class="img-fluid position-absolute p-1">
                        </div>
                        <p class="text-muted mt-7">Revenue growth driven by steady property sales.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-h-100">
                    <div class="card-body p-0">
                        <div class="text-center p-4 pb-1">
                            <div class="avatar ms-auto size-7 border rounded text-indigo">
                                <i class="ri-bar-chart-fill"></i>
                            </div>
                            <p class="text-muted mb-2">New Leads Today</p>
                            <h4 class="font-monospace mb-3"><span class="counter" data-start="0"
                                    data-end="4485" data-duration="1000"></span></h4>
                            <span
                                class="badge bg-success-subtle text-success border border-success-subtle">+2.6%</span>
                        </div>
                        <div id="activityChart" dir="ltr"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xxl-5">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center gap-3">
                <h5 class="card-title mb-0 flex-grow-1">Recent Purchase List</h5>
                <div class="d-flex gap-3 align-items-center">
                    <a href="#!" class="flex-shrink-0 link link-custom-primary">View All</a>
                    <div class="dropdown flex-shrink-0">
                        <a href="#!"
                            class="link link-custom-primary badge border d-flex align-items-center fs-12 py-1.5 px-3 dropdown-toggle"
                            aria-label="Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Weekly
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#!">Weekly</a>
                            <a class="dropdown-item" href="#!">Monthly</a>
                            <a class="dropdown-item" href="#!">Yearly</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-5 mb-6">
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-4 align-items-center">
                            <div>
                                <p class="text-muted mb-1">This week:</p>
                                <h6 class="mb-0 fs-16">₹1.8k revenue</h6>
                            </div>
                            <div id="purchaseChart1"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-4 align-items-center">
                            <div>
                                <p class="text-muted mb-1">Prev week:</p>
                                <h6 class="mb-0 fs-16">₹1.2k revenue</h6>
                            </div>
                            <div id="purchaseChart2"></div>
                        </div>
                    </div>
                </div>
                <div class="table-card table-responsive">
                    <table class="table table-borderless align-middle text-nowrap mb-0">
                        <thead class="bg-light">
                            <tr class="border-bottom">
                                <th class="fw-medium text-muted">Buyer</th>
                                <th class="fw-medium text-muted">Property</th>
                                <th class="fw-medium text-muted">Amount</th>
                                <th class="fw-medium text-muted">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="assets/images/user-1.png" alt="Buyer"
                                            class="rounded-circle h-9 w-9">
                                        <a href="apps-customer-details.html"
                                            class="link link-custom fw-medium">Sophia Carter</a>
                                    </div>
                                </td>
                                <td>
                                    <a href="apps-property-details.html"
                                        class="link link-custom fw-medium">Seaside Harmony Villa</a>
                                </td>
                                <td>$890k</td>
                                <td><span
                                        class="badge bg-success-subtle text-success border border-success-subtle">Completed</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="assets/images/user-2.png" alt="Buyer"
                                            class="rounded-circle h-9 w-9">
                                        <a href="apps-customer-details.html"
                                            class="link link-custom fw-medium">David Moore</a>
                                    </div>
                                </td>
                                <td>
                                    <a href="apps-property-details.html"
                                        class="link link-custom fw-medium">Hillside Garden Estate</a>
                                </td>
                                <td>$645k</td>
                                <td><span
                                        class="badge bg-info-subtle text-info border border-info-subtle">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="assets/images/user-3.png" alt="Buyer"
                                            class="rounded-circle h-9 w-9">
                                        <a href="apps-customer-details.html"
                                            class="link link-custom fw-medium">Alex White</a>
                                    </div>
                                </td>
                                <td>
                                    <a href="apps-property-details.html"
                                        class="link link-custom fw-medium">Greenwoods Apartment</a>
                                </td>
                                <td>$720k</td>
                                <td><span
                                        class="badge bg-warning-subtle text-warning border border-warning-subtle">Pending</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center g-3 mt-1">
                    <div class="col-md-5">
                        <p class="text-muted text-center text-md-start mb-0" id="paginationInfo">Showing
                            <b class="me-1">1-3</b> of <b class="ms-1">13</b> Results
                        </p>
                    </div>
                    <div class="col-md-7">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center justify-content-md-end mb-0"
                                id="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#!"><i
                                            data-lucide="chevron-left" class="size-4"></i> Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#!">1</a></li>
                                <li class="page-item "><a class="page-link" href="#!">2</a></li>
                                <li class="page-item "><a class="page-link" href="#!">Next <i
                                            data-lucide="chevron-right" class="size-4"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-xxl-3">
        <div class="card">
            <div class="card-header d-flex align-items-center flex-wrap gap-2">
                <h5 class="card-title mb-0 flex-grow-1">Upcoming Events</h5>
                <div class="dropdown flex-shrink-0">
                    <a href="#!" class="link link-custom-primary" id="onBoardingCapaignDropdown"
                        aria-label="dropdown link" data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-lucide="ellipsis" class="size-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="onBoardingCapaignDropdown">
                        <li><a class="dropdown-item" href="#!">Weekly</a></li>
                        <li><a class="dropdown-item" href="#!">Monthly</a></li>
                        <li><a class="dropdown-item" href="#!">Yearly</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div dir="ltr" class="swiper upcomingSwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div
                                class="position-relative overflow-hidden bg-dark-subtle rounded-3 p-6 h-52 avatar">
                                <img src="assets/images/event-1.png" alt="Upcoming Event"
                                    class="img-fluid h-48 object-fit-cover">
                            </div>
                            <div class="mt-5">
                                <div class="d-flex gap-3 align-items-start mb-1">
                                    <div class="flex-grow-1 text-truncate">
                                        <h6 class="mb-0 fs-16"><a href="#!"
                                                class="text-reset d-inline-block w-100 text-truncate">Luxury
                                                Property Expo 2025</a></h6>
                                        <p class="text-muted text-truncate w-100">Discover exclusive
                                            luxury property.</p>
                                    </div>
                                    <div
                                        class="text-center flex-shrink-0 text-muted float-end w-16 border rounded p-2 shadow">
                                        <h5 class="mb-1">15</h5>
                                        <span>Nov</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-time-line text-muted"></i>
                                    <span>10:00 AM</span> •
                                    <i class="ri-map-pin-line text-muted"></i>
                                    <span>Mumbai</span>
                                </div>
                                <div class="mt-4 d-flex align-items-center justify-content-between">
                                    <div class="avatar-group">
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="Sophia Carter">
                                            <img src="assets/images/user-3.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="David Moore">
                                            <img src="assets/images/user-8.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="Alex White">
                                            <img src="assets/images/user-10.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="More 3+">
                                            <div class="avatar bg-body-tertiary size-8 fs-11 text-body">
                                                +3</div>
                                        </a>
                                    </div>
                                    <a href="#!" class="btn btn-primary">Join Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="position-relative overflow-hidden bg-secondary-subtle rounded-3 p-6 h-52 avatar">
                                <img src="assets/images/event-2.png" alt="Upcoming Event"
                                    class="img-fluid h-48 object-fit-cover">
                            </div>
                            <div class="mt-5">
                                <div class="d-flex gap-3 align-items-start mb-1">
                                    <div class="flex-grow-1 text-truncate">
                                        <h6 class="mb-0 fs-16"><a href="#!"
                                                class="text-reset d-inline-block w-100 text-truncate">Smart
                                                Realty Tech Conference</a></h6>
                                        <p class="text-muted text-truncate w-100">Explore innovation
                                            shaping real estate.</p>
                                    </div>
                                    <div
                                        class="text-center flex-shrink-0 text-muted float-end w-16 border rounded p-2 shadow">
                                        <h5 class="mb-1">12</h5>
                                        <span>Dec</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-time-line text-muted"></i>
                                    <span>09:00 AM</span> •
                                    <i class="ri-map-pin-line text-muted"></i>
                                    <span>Delhi</span>
                                </div>
                                <div class="mt-4 d-flex align-items-center justify-content-between">
                                    <div class="avatar-group">
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="Ethan Harris">
                                            <img src="assets/images/user-2.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="Emma Wilson">
                                            <img src="assets/images/user-5.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="Lucas Martin">
                                            <img src="assets/images/user-9.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="More 4+">
                                            <div class="avatar bg-body-tertiary size-8 fs-11 text-body">
                                                +4</div>
                                        </a>
                                    </div>
                                    <a href="#!" class="btn btn-primary">Join Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="position-relative overflow-hidden bg-warning-subtle rounded-3 p-6 h-52 avatar">
                                <img src="assets/images/event-3.png" alt="Upcoming Event"
                                    class="img-fluid h-48 object-fit-cover">
                            </div>
                            <div class="mt-5">
                                <div class="d-flex gap-3 align-items-start mb-1">
                                    <div class="flex-grow-1 text-truncate">
                                        <h6 class="mb-0 fs-16"><a href="#!"
                                                class="text-reset d-inline-block w-100 text-truncate">Elite
                                                Brokers Networking Night</a></h6>
                                        <p class="text-muted text-truncate w-100">Meet top agents and
                                            investors.</p>
                                    </div>
                                    <div
                                        class="text-center flex-shrink-0 text-muted float-end w-16 border rounded p-2 shadow">
                                        <h5 class="mb-1">20</h5>
                                        <span>Dec</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-time-line text-muted"></i>
                                    <span>07:00 PM</span> •
                                    <i class="ri-map-pin-line text-muted"></i>
                                    <span>Pune</span>
                                </div>
                                <div class="mt-4 d-flex align-items-center justify-content-between">
                                    <div class="avatar-group">
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="Sophia Brown">
                                            <img src="assets/images/user-44.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="James Patel">
                                            <img src="assets/images/user-7.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="Ava Johnson">
                                            <img src="assets/images/user-13.png" loading="lazy" alt=""
                                                class="size-8 rounded-circle">
                                        </a>
                                        <a href="#!" class="avatar-group-item" data-bs-toggle="tooltip"
                                            data-bs-title="More 6+">
                                            <div class="avatar bg-body-tertiary size-8 fs-11 text-body">
                                                +6</div>
                                        </a>
                                    </div>
                                    <a href="#!" class="btn btn-primary">Join Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-7">
        <div class="position-relative">
            <h6 class="card-title position-absolute top-0 start-0 mb-5 mt-2">Property List</h6>
            <div class="swiper propertySwiper property-navigation">
                <div class="swiper-wrapper pt-14">
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body p-4 property-card">
                                <div class="position-relative propery-wrapper overflow-hidden">
                                    <img src="assets/images/property-3.jpg" alt="Property 3"
                                        class="card-img-top rounded object-fit-cover img-1">
                                    <img src="assets/images/property-4.jpg" alt="Property 4"
                                        class="card-img-top rounded object-fit-cover img-2">
                                    <span
                                        class="px-3 py-1 fs-11 text-white bg-danger bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">For
                                        Rent</span>
                                    <div
                                        class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                        <a href="#!"
                                            class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i
                                                data-lucide="bookmark" class="size-4"></i></a>
                                        <a href="#!"
                                            class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i
                                                data-lucide="heart" class="size-4"></i></a>
                                    </div>
                                </div>
                                <div class="my-4 pb-4 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fs-17 fw-normal text-primary">$1,250 / month
                                        </h6>
                                        <p class="text-muted small d-flex align-items-center gap-1"><i
                                                data-lucide="star" class="size-3 text-warning"></i>4.6
                                        </p>
                                    </div>
                                    <a href="apps-property-details.html"
                                        class="mb-2 fs-16 text-body fw-semibold d-block">Sunset Studio
                                        Apartment</a>
                                    <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-sm"><i
                                            data-lucide="map-pin" class="size-3"></i>3811 Ditmars Blvd,
                                        Astoria, NY</p>
                                </div>
                                <div class="d-flex justify-content-between text-muted fs-sm pb-1">
                                    <span><i data-lucide="bed-single" class="me-1 size-3"></i>2
                                        Beds</span>
                                    <span><i data-lucide="soap-dispenser-droplet"
                                            class="me-1 size-3"></i>1 Bath</span>
                                    <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>850
                                        sqft</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body p-4 property-card">
                                <div class="position-relative propery-wrapper overflow-hidden">
                                    <img src="assets/images/property-5.jpg" alt="Property 5"
                                        class="card-img-top rounded object-fit-cover img-1">
                                    <img src="assets/images/property-6.jpg" alt="Property 6"
                                        class="card-img-top rounded object-fit-cover img-2">
                                    <span
                                        class="px-3 py-1 fs-11 text-white bg-secondary bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">Sold</span>
                                    <div
                                        class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                        <a href="#!"
                                            class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i
                                                data-lucide="bookmark" class="size-4"></i></a>
                                        <a href="#!"
                                            class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i
                                                data-lucide="heart" class="size-4"></i></a>
                                    </div>
                                </div>
                                <div class="my-4 pb-4 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fs-17 fw-normal text-primary">$490,000</h6>
                                        <p class="text-muted small d-flex align-items-center gap-1"><i
                                                data-lucide="star" class="size-3 text-warning"></i>4.9
                                        </p>
                                    </div>
                                    <a href="apps-property-details.html"
                                        class="mb-2 fs-16 text-body fw-semibold d-block">Oakwood Family
                                        Home</a>
                                    <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-sm"><i
                                            data-lucide="map-pin" class="size-3"></i>221 Main St,
                                        Queens, NY</p>
                                </div>
                                <div class="d-flex justify-content-between text-muted fs-sm pb-1">
                                    <span><i data-lucide="bed-single" class="me-1 size-3"></i>4
                                        Beds</span>
                                    <span><i data-lucide="soap-dispenser-droplet"
                                            class="me-1 size-3"></i>3 Baths</span>
                                    <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>1450
                                        sqft</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body p-4 property-card">
                                <div class="position-relative propery-wrapper overflow-hidden">
                                    <img src="assets/images/property-17.jpg" alt="Property 17"
                                        class="card-img-top rounded object-fit-cover img-1">
                                    <img src="assets/images/property-2.jpg" alt="Property 18"
                                        class="card-img-top rounded object-fit-cover img-2">
                                    <span
                                        class="px-3 py-1 fs-11 text-white bg-danger bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">For
                                        Rent</span>
                                    <div
                                        class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                        <a href="#!"
                                            class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i
                                                data-lucide="bookmark" class="size-4"></i></a>
                                        <a href="#!"
                                            class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle like-btn"><i
                                                data-lucide="heart" class="size-4"></i></a>
                                    </div>
                                </div>
                                <div class="my-4 pb-4 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fs-17 fw-normal text-primary">$530,000</h6>
                                        <p class="text-muted small d-flex align-items-center gap-1"><i
                                                data-lucide="star" class="size-3 text-warning"></i>5.0
                                        </p>
                                    </div>
                                    <a href="apps-property-details.html"
                                        class="mb-2 fs-16 text-body fw-semibold d-block">Hillside
                                        Premium House</a>
                                    <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-sm"><i
                                            data-lucide="map-pin" class="size-3"></i>99 Sunset Blvd, LA,
                                        CA</p>
                                </div>
                                <div class="d-flex justify-content-between text-muted fs-sm pb-1">
                                    <span><i data-lucide="bed-single" class="me-1 size-3"></i>4
                                        Beds</span>
                                    <span><i data-lucide="soap-dispenser-droplet"
                                            class="me-1 size-3"></i>3 Baths</span>
                                    <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>1550
                                        sqft</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <div class="card-body p-4 property-card">
                                <div class="position-relative propery-wrapper overflow-hidden">
                                    <img src="assets/images/property-7.jpg" alt="Property 7"
                                        class="card-img-top rounded object-fit-cover img-1">
                                    <img src="assets/images/property-8.jpg" alt="Property 8"
                                        class="card-img-top rounded object-fit-cover img-2">
                                    <span
                                        class="px-3 py-1 fs-11 text-white bg-success bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">For
                                        Sale</span>
                                    <div
                                        class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                        <a href="#!"
                                            class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i
                                                data-lucide="bookmark" class="size-4"></i></a>
                                        <a href="#!"
                                            class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle like-btn"><i
                                                data-lucide="heart" class="size-4"></i></a>
                                    </div>
                                </div>
                                <div class="my-4 pb-4 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fs-17 fw-normal text-primary">$420,000</h6>
                                        <p class="text-muted small d-flex align-items-center gap-1"><i
                                                data-lucide="star" class="size-3 text-warning"></i>4.7
                                        </p>
                                    </div>
                                    <a href="apps-property-details.html"
                                        class="mb-2 fs-16 text-body fw-semibold d-block">Lakeview Modern
                                        Villa</a>
                                    <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-sm"><i
                                            data-lucide="map-pin" class="size-3"></i>112 Lake St,
                                        Seattle, WA</p>
                                </div>
                                <div class="d-flex justify-content-between text-muted fs-sm pb-1">
                                    <span><i data-lucide="bed-single" class="me-1 size-3"></i>3
                                        Beds</span>
                                    <span><i data-lucide="soap-dispenser-droplet"
                                            class="me-1 size-3"></i>2 Baths</span>
                                    <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>1050
                                        sqft</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-buttons position-absolute end-0">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Sold Properties</h5>
                <a href="#!" class="flex-shrink-0 link link-custom-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-card table-responsive">
                    <table class="table table-borderless align-middle text-nowrap mb-0">
                        <thead class="bg-light">
                            <tr class="border-bottom border-top">
                                <th class="fw-medium text-muted">Property</th>
                                <th class="fw-medium text-muted">Sold Price</th>
                                <th class="fw-medium text-muted">Sold Date</th>
                                <th class="fw-medium text-muted">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="assets/images/property-19.jpg" alt="Property"
                                            class="rounded-2 h-9 w-12">
                                        <a href="apps-property-details.html"
                                            class="link link-custom fw-medium">Ocean Crest Apartment</a>
                                    </div>
                                </td>
                                <td>$589k</td>
                                <td>15 Oct 2025</td>
                                <td><span
                                        class="badge bg-success-subtle text-success border border-success-subtle">Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="assets/images/property-5.jpg" alt="Property"
                                            class="rounded-2 h-9 w-12">
                                        <a href="apps-property-details.html"
                                            class="link link-custom fw-medium">Horizon Elite Towers</a>
                                    </div>
                                </td>
                                <td>$742k</td>
                                <td>10 Oct 2025</td>
                                <td><span
                                        class="badge bg-warning-subtle text-warning border border-warning-subtle">Pending</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="assets/images/property-7.jpg" alt="Property"
                                            class="rounded-2 h-9 w-12">
                                        <a href="apps-property-details.html"
                                            class="link link-custom fw-medium">Greenwoods Villa</a>
                                    </div>
                                </td>
                                <td>$1.02M</td>
                                <td>03 Oct 2025</td>
                                <td><span
                                        class="badge bg-success-subtle text-success border border-success-subtle">Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="assets/images/property-9.jpg" alt="Property"
                                            class="rounded-2 h-9 w-12">
                                        <a href="apps-property-details.html"
                                            class="link link-custom fw-medium">Crystal Heights
                                            Residency</a>
                                    </div>
                                </td>
                                <td>$865k</td>
                                <td>26 Sep 2025</td>
                                <td><span
                                        class="badge bg-info-subtle text-info border border-info-subtle">Processing</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center g-3 mt-0">
                    <div class="col-md-5">
                        <p class="text-muted text-center text-md-start mb-0" id="paginationInfo">Showing
                            <b class="me-1">1-4</b> of <b class="ms-1">13</b> Results
                        </p>
                    </div>
                    <div class="col-md-7">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center justify-content-md-end mb-0"
                                id="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#!"><i
                                            data-lucide="chevron-left" class="size-4"></i> Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#!">1</a></li>
                                <li class="page-item "><a class="page-link" href="#!">2</a></li>
                                <li class="page-item "><a class="page-link" href="#!">Next <i
                                            data-lucide="chevron-right" class="size-4"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection