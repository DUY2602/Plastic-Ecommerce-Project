@extends('layouts.app')

@section('title', 'Trang chủ - Plastic Store')

@section('content')
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero__text">
                    <h1>Nhà sản xuất chai nhựa chất lượng cao</h1>
                    <p>Chuyên cung cấp các loại chai nhựa PET, PP, PC với chất lượng vượt trội, giá cả cạnh tranh và dịch vụ tận tâm</p>
                    <a href="{{ route('products.index') }}" class="primary-btn">KHÁM PHÁ SẢN PHẨM</a>
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
                    <h5>Chất lượng đảm bảo</h5>
                    <p>Sản phẩm đạt tiêu chuẩn chất lượng quốc tế, an toàn cho sức khỏe</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature__item">
                    <div class="feature__item__icon">
                        <i class="fa fa-cube"></i>
                    </div>
                    <h5>Đa dạng mẫu mã</h5>
                    <p>Nhiều loại chai nhựa PET, PP, PC với kích thước và màu sắc đa dạng</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature__item">
                    <div class="feature__item__icon">
                        <i class="fa fa-headset"></i>
                    </div>
                    <h5>Tư vấn chuyên nghiệp</h5>
                    <p>Đội ngũ tư vấn chuyên nghiệp sẵn sàng hỗ trợ khách hàng</p>
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
                    <h2>Danh mục sản phẩm</h2>
                    <p>Khám phá các dòng sản phẩm chai nhựa chất lượng cao</p>
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
                            Xem sản phẩm
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
                    <h2>Sản phẩm nổi bật</h2>
                    <p>Những sản phẩm được ưa chuộng nhất</p>
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
                                <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}" title="Yêu thích">
                                    @if(Auth::check() && in_array($product->ProductID, $favoriteProductIds))
                                    <i class="fa fa-heart heart-icon" style="color: #000000"></i>
                                    @else
                                    <i class="fa fa-heart heart-icon" style="color: #cccccc"></i>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ asset($product->DocumentURL) }}" class="download-btn" target="_blank" title="Tải tài liệu">
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
                        <h5>Liên hệ</h5>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="{{ route('products.index') }}" class="primary-btn view-all-btn">
                    XEM TẤT CẢ SẢN PHẨM
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- PHẦN THÊM VÀO: Sản phẩm yêu thích -->
@auth
<section class="favorite-products spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm yêu thích của bạn</h2>
                    <p>Những sản phẩm bạn đã thêm vào danh sách yêu thích</p>
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
                                <a href="#" class="favorite-btn active" data-product-id="{{ $product->ProductID }}" title="Bỏ yêu thích">
                                    <i class="fa fa-heart heart-icon" style="color: #000000"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ asset($product->DocumentURL) }}" class="download-btn" target="_blank" title="Tải tài liệu">
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
                        <h5>Liên hệ</h5>
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
                    <h5>Bạn chưa có sản phẩm yêu thích nào</h5>
                    <p>Hãy thêm sản phẩm vào danh sách yêu thích để xem tại đây!</p>
                    <a href="{{ route('products.index') }}" class="primary-btn" style="margin-top: 15px;">
                        <i class="fa fa-shopping-bag"></i> KHÁM PHÁ SẢN PHẨM
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($favoriteProducts->count() > 6)
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="{{ route('favorites.index') }}" class="primary-btn view-all-btn">
                    XEM TẤT CẢ SẢN PHẨM YÊU THÍCH
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @endif
    </div>
</section>
@endauth
<!-- KẾT THÚC PHẦN THÊM VÀO -->

<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Tin tức & Blog</h2>
                    <p>Cập nhật những thông tin mới nhất về ngành nhựa</p>
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
                        <p>{{ Str::limit(strip_tags($blog->Content ?? 'Nội dung đang được cập nhật.'), 100) }}</p>
                        <div class="blog__item__info">
                            <span><i class="fa fa-user"></i> {{ $blog->Author ?? 'Quản trị viên' }}</span>
                            <span><i class="fa fa-calendar"></i> {{ $blog->created_at?->format('d/m/Y') ?? 'Đang cập nhật' }}</span>
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
                    <h3>Bạn cần tư vấn về sản phẩm?</h3>
                    <p>Đội ngũ chuyên gia của chúng tôi sẵn sàng hỗ trợ bạn lựa chọn sản phẩm phù hợp</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="primary-btn cta-btn">
                    LIÊN HỆ TƯ VẤN
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Xử lý click nút yêu thích
        $('.favorite-btn').click(function(e) {
            e.preventDefault();

            var productId = $(this).data('product-id');
            var heartIcon = $(this).find('.heart-icon');
            var button = $(this);
            var itemContainer = button.closest('.featured__item, .favorite__item');

            $.ajax({
                url: '{{ route("favorite.toggle") }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'added') {
                        heartIcon.css('color', '#000000');
                        button.addClass('active');
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    } else {
                        heartIcon.css('color', '#cccccc');
                        button.removeClass('active');
                        setTimeout(function() {
                            location.reload();
                        }, 500);
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
    });
</script>

<style>
    /* Thêm CSS cho phần sản phẩm yêu thích */
    .favorite-products {
        padding: 80px 0;
        background: #fff8f8;
    }

    .favorite__item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid #ffebee;
        position: relative;
    }

    .favorite__item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(255, 107, 129, 0.15);
        border-color: #ff6b81;
    }

    .favorite__item__pic {
        position: relative;
        height: 150px;
        overflow: hidden;
    }

    .favorite__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .favorite__item:hover .favorite__img {
        transform: scale(1.1);
    }

    .favorite__item__pic__hover {
        position: absolute;
        top: 10px;
        right: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .favorite__item:hover .favorite__item__pic__hover {
        opacity: 1;
    }

    .favorite__item__pic__hover li {
        display: block;
        margin-bottom: 5px;
    }

    .favorite__item__pic__hover a {
        display: block;
        width: 35px;
        height: 35px;
        background: white;
        border-radius: 50%;
        text-align: center;
        line-height: 35px;
        color: #666;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .favorite__item__pic__hover a:hover {
        background: #ff6b81;
        color: white;
        transform: scale(1.2);
    }

    .favorite__item__text {
        padding: 15px;
        text-align: center;
    }

    .favorite__item__text h6 {
        font-size: 0.9rem;
        margin-bottom: 5px;
        color: #222222 !important;
    }

    .favorite__item__text h5 {
        color: #ff6b81 !important;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .favorite-products .heart-icon {
        color: #000000 !important;
    }

    .empty-favorites {
        padding: 40px 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .empty-favorites h5 {
        color: #666 !important;
        margin-bottom: 10px;
    }

    .empty-favorites p {
        color: #888 !important;
        margin-bottom: 20px;
    }

    /* CSS hiện có (giữ nguyên) */
    body {
        font-family: 'Inter', sans-serif !important;
        color: #333333;
        line-height: 1.6;
    }

    .section-title h2,
    .hero__text h1 {
        font-weight: 700 !important;
        color: #222222 !important;
        margin-bottom: 15px;
    }

    h4,
    h5,
    h6,
    .categories__item__text h4,
    .featured__item__text h6,
    .blog__item__text h5 {
        font-weight: 600 !important;
        color: #222222 !important;
        margin-bottom: 10px;
    }

    p,
    .hero__text p,
    .feature__item p,
    .categories__item__text p,
    .blog__item__text p,
    .cta__text p {
        color: #555555 !important;
        font-weight: 400;
        line-height: 1.6;
    }

    /* ĐỔI MÀU GIÁ SẢN PHẨM THÀNH ĐỎ */
    .product-price {
        color: #ff0000 !important;
        font-weight: 700;
        font-size: 1.1rem;
    }

    * {
        box-sizing: border-box;
    }

    a {
        text-decoration: none !important;
        border: none !important;
        outline: none !important;
        transition: all 0.3s ease;
    }

    .featured__item__text a,
    .blog__item__text a,
    .categories__item__text a,
    .product-link,
    .blog-link,
    .categories__link {
        text-decoration: none !important;
        border-bottom: none !important;
        box-shadow: none !important;
    }

    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        color: white;
    }

    .hero__text h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        line-height: 1.2;
        color: white !important;
    }

    .hero__text p {
        font-size: 1.1rem;
        margin-bottom: 30px;
        opacity: 0.95;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.95) !important;
    }

    .hero__image img {
        max-height: 350px;
        object-fit: contain;
    }

    .features {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .feature__item {
        text-align: center;
        padding: 40px 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        background: white;
        border: 1px solid #f0f0f0;
        height: 100%;
    }

    .feature__item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        border-color: #7fad39;
    }

    .feature__item__icon {
        font-size: 2.5rem;
        color: #7fad39;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .feature__item h5 {
        margin-bottom: 15px;
        color: #222222 !important;
        font-size: 1.2rem;
    }

    .feature__item p {
        color: #666666 !important;
        line-height: 1.6;
    }

    .categories {
        padding: 80px 0;
        background: white;
    }

    .categories__item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid #f8f9fa;
    }

    .categories__item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        border-color: #7fad39;
    }

    .categories__item__image {
        height: 200px;
        overflow: hidden;
    }

    .categories__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .categories__item:hover .categories__img {
        transform: scale(1.1);
    }

    .categories__item__text {
        padding: 25px;
    }

    .categories__item__text h4 {
        color: #222222 !important;
        margin-bottom: 10px;
        font-size: 1.3rem;
    }

    .categories__item__text p {
        color: #666666 !important;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .categories__link {
        color: #7fad39;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(127, 173, 57, 0.1);
        border-radius: 5px;
    }

    .categories__link:hover {
        color: white;
        background: #7fad39;
        gap: 12px;
    }

    .featured {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .featured__item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid #f8f9fa;
    }

    .featured__item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        border-color: #7fad39;
    }

    .featured__item__pic {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .featured__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .featured__item:hover .featured__img {
        transform: scale(1.1);
    }

    .featured__item__pic__hover {
        position: absolute;
        bottom: 10px;
        right: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .featured__item__pic__hover li {
        display: inline-block;
        margin-left: 5px;
    }

    .featured__item__pic__hover a {
        display: block;
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        color: #666;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .featured__item__pic__hover a:hover {
        background: #7fad39;
        color: white;
        transform: scale(1.2);
    }

    .featured__item__text {
        padding: 20px;
    }

    .product-link {
        color: #222222 !important;
        font-weight: 600;
        font-size: 1rem;
        display: block;
        line-height: 1.4;
        margin-bottom: 10px;
    }

    .product-link:hover {
        color: #7fad39 !important;
    }

    .from-blog {
        padding: 80px 0;
        background: white;
    }

    .blog__item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid #f8f9fa;
    }

    .blog__item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        border-color: #7fad39;
    }

    .blog__item__pic {
        height: 200px;
        overflow: hidden;
    }

    .blog__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .blog__item:hover .blog__img {
        transform: scale(1.1);
    }

    .blog__item__text {
        padding: 25px;
    }

    .blog-link {
        color: #222222 !important;
        font-weight: 600;
        font-size: 1.1rem;
        line-height: 1.4;
        display: block;
        margin-bottom: 10px;
    }

    .blog-link:hover {
        color: #7fad39 !important;
    }

    .blog__item__text p {
        color: #666666 !important;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .blog__item__info {
        margin-top: 15px;
        font-size: 0.85rem;
        color: #888888;
    }

    .blog__item__info span {
        margin-right: 15px;
    }

    .cta {
        padding: 80px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .cta__text h3 {
        color: white !important;
        margin-bottom: 10px;
        font-size: 1.8rem;
    }

    .cta__text p {
        color: rgba(255, 255, 255, 0.95) !important;
        margin-bottom: 0;
        font-size: 1.1rem;
    }

    .primary-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #7fad39;
        color: white;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        box-shadow: 0 4px 12px rgba(127, 173, 57, 0.3);
    }

    .primary-btn:hover {
        background: #6b8e23;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(127, 173, 57, 0.4);
    }

    .view-all-btn,
    .cta-btn {
        background: transparent;
        border: 2px solid #7fad39;
        color: #7fad39;
    }

    .cta-btn {
        border-color: white;
        color: white;
    }

    .view-all-btn:hover,
    .cta-btn:hover {
        background: #7fad39;
        color: white;
    }

    .heart-icon {
        transition: all 0.3s ease;
    }

    .heart-icon {
        color: #cccccc !important;
    }

    .favorite-btn.active .heart-icon,
    .favorite-btn:hover .heart-icon {
        color: #000000 !important;
        transform: scale(1.2);
    }

    .download-btn:hover .download-icon {
        color: #7fad39 !important;
        transform: scale(1.2);
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-size: 2.2rem;
        color: #222222 !important;
        margin-bottom: 15px;
    }

    .section-title p {
        font-size: 1.1rem;
        color: #666666 !important;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .hero {
            padding: 60px 0;
        }

        .hero__text h1 {
            font-size: 2rem;
        }

        .section-title h2 {
            font-size: 1.8rem;
        }

        .features,
        .categories,
        .featured,
        .favorite-products,
        .from-blog,
        .cta {
            padding: 60px 0;
        }

        .primary-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .favorite__item__pic {
            height: 120px;
        }

        .empty-favorites {
            padding: 30px 15px;
        }
    }
</style>
@endsection