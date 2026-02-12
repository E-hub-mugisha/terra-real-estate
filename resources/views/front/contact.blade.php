@extends('layouts.guest')
@section('title', 'Get In Touch')
@section('content')

<div class="pt-[80px] lg:pt-[120px]">
    <div class="container">
        <form id="contact-form" action="https://template.hasthemes.com/bery/bery/assets/php/contact.php"
            method="post">
            <div class="grid grid-cols-12 gap-x-[30px] mb-[-30px] items-end">
                <div class="col-span-12 lg:col-span-7 mb-[30px]">
                    <div>
                        <h2
                            class="font-lora text-primary text-[24px] sm:text-[28px] leading-[1.277] capitalize mb-[10px] font-medium">
                            Send Message</h2>
                        <p class="max-w-[465px] mb-[40px]">
                            Huge number of propreties availabe here for buy, sell and Rent.
                            Also you find here co-living property, lots opportunity
                        </p>
                    </div>
                    <div class="grid grid-cols-12 gap-x-[20px] gap-y-[30px]">

                        <div class="col-span-12 md:col-span-6">
                            <input
                                class="font-light w-full leading-[1.75] placeholder:opacity-100 placeholder:text-body border border-primary border-opacity-60 rounded-[8px] p-[15px] focus:border-secondary focus:border-opacity-60 focus:outline-none focus:drop-shadow-[0px_6px_15px_rgba(0,0,0,0.1)] "
                                type="text" placeholder="First Name" name="name">
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <input
                                class="font-light w-full leading-[1.75] placeholder:opacity-100 placeholder:text-body border border-primary border-opacity-60 rounded-[8px] p-[15px] focus:border-secondary focus:border-opacity-60 focus:outline-none focus:drop-shadow-[0px_6px_15px_rgba(0,0,0,0.1)] "
                                type="text" placeholder="Last Name" name="name">
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <input
                                class="font-light w-full leading-[1.75] placeholder:opacity-100 placeholder:text-body border border-primary border-opacity-60 rounded-[8px] p-[15px] focus:border-secondary focus:border-opacity-60 focus:outline-none focus:drop-shadow-[0px_6px_15px_rgba(0,0,0,0.1)] "
                                type="text" placeholder="Phone number" name="number">
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <input
                                class="font-light w-full leading-[1.75] placeholder:opacity-100 placeholder:text-body border border-primary border-opacity-60 rounded-[8px] p-[15px] focus:border-secondary focus:border-opacity-60 focus:outline-none focus:drop-shadow-[0px_6px_15px_rgba(0,0,0,0.1)] "
                                type="email" placeholder="Email Address" name="email">
                        </div>

                        <div class="col-span-12">
                            <textarea
                                class="h-[196px] font-light w-full leading-[1.75] placeholder:opacity-100 placeholder:text-body border border-primary border-opacity-60 rounded-[8px] p-[15px] focus:border-secondary focus:border-opacity-60 focus:outline-none focus:drop-shadow-[0px_6px_15px_rgba(0,0,0,0.1)] resize-none"
                                name="message" id="textarea" cols="30" rows="10"
                                placeholder="Message"></textarea>
                        </div>


                    </div>
                </div>
                <div class="col-span-12 lg:col-span-5 mb-[30px] order-last lg:order-none">
                    <div class="h-[385px] rounded-[6px] overflow-hidden xl:ml-[40px]">
                        <iframe class="w-full h-full"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4814229.011985735!2d-65.89121968758322!3d-7.7486900084225026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91e8605342744385%3A0x3d3c6dc1394a7fc7!2sAmazon%20Rainforest!5e0!3m2!1sen!2sbd!4v1644813708270!5m2!1sen!2sbd"
                            style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
                <div class="col-span-12 mb-[30px] lg:mb-0  order-2 lg:order-none">
                    <button type="submit"
                        class="before:rounded-md before:block before:absolute before:left-auto before:right-0 before:inset-y-0 before:-z-[1] before:bg-secondary before:w-0 hover:before:w-full hover:before:left-0 hover:before:right-auto before:transition-all leading-none px-[30px] py-[15px] capitalize font-medium text-white text-[14px] xl:text-[16px] relative after:block after:absolute after:inset-0 after:-z-[2] after:bg-primary after:rounded-md after:transition-all mb-[30px] lg:mb-0">Contact
                        us</button>
                    <p class="form-messege mt-3"></p>
                </div>
            </div>
        </form>

    </div>
</div>


<!-- contact form start -->
<section class="py-[80px] lg:py-[120px]">
    <div class="container">
        <div class="grid col-span-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-[30px] mb-[-30px]">

            <div
                class="flex hover:drop-shadow-[0px_16px_10px_rgba(0,0,0,0.1)] hover:bg-[#F5F9F8] transition-all p-[20px] xl:p-[35px] rounded-[8px] mb-[30px] group">
                <img class="self-center mr-[20px] sm:mr-[40px] lg:mr-[20px] xl:mr-[40px] sm:mb-[15px] lg:mb-0"
                    src="assets/images/icon/map.png" width="40" height="55" loading="lazy" alt="image icon">
                <div class="flex-1">
                    <h4
                        class="font-lora group-hover:text-secondary group-hover:transition-all leading-none text-[28px] text-primary mb-[10px]">
                        Address <span class="text-secondary">.</span></h4>
                    <p class="font-light text-[18px] lg:max-w-[230px]">2104 Charmaine Lane Amarillo, New York
                    </p>
                </div>
            </div>

            <div
                class="flex hover:drop-shadow-[0px_16px_10px_rgba(0,0,0,0.1)] hover:bg-[#F5F9F8] transition-all p-[20px] xl:p-[35px] rounded-[8px] mb-[30px] group">
                <img class="self-center mr-[20px] sm:mr-[40px] lg:mr-[20px] xl:mr-[40px] sm:mb-[15px] lg:mb-0"
                    src="assets/images/icon/phone.png" width="46" height="46" loading="lazy" alt="image icon">
                <div class="flex-1">
                    <h4
                        class="font-lora group-hover:text-secondary group-hover:transition-all leading-none text-[28px] text-primary mb-[10px]">
                        Call us <span class="text-secondary">.</span></h4>
                    <p class="font-light text-[18px] lg:max-w-[230px]">2104 Charmaine Lane Amarillo, New York
                    </p>
                </div>
            </div>

            <div
                class="flex hover:drop-shadow-[0px_16px_10px_rgba(0,0,0,0.1)] hover:bg-[#F5F9F8] transition-all p-[20px] xl:p-[35px] rounded-[8px] mb-[30px] xl:pl-[65px] group">
                <img class="self-center mr-[20px] sm:mr-[40px] lg:mr-[20px] xl:mr-[40px] sm:mb-[15px] lg:mb-0"
                    src="assets/images/icon/mail.png" width="46" height="52" loading="lazy" alt="image icon">
                <div class="flex-1">
                    <h4
                        class="font-lora group-hover:text-secondary group-hover:transition-all leading-none text-[28px] text-primary mb-[10px]">
                        Email us <span class="text-secondary">.</span></h4>
                    <p class="font-light text-[18px] lg:max-w-[230px]">
                        <a href="mailto:admin@examples.com" class="hover:text-secondary">admin@examples.com</a>
                        <a href="mailto:info@examples.com" class="hover:text-secondary">info@examples.com</a>
                    </p>
                </div>
            </div>

        </div>


    </div>
</section>
<!-- contact form end -->


<!-- News Letter section start -->
<section class="py-[80px] lg:p-[90px] bg-primary relative">
    <div class="container">
        <div class="grid grid-cols-1">
            <div class="col-span">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="w-full lg:w-auto">
                        <h3
                            class="font-lora text-white text-[24px] sm:text-[30px] xl:text-[36px] leading-[1.277] mb-[10px]">
                            Are you a Home Owner?</h3>
                        <p class="text-secondary leading-[1.5] tracking-[0.03em] mb-10">Put your email address
                            and get listed.</p>
                        <form id="mc-form" action="#" class="relative w-full">
                            <input id="mc-email"
                                class="font-light text-white leading-[1.75] opacity-100 border border-secondary w-full lg:w-[395px] xl:w-[495px] h-[60px] rounded-[10px] py-[15px] pl-[15px] pr-[15px] sm:pr-[135px] focus:border-white focus:outline-none border-opacity-60 placeholder:text-[#E2E2E2] bg-transparent"
                                type="text" placeholder="Enter your email here...">
                            <button id="mc-submit" type="submit"
                                class="text-white font-medium text-[16px] leading-none tracking-[0.02em] bg-secondary py-[17px] px-[20px] mt-5 sm:mt-0 rounded-[10px] hover:bg-white hover:text-primary transition-all sm:absolute sm:right-[4px] sm:top-1/2 sm:-translate-y-1/2">Get
                                Listed</button>
                        </form>
                        <!-- mailchimp-alerts Start -->
                        <div class="mailchimp-alerts text-centre">
                            <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                            <div class="mailchimp-success text-green-400"></div><!-- mailchimp-success end -->
                            <div class="mailchimp-error text-red-600"></div><!-- mailchimp-error end -->
                        </div>
                        <!-- mailchimp-alerts end -->
                    </div>
                    <div class="w-full hidden lg:block lg:w-auto mt-5 lg:mt-0">
                        <div class="relative mt-10 md:mt-0 lg:absolute lg:right-0 lg:bottom-0">
                            <img class="hero_image lg:max-w-[550px] xl:max-w-[650px] 2xl:max-w-[714px]"
                                src="assets/images/newsletter/bg-1.png" width="866" height="879"
                                alt="hero image">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- News Letter section End -->

@endsection