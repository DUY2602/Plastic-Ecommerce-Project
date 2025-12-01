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

<!-- Product Search Section -->
<section class="hero hero-normal" style="margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Danh mục</span>
                    </div>
                    <ul class="category-dropdown">
                        <li><a href="#" data-category="">Tất cả danh mục</a></li>
                        @foreach($categories as $category)
                        <li><a href="#" data-category="{{ $category->CategoryName }}">{{ $category->CategoryName }}</a></li>
                        @endforeach
                    </ul>

                    <!-- Hiển thị category đã chọn -->
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
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
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

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <span>Sắp xếp theo</span>
                            <select name="sort_by" id="sort-select">
                                <option value="default" {{ request('sort_by', 'default') == 'default' ? 'selected' : '' }}>Mặc định</option>
                                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span id="product-count">{{ $products->count() }}</span> sản phẩm được tìm thấy</h6>
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
                                            <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}" title="Yêu thích">
                                                @if(isset($favoriteProductIds) && in_array($product->ProductID, $favoriteProductIds))
                                                <i class="fa fa-heart heart-icon" style="color: #ff0000"></i>
                                                @else
                                                <i class="fa fa-heart heart-icon" style="color: #000000ff"></i>
                                                @endif
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('product.download', $product->ProductID) }}" class="download-btn" title="Tải tài liệu">
                                                <i class="fa fa-download download-icon"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ route('product.detail', $product->ProductID) }}" class="product-link">{{ $product->ProductName }}</a></h6>
                                    <h5>từ {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
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
<script>
    $(document).ready(function() {
        let currentCategory = '';
        let currentSearch = '';
        let currentSort = 'default';

        // Hàm cập nhật giao diện category
        function updateCategoryUI(categoryName) {
            // Xóa active cũ
            $('.category-dropdown a').removeClass('active');

            // Thêm active cho category được chọn
            if (categoryName) {
                $(`.category-dropdown a[data-category="${categoryName}"]`).addClass('active');
                $('#selected-category-name').text(categoryName);
                $('#category-selected').slideDown(300);
            } else {
                $(`.category-dropdown a[data-category=""]`).addClass('active');
                $('#category-selected').slideUp(300);
            }
        }

        // Khởi tạo category UI
        updateCategoryUI('');

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

        // Xử lý click danh mục
        $(document).on('click', '.category-dropdown a', function(e) {
            e.preventDefault();
            e.stopPropagation();

            currentCategory = $(this).data('category') || '';

            // Cập nhật giao diện
            updateCategoryUI(currentCategory);

            // Đóng dropdown
            $('.category-dropdown').slideUp(300);
            $('.hero__categories__all').removeClass('active');

            // Load sản phẩm
            loadProducts();
        });

        // Xử lý xóa category
        $(document).on('click', '#clear-category', function(e) {
            e.preventDefault();
            e.stopPropagation();

            currentCategory = '';
            updateCategoryUI('');
            loadProducts();
        });

        // Xử lý tìm kiếm
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            currentSearch = $('input[name="search"]').val();
            loadProducts();
        });

        // Xử lý sắp xếp
        $('#sort-select').on('change', function() {
            currentSort = $(this).val();
            loadProducts();
        });

        // Hàm load sản phẩm
        function loadProducts() {
            console.log('Loading products:', {
                search: currentSearch,
                sort: currentSort,
                category: currentCategory
            });

            // Hiển thị loading
            $('#product-list').addClass('loading');

            $.ajax({
                url: '{{ route("products.index") }}',
                type: 'GET',
                data: {
                    search: currentSearch,
                    sort_by: currentSort,
                    category: currentCategory,
                    ajax: true
                },
                success: function(response) {
                    // Cập nhật danh sách sản phẩm
                    $('#product-list .row').html(response.html);
                    $('#product-count').text(response.count);
                    $('#product-list').removeClass('loading');
                    attachFavoriteEvents();
                },
                error: function(xhr) {
                    console.log('AJAX error:', xhr.responseText);
                    $('#product-list').removeClass('loading');
                    alert('Có lỗi xảy ra khi tải sản phẩm');
                }
            });
        }

        // Xử lý nút yêu thích
        function attachFavoriteEvents() {
            $('.favorite-btn').off('click').on('click', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                var heartIcon = $(this).find('.heart-icon');
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
                            heartIcon.css('color', '#ff0000');
                            button.addClass('active');
                            alert('Đã thêm vào danh sách yêu thích');
                        } else {
                            heartIcon.css('color', '#010101ff');
                            button.removeClass('active');
                            alert('Đã xóa khỏi danh sách yêu thích');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            alert('Vui lòng đăng nhập để thêm sản phẩm yêu thích');
                            window.location.href = '{{ route("login") }}';
                        } else {
                            alert('Có lỗi xảy ra, vui lòng thử lại');
                        }
                    }
                });
            });
        }

        // Gắn sự kiện ban đầu
        attachFavoriteEvents();
    });
</script>

<style>
    /* === LOADING === */
    .loading {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }

    .loading:after {
        content: "Đang tải sản phẩm...";
        display: block;
        text-align: center;
        padding: 40px;
        color: #7fad39;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* === CATEGORY DROPDOWN === */
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
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: 1px solid #e5e5e5;
        list-style: none;
        padding: 8px 0;
        margin: 0;
        display: none;
        z-index: 1001;
        border-radius: 8px;
        max-height: 300px;
        overflow-y: auto;
    }

    .category-dropdown li {
        border-bottom: 1px solid #f8f9fa;
        transition: all 0.3s ease;
    }

    .category-dropdown li:last-child {
        border-bottom: none;
    }

    .category-dropdown li:hover {
        background: rgba(127, 173, 57, 0.05);
    }

    .category-dropdown a {
        display: block;
        padding: 12px 20px;
        color: #333;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        font-weight: 500;
        text-decoration: none !important;
    }

    .category-dropdown a:hover {
        background: rgba(127, 173, 57, 0.1);
        color: #7fad39;
        padding-left: 30px;
        transform: translateX(5px);
    }

    /* Category active state */
    .category-dropdown a.active {
        background: linear-gradient(135deg, #7fad39, #6b8e23);
        color: white;
        font-weight: 600;
        padding-left: 30px;
    }

    .category-dropdown a.active:before {
        content: "✓";
        position: absolute;
        left: 12px;
        font-weight: bold;
        font-size: 14px;
    }

    /* === SELECTED CATEGORY DISPLAY === */
    .category-selected {
        background: linear-gradient(135deg, #7fad39, #6b8e23);
        color: white;
        padding: 12px 15px;
        border-radius: 8px;
        margin-top: 10px;
        display: none;
        font-weight: 600;
        text-align: center;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(127, 173, 57, 0.3);
        animation: slideDown 0.3s ease;
    }

    .category-selected i {
        margin-right: 8px;
        font-size: 14px;
    }

    .clear-category-btn {
        color: white !important;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }

    .clear-category-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    /* === ANIMATIONS === */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* === HERO CATEGORIES ALL === */
    .hero__categories__all.active {
        background: #6b8e23;
    }

    .hero__categories__all.active i {
        transform: rotate(90deg);
    }

    .hero__categories__all i {
        transition: transform 0.3s ease;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .category-dropdown {
            position: static;
            box-shadow: none;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            margin-top: 10px;
        }

        .category-selected {
            margin-top: 15px;
        }
    }
</style>
@endsection