@extends('layouts.app')

@section('title', 'Home - Plastic Store')

@section('content')
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero__text">
                    <h1>High-Quality Plastic Bottle Manufacturer</h1>
                    <p>Specializing in providing PET, PP, PC plastic bottles with superior quality, competitive prices, and dedicated service</p>
                    <a href="{{ route('products.index') }}" class="primary-btn">EXPLORE PRODUCTS</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero__image">
                    <img src="{{ asset('img/home-intro.jpg') }}" alt="Plastic Bottles" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="feature__item">
                    <div class="feature__item__icon">
                        <i class="fa fa-shield-alt"></i>
                    </div>
                    <h5>Quality Guaranteed</h5>
                    <p>Products meet international quality standards, safe for health</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature__item">
                    <div class="feature__item__icon">
                        <i class="fa fa-cube"></i>
                    </div>
                    <h5>Diverse Designs</h5>
                    <p>Various PET, PP, PC plastic bottles with diverse sizes and colors</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature__item">
                    <div class="feature__item__icon">
                        <i class="fa fa-headset"></i>
                    </div>
                    <h5>Professional Consultation</h5>
                    <p>Professional consulting team ready to support customers</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="categories spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Product Categories</h2>
                    <p>Discover our high-quality plastic bottle product lines</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="categories__item">
                    <div class="categories__item__image">
                        @php
                        $sluggedName = \Illuminate\Support\Str::slug($category->CategoryName, '-');
                        @endphp
                        <img src="{{ asset('img/categories/' . $sluggedName . '.jpg') }}"
                            alt="{{ $category->CategoryName }}"
                            class="img-fluid categories__img">
                    </div>
                    <div class="categories__item__text">
                        <h4>{{ $category->CategoryName }}</h4>
                        <p>{{ $category->Description }}</p>
                        <a href="{{ route('category', $sluggedName) }}" class="categories__link">
                            View Products
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Products</h2>
                    <p>Most popular products</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="featured__item">
                    <div class="featured__item__pic">
                        <img src="{{ asset($product->Photo) }}"
                            alt="{{ $product->ProductName }}"
                            class="img-fluid featured__img">

                        <ul class="featured__item__pic__hover">
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}" title="Add to Favorites">
                                    @if(isset($favoriteProductIds) && in_array($product->ProductID, $favoriteProductIds))
                                    <i class="fa fa-heart heart-icon" style="color: #ff0000"></i>
                                    @else
                                    <i class="fa fa-heart heart-icon" style="color: #000000ff"></i>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('product.download', $product->ProductID) }}" class="download-btn" title="Download Documents">
                                    <i class="fa fa-download download-icon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="{{ route('product.detail', $product->ProductID) }}" class="product-link">{{ $product->ProductName }}</a></h6>
                        @if($product->variants && $product->variants->isNotEmpty())
                        <h5 class="product-price">{{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
                        @else
                        <h5>Contact for Price</h5>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="{{ route('products.index') }}" class="primary-btn view-all-btn">
                    VIEW ALL PRODUCTS
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ADDED SECTION: Favorite Products -->
@auth
<section class="favorite-products spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Your Favorite Products</h2>
                    <p>Products you have added to your favorites list</p>
                </div>
            </div>
        </div>

        @if($favoriteProducts->count() > 0)
        <div class="row">
            @foreach($favoriteProducts as $product)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                <div class="favorite__item">
                    <div class="favorite__item__pic">
                        <img src="{{ asset($product->Photo) }}"
                            alt="{{ $product->ProductName }}"
                            class="img-fluid favorite__img">

                        <ul class="favorite__item__pic__hover">
                            <li>
                                <a href="#" class="favorite-btn active" data-product-id="{{ $product->ProductID }}" title="Remove from Favorites">
                                    <i class="fa fa-heart heart-icon" style="color: #000000"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ asset($product->DocumentURL) }}" class="download-btn" target="_blank" title="Download Documents">
                                    <i class="fa fa-download download-icon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="favorite__item__text">
                        <h6><a href="{{ route('product.detail', $product->ProductID) }}" class="product-link">{{ $product->ProductName }}</a></h6>
                        @if($product->variants && $product->variants->isNotEmpty())
                        <h5 class="product-price">{{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
                        @else
                        <h5>Contact for Price</h5>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="empty-favorites">
                    <i class="fa fa-heart" style="font-size: 60px; color: #ddd; margin-bottom: 20px;"></i>
                    <h5>You don't have any favorite products yet</h5>
                    <p>Add products to your favorites list to view them here!</p>
                    <a href="{{ route('products.index') }}" class="primary-btn" style="margin-top: 15px;">
                        <i class="fa fa-shopping-bag"></i> EXPLORE PRODUCTS
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($favoriteProducts->count() > 6)
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="{{ route('favorites.index') }}" class="primary-btn view-all-btn">
                    VIEW ALL FAVORITE PRODUCTS
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @endif
    </div>
</section>
@endauth
<!-- END OF ADDED SECTION -->

<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>News & Blog</h2>
                    <p>Latest updates from the plastics industry</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($latestBlogs as $blog)
            @if($blog)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="{{ asset($blog->Image) }}"
                            alt="{{ $blog->Title }}"
                            class="img-fluid blog__img">
                    </div>
                    <div class="blog__item__text">
                        <h5><a href="{{ route('blog.show', $blog->BlogID) }}" class="blog-link">{{ $blog->Title }}</a></h5>
                        <p>{{ Str::limit(strip_tags($blog->Content ?? 'Content is being updated.'), 100) }}</p>
                        <div class="blog__item__info">
                            <span><i class="fa fa-user"></i> {{ $blog->Author ?? 'Administrator' }}</span>
                            <span><i class="fa fa-calendar"></i> {{ $blog->created_at?->format('m/d/Y') ?? 'Updating' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

<section class="cta spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="cta__text">
                    <h3>Need Product Consultation?</h3>
                    <p>Our team of experts is ready to help you choose the right products</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="primary-btn cta-btn">
                    CONTACT FOR CONSULTATION
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/home.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection