@extends('layouts.user')

@section('title', $product->ProductName . ' - Plastic Store')

@section('user-content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Chi tiết sản phẩm</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <a href="{{ route('products') }}">Sản phẩm</a>
                        <span>Chi tiết sản phẩm</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-details spad">
    <div class="container">
        <div class="row">
            {{-- Product Images and Thumbnails --}}
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large"
                            src="{{ asset($product->Photo ? str_replace('/images/', '/img/', $product->Photo) : 'img/product/default.jpg') }}"
                            alt="{{ $product->ProductName }}"
                            id="mainProductImage" style="width: 100%; height: 500px; object-fit: cover;">
                    </div>
                    @if($product->variants->count() > 0)
                    <div class="product__details__pic__slider owl-carousel">
                        @foreach($product->variants->groupBy('ColourID') as $colorId => $colorVariants)
                        @php
                        $color = $colorVariants->first()->color;
                        $firstVariant = $colorVariants->first();
                        @endphp
                        <img data-imgbigurl="{{ asset($firstVariant->MainImage ? str_replace('/images/', '/img/', $firstVariant->MainImage) : 'img/product/default.jpg') }}"
                            src="{{ asset($firstVariant->MainImage ? str_replace('/images/', '/img/', $firstVariant->MainImage) : 'img/product/default.jpg') }}"
                            alt="{{ $product->ProductName }} - {{ $color->ColourName }}"
                            data-color="{{ $colorId }}"
                            class="color-thumbnail">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Product Information and Controls --}}
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>{{ $product->ProductName }}</h3>
                    <div class="product__details__rating">
                        @php
                        $avgRating = $product->feedback->avg('Rating') ?? 0;
                        $fullStars = floor($avgRating);
                        $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=$fullStars)
                            <i class="fa fa-star"></i>
                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                            <i class="fa fa-star-half-o"></i>
                            @else
                            <i class="fa fa-star-o"></i>
                            @endif
                            @endfor
                            <span>({{ $product->feedback->count() }} đánh giá)</span>
                    </div>

                    {{-- Price Display --}}
                    <div class="product__details__price">
                        @if($product->variants->count() > 0)
                        @php
                        $minPrice = $product->variants->min('Price');
                        $maxPrice = $product->variants->max('Price');
                        @endphp
                        @if($minPrice == $maxPrice)
                        ${{ number_format($minPrice, 2) }}
                        @else
                        ${{ number_format($minPrice, 2) }} - ${{ number_format($maxPrice, 2) }}
                        @endif
                        @else
                        Liên hệ để biết giá
                        @endif
                    </div>

                    <p>{{ $product->Description }}</p>

                    @if($product->variants->count() > 0)
                    <div class="product__details__variant">
                        <div class="variant__item">
                            <span>Màu sắc:</span>
                            <div class="color__list">
                                @foreach($product->variants->groupBy('ColourID') as $colorId => $colorVariants)
                                @php
                                $color = $colorVariants->first()->color;
                                $firstVariant = $colorVariants->first();

                                $swatchStyle = 'background: #ccc;';
                                if($color->ColourName == 'Trong suốt') {
                                $swatchStyle = 'background: #f8f9fa; border: 1px solid #ddd;';
                                } elseif($color->ColourName == 'Xanh dương') {
                                $swatchStyle = 'background: #007bff;';
                                } elseif($color->ColourName == 'Xanh lá') {
                                $swatchStyle = 'background: #28a745;';
                                } elseif($color->ColourName == 'Vàng') {
                                $swatchStyle = 'background: #ffc107;';
                                }
                                @endphp
                                <div class="color__item"
                                    data-color="{{ $colorId }}"
                                    data-image="{{ asset($firstVariant->MainImage ? str_replace('/images/', '/img/', $firstVariant->MainImage) : 'img/product/default.jpg') }}">
                                    <span class="color-swatch" style="{{ $swatchStyle }}"></span>
                                    {{ $color->ColourName }}
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="variant__item">
                            <span>Dung tích:</span>
                            <div class="size__list">
                                @php
                                $uniqueVolumes = $product->variants->groupBy('VolumeID');
                                @endphp
                                @foreach($uniqueVolumes as $volumeId => $volumeVariants)
                                @php $volume = $volumeVariants->first()->volume; @endphp
                                <div class="size__item" data-volume="{{ $volumeId }}">
                                    {{ $volume->VolumeValue }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="selected__variant__info">
                        <div class="variant__price">
                            <strong>Giá: </strong>
                            <span id="variantPrice">${{ number_format($minPrice, 2) }}</span>
                        </div>
                        <div class="variant__stock">
                            <strong>Tồn kho: </strong>
                            <span id="variantStock">Chọn màu và dung tích</span>
                        </div>
                        <input type="hidden" id="selectedVariantId" value="">
                    </div>
                    @endif

                    {{-- Quantity Counter --}}
                    <div class="product__details__quantity">
                        <div class="quantity">
                            <div class="pro-qty">
                                <span class="qtybtn dec">-</span>
                                <input type="text" value="1" id="productQuantityInput" readonly>
                                <span class="qtybtn inc">+</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <button href="#" class="primary-btn" id="addToCartButton" style="border: none;">THÊM VÀO GIỎ</button>
                    <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>

                    <ul>
                        <li><b>Tình trạng</b> <span>
                                @if($product->variants->where('StockQuantity', '>', 0)->count() > 0)
                                Còn hàng
                                @else
                                Hết hàng
                                @endif
                            </span></li>
                        <li><b>Vận chuyển</b> <span>Giao hàng trong 1 ngày. <samp>Miễn phí giao hàng</samp></span></li>
                        <li><b>Chia sẻ</b>
                            <div class="share">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Product Details Tabs --}}
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                aria-selected="true">Mô tả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                aria-selected="false">Thông tin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                aria-selected="false">Đánh giá <span>({{ $product->feedback->count() }})</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        {{-- Tab 1: Description --}}
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Thông tin sản phẩm</h6>
                                <p>{{ $product->Description }}</p>
                                <p><strong>Chất liệu:</strong> {{ $product->category->CategoryName }} - {{ $product->category->Description }}</p>
                            </div>
                        </div>

                        {{-- Tab 2: Detailed Information --}}
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Thông tin chi tiết</h6>
                                <p>Sản phẩm được làm từ chất liệu <strong>{{ $product->category->CategoryName }}</strong>. Các biến thể có sẵn:</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Mã biến thể</th>
                                                <th>Màu sắc</th>
                                                <th>Dung tích</th>
                                                <th>Giá</th>
                                                <th>Tồn kho</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->variants as $variant)
                                            <tr>
                                                <td>#{{ $variant->VariantID }}</td>
                                                <td>{{ $variant->color->ColourName }}</td>
                                                <td>{{ $variant->volume->VolumeValue }}</td>
                                                <td>${{ number_format($variant->Price, 2) }}</td>
                                                <td>{{ $variant->StockQuantity }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Tab 3: Reviews --}}
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Đánh giá từ khách hàng ({{ $product->feedback->count() }})</h6>
                                @if($product->feedback->count() > 0)
                                @foreach($product->feedback as $feedback)
                                <div class="review-item" style="border-bottom: 1px solid #eee; padding: 15px 0;">
                                    <strong>{{ $feedback->account->Username ?? 'Khách hàng ẩn danh' }}</strong> -
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star" style="color: {{ $i <= $feedback->Rating ? '#ffd700' : '#ccc' }}"></i>
                                        @endfor
                                        ({{ $feedback->Rating }}/5)
                                        <p style="margin: 8px 0 0 0;">{{ $feedback->CommentText }}</p>
                                        @php
                                        // Sửa lỗi format() bằng cách chuyển đổi thành Carbon instance
                                        $submissionDate = \Carbon\Carbon::parse($feedback->SubmissionDate);
                                        @endphp
                                        <small>Đánh giá ngày: {{ $submissionDate->format('d/m/Y H:i') }}</small>
                                </div>
                                @endforeach
                                @else
                                <p>Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Products --}}
<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Sản phẩm liên quan</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @php
            $relatedProducts = \App\Models\Product::where('CategoryID', $product->CategoryID)
            ->where('ProductID', '!=', $product->ProductID)
            ->where('Status', 1)
            ->with(['variants', 'category'])
            ->take(4)
            ->get();
            @endphp

            @forelse($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg"
                        data-setbg="{{ asset($relatedProduct->Photo ? str_replace('/images/', '/img/', $relatedProduct->Photo) : 'img/product/default.jpg') }}"
                        style="background-size: cover; background-position: center; height: 250px;">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{ route('product.detail', $relatedProduct->ProductID) }}">{{ $relatedProduct->ProductName }}</a></h6>
                        <h5>
                            @if($relatedProduct->variants->count() > 0)
                            ${{ number_format($relatedProduct->variants->min('Price'), 2) }}
                            @else
                            Liên hệ
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Không có sản phẩm liên quan</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@php
$variantsData = [];
$firstVariantID = null;
$firstColorID = null;
$firstVolumeID = null;
$minPrice = $product->variants->count() > 0 ? $product->variants->min('Price') : 0;

if ($product->variants->count() > 0) {
foreach ($product->variants as $variant) {
if (is_null($firstVariantID)) {
$firstVariantID = $variant->VariantID;
$firstColorID = $variant->ColourID;
$firstVolumeID = $variant->VolumeID;
}

$key = $variant->ColourID . '_' . $variant->VolumeID;
$variantsData[$key] = [
'id' => $variant->VariantID,
'price' => number_format($variant->Price, 2),
'stock' => $variant->StockQuantity,
'image' => asset($variant->MainImage ? str_replace('/images/', '/img/', $variant->MainImage) : 'img/product/default.jpg'),
];
}
}
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allVariants = @json($variantsData);
        let selectedColor = '{{ $firstColorID }}';
        let selectedSize = '{{ $firstVolumeID }}';

        const mainImage = document.getElementById('mainProductImage');
        const colorItems = document.querySelectorAll('.color__item');
        const sizeItems = document.querySelectorAll('.size__item');
        const variantPrice = document.getElementById('variantPrice');
        const variantStock = document.getElementById('variantStock');
        const selectedVariantIdInput = document.getElementById('selectedVariantId');
        const productQuantityInput = document.getElementById('productQuantityInput');
        const addToCartButton = document.getElementById('addToCartButton');

        const hasVariants = Object.keys(allVariants).length > 0;

        function initializeVariant() {
            if (hasVariants) {
                if (selectedColor) {
                    const initialColor = document.querySelector(`.color__item[data-color="${selectedColor}"]`);
                    if (initialColor) initialColor.classList.add('active');
                }
                if (selectedSize) {
                    const initialSize = document.querySelector(`.size__item[data-volume="${selectedSize}"]`);
                    if (initialSize) initialSize.classList.add('active');
                }
                updateVariantDisplay();
            }
        }

        function updateVariantDisplay() {
            if (!hasVariants) return;

            if (selectedColor && selectedSize) {
                const variantKey = selectedColor + '_' + selectedSize;
                const variant = allVariants[variantKey];

                if (variant) {
                    variantPrice.textContent = '$' + variant.price;
                    variantStock.textContent = variant.stock > 0 ? 'Còn hàng (' + variant.stock + ' sản phẩm)' : 'Hết hàng';
                    selectedVariantIdInput.value = variant.id;

                    // Update quantity input
                    const currentQuantity = parseInt(productQuantityInput.value);
                    const stock = parseInt(variant.stock);

                    if (stock === 0) {
                        productQuantityInput.value = 0;
                        addToCartButton.disabled = true;
                        addToCartButton.style.opacity = '0.6';
                    } else {
                        if (currentQuantity > stock) {
                            productQuantityInput.value = stock;
                        }
                        if (currentQuantity === 0 && stock > 0) {
                            productQuantityInput.value = 1;
                        }
                        addToCartButton.disabled = false;
                        addToCartButton.style.opacity = '1';
                    }
                } else {
                    variantPrice.textContent = 'Biến thể không khả dụng';
                    variantStock.textContent = 'Hết hàng';
                    selectedVariantIdInput.value = '';
                    productQuantityInput.value = 0;
                    addToCartButton.disabled = true;
                    addToCartButton.style.opacity = '0.6';
                }
            } else {
                variantPrice.textContent = 'Vui lòng chọn màu và dung tích';
                variantStock.textContent = '-';
                selectedVariantIdInput.value = '';
            }
        }

        // Color selection
        colorItems.forEach(item => {
            item.addEventListener('click', function() {
                colorItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                selectedColor = this.dataset.color;

                const newImage = this.dataset.image;
                if (newImage) {
                    mainImage.src = newImage;
                }
                updateVariantDisplay();
            });
        });

        // Size selection
        sizeItems.forEach(item => {
            item.addEventListener('click', function() {
                sizeItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                selectedSize = this.dataset.volume;
                updateVariantDisplay();
            });
        });

        // Quantity controls
        const proQty = document.querySelector('.pro-qty');
        if (proQty) {
            const decBtn = proQty.querySelector('.dec');
            const incBtn = proQty.querySelector('.inc');

            decBtn.addEventListener('click', function() {
                let value = parseInt(productQuantityInput.value);
                if (value > 1) {
                    productQuantityInput.value = value - 1;
                }
            });

            incBtn.addEventListener('click', function() {
                let value = parseInt(productQuantityInput.value);
                const variantKey = selectedColor + '_' + selectedSize;
                const variant = allVariants[variantKey];

                if (variant && value < parseInt(variant.stock)) {
                    productQuantityInput.value = value + 1;
                }
            });
        }

        // Add to cart functionality
        addToCartButton.addEventListener('click', function(e) {
            e.preventDefault();
            const variantId = selectedVariantIdInput.value;
            const quantity = productQuantityInput.value;

            if (!variantId) {
                alert('Vui lòng chọn màu và dung tích sản phẩm');
                return;
            }

            if (quantity < 1) {
                alert('Số lượng sản phẩm không hợp lệ');
                return;
            }

            // Add to cart logic here
            console.log('Add to cart:', {
                variantId,
                quantity
            });
            alert('Đã thêm sản phẩm vào giỏ hàng');
        });

        initializeVariant();
    });
</script>

<style>
    .color__list,
    .size__list {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .color__item,
    .size__item {
        padding: 8px 15px;
        border: 1px solid #ebebeb;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.3s ease;
        user-select: none;
        display: flex;
        align-items: center;
    }

    .color__item.active,
    .size__item.active {
        border-color: #7fad39;
        background: #7fad39;
        color: white;
    }

    .color-swatch {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 5px;
        vertical-align: middle;
        border: 2px solid transparent;
    }

    .color__item.active .color-swatch {
        border-color: white;
    }

    .selected__variant__info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin: 15px 0;
        border-left: 4px solid #7fad39;
    }

    .product__details__pic__slider img {
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
        width: 80px;
        height: 80px;
        object-fit: cover;
    }

    .product__details__pic__slider img.active {
        border-color: #7fad39;
    }

    .pro-qty {
        width: 120px;
        height: 40px;
        border: 1px solid #ebebeb;
        border-radius: 3px;
        overflow: hidden;
        position: relative;
        display: inline-block;
    }

    .pro-qty input {
        width: 100%;
        height: 100%;
        text-align: center;
        border: none;
        outline: none;
        background: transparent;
    }

    .pro-qty .qtybtn {
        position: absolute;
        top: 0;
        width: 30px;
        height: 100%;
        background: #f5f5f5;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        user-select: none;
    }

    .pro-qty .dec {
        left: 0;
        border-right: 1px solid #ebebeb;
    }

    .pro-qty .inc {
        right: 0;
        border-left: 1px solid #ebebeb;
    }

    .table-responsive {
        margin-top: 15px;
    }

    .table th {
        background: #f8f9fa;
        font-weight: 600;
    }

    .review-item:last-child {
        border-bottom: none !important;
    }
</style>
@endsection