@extends('layouts.app')
@section('title', 'Professionals Lists')
@section('content')

<div class="gap-2 page-heading mb-3 flex-column flex-md-row">
    <h6 class="flex-grow-1 mb-0">List Professionals</h6>
    <ul class="breadcrumb flex-shrink-0 mb-0">
        <li class="breadcrumb-item"><a href="#!">Professionals</a></li>
        <li class="breadcrumb-item active">Lists</li>
    </ul>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex gap-2 flex-wrap justify-content-between align-items-center">
                <div class="d-flex flex-grow-1">
                    <h6 class="card-title mb-0">Professionals List</h6>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addProfessionalModal" id="addProfessionalBtn">
                        <i class="ri-add-line me-1"></i>Add Professional
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-card table-responsive">
                    <table class="table table-borderless align-middle text-nowrap mb-0">
                        <thead>
                            <tr class="bg-light border-bottom">
                                <th class="sortable" data-column="id">ID</th>
                                <th class="sortable" data-column="name">Names</th>
                                <th class="sortable" data-column="professionType">Profession type</th>
                                <th class="sortable" data-column="email">Email</th>
                                <th class="sortable" data-column="phone">Phone</th>
                                <th class="sortable" data-column="status">Status</th>
                                <th class="sortable" data-column="location">Location</th>
                                <th class="sortable" data-column="registrationDate">Registration Date
                                </th>
                                <th class="fw-medium text-muted">Action</th>
                            </tr>
                        </thead>
                        <tbody id="customerTableBody">
                            @foreach ($professionals as $professional)
                            <tr>
                                <td>{{ $professional->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar">
                                            <img src="{{ $professional->profile_image_url }}" loading="lazy" alt="Avatar"
                                                class="rounded-circle w-100 h-100 object-cover">
                                        </div>
                                        <div>
                                            <h6 class="mb-1"><a href="{{ route('admin.professionals.show', $professional->id) }}" class="text-reset">{{ $professional->full_name }}</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $professional->profession }}</td>
                                <td><a href="#!" class="text-reset">{{ $professional->email }}</a></td>
                                <td>{{ $professional->phone }}</td>
                                <td>{{ $professional->is_verified ? 'Verified' : 'Unverified' }}</td>
                                <td>{{ $professional->office_location ?? 'N/A' }}</td>
                                <td>{{ $professional->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('admin.professionals.show', $professional->id) }}" class="btn btn-sub-primary size-8 btn-icon">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <button class="btn btn-sub-primary size-8 btn-icon edit-btn" data-id="{{ $professional->id }}">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <button class="btn btn-sub-danger size-8 btn-icon delete-btn" data-id="{{ $professional->id }}">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center g-3 mt-2">
                    <div class="col-md-6">
                        <p class="text-muted text-center text-md-start mb-0" id="paginationInfo">
                            Showing <b class="me-1">1-0</b>of<b class="ms-1">0</b> Results
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

<!-- Add/Edit Customer Modal -->
<div class="modal fade" id="addProfessionalModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addProfessionalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="p-2 modal-content">
            <div class="h-24 w-100 rounded-top modal-gradient-bg"></div>
            <div class="p-4">
                <form method="POST" action="{{ route('admin.professionals.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-n16 row g-4">
                        <div class="col-12">
                            <label
                                class="avatar cursor-pointer border border-2 border-light-subtle bg-light size-24 rounded-circle">
                                <img id="imagePreview" loading="lazy"
                                    class="rounded-circle w-100 h-100 object-cover"
                                    style="display:none;">
                                <i id="uploadIcon" data-lucide="upload" class="text-muted"></i>
                                <input type="file" name="profile_image" class="d-none" id="imageInput" accept="image/*">
                            </label>
                        </div>
                        <div class="col-12">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" name="full_name" id="fullName" placeholder="Enter professional name"
                                class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="professionalType" class="form-label">Professional Type</label>
                            <select name="profession" class="form-control">
                                <option value="architect">Architect</option>
                                <option value="engineer">Engineer</option>
                                <option value="valuer">Valuer</option>
                                <option value="surveyor">Surveyor</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="license_number" class="form-label">License / Registration Number</label>
                            <input name="license_number" class="form-control" placeholder="License / Registration number">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" placeholder="email@example.com"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" placeholder="+(000) 0000 0000"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="years_experience" class="form-label">Years of Experience</label>
                            <input type="text" name="years_experience" id="years_experience" placeholder="Enter years of experience"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rating" class="form-label">Rating</label>
                            <input name="rating" type="number" step="0.1" min="0" max="5" class="form-control" placeholder="Rating">
                        </div>

                        <div class="col-md-12">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea name="bio" class="form-control" placeholder="Biography"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label for="services" class="form-label">Services Offered</label>
                            <input name="services" class="form-control" placeholder="Services (e.g. Valuation, Design, Supervision)">
                        </div>

                        <div class="col-md-12">
                            <label for="portfolio_url" class="form-label">Portfolio URL</label>
                            <input name="portfolio_url" class="form-control" placeholder="Portfolio URL">
                        </div>

                        <div class="col-md-12">
                            <label for="credentials_doc" class="form-label">Credentials Document</label>
                            <input type="file" name="credentials_doc" class="form-control">
                        </div>

                        <input name="linkedin" class="form-control" placeholder="LinkedIn URL">
                        <input name="website" class="form-control" placeholder="Website">
                        <input name="whatsapp" class="form-control" placeholder="WhatsApp">
                        <input name="office_location" class="form-control" placeholder="Office location">
                        <input name="languages" class="form-control" placeholder="English, Kinyarwanda, French">

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-active-danger" data-bs-dismiss="modal">
                                <i data-lucide="x" class="size-4 me-1"></i>Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="saveCustomerBtn">Save
                                Customer</button>
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
            <h5 class="mb-4 lh-base">Are you sure you want to delete this customer?</h5>
            <input type="hidden" id="deleteCustomerId">
            <div class="d-flex justify-content-center align-items-center gap-2">
                <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                <button class="btn btn-link text-reset" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@endsection