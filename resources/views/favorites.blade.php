@extends('layouts.app')

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
                        <form action="{{ route('products') }}">
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

<!-- Wishlist Section -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm yêu thích</h2>
                </div>
            </div>
        </div>
        @if(count($favoriteProducts) > 0)
        <div class="row">
            @foreach($favoriteProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="{{ asset($product->Photo) }}">
                        <ul class="featured__item__pic__hover">
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}">
                                    <i class="fa fa-heart"></i>
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
        @else
        <div class="text-center py-5">
            <i class="fa fa-heart-o fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Chưa có sản phẩm yêu thích</h4>
            <p class="text-muted">Hãy thêm sản phẩm vào danh sách yêu thích của bạn</p>
            <a href="{{ route('products') }}" class="site-btn">MUA SẮM NGAY</a>
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
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'removed') {
                        button.closest('.col-lg-3').remove();

                        if ($('.col-lg-3').length === 0) {
                            location.reload();
                        }
                    }
                }
            });
        });
    });
</script>
@endsection