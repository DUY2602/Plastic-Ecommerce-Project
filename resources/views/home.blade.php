@extends('layouts.app')

@section('title', 'Trang chủ - Plastic Store')

@section('content')
<!-- Hero Section -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Danh mục</span>
                    </div>
                    <ul class="category-dropdown">
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
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm...">
                            <button type="submit" class="site-btn">TÌM KIẾM</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+84 123 456 789</h5>
                            <span>Hỗ trợ 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm nổi bật</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="{{ asset($product->Photo) }}" style="height: 180px; width: 100%; background-size: contain; background-position: center; background-repeat: no-repeat;">
                        <ul class="featured__item__pic__hover">
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}">
                                    <i class="fa fa-heart" style="color: <?php echo in_array($product->ProductID, $favoriteProductIds) ? '#ff0000' : '#000000'; ?>"></i>
                                </a>
                            </li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="{{ route('product.detail', $product->ProductID) }}">{{ $product->ProductName }}</a></h6>
                        <h5>từ {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Wishlist Section (nếu có sản phẩm yêu thích) -->
@if(count($favoriteProducts) > 0)
<section class="wishlist spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm yêu thích</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($favoriteProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="{{ asset($product->Photo) }}">
                        <ul class="featured__item__pic__hover">
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}">
                                    <!-- TRÁI TIM MÀU ĐỎ CHO SẢN PHẨM YÊU THÍCH -->
                                    <i class="fa fa-heart" style="color: #ff0000;"></i>
                                </a>
                            </li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="{{ route('product.detail', $product->ProductID) }}">{{ $product->ProductName }}</a></h6>
                        <h5>từ {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Dropdown danh mục - hover effect
        $('.hero__categories').hover(
            function() {
                $(this).find('.category-dropdown').stop(true, true).slideDown(300);
                $(this).find('.hero__categories__all').addClass('active');
            },
            function() {
                $(this).find('.category-dropdown').stop(true, true).slideUp(300);
                $(this).find('.hero__categories__all').removeClass('active');
            }
        );

        // Xử lý click nút yêu thích
        $('.favorite-btn').click(function(e) {
            e.preventDefault();

            var productId = $(this).data('product-id');
            var heartIcon = $(this).find('i');
            var button = $(this);

            $.ajax({
                url: '{{ route("favorite.toggle") }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'added') {
                        // Thêm vào yêu thích - chuyển sang màu đỏ
                        heartIcon.css('color', '#ff0000');
                        alert('Đã thêm vào danh sách yêu thích');
                    } else {
                        // Xóa khỏi yêu thích - chuyển sang màu đen
                        heartIcon.css('color', '#000000');
                        alert('Đã xóa khỏi danh sách yêu thích');

                        // Nếu đang ở trang wishlist, xóa sản phẩm khỏi view
                        if ($('.wishlist').length) {
                            button.closest('.col-lg-3').remove();

                            // Nếu không còn sản phẩm yêu thích, ẩn section
                            if ($('.wishlist .col-lg-3').length === 0) {
                                $('.wishlist').hide();
                            }
                        }
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                }
            });
        });
    });
</script>

<style>
    /* CSS cho dropdown danh mục */
    .hero__categories {
        position: relative;
        z-index: 1000;
    }

    .category-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e5e5;
        list-style: none;
        padding: 10px 0;
        margin: 0;
        display: none;
        z-index: 1001;
        border-radius: 0 0 5px 5px;
    }

    .category-dropdown li {
        border-bottom: 1px solid #f1f1f1;
    }

    .category-dropdown li:last-child {
        border-bottom: none;
    }

    .category-dropdown a {
        display: block;
        padding: 10px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .category-dropdown a:hover {
        background: #f8f9fa;
        color: #7fad39;
        padding-left: 25px;
    }

    .hero__categories__all.active {
        background: #6b8e23;
    }
</style>
@endsection