@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Danh mục</span>
                    </div>
                    <ul>
                        @isset($categories)
                        @foreach($categories as $category)
                        <li><a href="{{ route('category', strtolower($category->CategoryName)) }}">{{ $category->CategoryName }}</a></li>
                        @endforeach
                        @else
                        <li><a href="{{ route('category', 'pet') }}">PET</a></li>
                        <li><a href="{{ route('category', 'pp') }}">PP</a></li>
                        <li><a href="{{ route('category', 'pc') }}">PC</a></li>
                        @endisset
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="{{ route('products') }}">
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

<!-- Main Content -->
<div class="container mt-4">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('user-content')
</div>
@endsection