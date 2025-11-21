@extends('layouts.app')

@section('title', 'PolySite - Premium PET, PP, PC Bottles Manufacturer')

@section('content')
<!-- Copy NỘI DUNG chính từ file index.html của theme Ogani -->

<!-- Hero Section Begin -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Product Categories</span>
                    </div>
                    <ul>
                        <li><a href="#">PET Bottles</a></li>
                        <li><a href="#">PP Bottles</a></li>
                        <li><a href="#">PC Bottles</a></li>
                        <li><a href="#">Water Bottles</a></li>
                        <li><a href="#">Chemical Bottles</a></li>
                        <li><a href="#">Pharma Bottles</a></li>
                        <li><a href="#">Edible Oil Bottles</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do you need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/banner.jpg') }}">
                    <div class="hero__text">
                        <span>PREMIUM BOTTLES</span>
                        <h2>PET • PP • PC <br />Manufacturing Experts</h2>
                        <p>Free Download PDF Catalog Available</p>
                        <a href="#" class="primary-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/cat-1.jpg') }}">
                        <h5><a href="#">PET Bottles</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/cat-2.jpg') }}">
                        <h5><a href="#">PP Bottles</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/cat-3.jpg') }}">
                        <h5><a href="#">PC Bottles</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/cat-4.jpg') }}">
                        <h5><a href="#">Chemical Bottles</a></h5>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/cat-5.jpg') }}">
                        <h5><a href="#">Pharma Bottles</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Continue copying other sections from index.html -->
<!-- Featured Product Section -->
<!-- Latest Product Section -->
<!-- Blog Section -->
<!-- etc... -->

@endsection