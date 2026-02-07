@extends('layouts.app')
@section('title', 'Land Properties')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">List View</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Property</a></li>
        <li class="breadcrumb-item active">List View</li>
    </ul>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
                <h6 class="card-title mb-0">Property List</h6>
                <button type="button" class="btn btn-primary d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#addPropertyModal" id="addPropertyBtn"><i
                        data-lucide="plus" class="size-4"></i>Add Property</button>
            </div>
            <div class="card-body">
                <div class="table-card table-responsive">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr class="bg-light border-bottom">
                                <th>
                                    <div class="form-check check-primary">
                                        <input class="form-check-input" type="checkbox"
                                            aria-label="checkbox" id="checAllData">
                                        <label class="form-check-label d-none" for="checAllData">Check
                                            All Data</label>
                                    </div>
                                </th>
                                <th class="fw-medium text-muted sortable" data-column="id">ID</th>
                                <th class="fw-medium text-muted sortable" data-column="title">Title</th>
                                <th class="fw-medium text-muted sortable" data-column="location">
                                    Location</th>
                                <th class="fw-medium text-muted sortable" data-column="type">Type</th>
                                <th class="fw-medium text-muted sortable" data-column="price">Price</th>
                                <th class="fw-medium text-muted sortable" data-column="area">Area (sqft)
                                </th>
                                <th class="fw-medium text-muted sortable" data-column="status">Status
                                </th>
                                <th class="fw-medium text-muted sortable" data-column="agent">Agent</th>
                                <th class="fw-medium text-muted sortable" data-column="dateListed">Date
                                    Listed</th>
                                <th class="fw-medium text-muted">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>
                                <div class="form-check check-primary">
                                    <input class="form-check-input" type="checkbox" aria-label="checkbox">
                                    <label class="form-check-label d-none">Check All Data</label>
                                </div>
                            </td>
                            <td>P011</td>
                            <td>
                                <a href="apps-property-details.html" class="text-reset">title</a>
                            </td>
                            <td>location</td>
                            <td>type</td>
                            <td>price</td>
                            <td>area</td>
                            <td>
                                <span class="badge bg-success">
                                    For Sale
                                </span>
                            </td>
                            <td>agent</td>
                            <td>Feb 20, 2023</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <button class="btn btn-sub-primary size-8 btn-icon edit-btn" aria-label="edit-button" data-id="#addPropertyModal">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <button class="btn btn-sub-danger size-8 btn-icon delete-btn" aria-label="delete-button" data-id="#deleteModal">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center g-3 mt-2">
                    <div class="col-md-6">
                        <p class="text-muted text-center text-md-start mb-0" id="paginationInfo">
                            Showing <b class="me-1">1-0</b> of <b class="ms-1">0</b> Results
                        </p>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center justify-content-md-end mb-0"
                                id="pagination">
                                <!-- Pagination will be dynamically added here -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Property Modal -->
<div class="modal fade" id="addPropertyModal" tabindex="-1" aria-labelledby="addPropertyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="addPropertyModalLabel">Add New Property</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="propertyForm">
                    <input type="hidden" id="propertyId" value="">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="propertyTitle" class="form-label">Property Title</label>
                            <input type="text" id="propertyTitle" placeholder="Enter property title"
                                class="form-control" required />
                        </div>
                        <div class="col-12 mb-4">
                            <label for="propertyType" class="form-label">Property Type</label>
                            <div id="propertyType" required></div>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="propertyLocation" class="form-label">Location</label>
                            <input type="text" id="propertyLocation" placeholder="Enter location"
                                class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="propertyPrice" class="form-label">Price</label>
                            <input type="text" id="propertyPrice" placeholder="$0" class="form-control"
                                required />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="propertyArea" class="form-label">Area (sqft)</label>
                            <input type="number" id="propertyArea" placeholder="Enter area in sqft"
                                class="form-control" required />
                        </div>
                        <div class="col-12 mb-4">
                            <label for="propertyStatus" class="form-label">Status</label>
                            <div id="propertyStatus" required></div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="propertyAgent" class="form-label">Agent</label>
                            <input type="text" id="propertyAgent" placeholder="Enter agent name"
                                class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="propertyDateListed" class="form-label">Date Listed</label>
                            <input type="text" id="propertyDateListed" class="form-control"
                                placeholder="YYYY-MM-DD" required />
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-active-danger" data-bs-dismiss="modal">
                                <i data-lucide="x" class="size-4 me-1"></i>Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="savePropertyBtn">Save
                                Property</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xs">
        <div class="modal-content p-7 text-center">
            <div class="d-flex justify-content-center mb-4">
                <div
                    class="size-14 bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center size-16">
                    <i class="ri-delete-bin-line text-danger fs-2xl"></i>
                </div>
            </div>
            <h5 class="mb-4 lh-base">Are you sure you want to delete this property?</h5>
            <input type="hidden" id="deletePropertyId">
            <div class="d-flex justify-content-center align-items-center gap-2">
                <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                <button class="btn btn-link text-reset" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@endsection