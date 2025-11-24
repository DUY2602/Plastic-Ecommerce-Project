@extends('layouts.user')

@section('title', 'Trang chủ - Plastic Store')

@section('user-content')
<!-- Hero Item Section -->
<div class="hero__item set-bg" data-setbg="{{ asset('img/hero/banner.jpg') }}">
    <div class="hero__text">
        <span>NHỰA CHẤT LƯỢNG CAO</span>
        <h2>Plastic <br />100% An toàn</h2>
        <p>Miễn phí vận chuyển toàn quốc</p>
        <a href="{{ route('products') }}" class="primary-btn">MUA NGAY</a>
    </div>
</div>

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                @foreach($categories as $category)
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/cat-1.jpg') }}">
                        <h5><a href="{{ route('category', strtolower($category->CategoryName)) }}">{{ $category->CategoryName }}</a></h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Featured Product Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm nổi bật</h2>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mix {{ strtolower($product->category->CategoryName) }}">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="{{ asset($product->Photo) }}">
                        <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="{{ route('product.detail', $product->ProductID) }}">{{ $product->ProductName }}</a></h6>
                        <h5> từ {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Product Section End -->

<!-- Banner Section Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="{{ asset('img/banner/banner-1.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="{{ asset('img/banner/banner-2.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Section End -->
@endsection