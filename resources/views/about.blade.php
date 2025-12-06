@extends('layouts.app')

@section('title', 'About Us - Plastic Store')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>About Us</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>About Us</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- About Section Begin -->
<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about__pic">
                    <img src="{{ asset('img/polysite-logo.jpg') }}" alt="About Us">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__text">
                    <div class="section-title">
                        <span>About Us</span>
                        <h2>Plastic Store - Plastic Products Expert</h2>
                    </div>
                    <p>With over 10 years of experience in the plastic manufacturing and distribution industry,
                        we are proud to be a reliable partner for hundreds of businesses and individual customers.</p>
                    <p>Specializing in providing high-quality PET, PP, PC plastic products, ensuring food safety
                        and environmental friendliness.</p>

                    <div class="about__achievement">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="about__achievement__item">
                                    <h4>500+</h4>
                                    <p>Customers</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="about__achievement__item">
                                    <h4>50+</h4>
                                    <p>Products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission Vision Section -->
<section class="mission spad bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="mission__item text-center">
                    <div class="mission__icon">
                        <i class="fa fa-bullseye"></i>
                    </div>
                    <h4>Mission</h4>
                    <p>Provide high-quality plastic products at competitive prices,
                        meeting all customer needs.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="mission__item text-center">
                    <div class="mission__icon">
                        <i class="fa fa-eye"></i>
                    </div>
                    <h4>Vision</h4>
                    <p>Become the leading plastic manufacturing and distribution company
                        in Vietnam by 2025.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="mission__item text-center">
                    <div class="mission__icon">
                        <i class="fa fa-gem"></i>
                    </div>
                    <h4>Core Values</h4>
                    <p>Quality - Safety - Environmentally Friendly -
                        Dedicated Service - Innovation and Creativity.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section (Optional) -->
<section class="team spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Our Team</span>
                    <h2>Professional Team</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Member 1 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team__item text-center">
                    <div class="team__pic">
                        <img src="{{ asset('img/duy.jpg') }}" alt="CEO">
                    </div>
                    <div class="team__text">
                        <h5>Đỗ Đức Duy</h5>
                        <span>CEO & Founder</span>
                        <p>15 years of experience in the plastic industry</p>
                    </div>
                </div>
            </div>
            <!-- Member 2 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team__item text-center">
                    <div class="team__pic">
                        <img src="{{ asset('img/khai.jpg') }}" alt="CTO">
                    </div>
                    <div class="team__text">
                        <h5>Đào Đức Khải</h5>
                        <span>Technical Director</span>
                        <p>Expert in plastic production technology</p>
                    </div>
                </div>
            </div>
            <!-- Member 3 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team__item text-center">
                    <div class="team__pic">
                        <img src="{{ asset('img/vu.jpg') }}" alt="Sales">
                    </div>
                    <div class="team__text">
                        <h5>Nguyễn Hoàng Vũ</h5>
                        <span>Sales Manager</span>
                        <p>Market and customer development</p>
                    </div>
                </div>
            </div>
            <!-- Member 4 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team__item text-center">
                    <div class="team__pic">
                        <img src="{{ asset('img/tuan.jpg') }}" alt="Marketing">
                    </div>
                    <div class="team__text">
                        <h5>Nguyễn Phan Ngọc Tuấn</h5>
                        <span>Marketing Manager</span>
                        <p>Brand and communication strategy</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<style>
    .about__pic img {
        width: 100%;
        border-radius: 10px;
    }

    .about__achievement__item {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .about__achievement__item h4 {
        font-size: 2rem;
        color: #7fad39;
        font-weight: bold;
    }

    .mission__item {
        padding: 30px 20px;
    }

    .mission__icon {
        font-size: 3rem;
        color: #7fad39;
        margin-bottom: 20px;
    }

    .team__pic img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
    }
</style>
@endsection