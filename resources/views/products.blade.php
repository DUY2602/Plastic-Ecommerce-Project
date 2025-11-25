@extends('layouts.app')

@section('title', 'Sản phẩm - Plastic Store')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Tất cả sản phẩm</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <span>Sản phẩm</span>
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
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sắp xếp theo</span>
                                <select>
                                    <option value="0">Mặc định</option>
                                    <option value="0">Giá thấp đến cao</option>
                                    <option value="0">Giá cao đến thấp</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>{{ $products->total() }}</span> sản phẩm được tìm thấy</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset($product->Photo) }}">
                                <ul class="product__item__pic__hover">
                                    <li>
                                        <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}">
                                            <!-- LUÔN HIỂN THỊ TRÁI TIM -->
                                            <i class="fa fa-heart"
                                                style="@if(in_array($product->ProductID, $favoriteProductIds)) color: #ff0000; @else color: #000000; @endif"></i>
                                        </a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ route('product.detail', $product->ProductID) }}">{{ $product->ProductName }}</a></h6>
                                <h5>từ {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="product__pagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
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