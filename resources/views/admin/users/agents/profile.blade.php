@extends('layouts.app')
@section('title', 'Agents Profile')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">Profile</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Agents</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ul>
</div>
<div class="row">
    <div class="col-lg-7 col-xl-8 col-xxl-9">
        <div class="row">
            <div class="col-xxl-4">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="dropdown flex-shrink-0 float-end">
                            <a href="#!" class="link link-custom-primary" aria-label="dropdown link" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-lucide="ellipsis-vertical" class="size-4"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#!">View</a></li>
                                <li><a class="dropdown-item" href="#!">Edit</a></li>
                                <li><a class="dropdown-item" href="#!">Delete</a></li>
                            </ul>
                        </div>
                        <div class="text-center mb-6">
                            <div class="profile-avatar position-relative d-inline-block mb-4">
                                <img src="{{ asset('dashboard/assets/images/user.jfif') }}" loading="lazy" alt="Samantha Peterson" class="rounded-circle flex-shrink-0 size-16">
                                <div class="status-indicator bg-success rounded-circle size-3"></div>
                            </div>
                            <h5 class="mb-1">{{ $agent->full_name }}</h5>
                            <p class="mb-1 text-muted">Senior Property Agent, {{ $agent->years_experience }} yrs exp.</p>
                            <div class="text-muted">
                                <small class="px-3 border-end">{{ $agent->office_location }}</small>
                                <small class="px-3">Joined in {{ date('Y', strtotime($agent->created_at)) }}</small>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <p class="mb-0 text-muted w-25 min-w-32">Email :</p>
                                <a href="mailto:{{ $agent->email }}" class="mb-0 link link-custom fw-medium ms-auto">{{ $agent->email }}</a>
                            </div>
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <p class="mb-0 text-muted w-25 min-w-32">Phone :</p>
                                <a href="tel:+1{{ $agent->phone }}" class="mb-0 text-reset fw-medium ms-auto"> {{ $agent->phone }}</a>
                            </div>
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <p class="mb-0 text-muted w-25 min-w-32">Agency :</p>
                                <span class="mb-0 fw-medium text-truncate ms-auto">{{ $agent->agency ?? 'Terra Real Estate' }}</span>
                            </div>
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <p class="mb-0 text-muted w-25 min-w-32">Specialization :</p>
                                <span class="mb-0 fw-medium text-truncate ms-auto">{{ $agent->role ?? 'Residential & Commercial' }}</span>
                            </div>
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <p class="mb-0 text-muted w-25 min-w-32">Languages :</p>
                                <span class="mb-0 fw-medium text-truncate ms-auto">{{ $agent->languages ?? 'English, Kinyarwanda' }}</span>
                            </div>
                            <div class="d-flex flex-wrap align-items-center">
                                <p class="mb-0 text-muted w-25 min-w-32">License No :</p>
                                <span class="mb-0 fw-medium text-truncate ms-auto">{{ $agent->license_number ?? 'AB12345XYZ' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Agent About</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-6">
                            {{ $agent->bio ?? ' Agent is an experienced real estate agent at Terra Real Estate Realty, specializing in residential and commercial properties. Together, they provide expert guidance, personalized service, and trusted solutions to help clients find their ideal homes or make smart property investments.' }}
                        </p>
                        <div class="row mb-3">
                            <div class="col-md-4 col-xl-3">
                                <h6 class="mb-0"><i class="ri-checkbox-circle-fill fw-normal me-2 text-primary fs-17 align-middle"></i>Number of Agents :</h6>
                            </div>
                            <div class="col-md-8 col-xl-9">
                                <p class="text-muted">50+ Properties</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 col-xl-3">
                                <h6 class="mb-0"><i class="ri-checkbox-circle-fill fw-normal me-2 text-primary fs-17 align-middle"></i>Office Locations :</h6>
                            </div>
                            <div class="col-md-8 col-xl-9">
                                <p class="text-muted">{{ $agent->office_location ?? 'Kigali, Gasabo, KG 400' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 col-xl-3">
                                <h6 class="mb-0"><i class="ri-checkbox-circle-fill fw-normal me-2 text-primary fs-17 align-middle"></i>Years in Business :</h6>
                            </div>
                            <div class="col-md-8 col-xl-9">
                                <p class="text-muted">{{ $agent->years_experience ?? '18' }} Years of Excellence</p>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <div class="col-md-4 col-xl-3">
                                <h6 class="mb-0"><i class="ri-checkbox-circle-fill fw-normal me-2 text-primary fs-17 align-middle"></i>Core Services :</h6>
                            </div>
                            <div class="col-md-8 col-xl-9">
                                <p class="text-muted">Residential Sales, Commercial Leasing, Property Management</p>
                            </div>
                        </div>
                        <div class="row g-5">
                            <div class="col-md-6 col-xl-4">
                                <div class="card border shadow-none mb-0">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                            <div>
                                                <p class="text-muted mb-3">Total Listing</p>
                                                <h4 class="mb-0">1,520</h4>
                                            </div>
                                            <div class="progress-circle fs-13" data-stroke-width="7" data-value="75" data-size="65" data-color="var(--dx-info)" data-text=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card border shadow-none mb-0">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                            <div>
                                                <p class="text-muted mb-3">Active Listings</p>
                                                <h4 class="mb-0">850</h4>
                                            </div>
                                            <div class="progress-circle fs-13" data-stroke-width="7" data-value="60" data-size="65" data-color="var(--dx-danger)" data-text=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card border shadow-none mb-0">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                            <div>
                                                <p class="text-muted mb-3">Closed Deals</p>
                                                <h4 class="mb-0">670</h4>
                                            </div>
                                            <div class="progress-circle fs-13" data-stroke-width="7" data-value="55" data-size="65" data-color="var(--dx-warning)" data-text=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Performance Overview</h6>
                    </div>
                    <div class="card-body">
                        <div id="performanceChart" dir="ltr"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-4">
                <div class="card card-h-100">
                    <div class="card-header d-flex align-items-center gap-2">
                        <h6 class="card-title flex-grow-1 mb-0">Property Files</h6>
                        <a href="#!" class="link link-custom-primary flex-shrink-0">See All<i class="align-baseline ri-arrow-right-line ms-1"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3 border-dashed">
                            <div class="d-flex flex-wrap align-items-center gap-3 p-3 border rounded">
                                <div class="avatar size-10 bg-success-subtle flex-shrink-0 rounded-2 p-2">
                                    <img src="data:image/png;base64,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" loading="lazy" alt="property-image" class="img-fluid">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><a href="#!" class="link link-custom">LivingRoom-01.jpg</a></h6>
                                    <p class="fs-sm text-muted">14 June, 2024</p>
                                </div>
                                <p class="ms-auto">2.4 MB</p>
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-3 p-3 border rounded">
                                <div class="avatar size-10 bg-info-subtle flex-shrink-0 rounded-2 p-2">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAB2AAAAdgB+lymcgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAANQSURBVHic7drPaxRnHMfx9/PM7uwP1x9ZE2NIRReMFRoEIXiQYoVSLfXSoIJ39WYv9igKPfTW/0BoBUGhtafGgNBecmgOoSCNXhKRaA9rY7Ix5tfuzOw8PSRDNWZDt+7Md5LM6zjL7PP9fpjn2XlmFhKJRCKR2LLU6gPnf/8rN+8WDmutdksUFBaFeZmz5sd+Or5v6e3jK04PveyyVOpbBReAXOQVRmMRuOsZ7/qDEx1lWAmgdO/pkcMdxQdam72i5UWnbHxzevCT4qjq+PFxIZvKj33UvrPLUu/MiM3sWd5ze7VtZb/yjemSrkbA/oV06ooGdV66EinKqHMa6JEuRNCHGihIVyGooKUrkJYEIF2AtC0fQCrsAbpzFifabdIafinXmHH8sIdsSqgBZLXi6qEC2yxFewb6uzP8Nulw53mVSkyCCHUKfJC32Gb9e3ud1vD5Xpubfdu5VMrRZsvPwFArSDXYWmS04svuDN/37eDKwTxFwSBCXwPWE1wRn+6xxaaGaAABySBiEUBAIohYBRCIMgj5ZXgdb/5qXCzlsHXrH9jEOoCArRWfdWa4XMq3/LtjOQUCBljwYM6FuoE9WavlY8QygNWNB/6YcVo+VqwCaNR4xfEZKFcZnt7AAXim8WfrNT74Yrnx+jrnv4/IAph3IW/Bmwu5ZOOBSK+AySoU0st7BMdfbl6q8UCka4Bn4NUa07ji+Pw6WWNoqoYX8S5ZdBGUbDwQagA1f+3rWOJSbyTUAJ4v1vm76tOZXb7hjFPjgVADqBv4bmyOo7tsZj2fR7NubBoPhL4GzHmGoala2MP8bxtiMxSmJADpAqQlAQCzAF6D3+xNTTGrgVGAOccVrkaA4U+tULcBXiwsuY4fj9dVUVFG3dadU9M/ACOeb9LjldfuTNWhbjb/dDCGkXJ+5y0FsP/niS4P/z5wVLiuSFiK8aJSpx72lyY0wLOzB8rp1+o4xnwNPBKuLzyGUZS5ut1b6n3YX5qANf4rDHBwcDzj+Hbrn0ELsrWz+OSLnvjekyeENPWu6cxQ5QxK3QBa/4aiNepKmW8GPi4O/tcTmt0OnwSONXlO1E4C4QSQ3912rTr9asBXKt1sVVHQxrjZYtuwdB2JRCKRSGwQ/wA+a12+/RXJTAAAAABJRU5ErkJggg==" loading="lazy" alt="property-video" class="img-fluid">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><a href="#!" class="link link-custom">PropertyTour.mp4</a></h6>
                                    <p class="fs-sm text-muted">16 June, 2024</p>
                                </div>
                                <p class="ms-auto">120 MB</p>
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-3 p-3 border rounded">
                                <div class="avatar size-10 bg-danger-subtle flex-shrink-0 rounded-2 p-2">
                                    <img src="data:image/png;base64,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" loading="lazy" alt="legal-doc" class="img-fluid">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><a href="#!" class="link link-custom">OwnershipDocument.pdf</a></h6>
                                    <p class="fs-sm text-muted">18 June, 2024</p>
                                </div>
                                <p class="ms-auto">4.5 MB</p>
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-3 p-3 border rounded">
                                <div class="avatar size-10 bg-warning-subtle flex-shrink-0 rounded-2 p-2">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAB2AAAAdgB+lymcgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAANESURBVHic7ZtLaBNRFIa/O5nWakJpfaXWBwU1LkQQxI2gIIqvigtBN4JrwZUbQbAbF+5UBBHdiO5UFF8gIihoRVERtVqQLkRqrH3Z2odNjZ05LtxqZnLndm5a54Nswnn88+fezJnJRBESeXMmh5s6gi9bUCwAVNjcknQ+/Pv7jiv0vx8jnT2rdj84bKTXXwh1ENJ2bgfKvwqkjSv4lwEAn+5DcQTmr+5Q+16vMN4bcIICpP38EpR/hck4+FAI9L7OycVcr8ielOnqgQbgeYeAjOnGZTPYMY9Lb/vk6p5qk2WDDVBsNNkwEoMd9Yy+HJC722tNlQw2QJhnqpkRhj6l+fKuV27typooF2YFmPm2N8lofgbdz/NybefyqKWCDahUxnpc+p99kBvNa6KUmboGABS+OXQ/fSE3m9fplpjaBgCMDzp0tT6RW5ubddKnvgEAP4cV+Wd35ObW/eWmTg8DAIo/FJ8fXZJrmw+VkzZ9DACYGIeuxyfl+qZjYVMq2wCnqvwcrwj51pawJlS2AZkFenl+EbqetsjtbWuDQl29DjFRnwPfg5FO8H6Vl+t7MNp3GVhaKqyyDVAOzF3556WDm8nCq5Ihlb0FoiLFmqCQ6W1ACBIDbAuwTWKAbQG2SQywLcA22oOQ73v0fGyjMNyPiGgL+D78UzsXFDXVDisaq3FTep+l9goY+dbF2FBfpIOPjjBe9Pg6OKFdQduAlGv09nwkqlz9nay9BTL185lYlKMwPBBpFRQKPdq5AJmZDg11+pc0ES6GFHXZJuqyTfolgMaaEr8NxsB/fxZIDLAtwDaJAbYF2CaZBHVbJ5NgMgkmk2AyCU4HEgNsC7BNYoBtAbaJdRJ03CrmLFxG7dzFum2NE+sk6E/8or/zA+J7um2NE/sk6KRccCpn58U6CTquS322qaIePrU+CdqmctaiJRIDbAuwTWKAbQG2SQywLcA2iQGBEYLN276TTpg/TfXFoGNycNxiYEhgEVF271pGwZ3VHhQSYgX4p4ARE3pixUkJVekDgWFBAWrVwc84shf4YURYHKiUkG44qtafKP2oOCHPAmrlwXs4shrkAqg84EcWaRoFpGZ41MzuINO4UW04fTxM2m9+4hqehcgNDwAAAABJRU5ErkJggg==" loading="lazy" alt="floor-plan" class="img-fluid">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><a href="#!" class="link link-custom">FloorPlan.pdf</a></h6>
                                    <p class="fs-sm text-muted">17 June, 2024</p>
                                </div>
                                <p class="ms-auto">3.2 MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Client Feedback</h6>
                    </div>
                    <div class="card-body">
                        <div data-simplebar style="max-height: 330px;" class="px-5 mx-n5">
                            <div class="border-start border-2 border-primary-subtle ps-3 mb-3">
                                <p class="mb-1 fst-italic">"Sophia made our home-buying process so smooth!"</p>
                                <small class="text-muted">— Olivia Brown</small>
                            </div>
                            <div class="border-start border-2 border-warning-subtle ps-3 mb-3">
                                <p class="mb-1 fst-italic">"Excellent communication and great negotiation skills."</p>
                                <small class="text-muted">— Daniel White</small>
                            </div>
                            <div class="border-start border-2 border-danger-subtle ps-3 mb-3">
                                <p class="mb-1 fst-italic">"Highly recommend for first-time buyers!"</p>
                                <small class="text-muted">— Emma Davis</small>
                            </div>
                            <div class="border-start border-2 border-success-subtle ps-3 mb-3">
                                <p class="mb-1 fst-italic">"Professional, knowledgeable, and very responsive."</p>
                                <small class="text-muted">— Michael Johnson</small>
                            </div>
                            <div class="border-start border-2 border-info-subtle ps-3 mb-3">
                                <p class="mb-1 fst-italic">"Helped us find the perfect property within our budget."</p>
                                <small class="text-muted">— Sarah Lee</small>
                            </div>
                            <div class="border-start border-2 border-orange-subtle ps-3">
                                <p class="mb-1 fst-italic">"Outstanding service and attention to detail throughout the process."</p>
                                <small class="text-muted">— David Martinez</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8">
                <div class="d-flex align-items-center gap-2 mb-5">
                    <h6 class="card-title flex-grow-1 mb-0">Active Listings</h6>
                    <a href="#!" class="link link-custom-primary flex-shrink-0">See All<i class="align-baseline ri-arrow-right-line ms-1"></i></a>
                </div>
                <div class="swiper activeListings swiper-navigation-hover">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card">
                                <div class="card-body p-4 property-card">
                                    <div class="position-relative propery-wrapper overflow-hidden">
                                        <img src="assets/images/property-3.jpg" alt="Property 3" class="card-img-top rounded object-fit-cover img-1">
                                        <img src="assets/images/property-4.jpg" alt="Property 4" class="card-img-top rounded object-fit-cover img-2">
                                        <span class="px-3 py-1 fs-11 text-white bg-danger bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">For Rent</span>
                                        <div class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                            <a href="#!" class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i data-lucide="bookmark" class="size-4"></i></a>
                                            <a href="#!" class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i data-lucide="heart" class="size-4"></i></a>
                                        </div>
                                    </div>
                                    <div class="my-4 pb-4 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-primary">$1,250 / month</h6>
                                            <p class="mb-0 text-muted small d-flex align-items-center gap-1"><i data-lucide="star" class="size-3 text-warning"></i>4.6</p>
                                        </div>
                                        <a href="apps-property-details.html" class="mb-1 fs-16 text-body fw-semibold d-block">Sunset Studio Apartment</a>
                                        <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-13"><i data-lucide="map-pin" class="size-3"></i>3811 Ditmars Blvd, Astoria, NY</p>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted fs-13 pb-1">
                                        <span><i data-lucide="bed-single" class="me-1 size-3"></i>2 Beds</span>
                                        <span><i data-lucide="soap-dispenser-droplet" class="me-1 size-3"></i>1 Bath</span>
                                        <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>850 sqft</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card">
                                <div class="card-body p-4 property-card">
                                    <div class="position-relative propery-wrapper overflow-hidden">
                                        <img src="assets/images/property-5.jpg" alt="Property 5" class="card-img-top rounded object-fit-cover img-1">
                                        <img src="assets/images/property-6.jpg" alt="Property 6" class="card-img-top rounded object-fit-cover img-2">
                                        <span class="px-3 py-1 fs-11 text-white bg-secondary bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">Sold</span>
                                        <div class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                            <a href="#!" class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i data-lucide="bookmark" class="size-4"></i></a>
                                            <a href="#!" class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i data-lucide="heart" class="size-4"></i></a>
                                        </div>
                                    </div>
                                    <div class="my-4 pb-4 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-primary">$490,000</h6>
                                            <p class="mb-0 text-muted small d-flex align-items-center gap-1"><i data-lucide="star" class="size-3 text-warning"></i>4.9</p>
                                        </div>
                                        <a href="apps-property-details.html" class="mb-1 fs-16 text-body fw-semibold d-block">Oakwood Family Home</a>
                                        <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-13"><i data-lucide="map-pin" class="size-3"></i>221 Main St, Queens, NY</p>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted fs-13 pb-1">
                                        <span><i data-lucide="bed-single" class="me-1 size-3"></i>4 Beds</span>
                                        <span><i data-lucide="soap-dispenser-droplet" class="me-1 size-3"></i>3 Baths</span>
                                        <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>1450 sqft</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card">
                                <div class="card-body p-4 property-card">
                                    <div class="position-relative propery-wrapper overflow-hidden">
                                        <img src="assets/images/property-17.jpg" alt="Property 17" class="card-img-top rounded object-fit-cover img-1">
                                        <img src="assets/images/property-2.jpg" alt="Property 18" class="card-img-top rounded object-fit-cover img-2">
                                        <span class="px-3 py-1 fs-11 text-white bg-danger bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">For Rent</span>
                                        <div class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                            <a href="#!" class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i data-lucide="bookmark" class="size-4"></i></a>
                                            <a href="#!" class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle like-btn"><i data-lucide="heart" class="size-4"></i></a>
                                        </div>
                                    </div>
                                    <div class="my-4 pb-4 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-primary">$530,000</h6>
                                            <p class="mb-0 text-muted small d-flex align-items-center gap-1"><i data-lucide="star" class="size-3 text-warning"></i>5.0</p>
                                        </div>
                                        <a href="apps-property-details.html" class="mb-1 fs-16 text-body fw-semibold d-block">Hillside Premium House</a>
                                        <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-13"><i data-lucide="map-pin" class="size-3"></i>99 Sunset Blvd, LA, CA</p>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted fs-13 pb-1">
                                        <span><i data-lucide="bed-single" class="me-1 size-3"></i>4 Beds</span>
                                        <span><i data-lucide="soap-dispenser-droplet" class="me-1 size-3"></i>3 Baths</span>
                                        <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>1550 sqft</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card">
                                <div class="card-body p-4 property-card">
                                    <div class="position-relative propery-wrapper overflow-hidden">
                                        <img src="assets/images/property-7.jpg" alt="Property 7" class="card-img-top rounded object-fit-cover img-1">
                                        <img src="assets/images/property-8.jpg" alt="Property 8" class="card-img-top rounded object-fit-cover img-2">
                                        <span class="px-3 py-1 fs-11 text-white bg-success bg-opacity-75 backdrop-blur-md position-absolute top-0 rounded-1 rounded-start-0 start-0 mt-3">For Sale</span>
                                        <div class="position-absolute bottom-0 d-flex flex-column gap-2 m-2 social-btn">
                                            <a href="#!" class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle"><i data-lucide="bookmark" class="size-4"></i></a>
                                            <a href="#!" class="avatar bg-white bg-opacity-25 backdrop-blur-md text-white size-9 rounded-circle like-btn"><i data-lucide="heart" class="size-4"></i></a>
                                        </div>
                                    </div>
                                    <div class="my-4 pb-4 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-primary">$420,000</h6>
                                            <p class="mb-0 text-muted small d-flex align-items-center gap-1"><i data-lucide="star" class="size-3 text-warning"></i>4.7</p>
                                        </div>
                                        <a href="apps-property-details.html" class="mb-1 fs-16 text-body fw-semibold d-block">Lakeview Modern Villa</a>
                                        <p class="text-muted mb-0 d-flex align-items-center gap-1 fs-13"><i data-lucide="map-pin" class="size-3"></i>112 Lake St, Seattle, WA</p>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted fs-13 pb-1">
                                        <span><i data-lucide="bed-single" class="me-1 size-3"></i>3 Beds</span>
                                        <span><i data-lucide="soap-dispenser-droplet" class="me-1 size-3"></i>2 Baths</span>
                                        <span><i data-lucide="squares-subtract" class="me-1 size-3"></i>1050 sqft</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next fs-2xl text-body"></div>
                    <div class="swiper-button-prev fs-2xl text-body"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-xl-4 col-xxl-3">
        <div class="position-sticky top-24 mb-5">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-center">Achievements</h6>
                </div>
                <div class="card-body">
                    <div class="swiper achievementsSwiper swiper-navigation-hover">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="card border shadow-none mb-0 p-3">
                                    <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3">
                                        <div class="avatar mx-auto rounded-circle size-20">
                                            <img src="assets/images/trophy.png" loading="lazy" alt="" class="size-20">
                                        </div>
                                        <div>
                                            <a href="#!" class="text-reset d-block mb-2 fw-medium">Top Seller 2025</a>
                                            <p class="text-muted fs-sm">Achieved the highest in the region with over 150 properties sold.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border shadow-none mb-0 p-3">
                                    <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3">
                                        <div class="avatar mx-auto rounded-circle size-20">
                                            <img src="assets/images/medal.png" loading="lazy" alt="" class="size-20">
                                        </div>
                                        <div>
                                            <a href="#!" class="text-reset d-block mb-2 fw-medium">Customer Choice Award</a>
                                            <p class="text-muted fs-sm">Voted by clients for and outstanding professionalism.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border shadow-none mb-0 p-3">
                                    <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-3">
                                        <div class="avatar mx-auto rounded-circle size-20">
                                            <img src="assets/images/winner.png" loading="lazy" alt="" class="size-20">
                                        </div>
                                        <div>
                                            <a href="#!" class="text-reset d-block mb-2 fw-medium">5-Star Rating</a>
                                            <p class="text-muted fs-sm">Maintained a perfect 5-star from over 200 satisfied clients.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-next fs-2xl text-body"></div>
                        <div class="swiper-button-prev fs-2xl text-body"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <h6 class="card-title flex-grow-1 mb-0">Top Properties</h6>
                    <a href="#!" class="link link-custom-primary flex-shrink-0">See All<i class="align-baseline ri-arrow-right-line ms-1"></i></a>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-5">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <img src="assets/images/property-1.jpg" alt="" class="rounded h-12 object-fit-cover">
                            <div>
                                <a href="apps-property-details.html" class="mb-1 d-block text-reset fw-semibold">Skyline Apartment</a>
                                <span class="text-muted fs-sm">$750,000 • 12 Enquiries</span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted ms-auto fs-sm">3 days ago</p>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-5">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <img src="assets/images/property-2.jpg" alt="" class="rounded h-12 object-fit-cover">
                            <div>
                                <a href="apps-property-details.html" class="mb-1 d-block text-reset fw-semibold">Riverfront Condo</a>
                                <span class="text-muted fs-sm">$620,000 • 8 Enquiries</span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted ms-auto fs-sm">1 week ago</p>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-5">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <img src="assets/images/property-3.jpg" alt="" class="rounded h-12 object-fit-cover">
                            <div>
                                <a href="apps-property-details.html" class="mb-1 d-block text-reset fw-semibold">Downtown Loft</a>
                                <span class="text-muted fs-sm">$890,000 • 20 Enquiries</span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted ms-auto fs-sm">2 days ago</p>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-5">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <img src="assets/images/property-4.jpg" alt="" class="rounded h-12 object-fit-cover">
                            <div>
                                <a href="apps-property-details.html" class="mb-1 d-block text-reset fw-semibold">Sunset Villa</a>
                                <span class="text-muted fs-sm">$1,250,000 • 5 Enquiries</span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted ms-auto fs-sm">5 days ago</p>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap gap-2">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <img src="assets/images/property-6.jpg" alt="" class="rounded h-12 object-fit-cover">
                            <div>
                                <a href="apps-property-details.html" class="mb-1 d-block text-reset fw-semibold">Greenview Residency</a>
                                <span class="text-muted fs-sm">$980,000 • 3 Enquiries</span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted ms-auto fs-sm">2 days ago</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <h6 class="card-title flex-grow-1 mb-0">Upcoming Meetings</h6>
                    <a href="#!" class="link link-custom-primary flex-shrink-0">See All<i class="align-baseline ri-arrow-right-line ms-1"></i></a>
                </div>
                <div class="card-body">
                    <div data-simplebar style="max-height: 380px;" class="mx-n5 px-5">
                        <div class="d-flex gap-3 flex-column">
                            <div class="p-3 border rounded d-flex flex-wrap gap-2 justify-content-between align-items-start">
                                <div class="d-flex flex-wrap align-items-start gap-3">
                                    <div class="avatar rounded text-danger bg-danger-subtle size-10 flex-shrink-0 d-flex align-items-center justify-content-center">
                                        <i data-lucide="shopping-bag" class="size-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">Meeting with John Doe</p>
                                        <span class="text-muted fs-13">10:30 AM, Oct 10</span>
                                    </div>
                                </div>
                                <span class="bg-success-subtle text-success border border-success-subtle badge ms-auto">Confirmed</span>
                            </div>

                            <div class="p-3 border rounded d-flex flex-wrap gap-2 justify-content-between align-items-start">
                                <div class="d-flex flex-wrap align-items-start gap-3">
                                    <div class="avatar rounded text-primary bg-primary-subtle size-10 flex-shrink-0 d-flex align-items-center justify-content-center">
                                        <i data-lucide="users" class="size-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">Team Standup</p>
                                        <span class="text-muted fs-13">09:00 AM, Oct 11</span>
                                    </div>
                                </div>
                                <span class="bg-warning-subtle text-warning border border-warning-subtle badge ms-auto">Pending</span>
                            </div>

                            <div class="p-3 border rounded d-flex flex-wrap gap-2 justify-content-between align-items-start">
                                <div class="d-flex flex-wrap align-items-start gap-3">
                                    <div class="avatar rounded text-info bg-info-subtle size-10 flex-shrink-0 d-flex align-items-center justify-content-center">
                                        <i data-lucide="video" class="size-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">Client Video Call</p>
                                        <span class="text-muted fs-13">02:00 PM, Oct 12</span>
                                    </div>
                                </div>
                                <span class="bg-primary-subtle text-primary border border-primary-subtle badge ms-auto">Scheduled</span>
                            </div>

                            <div class="p-3 border rounded d-flex flex-wrap gap-2 justify-content-between align-items-start">
                                <div class="d-flex flex-wrap align-items-start gap-3">
                                    <div class="avatar rounded text-pink bg-pink-subtle size-10 flex-shrink-0 d-flex align-items-center justify-content-center">
                                        <i data-lucide="calendar" class="size-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">Project Review</p>
                                        <span class="text-muted fs-13">11:30 AM, Oct 13</span>
                                    </div>
                                </div>
                                <span class="bg-danger-subtle text-danger border border-danger-subtle badge ms-auto"> ms-autoCancelled</span>
                            </div>

                            <div class="p-3 border rounded d-flex flex-wrap gap-2 justify-content-between align-items-start">
                                <div class="d-flex flex-wrap align-items-start gap-3">
                                    <div class="avatar rounded text-warning bg-warning-subtle size-10 flex-shrink-0 d-flex align-items-center justify-content-center">
                                        <i data-lucide="check-square" class="size-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">Code Review Session</p>
                                        <span class="text-muted fs-13">01:00 PM, Oct 14</span>
                                    </div>
                                </div>
                                <span class="bg-success-subtle text-success border border-success-subtle badge ms-auto">Confirmed</span>
                            </div>

                            <div class="p-3 border rounded d-flex flex-wrap gap-2 justify-content-between align-items-start">
                                <div class="d-flex flex-wrap align-items-start gap-3">
                                    <div class="avatar rounded text-secondary bg-secondary-subtle size-10 flex-shrink-0 d-flex align-items-center justify-content-center">
                                        <i data-lucide="file-text" class="size-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">Document Verification</p>
                                        <span class="text-muted fs-13">09:15 AM, Oct 15</span>
                                    </div>
                                </div>
                                <span class="bg-warning-subtle text-warning border border-warning-subtle badge ms-auto">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                        <div class="w-100">
                            <a href="#!" class="link link-custom text-center d-block p-3 border rounded-4 bg-body-tertiary bg-opacity-25">
                                <i data-lucide="plus" class="size-4"></i>
                                <span class="d-block mt-3">Add</span>
                            </a>
                        </div>
                        <div class="w-100">
                            <a href="#!" class="link link-custom text-center d-block p-3 border rounded-4 bg-body-tertiary bg-opacity-25">
                                <i data-lucide="edit-3" class="size-4"></i>
                                <span class="d-block mt-3">Edit</span>
                            </a>
                        </div>
                        <div class="w-100">
                            <a href="#!" class="link link-custom text-center d-block p-3 border rounded-4 bg-body-tertiary bg-opacity-25">
                                <i data-lucide="mail" class="size-4"></i>
                                <span class="d-block mt-3">Message</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection