<style>
    .partner-box {
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        /* border: 1px solid #eee; */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 10px;
    }

    .partner-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* keeps logo ratio */
    }
</style>
<div class="about4-section-area sp1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="about-heading heading3">
                    <div class="space20"></div>
                    <h2 class="text-anime-style-3">
                        Our <span class="text-gradient">Partners</span>
                    </h2>
                    <div class="space18"></div>
                    <p data-aos="fade-left" data-aos-duration="900" class="aos-init">At HouseBox, we’re redefining the way people find, sell, and invest in properties. Our mission is to simplify real a estate by provide innovative solutions, expert guidance.</p>

                </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-6">
                <div class="row">
                    @foreach($partners as $partner)
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="gallery-boxarea partner-box">
                            <div class="img1">
                                <img src="{{ asset('storage/'.$partner->image) }}"
                                    alt="{{ $partner->name }}"
                                    class="partner-img">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>