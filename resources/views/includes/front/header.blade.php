<!-- Header start -->

<!-- Header start -->
<header id="sticky-header" class="position-absolute top-0 w-100 ">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            <!-- Logo -->
            <a href="index.html" class="d-flex align-items-center text-decoration-none">
                <h2 class="text-white mb-0">RealEstate</h2>
            </a>

            <!-- Navbar -->
            <nav class="d-none d-lg-block">
                <ul class="nav">
                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('front.home') }}">Home</a>
                    </li>

                    <!-- Buy Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Buy
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('front.buy.homes') }}">Homes for Sale</a></li>
                            <li><a class="dropdown-item" href="{{ route('front.buy.lands') }}">Land for Sale</a></li>
                            <li><a class="dropdown-item" href="{{ route('front.buy.design') }}">Architectural Designs</a></li>
                            <li><a class="dropdown-item" href="about.html">Buy Guide</a></li>
                            <li><a class="dropdown-item" href="about-v2.html">Find an Agent</a></li>
                        </ul>
                    </li>

                    <!-- Rent Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Rent
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="about.html">Houses for Rent</a></li>
                            <li><a class="dropdown-item" href="about-v2.html">Apartments for Rent</a></li>
                            <li><a class="dropdown-item" href="about.html">Short-Term Stays</a></li>
                            <li><a class="dropdown-item" href="about-v2.html">Rent Near Me</a></li>
                        </ul>
                    </li>

                    <!-- Sell Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sell
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="about.html">List Your Property</a></li>
                            <li><a class="dropdown-item" href="about-v2.html">List Your Land</a></li>
                            <li><a class="dropdown-item" href="about.html">Find an Agent</a></li>
                        </ul>
                    </li>

                    <!-- Find an Agent Mega Menu -->
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Find an Agent
                        </a>
                        <div class="dropdown-menu w-100 p-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h6 class="text-primary">Looking for agent</h6>
                                    <ul class="list-unstyled">
                                        <li><a class="dropdown-item" href="properties-v1.html">Real Estate Agent</a></li>
                                        <li><a class="dropdown-item" href="properties-v2.html">Real Estate Consultant</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="text-primary">I'm a Pro</h6>
                                    <ul class="list-unstyled">
                                        <li><a class="dropdown-item" href="properties-left-side-bar.html">Create Agent Account</a></li>
                                        <li><a class="dropdown-item" href="properties-right-side-bar.html">Agent Advertising</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="text-primary">Consultant</h6>
                                    <ul class="list-unstyled">
                                        <li><a class="dropdown-item" href="add-properties.html">Get Consultant</a></li>
                                        <li><a class="dropdown-item" href="properties-details.html">Become a Consultant</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- Get Help -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('front.contact') }}">Get Help</a>
                    </li>

                    <!-- News & Ads -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            News & Ads
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('front.ads.index') }}">Advertisements</a></li>
                            <li><a class="dropdown-item" href="{{ route('front.announcements.index') }}">Announcements</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- User & Quick Find -->
            <ul class="nav align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('front/assets/images/user/avater.png') }}" alt="avatar" class="rounded-circle" width="40">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="login.html">Login</a></li>
                        <li><a class="dropdown-item" href="register.html">Register</a></li>
                    </ul>
                </li>
                <li class="nav-item ms-3">
                    <a href="add-properties.html" class="btn btn-secondary text-white">Quick Find</a>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- Header end -->
<!-- Mobile Offcanvas Menu start -->
<button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMobileMenu" aria-controls="offcanvasMobileMenu">
  <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
    <path d="M0 96C0 78.33 14.33 64 32 64H416C433.7 64 448 78.33 448 96C448 113.7 433.7 128 416 128H32C14.33 128 0 113.7 0 96zM0 256C0 238.3 14.33 224 32 224H416C433.7 224 448 238.3 448 256C448 273.7 433.7 288 416 288H32C14.33 288 0 273.7 0 256zM416 448H32C14.33 448 0 433.7 0 416C0 398.3 14.33 384 32 384H416C433.7 384 448 398.3 448 416C448 433.7 433.7 448 416 448z"/>
  </svg>
</button>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMobileMenu" aria-labelledby="offcanvasMobileMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasMobileMenuLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0">
    <nav class="nav flex-column">
      <!-- Home -->
      <a class="nav-link" href="#">Home</a>

      <!-- About -->
      <a class="nav-link" data-bs-toggle="collapse" href="#mobileAbout" role="button" aria-expanded="false" aria-controls="mobileAbout">
        About
      </a>
      <div class="collapse ps-3" id="mobileAbout">
        <a class="nav-link" href="about.html">About</a>
        <a class="nav-link" href="about-v2.html">About v2</a>
      </div>

      <!-- Properties -->
      <a class="nav-link" data-bs-toggle="collapse" href="#mobileProperties" role="button" aria-expanded="false" aria-controls="mobileProperties">
        Properties
      </a>
      <div class="collapse ps-3" id="mobileProperties">
        <!-- Properties main -->
        <a class="nav-link" data-bs-toggle="collapse" href="#mobilePropertiesMain" role="button" aria-expanded="false" aria-controls="mobilePropertiesMain">
          Properties
        </a>
        <div class="collapse ps-3" id="mobilePropertiesMain">
          <a class="nav-link" href="properties-v1.html">Properties v1</a>
          <a class="nav-link" href="properties-v2.html">Properties v2</a>
          <a class="nav-link" href="add-properties.html">Add Properties</a>
        </div>
        <!-- Properties with sidebar -->
        <a class="nav-link" data-bs-toggle="collapse" href="#mobilePropertiesSidebar" role="button" aria-expanded="false" aria-controls="mobilePropertiesSidebar">
          Properties with Sidebar
        </a>
        <div class="collapse ps-3" id="mobilePropertiesSidebar">
          <a class="nav-link" href="properties-left-side-bar.html">Left Sidebar</a>
          <a class="nav-link" href="properties-right-side-bar.html">Right Sidebar</a>
          <a class="nav-link" href="properties-list-left-side-bar.html">List Left Sidebar</a>
          <a class="nav-link" href="properties-list-right-side-bar.html">List Right Sidebar</a>
        </div>
        <!-- Property Details -->
        <a class="nav-link" data-bs-toggle="collapse" href="#mobilePropertyDetails" role="button" aria-expanded="false" aria-controls="mobilePropertyDetails">
          Property Details
        </a>
        <div class="collapse ps-3" id="mobilePropertyDetails">
          <a class="nav-link" href="add-properties.html">Add Properties</a>
          <a class="nav-link" href="properties-details.html">Property Details</a>
        </div>
      </div>

      <!-- Pages -->
      <a class="nav-link" data-bs-toggle="collapse" href="#mobilePages" role="button" aria-expanded="false" aria-controls="mobilePages">
        Pages
      </a>
      <div class="collapse ps-3" id="mobilePages">
        <a class="nav-link" href="service.html">Service</a>
        <a class="nav-link" href="single-service.html">Single Service</a>
        <a class="nav-link" href="contact-us.html">Contact Us</a>
        <a class="nav-link" href="create-agency.html">Create Agency</a>
        <a class="nav-link" href="login.html">Login</a>
        <a class="nav-link" href="register.html">Register</a>
      </div>

      <!-- Agency -->
      <a class="nav-link" data-bs-toggle="collapse" href="#mobileAgency" role="button" aria-expanded="false" aria-controls="mobileAgency">
        Agency
      </a>
      <div class="collapse ps-3" id="mobileAgency">
        <a class="nav-link" href="agency.html">Agency</a>
        <a class="nav-link" href="create-agency.html">Create Agency</a>
        <a class="nav-link" href="agent.html">Agent</a>
        <a class="nav-link" href="agency-details.html">Agency Details</a>
        <a class="nav-link" href="agent-details.html">Agent Details</a>
      </div>

      <!-- Blog -->
      <a class="nav-link" data-bs-toggle="collapse" href="#mobileBlog" role="button" aria-expanded="false" aria-controls="mobileBlog">
        Blog
      </a>
      <div class="collapse ps-3" id="mobileBlog">
        <a class="nav-link" href="blog-grid.html">Blog Grid</a>
        <a class="nav-link" href="blog-grid-left-side-bar.html">Blog Grid Left Sidebar</a>
        <a class="nav-link" href="blog-grid-right-side-bar.html">Blog Grid Right Sidebar</a>
        <a class="nav-link" href="blog-details.html">Blog Details</a>
      </div>

      <!-- Contact -->
      <a class="nav-link" href="contact.html">Contact</a>

      <!-- Add Property Button -->
      <div class="mt-3 px-3">
        <a href="add-properties.html" class="btn btn-primary w-100">Add Property</a>
      </div>
    </nav>
  </div>
</div>
<!-- Mobile Offcanvas Menu end -->
<!-- offcanvas-mobile-menu end -->
<!-- Header end -->
