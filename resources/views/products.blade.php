@extends('layouts.user')

@section('title', 'Sản phẩm - Plastic Store')

@section('user-content')
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
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Danh mục</h4>
                        <ul>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('category', strtolower($category->CategoryName)) }}">{{ $category->CategoryName }}</a>
                                <span>({{ $category->products_count }})</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7">
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
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset($product->Photo) }}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ route('product.detail', $product->ProductID) }}">{{ $product->ProductName }}</a></h6>
                                <h5> từ {{ number_format($product->variants->min('Price') * 1000, 0, ',', '.') }}đ</h5>
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