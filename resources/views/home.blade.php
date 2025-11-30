@extends('layouts.app')

@section('title', 'Trang chủ - Plastic Store')

@section('content')
<!-- Hero Banner Section -->
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
                    <img src="{{ asset('img/hero-bottle.png') }}" alt="Plastic Bottles" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
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

<!-- Categories Section -->
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
                        <img src="{{ asset('img/category-' . strtolower($category->CategoryName) . '.jpg') }}" alt="{{ $category->CategoryName }}" class="img-fluid">
                    </div>
                    <div class="categories__item__text">
                        <h4>{{ $category->CategoryName }}</h4>
                        <p>{{ $category->Description }}</p>
                        <a href="{{ route('category', strtolower($category->CategoryName)) }}" class="categories__link">
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

<!-- Featured Products Section -->
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
                        <img src="{{ asset($product->Photo) }}" alt="{{ $product->ProductName }}" class="img-fluid">
                        <ul class="featured__item__pic__hover">
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="{{ $product->ProductID }}" title="Yêu thích">
                                    @if(Auth::check() && in_array($product->ProductID, $favoriteProductIds))
                                    <i class="fa fa-heart heart-icon" style="color: #ff0000"></i>
                                    @else
                                    <i class="fa fa-heart heart-icon" style="color: #b2b2b2"></i>
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
                        <h5>từ {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
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

<!-- Blog Section -->
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
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="{{ asset($blog->Image) }}" alt="{{ $blog->Title }}" class="img-fluid">
                    </div>
                    <div class="blog__item__text">
                        <h5><a href="{{ route('blog.show', $blog->BlogID) }}" class="blog-link">{{ $blog->Title }}</a></h5>
                        <p>{{ Str::limit(strip_tags($blog->Content), 100) }}</p>
                        <div class="blog__item__info">
                            <span><i class="fa fa-user"></i> {{ $blog->Author }}</span>
                            <span><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
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
                        heartIcon.css('color', '#b2b2b2');
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
    });
</script>

<style>
    /* === RESET HOÀN TOÀN === */
    * {
        box-sizing: border-box;
    }

    a {
        text-decoration: none !important;
        border: none !important;
        outline: none !important;
    }

    a:hover,
    a:focus,
    a:active {
        text-decoration: none !important;
        border: none !important;
        outline: none !important;
    }

    /* === REMOVE ALL UNDERLINES === */
    .featured__item__text a,
    .blog__item__text a,
    .categories__item__text a,
    .section-title a,
    .hero__text a,
    .cta__text a,
    .product-link,
    .blog-link,
    .categories__link {
        text-decoration: none !important;
        border-bottom: none !important;
        box-shadow: none !important;
    }

    /* === HERO SECTION === */
    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0;
        color: white;
    }

    .hero__text h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .hero__text p {
        font-size: 1.1rem;
        margin-bottom: 30px;
        opacity: 0.9;
        line-height: 1.6;
    }

    .hero__image img {
        max-height: 350px;
        object-fit: contain;
    }

    /* === FEATURES SECTION === */
    .features {
        padding: 80px 0;
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
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        border-color: #7fad39;
    }

    .feature__item__icon {
        font-size: 2.5rem;
        color: #7fad39;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .feature__item:hover .feature__item__icon {
        transform: scale(1.2);
        color: #6b8e23;
    }

    .feature__item h5 {
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .feature__item:hover h5 {
        color: #7fad39;
        transform: scale(1.05);
    }

    .feature__item p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 0;
        transition: all 0.3s ease;
    }

    .feature__item:hover p {
        color: #333;
    }

    /* === CATEGORIES SECTION === */
    .categories {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .categories__item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid transparent;
    }

    .categories__item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        border-color: #7fad39;
    }

    .categories__item__image {
        height: 200px;
        overflow: hidden;
    }

    .categories__item__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .categories__item:hover .categories__item__image img {
        transform: scale(1.1);
    }

    .categories__item__text {
        padding: 25px;
    }

    .categories__item__text h4 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.3rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .categories__item:hover .categories__item__text h4 {
        color: #7fad39;
        transform: translateX(5px);
    }

    .categories__item__text p {
        color: #666;
        margin-bottom: 15px;
        line-height: 1.5;
        transition: all 0.3s ease;
    }

    .categories__item:hover .categories__item__text p {
        color: #333;
    }

    .categories__link {
        color: #7fad39;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
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
        transform: translateX(5px);
    }

    .categories__link i {
        transition: transform 0.3s ease;
    }

    .categories__link:hover i {
        transform: translateX(5px);
    }

    /* === FEATURED PRODUCTS SECTION === */
    .featured {
        padding: 80px 0;
    }

    .featured__item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid transparent;
    }

    .featured__item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        border-color: #7fad39;
    }

    .featured__item__pic {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .featured__item__pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .featured__item:hover .featured__item__pic img {
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .featured__item__text {
        padding: 20px;
    }

    .product-link {
        color: #333;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: block;
        line-height: 1.4;
        padding: 5px 0;
    }

    .product-link:hover {
        color: #7fad39;
        padding-left: 10px;
        background: rgba(127, 173, 57, 0.05);
        border-radius: 3px;
    }

    .featured__item__text h5 {
        color: #7fad39;
        font-weight: 700;
        margin-bottom: 0;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .featured__item:hover .featured__item__text h5 {
        color: #6b8e23;
        transform: scale(1.05);
    }

    /* === BLOG SECTION === */
    .from-blog {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .blog__item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid transparent;
    }

    .blog__item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        border-color: #7fad39;
    }

    .blog__item__pic {
        height: 200px;
        overflow: hidden;
    }

    .blog__item__pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .blog__item:hover .blog__item__pic img {
        transform: scale(1.1);
    }

    .blog__item__text {
        padding: 25px;
    }

    .blog-link {
        color: #333;
        font-weight: 600;
        font-size: 1.1rem;
        line-height: 1.4;
        transition: all 0.3s ease;
        display: block;
        margin-bottom: 10px;
        padding: 5px 0;
    }

    .blog-link:hover {
        color: #7fad39;
        padding-left: 10px;
        background: rgba(127, 173, 57, 0.05);
        border-radius: 3px;
    }

    .blog__item__text p {
        color: #666;
        line-height: 1.5;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .blog__item:hover .blog__item__text p {
        color: #333;
    }

    .blog__item__info {
        margin-top: 15px;
        font-size: 0.85rem;
        color: #888;
        transition: all 0.3s ease;
    }

    .blog__item:hover .blog__item__info {
        color: #666;
    }

    .blog__item__info span {
        margin-right: 15px;
    }

    /* === CTA SECTION === */
    .cta {
        padding: 80px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .cta__text h3 {
        color: white;
        margin-bottom: 10px;
        font-size: 1.8rem;
        font-weight: 600;
    }

    .cta__text p {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0;
        font-size: 1.1rem;
    }

    /* === BUTTONS === */
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
        gap: 15px;
    }

    .primary-btn i {
        transition: transform 0.3s ease;
    }

    .primary-btn:hover i {
        transform: translateX(5px);
    }

    .view-all-btn,
    .cta-btn {
        background: transparent;
        border: 2px solid #7fad39;
        color: #7fad39;
        box-shadow: none;
    }

    .view-all-btn:hover,
    .cta-btn:hover {
        background: #7fad39;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(127, 173, 57, 0.4);
    }

    /* === FAVORITE & DOWNLOAD BUTTONS === */
    .heart-icon,
    .download-icon {
        transition: all 0.3s ease;
    }

    .favorite-btn.active .heart-icon,
    .favorite-btn:hover .heart-icon {
        color: #ff0000 !important;
        transform: scale(1.2);
    }

    .download-btn:hover .download-icon {
        color: #7fad39 !important;
        transform: scale(1.2);
    }

    /* === SECTION TITLE === */
    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .section-title p {
        font-size: 1.1rem;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* === RESPONSIVE === */
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
        .from-blog,
        .cta {
            padding: 60px 0;
        }

        .primary-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .featured__item__pic__hover a {
            width: 35px;
            height: 35px;
            line-height: 35px;
        }
    }
</style>
@endsection