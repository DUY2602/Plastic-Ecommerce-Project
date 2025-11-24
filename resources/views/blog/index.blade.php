@extends('layouts.user')

@section('title', 'Blog - Plastic Store')

@section('user-content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Blog</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            @foreach($blogs as $blog)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="{{ asset($blog['image']) }}" alt="{{ $blog['title'] }}">
                    </div>
                    <div class="blog__item__text">
                        <span class="blog__category">{{ $blog['category'] }}</span>
                        <h5><a href="{{ route('blog.show', $blog['id']) }}">{{ $blog['title'] }}</a></h5>
                        <p>{{ $blog['excerpt'] }}</p>
                        <div class="blog__item__info">
                            <span><i class="fa fa-calendar"></i> {{ $blog['date'] }}</span>
                            <a href="{{ route('blog.show', $blog['id']) }}" class="read-more">Đọc tiếp <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination (nếu cần) -->
        <div class="col-lg-12">
            <div class="product__pagination blog__pagination text-center">
                <a href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#"><i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

<style>
    .blog__item {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .blog__item:hover {
        transform: translateY(-5px);
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
        padding: 20px;
    }

    .blog__category {
        background: #7fad39;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
    }

    .blog__item__text h5 {
        margin: 15px 0 10px;
        line-height: 1.4;
    }

    .blog__item__text h5 a {
        color: #1c1c1c;
        text-decoration: none;
    }

    .blog__item__text h5 a:hover {
        color: #7fad39;
    }

    .blog__item__text p {
        color: #6f6f6f;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .blog__item__info {
        display: flex;
        justify-content: between;
        align-items: center;
        font-size: 14px;
        color: #b2b2b2;
    }

    .blog__item__info span {
        margin-right: auto;
    }

    .read-more {
        color: #7fad39;
        text-decoration: none;
        font-weight: bold;
    }

    .read-more:hover {
        color: #1c1c1c;
    }

    .blog__pagination {
        margin-top: 50px;
    }
</style>
@endsection