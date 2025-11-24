@extends('layouts.app')

@section('title', 'Our Products - PET, PP, PC Bottles | PolySite')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Our Products</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ url('/') }}">Home</a>
                        <span>Products</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Material Type</h4>
                        <ul>
                            <li><a href="#">PET Bottles</a></li>
                            <li><a href="#">PP Bottles</a></li>
                            <li><a href="#">PC Bottles</a></li>
                            <li><a href="#">HDPE Bottles</a></li>
                        </ul>
                    </div>
                    <div class="sidebar__item">
                        <h4>Industries</h4>
                        <ul>
                            <li><a href="#">Drinking Water</a></li>
                            <li><a href="#">Pharmaceuticals</a></li>
                            <li><a href="#">Household Chemicals</a></li>
                            <li><a href="#">Edible Oils</a></li>
                            <li><a href="#">Liquor & Beverages</a></li>
                            <li><a href="#">Hair Care</a></li>
                            <li><a href="#">Pesticides</a></li>
                        </ul>
                    </div>
                    <div class="sidebar__item">
                        <h4>Capacity</h4>
                        <div class="price-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="10" data-max="5000">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            </div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar__item">
                        <div class="latest-product__text">
                            <h4>Latest Products</h4>
                            <div class="latest-product__slider owl-carousel">
                                <div class="latest-prdouct__slider__item">
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{ asset('img/latest-product/lp-1.jpg') }}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>500ml PET Water Bottle</h6>
                                            <span>$0.15</span>
                                        </div>
                                    </a>
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{ asset('img/latest-product/lp-2.jpg') }}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>1L PP Chemical Bottle</h6>
                                            <span>$0.25</span>
                                        </div>
                                    </a>
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{ asset('img/latest-product/lp-3.jpg') }}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>250ml PC Pharma Bottle</h6>
                                            <span>$0.35</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7">
                <div class="product__discount">
                    <div class="section-title product__discount__title">
                        <h2>Featured Products</h2>
                    </div>
                    <div class="row">
                        <div class="product__discount__slider owl-carousel">
                            <div class="col-lg-4">
                                <div class="product__discount__item">
                                    <div class="product__discount__item__pic set-bg"
                                        data-setbg="{{ asset('img/product/discount/pd-1.jpg') }}">
                                        <div class="product__discount__percent">-20%</div>
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__discount__item__text">
                                        <span>PET Bottles</span>
                                        <h5><a href="{{url('product/1')}}">1L Mineral Water Bottle</a></h5>
                                        <div class="product__item__price">$0.12 <span>$0.15</span></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Thêm more featured products here -->
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select>
                                    <option value="0">Default</option>
                                    <option value="0">Price (Low to High)</option>
                                    <option value="0">Price (High to Low)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>16</span> Products found</h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Product Items -->
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset('img/product/product-1.jpg') }}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <span class="badge badge-pet">PET</span>
                                <h6><a href="#">500ml Water Bottle</a></h6>
                                <h5>$0.08</h5>
                                <div class="product-details-link">
                                    <a href="{{ url('/product/1') }}" class="view-details">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Thêm more products here -->
                </div>
                <div class="product__pagination">
                    <a href="#">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection