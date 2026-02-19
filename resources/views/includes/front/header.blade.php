<!-- Header start -->

<header id="sticky-header" class="absolute left-0 top-[15px] lg:top-[30px] xl:top-[40px] w-full z-10">
    <div class="container">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="flex flex-wrap items-center justify-between">
                    <a href="index.html" class="block">
                        <!-- <img class="w-full h-full white-logo" src="{{ asset('front/assets/images/logo/logo-white.png') }}" loading="lazy" width="99" height="46" alt="brand logo">
                        <img class="w-full h-full hidden dark-logo" src="{{ asset('front/assets/images/logo/logo.svg') }}" loading="lazy" width="99" height="46" alt="brand logo"> -->
                        <h2 class="text-2xl font-bold text-white">RealEstate</h2>
                        <h2 class="text-2xl font-bold hidden text-secondary">RealEstate</h2>
                    </a>
                    <nav class="flex flex-wrap items-center">
                        <ul class="hidden lg:flex flex-wrap items-center font-lora text-[16px] xl:text-[18px] leading-none text-black">
                            <li class="mr-7 xl:mr-[40px] relative group py-[20px]">

                                <a href="{{ route('front.home') }}" class="sticky-dark transition-all text-white hover:text-secondary">Home</a>
                            </li>
                            <li class="mr-7 xl:mr-[40px] relative group py-[20px]">

                                <a href="#!" class="sticky-dark transition-all text-white hover:text-secondary">Buy</a>

                                <ul class="list-none bg-white drop-shadow-[0px_6px_10px_rgba(0,0,0,0.2)] rounded-[12px] flex flex-wrap flex-col w-[220px] absolute top-[120%] left-1/2 -translate-x-1/2 transition-all
            group-hover:top-[100%] invisible group-hover:visible opacity-0 group-hover:opacity-100
            
            ">
                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="{{ route('front.buy.homes') }}" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-t-[12px]">Homes for Sale</a>
                                    </li>

                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="{{ route('front.buy.lands') }}" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-b-[12px]">Land for Sale</a>
                                    </li>
                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="{{ route('front.buy.design')}}" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-b-[12px]">Architectural designs</a>
                                    </li>
                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-t-[12px]">Buy guide</a>
                                    </li>

                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about-v2.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-b-[12px]">Find an Agent</a>
                                    </li>
                                    
                                </ul>

                            </li>
                            <li class="mr-7 xl:mr-[40px] relative group py-[20px]">

                                <a href="about.html" class="sticky-dark transition-all text-white hover:text-secondary">Rent</a>

                                <ul class="list-none bg-white drop-shadow-[0px_6px_10px_rgba(0,0,0,0.2)] rounded-[12px] flex flex-wrap flex-col w-[220px] absolute top-[120%] left-1/2 -translate-x-1/2 transition-all
            group-hover:top-[100%] invisible group-hover:visible opacity-0 group-hover:opacity-100
            
            ">
                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-t-[12px]">Houses for Rent</a>
                                    </li>

                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about-v2.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-b-[12px]">Apartments for Rent</a>
                                    </li>
                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-t-[12px]">Short-Term Stays</a>
                                    </li>

                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about-v2.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-b-[12px]">Rent Near Me</a>
                                    </li>

                                </ul>

                            </li>
                            <li class="mr-7 xl:mr-[40px] relative group py-[20px]">

                                <a href="about.html" class="sticky-dark transition-all text-white hover:text-secondary">Sell</a>

                                <ul class="list-none bg-white drop-shadow-[0px_6px_10px_rgba(0,0,0,0.2)] rounded-[12px] flex flex-wrap flex-col w-[220px] absolute top-[120%] left-1/2 -translate-x-1/2 transition-all
            group-hover:top-[100%] invisible group-hover:visible opacity-0 group-hover:opacity-100
            
            ">
                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-t-[12px]">List Your Property</a>
                                    </li>

                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about-v2.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-b-[12px]">List Your Land</a>
                                    </li>
                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="about.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-t-[12px]">Find an Agent</a>
                                    </li>
                                </ul>

                            </li>
                            <li class="mr-7 xl:mr-[40px] relative group py-[20px]">

                                <a href="#" class="sticky-dark transition-all text-white hover:text-secondary">Find an agent</a>

                                <ul class="list-none bg-white drop-shadow-[0px_6px_10px_rgba(0,0,0,0.2)] rounded-[12px] flex flex-wrap w-[890px] absolute top-[120%] left-1/2 translate-x-[-40%] xl:translate-x-[-45%] transition-all
            group-hover:top-[100%] invisible group-hover:visible opacity-0 group-hover:opacity-100 px-[40px] py-[45px]
            bg-contain bg-right-top bg-no-repeat
            " style="background-image: url('assets/images/mega-menu/image.png');">


                                    <li class="mr-[70px]">
                                        <ul>
                                            <li class="text-primary underline font-lora mb-[30px]">Looking for agent</li>
                                            <li class="mb-[25px] last:mb-0">
                                                <a href="properties-v1.html" class="font-lora text-[14px] hover:text-secondary">Real Estate agent</a>
                                            </li>
                                            <li class="mb-[25px] last:mb-0">
                                                <a href="properties-v2.html" class="font-lora text-[14px] hover:text-secondary">Real Estate Consultant</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="mr-[70px]">
                                        <ul>
                                            <li class="text-primary underline font-lora mb-[30px]">I'm a Pro</li>
                                            <li class="mb-[25px] last:mb-0">
                                                <a href="properties-left-side-bar.html" class="font-lora text-[14px] hover:text-secondary">Create agent account</a>
                                            </li>
                                            <li class="mb-[25px] last:mb-0">
                                                <a href="properties-right-side-bar.html" class="font-lora text-[14px] hover:text-secondary">Agent Advertizing</a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li>
                                        <ul>
                                            <li class="text-primary underline font-lora mb-[30px]">Consultant</li>
                                            <li class="mb-[25px] last:mb-0">
                                                <a href="add-properties.html" class="font-lora text-[14px] hover:text-secondary">Get Consultant</a>
                                            </li>

                                            <li class="mb-[25px] last:mb-0">
                                                <a href="properties-details.html" class="font-lora text-[14px] hover:text-secondary">Become a Consultant</a>
                                            </li>

                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            
                            <li class="mr-7 xl:mr-[40px] relative group py-[20px]">

                                <a href="{{ route('front.contact') }}" class="sticky-dark transition-all text-white hover:text-secondary">Get Help</a>

                            </li>
                            <li class="mr-7 xl:mr-[40px] relative group py-[20px]">

                                <a href="{{ route('front.contact') }}" class="sticky-dark transition-all text-white hover:text-secondary">News & Ads</a>

                            </li>
                        </ul>

                        <ul class="flex flex-wrap items-center">
                            <li class="sm:mr-5 xl:mr-[20px] relative group"><a href="#">
                                    <img src="{{ asset('front/assets/images/user/avater.png') }}" loading="lazy" width="62" height="62" alt="avater">
                                </a>

                                <ul class="list-none bg-white drop-shadow-[0px_6px_10px_rgba(0,0,0,0.2)] rounded-[12px] flex flex-wrap flex-col w-[180px] absolute top-[120%] sm:left-1/2 sm:-translate-x-1/2 transition-all
                group-hover:top-[60px] invisible group-hover:visible opacity-0 group-hover:opacity-100 right-0
                
                ">
                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="login.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-t-[12px]">login</a>
                                    </li>

                                    <li class="border-b border-dashed border-primary border-opacity-40 last:border-b-0 hover:border-solid transition-all">
                                        <a href="register.html" class="font-lora leading-[1.571] text-[14px] text-primary p-[10px] capitalize block transition-all hover:bg-secondary hover:text-white text-center my-[-1px] rounded-b-[12px]">register</a>
                                    </li>


                                </ul>
                            </li>
                            <li>
                                <a href="add-properties.html" class="sticky-btn before:rounded-md before:block before:absolute before:left-auto before:right-0 before:inset-y-0 before:-z-[1] before:bg-white before:w-0 hover:before:w-full hover:before:left-0 hover:before:right-auto hover:text-primary before:transition-all leading-none px-[20px] py-[15px] capitalize font-medium text-white hidden sm:block text-[14px] xl:text-[16px] relative after:block after:absolute after:inset-0 after:-z-[2] after:bg-secondary after:rounded-md after:transition-all">Quick Find</a>
                            </li>
                            <li class="ml-2 sm:ml-5 lg:hidden">
                                <a href="#offcanvas-mobile-menu" class="offcanvas-toggle flex text-[#016450] hover:text-secondary">
                                    <svg width="24" height="24" class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M0 96C0 78.33 14.33 64 32 64H416C433.7 64 448 78.33 448 96C448 113.7 433.7 128 416 128H32C14.33 128 0 113.7 0 96zM0 256C0 238.3 14.33 224 32 224H416C433.7 224 448 238.3 448 256C448 273.7 433.7 288 416 288H32C14.33 288 0 273.7 0 256zM416 448H32C14.33 448 0 433.7 0 416C0 398.3 14.33 384 32 384H416C433.7 384 448 398.3 448 416C448 433.7 433.7 448 416 448z" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- offcanvas-overlay start -->
<div class="offcanvas-overlay hidden fixed inset-0 bg-black opacity-50 z-50"></div>
<!-- offcanvas-overlay end -->
<!-- offcanvas-mobile-menu start -->
<div id="offcanvas-mobile-menu" class="offcanvas left-0 transform -translate-x-full fixed font-normal text-sm top-0 z-50 h-screen xs:w-[300px] lg:w-[380px] transition-all ease-in-out duration-300 bg-white">

    <div class="py-12 pr-5 h-[100vh] overflow-y-auto">
        <!-- close button start -->
        <button class="offcanvas-close text-primary text-[25px] w-10 h-10 absolute right-0 top-0 z-[1]" aria-label="offcanvas">x</button>
        <!-- close button end -->

        <!-- offcanvas-menu start -->

        <nav class="offcanvas-menu mr-[20px]">
            <ul>
                <li class="relative block border-b-primary border-b first:border-t first:border-t-primary">
                    <a href="#" class="block capitalize font-normal text-black hover:text-secondary text-base my-2 py-1 px-5">Home</a>
                    <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">
                        <li><a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="index.html">home 01</a></li>
                        <li><a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="index-2.html">home 02</a></li>
                        <li><a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="index-3.html">home 03</a></li>
                        <li><a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="index-4.html">home 04</a></li>
                        <li><a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="index-5.html">home 05</a></li>
                        <li><a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="index-6.html">home 06</a></li>
                    </ul>
                </li>
                <li class="relative block border-b-primary border-b">
                    <a href="about.html" class="block capitalize font-normal text-black hover:text-secondary text-base my-2 py-1 px-5">About</a>
                    <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">
                        <li><a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="about.html">About</a></li>

                        <li><a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="about-v2.html">About v2</a></li>
                    </ul>

                </li>
                <li class="relative block border-b-primary border-b">
                    <a href="#" class="block capitalize font-normal text-black hover:text-secondary text-base my-2 py-1 px-5">Properties</a>
                    <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">
                        <li>
                            <a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="#">Properties</a>
                            <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">



                                <li>
                                    <a class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary" href="properties-v1.html"> properties v1</a>
                                </li>
                                <li>
                                    <a class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary" href="properties-v2.html"> properties v2</a>
                                </li>
                                <li>
                                    <a class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary" href="add-properties.html">add properties </a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="#">Properties with sidebar</a>
                            <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">

                                <li>
                                    <a href="properties-left-side-bar.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">properties
                                        left side bar</a>
                                </li>
                                <li>
                                    <a href="properties-right-side-bar.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">properties
                                        right side bar</a>
                                </li>

                                <li>
                                    <a href="properties-list-left-side-bar.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">properties
                                        list left side bar</a>
                                </li>

                                <li>
                                    <a href="properties-list-right-side-bar.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">properties
                                        list
                                        right side bar</a>
                                </li>
                            </ul>


                        </li>
                        <li>
                            <a class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary" href="#">Property Details</a>

                            <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">

                                <li>
                                    <a href="add-properties.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">add
                                        properties</a>
                                </li>

                                <li>
                                    <a href="properties-details.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">properties
                                        details</a>
                                </li>

                            </ul>

                        </li>

                    </ul>
                </li>
                <li class="relative block border-b-primary border-b"><a href="#" class="relative block capitalize font-normal text-black hover:text-secondary text-base my-2 py-1 px-5">Pages</a>

                    <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">
                        <li>
                            <a href="service.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">Service</a>
                        </li>
                        <li>
                            <a href="single-service.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">single
                                service</a>
                        </li>
                        <li>
                            <a href="contact-us.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">contact
                                us</a>
                        </li>
                        <li>
                            <a href="create-agency.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">create
                                agency</a>
                        </li>
                        <li>
                            <a href="login.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">login</a>
                        </li>
                        <li>
                            <a href="register.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">register</a>
                        </li>
                    </ul>
                </li>

                <li class="relative block border-b-primary border-b"><a href="#" class="relative block capitalize font-normal text-black hover:text-secondary text-base my-2 py-1 px-5">agency</a>

                    <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">
                        <li>
                            <a href="agency.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">agency</a>
                        </li>
                        <li>
                            <a href="create-agency.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">create
                                agency</a>
                        </li>

                        <li>
                            <a href="agent.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">agent</a>
                        </li>

                        <li>
                            <a href="agency-details.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">agency
                                details</a>
                        </li>

                        <li>
                            <a href="agent-details.html" class="text-sm pt-3 px-10 pb-1 text-black font-light block transition-all hover:text-secondary">agent
                                details</a>
                        </li>

                    </ul>

                </li>

                <li class="relative block border-b-primary border-b"><a href="#" class="relative block capitalize text-black hover:text-secondary text-base my-2 py-1 px-5">Blog</a>

                    <ul class="offcanvas-submenu static top-auto hidden w-full visible opacity-100 capitalize">
                        <li>
                            <a href="blog-grid.html" class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary">blog
                                grid</a>
                        </li>
                        <li>
                            <a href="blog-grid-left-side-bar.html" class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary">blog
                                grid left side bar</a>
                        </li>
                        <li>
                            <a href="blog-grid-right-side-bar.html" class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary">blog
                                grid right side bar</a>
                        </li>
                        <li>
                            <a href="blog-details.html" class="text-sm py-2 px-[30px] text-black font-light block transition-all hover:text-secondary">blog
                                details</a>
                        </li>

                    </ul>
                </li>
                <li class="relative block border-b-primary border-b"><a href="contact.html" class="relative block capitalize text-black hover:text-secondary text-base my-2 py-1 px-5">Contact</a></li>
            </ul>
        </nav>
        <!-- offcanvas-menu end -->

        <div class="px-5 flex flex-wrap mt-3 sm:hidden">
            <a href="#" class="before:rounded-md before:block before:absolute before:left-auto before:right-0 before:inset-y-0 before:-z-[1] before:bg-secondary before:w-0 hover:before:w-full hover:before:left-0 hover:before:right-auto before:transition-all leading-none px-[20px] py-[15px] capitalize font-medium text-white text-[14px] xl:text-[16px] relative after:block after:absolute after:inset-0 after:-z-[2] after:bg-primary after:rounded-md after:transition-all">Add
                Property</a>
        </div>



    </div>
</div>
<!-- offcanvas-mobile-menu end -->
<!-- Header end -->