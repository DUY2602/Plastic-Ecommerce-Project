@extends('layouts.app')

@section('content')
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Categories</span>
                    </div>
                    {{-- This line uses the $categories variable, already fixed in FavoriteController.php --}}
                    <ul>
                        @foreach($categories as $category)
                        <li><a href="{{ route('category', strtolower($category->CategoryName)) }}">{{ $category->CategoryName }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="{{ route('products.index') }}">
                            <input type="text" name="search" placeholder="Search products...">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+84 123 456 789</h5>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Favorite Products</h2>
                </div>
            </div>
        </div>

        @if(isset($favoriteProducts) && count($favoriteProducts) > 0)
        <div class="row featured__filter">
            @foreach($favoriteProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mix">
                <div class="featured__item">
                    {{-- Product Image --}}
                    <div class="featured__item__pic set-bg" data-setbg="{{ asset($product->Photo ? str_replace('/images/', '/img/', $product->Photo) : 'img/product/default.jpg') }}">
                        <ul class="featured__item__pic__hover">
                            {{-- Favorite Button (Since it's favorites, only remove action) --}}
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}">
                                    {{-- In Favorites page, always show full heart --}}
                                    <i class="fa fa-heart" style="color: red;"></i>
                                </a>
                            </li>
                            <li><a href="{{ route('product.detail', $product->ProductID) }}"><i class="fa fa-eye"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="{{ route('product.detail', $product->ProductID) }}">{{ $product->ProductName }}</a></h6>
                        {{-- Assuming product->variants is a relationship and eagerly loaded --}}
                        <h5>from {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}₫</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-heart-o fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No Favorite Products Yet</h4>
            <p class="text-muted">Add products to your favorites list</p>
            <a href="{{ route('products.index') }}" class="site-btn">SHOP NOW</a>
        </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.favorite-btn').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            var button = $(this);

            $.ajax({
                url: '{{ route("favorite.toggle") }}',
                type: 'POST',
                data: {
                    product_id: productId
                    // 🔥 REMOVE _token: '{{ csrf_token() }}' since $.ajaxSetup is configured in app.blade.php
                },
                success: function(response) {
                    if (response.status === 'removed') {
                        // Remove product from DOM when successfully removed
                        button.closest('.col-lg-3').remove();

                        // If no products left, reload page to show "No Favorite Products Yet" message
                        if ($('.col-lg-3').length === 0) {
                            location.reload();
                        }
                    }
                    alert(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle errors in more detail
                    var errorMessage = "Unknown error.";
                    if (xhr.status === 401) {
                        errorMessage = "Please login to perform this action.";
                    } else if (xhr.status === 419) {
                        errorMessage = "Session expired (419 Page Expired). Please refresh the page.";
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = "Error: " + xhr.responseJSON.message;
                    }

                    console.error("AJAX Error Status:", xhr.status, error);
                    alert("An error occurred: " + errorMessage);
                }
            });
        });
    });
</script>
@endsection