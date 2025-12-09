@extends('layouts.app')

@section('title', $product->ProductName . ' - Plastic Store')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{ $product->ProductName }}</h2>
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
                            id="mainProductImage" style="width: 100px; height: 800px; object-fit: fit;">
                    </div>
                    @if($product->variants->count() > 0)
                    <div class="product__details__pic__slider owl-carousel">
                        @foreach($product->variants->groupBy('ColourID') as $colorId => $colorVariants)
                        @php
                        $color = $colorVariants->first()->colour;
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
                            <span>({{ $product->feedback->count() }} reviews)</span>
                    </div>

                    {{-- Price Display --}}
                    <div class="product__details__price" id="mainProductPrice">
                        @if($product->variants->count() > 0)
                        @php
                        $defaultPrice = $product->variants->first()->Price ?? $product->variants->min('Price');
                        @endphp
                        {{ number_format($defaultPrice * 1000, 0, ',', '.') }}đ
                        @else
                        Contact for price
                        @endif
                    </div>

                    <p>{{ $product->Description }}</p>

                    @if($product->variants->count() > 0)
                    <div class="product__details__variant">
                        <div class="variant__item">
                            <span>Color:</span>
                            <div class="color__list">
                                @foreach($product->variants->groupBy('ColourID') as $colorId => $colorVariants)
                                @php
                                $color = $colorVariants->first()->colour;
                                $firstVariant = $colorVariants->first();

                                $swatchStyle = 'background: #ccc;';
                                if($color->ColourName == 'Transparent') {
                                $swatchStyle = 'background: #f8f9fa; border: 1px solid #ddd;';
                                } elseif($color->ColourName == 'Blue') {
                                $swatchStyle = 'background: #007bff;';
                                } elseif($color->ColourName == 'Green') {
                                $swatchStyle = 'background: #28a745;';
                                } elseif($color->ColourName == 'Yellow') {
                                $swatchStyle = 'background: #ffc107;';
                                }
                                @endphp
                                <div class="color__item"
                                    data-color="{{ $colorId }}"
                                    data-image="{{ asset($firstVariant->MainImage ? str_replace('/images/', '/img/', $firstVariant->MainImage) : 'img/product/default.jpg') }}">

                                    <span class="color-swatch" data-custom-style="{{ $swatchStyle }}"></span>
                                    {{ $color->ColourName }}
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="variant__item">
                            <span>Capacity:</span>
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
                            <strong>Price: </strong>
                            <span id="variantPrice">{{ number_format($defaultPrice * 1000, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="variant__stock">
                            <strong>Stock: </strong>
                            <span id="variantStock">Select color and capacity</span>
                        </div>
                        <input type="hidden" id="selectedVariantId" value="">
                    </div>
                    @endif

                    {{-- Action Buttons - Chỉ giữ Favorite và Download --}}
                    <div class="product__details__actions">
                        {{-- Favorite Button --}}
                        <a href="#" class="action-btn favorite-btn" data-product-id="{{ $product->ProductID }}" title="Add to Favorite">
                            @if(isset($favoriteProductIds) && in_array($product->ProductID, $favoriteProductIds))
                            <i class="fa fa-heart" style="color: #ff0000"></i>
                            @else
                            <i class="fa fa-heart" style="color: #333"></i>
                            @endif
                            <span>Favorite</span>
                        </a>

                        {{-- Download Button --}}
                        <a href="{{ route('product.download', $product->ProductID) }}" class="action-btn download-btn" title="Download Product Document">
                            <i class="fa fa-download"></i>
                            <span>Document</span>
                        </a>
                    </div>

                    <ul>
                        <li><b>Availability</b> <span>
                                @if($product->variants->where('StockQuantity', '>', 0)->count() > 0)
                                In Stock
                                @else
                                Out of Stock
                                @endif
                            </span></li>
                        <li><b>Shipping</b> <span>Delivery in 1 day. <samp>Free shipping</samp></span></li>
                    </ul>
                </div>
            </div>

            {{-- Product Details Tabs --}}
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                aria-selected="false">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                aria-selected="false">Reviews <span>({{ $product->feedback->count() }})</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        {{-- Tab 1: Description --}}
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Product Information</h6>
                                <p>{{ $product->Description }}</p>
                                <p><strong>Material:</strong> {{ $product->category->CategoryName }} - {{ $product->category->Description }}</p>
                            </div>
                        </div>

                        {{-- Tab 2: Detailed Information --}}
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Detailed Information</h6>
                                <p>Product is made from <strong>{{ $product->category->CategoryName }}</strong> material. Available variants:</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Variant Code</th>
                                                <th>Color</th>
                                                <th>Capacity</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->variants as $variant)
                                            <tr>
                                                <td>#{{ $variant->VariantID }}</td>
                                                <td>{{ $variant->colour->ColourName }}</td>
                                                <td>{{ $variant->volume->VolumeValue }}</td>
                                                <td>{{ number_format($variant->Price * 1000, 0, ',', '.') }}đ</td>
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
                                <h6>Customer Reviews ({{ $product->feedback->count() }})</h6>
                                {{-- FORM VIẾT REVIEW MỚI --}}
                                @auth
                                <div class="write-review-form" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                                    <h6 style="margin-bottom: 15px;">Write Your Review</h6>
                                    <form action="{{ route('feedback.store') }}" method="POST" id="reviewForm">
                                        @csrf
                                        <input type="hidden" name="ProductID" value="{{ $product->ProductID }}">

                                        <div class="form-group mb-3">
                                            <label for="rating" class="form-label">Rating:</label>
                                            <div class="rating-stars">
                                                @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="star{{ $i }}" name="Rating" value="{{ $i }}" required>
                                                <label for="star{{ $i }}" title="{{ $i }} stars">
                                                    <i class="fa fa-star"></i>
                                                </label>
                                                @endfor
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="comment" class="form-label">Your Review:</label>
                                            <textarea name="CommentText" id="comment" class="form-control"
                                                rows="4" placeholder="Share your thoughts about this product..."
                                                required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    </form>
                                </div>
                                @else
                                <div class="alert alert-info">
                                    Please <a href="{{ route('login') }}">login</a> to write a review.
                                </div>
                                @endauth
                                @if($product->feedback->count() > 0)
                                @foreach($product->feedback as $feedback)
                                <div class="review-item" style="border-bottom: 1px solid #eee; padding: 15px 0;">
                                    <strong>{{ $feedback->user->Username ?? 'Anonymous Customer' }}</strong> -
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star" style="color: {{ $i <= $feedback->Rating ? '#ffd700' : '#ccc' }}"></i>
                                        @endfor
                                        ({{ $feedback->Rating }}/5)
                                        <p style="margin: 8px 0 0 0;">{{ $feedback->CommentText }}</p>
                                        @php
                                        $submissionDate = \Carbon\Carbon::parse($feedback->SubmissionDate);
                                        @endphp
                                        <small>Reviewed on: {{ $submissionDate->format('d/m/Y H:i') }}</small>
                                </div>
                                @endforeach
                                @else
                                <p>No reviews yet. Be the first to review this product!</p>
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
                    <h2>Related Products</h2>
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
                            {{-- Favorite button for related products --}}
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="{{ $relatedProduct->ProductID }}" title="Favorite">
                                    @if(isset($favoriteProductIds) && in_array($relatedProduct->ProductID, $favoriteProductIds))
                                    <i class="fa fa-heart" style="color: #ff0000"></i>
                                    @else
                                    <i class="fa fa-heart" style="color: #ffffff"></i>
                                    @endif
                                </a>
                            </li>
                            {{-- Download button for related products --}}
                            <li>
                                <a href="{{ route('product.download', $relatedProduct->ProductID) }}" title="Download document" class="download-btn">
                                    <i class="fa fa-download"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{ route('product.detail', $relatedProduct->ProductID) }}">{{ $relatedProduct->ProductName }}</a></h6>
                        <h5 class="product-price">
                            @if($relatedProduct->variants->count() > 0)
                            {{ number_format($relatedProduct->variants->first()->Price * 1000, 0, ',', '.') }}đ
                            @else
                            Contact
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No related products</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@php
$variantsData = [];
$firstColorID = null;
$firstVolumeID = null;
$defaultPrice = $product->variants->count() > 0 ? $product->variants->first()->Price : 0;

if ($product->variants->count() > 0) {
foreach ($product->variants as $variant) {
if (is_null($firstColorID)) {
$firstColorID = $variant->ColourID;
$firstVolumeID = $variant->VolumeID;
}

$key = $variant->ColourID . '_' . $variant->VolumeID;
$variantsData[$key] = [
'id' => $variant->VariantID,
'price' => number_format($variant->Price * 1000, 0, ',', '.') . 'đ',
'stock' => $variant->StockQuantity,
'image' => asset($variant->MainImage ? str_replace('/images/', '/img/', $variant->MainImage) : 'img/product/default.jpg'),
];
}
}
@endphp

<script>
    document.querySelectorAll('.color-swatch[data-custom-style]').forEach(swatch => {
        const styleValue = swatch.getAttribute('data-custom-style');
        swatch.style.cssText = styleValue;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const allVariants = JSON.parse('{!! json_encode($variantsData) !!}');
        let selectedColor = '{{ $firstColorID }}';
        let selectedSize = '{{ $firstVolumeID }}';

        const mainImage = document.getElementById('mainProductImage');
        const colorItems = document.querySelectorAll('.color__item');
        const sizeItems = document.querySelectorAll('.size__item');
        const variantPrice = document.getElementById('variantPrice');
        const mainProductPrice = document.getElementById('mainProductPrice');
        const variantStock = document.getElementById('variantStock');
        const selectedVariantIdInput = document.getElementById('selectedVariantId');

        const hasVariants = Object.keys(allVariants).length > 0;
        const defaultPrice = '{{ number_format($defaultPrice * 1000, 0, ",", ".") }}đ';

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
                    variantPrice.textContent = variant.price;
                    mainProductPrice.textContent = variant.price;
                    variantStock.textContent = variant.stock > 0 ? 'In Stock (' + variant.stock + ' products)' : 'Out of Stock';
                    selectedVariantIdInput.value = variant.id;
                } else {
                    variantPrice.textContent = defaultPrice;
                    mainProductPrice.textContent = defaultPrice;
                    variantStock.textContent = 'Out of Stock';
                    selectedVariantIdInput.value = '';
                }
            } else {
                variantPrice.textContent = defaultPrice;
                mainProductPrice.textContent = defaultPrice;
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

        // Favorite button functionality
        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('data-product-id');
                const heartIcon = this.querySelector('i');
                const isRelatedProduct = this.closest('.product__item__pic__hover');

                $.ajax({
                    url: '{{ route("favorite.toggle") }}',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'added') {
                            heartIcon.style.color = '#ff0000';
                            if (!isRelatedProduct) {
                                showNotification('Added to favorites', 'success');
                            }
                        } else {
                            heartIcon.style.color = isRelatedProduct ? '#ffffff' : '#333';
                            if (!isRelatedProduct) {
                                showNotification('Removed from favorites', 'info');
                            }
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            showNotification('Please login to add favorite products', 'warning');
                            setTimeout(() => {
                                window.location.href = '{{ route("login") }}';
                            }, 1500);
                        } else {
                            showNotification('An error occurred, please try again', 'error');
                        }
                    }
                });
            });
        });

        // Notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()">&times;</button>
            `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Disable click on disabled download buttons
        document.querySelectorAll('.download-btn.disabled').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                showNotification('No document available for this product', 'info');
            });
        });

        initializeVariant();
    });
</script>

<style>
    /* CHANGE PRODUCT PRICE COLOR TO RED */
    .product__details__price {
        color: #ff0000 !important;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 15px 0;
    }

    .variant__price {
        color: #ff0000 !important;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .product-price {
        color: #ff0000 !important;
        font-weight: 700;
        font-size: 1.2rem;
    }

    /* Action Buttons Styling */
    .product__details__actions {
        display: flex;
        gap: 20px;
        margin: 25px 0;
        align-items: center;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
        min-width: 100px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .action-btn:hover {
        background: #007bff;
        color: white;
        border-color: #007bff;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }

    .action-btn i {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .action-btn span {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .favorite-btn.active i {
        color: #ff0000 !important;
    }

    .disabled-btn {
        opacity: 0.6;
        cursor: not-allowed !important;
    }

    .disabled-btn:hover {
        background: #f8f9fa !important;
        color: #333 !important;
        border-color: #e0e0e0 !important;
        transform: none !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
    }

    /* Notification Styling */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 5px;
        color: white;
        font-weight: 500;
        z-index: 9999;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-width: 300px;
        animation: slideIn 0.3s ease;
        transition: opacity 0.3s ease;
    }

    .notification.success {
        background: #28a745;
    }

    .notification.info {
        background: #17a2b8;
    }

    .notification.warning {
        background: #ffc107;
        color: #333;
    }

    .notification.error {
        background: #dc3545;
    }

    .notification button {
        background: transparent;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        margin-left: 15px;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

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

    /* Related products hover buttons */
    .product__item__pic__hover {
        position: absolute;
        left: 0;
        bottom: -50px;
        width: 100%;
        text-align: center;
        transition: all 0.5s ease;
        opacity: 0;
        padding: 0;
        margin: 0;
    }

    .product__item:hover .product__item__pic__hover {
        bottom: 20px;
        opacity: 1;
    }

    .product__item__pic__hover li {
        list-style: none;
        display: inline-block;
        margin-right: 10px;
    }

    .product__item__pic__hover li:last-child {
        margin-right: 0;
    }

    .product__item__pic__hover li a {
        font-size: 16px;
        color: #1c1c1c;
        height: 40px;
        width: 40px;
        line-height: 40px;
        text-align: center;
        border-radius: 50%;
        background: #ffffff;
        display: block;
        transition: all 0.5s ease;
    }

    .product__item__pic__hover li a:hover {
        background: #7fad39;
        color: #ffffff;
    }

    .product__item__pic__hover li a.disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .product__item__pic__hover li a.disabled:hover {
        background: #ffffff;
        color: #1c1c1c;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .product__details__actions {
            flex-direction: column;
            gap: 15px;
        }

        .action-btn {
            width: 100%;
        }

        .notification {
            min-width: auto;
            width: 90%;
            left: 5%;
            right: 5%;
        }
    }

    /* Rating Stars Styling */
    .rating-stars {
        direction: rtl;
        display: inline-block;
        unicode-bidi: bidi-override;
    }

    .rating-stars input[type="radio"] {
        display: none;
    }

    .rating-stars label {
        color: #ccc;
        font-size: 24px;
        padding: 0;
        cursor: pointer;
        transition: color 0.2s;
    }

    .rating-stars label:hover,
    .rating-stars label:hover~label,
    .rating-stars input[type="radio"]:checked~label {
        color: #ffc107;
    }

    /* Write review form styling */
    .write-review-form {
        border: 1px solid #e0e0e0;
    }

    .write-review-form .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .write-review-form .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 14px;
    }

    .write-review-form .btn-primary {
        background: #7fad39;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        font-weight: 600;
        transition: background 0.3s;
    }

    .write-review-form .btn-primary:hover {
        background: #68982d;
    }
</style>
@endsection