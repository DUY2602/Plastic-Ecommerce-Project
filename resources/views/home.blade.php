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
                    {{-- FIX LỖI 404: Thêm onerror --}}
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
                        {{-- FIX SLUG: Đảm bảo sử dụng Str::slug() và thêm onerror --}}
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
                        {{-- FIX LỖI NULL: Kiểm tra biến thể --}}
                        @if($product->variants && $product->variants->isNotEmpty())
                        <h5>từ {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
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
            {{-- FIX LỖI NULL: Kiểm tra $blog có tồn tại không --}}
            @if($blog)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        {{-- FIX LỖI 404: Thêm onerror --}}
                        <img src="{{ asset($blog->Image) }}"
                            alt="{{ $blog->Title }}"
                            class="img-fluid blog__img">
                    </div>
                    <div class="blog__item__text">
                        <h5><a href="{{ route('blog.show', $blog->BlogID) }}" class="blog-link">{{ $blog->Title }}</a></h5>
                        <p>{{ Str::limit(strip_tags($blog->Content ?? 'Nội dung đang được cập nhật.'), 100) }}</p>
                        <div class="blog__item__info">
                            {{-- FIX LỖI NULL: Dùng toán tử nullsafe (?->) và ?? --}}
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
                        alert('Đã thêm vào danh sách yêu thích');
                    } else {
                        heartIcon.css('color', '#cccccc');
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
    /* ---------------------------------------------------------------------- */
    /* === FONT CHỮ VÀ MÀU SẮC RÕ RÀNG === */
    /* ---------------------------------------------------------------------- */
    body {
        font-family: 'Inter', sans-serif !important;
        color: #333333;
        line-height: 1.6;
    }

    /* Tiêu đề lớn */
    .section-title h2,
    .hero__text h1 {
        font-weight: 700 !important;
        color: #222222 !important;
        margin-bottom: 15px;
    }

    /* Tiêu đề nhỏ */
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

    /* Nội dung chính */
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

    /* Giá sản phẩm */
    .featured__item__text h5 {
        color: #7fad39 !important;
        font-weight: 700;
    }

    /* ---------------------------------------------------------------------- */
    /* === FIX LỖI VÀ CẢI THIỆN STYLE === */
    /* ---------------------------------------------------------------------- */
    * {
        box-sizing: border-box;
    }

    a {
        text-decoration: none !important;
        border: none !important;
        outline: none !important;
        transition: all 0.3s ease;
    }

    /* === REMOVE ALL UNDERLINES === */
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

    /* === HERO SECTION === */
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

    /* === FEATURES SECTION === */
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

    /* === CATEGORIES SECTION === */
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

    /* === FEATURED PRODUCTS SECTION === */
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

    /* === BLOG SECTION === */
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

    /* === CTA SECTION === */
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

    /* === FAVORITE & DOWNLOAD BUTTONS - TRÁI TIM MÀU ĐEN === */
    .heart-icon {
        transition: all 0.3s ease;
    }

    /* Trái tim chưa yêu thích */
    .heart-icon {
        color: #cccccc !important;
    }

    /* Trái tim đã yêu thích */
    .favorite-btn.active .heart-icon,
    .favorite-btn:hover .heart-icon {
        color: #000000 !important;
        transform: scale(1.2);
    }

    /* Download button */
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
    }
</style>
@endsection