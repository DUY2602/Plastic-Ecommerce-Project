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
            </div>@extends('layouts.app')

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
                                    <div class="col-lg-4 col-md-4">
                                        <span>Sắp xếp theo</span>
                                        <form id="sort-form" method="GET" action="{{ url()->current() }}">
                                            {{-- Giữ lại các parameters --}}
                                            @if(request('search'))
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            @endif
                                            @if(request('category'))
                                            <input type="hidden" name="category" value="{{ request('category') }}">
                                            @endif

                                            {{-- THÊM onchange VÀO ĐÂY --}}
                                            <select name="sort_by" id="sort-select" onchange="this.form.submit()">
                                                <option value="default" {{ request('sort_by', 'default') == 'default' ? 'selected' : '' }}>Mặc định</option>
                                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="filter__found">
                                            <h6><span>{{ $products->count() }}</span> sản phẩm được tìm thấy</h6>
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
                                                        <!-- KIỂM TRA NẾU BIẾN TỒN TẠI -->
                                                        @if(isset($favoriteProductIds) && in_array($product->ProductID, $favoriteProductIds))
                                                        <i class="fa fa-heart text-red"></i>
                                                        @else
                                                        <i class="fa fa-heart text-black"></i>
                                                        @endif
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
                        </div>
                    </div>
                </div>
            </section>
            <!-- Product Section End -->
            @endsection

            @section('scripts')
            <script>
                console.log('Script section loaded');

                // Kiểm tra xem jQuery có sẵn sàng không
                if (typeof jQuery === 'undefined') {
                    console.error('jQuery is not loaded!');
                } else {
                    console.log('jQuery version:', jQuery.fn.jquery);
                }

                $(document).ready(function() {
                    console.log('Document ready executed');
                    console.log('Sort select found:', $('#sort-select').length);
                    console.log('Sort form found:', $('#sort-form').length);

                    // Xử lý thay đổi sắp xếp
                    $('#sort-select').on('change', function() {
                        console.log('SELECT CHANGED TO:', $(this).val());
                        console.log('Submitting form...');
                        $('#sort-form').submit();
                    });

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
                        console.log('Favorite button clicked');

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
                                    heartIcon.css('color', '#ff0000');
                                    alert('Đã thêm vào danh sách yêu thích');
                                } else {
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
                .text-red {
                    color: #ff0000;
                }

                .text-black {
                    color: #000000;
                }

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
            <div class="col-lg-9">
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <span>Sắp xếp theo</span>
                            <form id="sort-form" method="GET" action="{{ url()->current() }}">
                                {{-- Giữ lại các parameters --}}
                                @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif

                                {{-- THÊM onchange VÀO ĐÂY --}}
                                <select name="sort_by" id="sort-select" onchange="this.form.submit()">
                                    <option value="default" {{ request('sort_by', 'default') == 'default' ? 'selected' : '' }}>Mặc định</option>
                                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>{{ $products->count() }}</span> sản phẩm được tìm thấy</h6>
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
                                            <!-- KIỂM TRA NẾU BIẾN TỒN TẠI -->
                                            @if(isset($favoriteProductIds) && in_array($product->ProductID, $favoriteProductIds))
                                            <i class="fa fa-heart text-red"></i>
                                            @else
                                            <i class="fa fa-heart text-black"></i>
                                            @endif
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
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection

@section('scripts')
<script>
    console.log('Script section loaded');

    // Kiểm tra xem jQuery có sẵn sàng không
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded!');
    } else {
        console.log('jQuery version:', jQuery.fn.jquery);
    }

    $(document).ready(function() {
        console.log('Document ready executed');
        console.log('Sort select found:', $('#sort-select').length);
        console.log('Sort form found:', $('#sort-form').length);

        // Xử lý thay đổi sắp xếp
        $('#sort-select').on('change', function() {
            console.log('SELECT CHANGED TO:', $(this).val());
            console.log('Submitting form...');
            $('#sort-form').submit();
        });

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
            console.log('Favorite button clicked');

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
                        heartIcon.css('color', '#ff0000');
                        alert('Đã thêm vào danh sách yêu thích');
                    } else {
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
    .text-red {
        color: #ff0000;
    }

    .text-black {
        color: #000000;
    }

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