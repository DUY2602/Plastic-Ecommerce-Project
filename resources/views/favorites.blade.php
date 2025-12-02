@extends('layouts.app')

@section('content')
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Danh mục</span>
                    </div>
                    {{-- Dòng này dùng biến $categories, đã được fix trong FavoriteController.php --}}
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
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm yêu thích</h2>
                </div>
            </div>
        </div>

        @if(isset($favoriteProducts) && count($favoriteProducts) > 0)
        <div class="row featured__filter">
            @foreach($favoriteProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mix">
                <div class="featured__item">
                    {{-- Ảnh sản phẩm --}}
                    <div class="featured__item__pic set-bg" data-setbg="{{ asset($product->Photo ? str_replace('/images/', '/img/', $product->Photo) : 'img/product/default.jpg') }}">
                        <ul class="featured__item__pic__hover">
                            {{-- Nút yêu thích (Đã là yêu thích nên chỉ có hành động xóa) --}}
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}">
                                    {{-- Khi ở trang Favorites, luôn hiển thị trái tim đầy --}}
                                    <i class="fa fa-heart" style="color: red;"></i>
                                </a>
                            </li>
                            <li><a href="{{ route('product.detail', $product->ProductID) }}"><i class="fa fa-eye"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="{{ route('product.detail', $product->ProductID) }}">{{ $product->ProductName }}</a></h6>
                        {{-- Giả định product->variants là mối quan hệ và đã được eager load --}}
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
            <a href="{{ route('products.index') }}" class="site-btn">MUA SẮM NGAY</a>
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
                    // 🔥 BỎ DÒNG _token: '{{ csrf_token() }}' vì đã cấu hình $.ajaxSetup trong app.blade.php
                },
                success: function(response) {
                    if (response.status === 'removed') {
                        // Xóa sản phẩm khỏi DOM khi đã xóa thành công
                        button.closest('.col-lg-3').remove();

                        // Nếu không còn sản phẩm nào, tải lại trang để hiển thị thông báo "Chưa có sản phẩm yêu thích"
                        if ($('.col-lg-3').length === 0) {
                            location.reload();
                        }
                    }
                    alert(response.message);
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi chi tiết hơn
                    var errorMessage = "Lỗi không xác định.";
                    if (xhr.status === 401) {
                        errorMessage = "Vui lòng đăng nhập để thực hiện hành động này.";
                    } else if (xhr.status === 419) {
                        errorMessage = "Phiên làm việc đã hết hạn (419 Page Expired). Vui lòng làm mới trang.";
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = "Lỗi: " + xhr.responseJSON.message;
                    }

                    console.error("AJAX Error Status:", xhr.status, error);
                    alert("Có lỗi xảy ra: " + errorMessage);
                }
            });
        });
    });
</script>
@endsection