@extends('layouts.app')

@section('title', 'Products - Plastic Store')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>All Products</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Search Section -->
<section class="hero hero-normal" style="margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Categories</span>
                    </div>
                    <ul class="category-dropdown">
                        <li><a href="#" data-category="">All Categories</a></li>
                        @foreach($categories as $category)
                        <li><a href="#" data-category="{{ $category->CategoryName }}">{{ $category->CategoryName }}</a></li>
                        @endforeach
                    </ul>

                    <!-- Display selected category -->
                    <div class="category-selected" id="category-selected" style="display: none;">
                        <i class="fa fa-tag"></i>
                        <span id="selected-category-name"></span>
                        <a href="#" id="clear-category" class="clear-category-btn">✕</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form id="search-form">
                            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <a href="tel:+84901234567"><i class="fa fa-phone"></i></a>
                        </div>
                        <div class="hero__search__phone__text">
                            </a>
                            <h5>+84 929 097 779</h5>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <span>Sort by</span>
                            <select name="sort_by" id="sort-select">
                                <option value="default" {{ request('sort_by', 'default') == 'default' ? 'selected' : '' }}>Default</option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span id="product-count">{{ $products->count() }}</span> products found</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product List Container -->
                <div id="product-list">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                            <div class="product__item">
                                <div class="product__item__pic">
                                    <img src="{{ asset($product->Photo) }}" alt="{{ $product->ProductName }}" class="img-fluid">
                                    <ul class="product__item__pic__hover">
                                        <li>
                                            <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}" title="Favorite">
                                                @if(isset($favoriteProductIds) && in_array($product->ProductID, $favoriteProductIds))
                                                <i class="fa fa-heart heart-icon" style="color: #ff0000"></i>
                                                @else
                                                <i class="fa fa-heart heart-icon" style="color: #000000ff"></i>
                                                @endif
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('product.download', $product->ProductID) }}" class="download-btn" title="Download document">
                                                <i class="fa fa-download download-icon"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ route('product.detail', $product->ProductID) }}" class="product-link">{{ $product->ProductName }}</a></h6>
                                    <h5 class="product-price">{{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection

@section('scripts')
<script src="{{ asset('js/products/index.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection