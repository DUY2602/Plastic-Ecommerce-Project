@extends('layouts.app')

@section('title', 'Giới thiệu - Plastic Store')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Giới thiệu</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <span>Giới thiệu</span>
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
                    <img src="{{ asset('img/polysite-logo.jpg') }}" alt="Về chúng tôi">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__text">
                    <div class="section-title">
                        <span>Về chúng tôi</span>
                        <h2>Plastic Store - Chuyên gia sản phẩm nhựa</h2>
                    </div>
                    <p>Với hơn 10 năm kinh nghiệm trong ngành sản xuất và phân phối sản phẩm nhựa,
                        chúng tôi tự hào là đối tác tin cậy của hàng trăm doanh nghiệp và khách hàng cá nhân.</p>
                    <p>Chuyên cung cấp các sản phẩm nhựa PET, PP, PC chất lượng cao, đảm bảo an toàn
                        vệ sinh thực phẩm và thân thiện với môi trường.</p>

                    <div class="about__achievement">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="about__achievement__item">
                                    <h4>500+</h4>
                                    <p>Khách hàng</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="about__achievement__item">
                                    <h4>50+</h4>
                                    <p>Sản phẩm</p>
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
                    <h4>Sứ mệnh</h4>
                    <p>Cung cấp sản phẩm nhựa chất lượng cao với giá cả cạnh tranh,
                        đáp ứng mọi nhu cầu của khách hàng.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="mission__item text-center">
                    <div class="mission__icon">
                        <i class="fa fa-eye"></i>
                    </div>
                    <h4>Tầm nhìn</h4>
                    <p>Trở thành công ty sản xuất và phân phối sản phẩm nhựa
                        hàng đầu Việt Nam vào năm 2025.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="mission__item text-center">
                    <div class="mission__icon">
                        <i class="fa fa-gem"></i>
                    </div>
                    <h4>Giá trị cốt lõi</h4>
                    <p>Chất lượng - An toàn - Thân thiện môi trường -
                        Phục vụ tận tâm - Đổi mới sáng tạo.</p>
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
                    <span>Đội ngũ của chúng tôi</span>
                    <h2>Đội ngũ chuyên nghiệp</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Thành viên 1 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team__item text-center">
                    <div class="team__pic">
                        <img src="{{ asset('img/duy.jpg') }}" alt="CEO">
                    </div>
                    <div class="team__text">
                        <h5>Đỗ Đức Duy</h5>
                        <span>CEO & Founder</span>
                        <p>15 năm kinh nghiệm trong ngành nhựa</p>
                    </div>
                </div>
            </div>
            <!-- Thành viên 2 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team__item text-center">
                    <div class="team__pic">
                        <img src="{{ asset('img/khai.jpg') }}" alt="CTO">
                    </div>
                    <div class="team__text">
                        <h5>Đào Đức Khải</h5>
                        <span>Giám đốc Kỹ thuật</span>
                        <p>Chuyên gia công nghệ sản xuất nhựa</p>
                    </div>
                </div>
            </div>
            <!-- Thành viên 3 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team__item text-center">
                    <div class="team__pic">
                        <img src="{{ asset('img/vu.jpg') }}" alt="Sales">
                    </div>
                    <div class="team__text">
                        <h5>Nguyễn Hoàng Vũ</h5>
                        <span>Trưởng phòng Kinh doanh</span>
                        <p>Phát triển thị trường và khách hàng</p>
                    </div>
                </div>
            </div>
            <!-- Thành viên 4 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team__item text-center">
                    <div class="team__pic">
                        <img src="{{ asset('img/tuan.jpg') }}" alt="Marketing">
                    </div>
                    <div class="team__text">
                        <h5>Nguyễn Phan Ngọc Tuấn</h5>
                        <span>Trưởng phòng Marketing</span>
                        <p>Chiến lược thương hiệu và truyền thông</p>
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