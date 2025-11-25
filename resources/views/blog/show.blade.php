@extends('layouts.app')

@section('title', $blog['title'] . ' - Plastic Store')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Blog</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <a href="{{ route('blog') }}">Blog</a>
                        <span>Bài viết</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7">
                <div class="blog__details__item">
                    <img src="{{ asset($blog['image']) }}" alt="{{ $blog['title'] }}">
                    <div class="blog__details__item__title">
                        <span class="blog__category">{{ $blog['category'] }}</span>
                        <h3>{{ $blog['title'] }}</h3>
                        <ul>
                            <li><i class="fa fa-calendar"></i> {{ $blog['date'] }}</li>
                            <li><i class="fa fa-user"></i> {{ $blog['author'] }}</li>
                            <li><i class="fa fa-clock"></i> {{ $blog['read_time'] }}</li>
                        </ul>
                    </div>
                    <div class="blog__details__desc">
                        {!! $blog['content'] !!}
                    </div>
                    <div class="blog__details__tags">
                        <a href="#">Nhựa PET</a>
                        <a href="#">Công nghệ</a>
                        <a href="#">Thực phẩm</a>
                        <a href="#">An toàn</a>
                    </div>
                    <div class="blog__details__btns">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <a href="#" class="blog__details__btn">
                                    <span>Bài trước</span>
                                    <h5>Lợi ích của nhựa PP trong công nghiệp hóa chất</h5>
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <a href="#" class="blog__details__btn blog__details__btn--next">
                                    <span>Bài tiếp theo</span>
                                    <h5>Bảo quản sản phẩm nhựa đúng cách</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Tìm kiếm blog...">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Danh mục</h4>
                        <ul>
                            <li><a href="#">Công nghệ <span>(12)</span></a></li>
                            <li><a href="#">Ứng dụng <span>(8)</span></a></li>
                            <li><a href="#">Mẹo hay <span>(5)</span></a></li>
                            <li><a href="#">Môi trường <span>(7)</span></a></li>
                        </ul>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Bài viết gần đây</h4>
                        <div class="blog__sidebar__recent">
                            <a href="#" class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="{{ asset('img/blog/blog-2.jpg') }}" alt="">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>Lợi ích của nhựa PP<br /> trong công nghiệp</h6>
                                    <span>10/11/2024</span>
                                </div>
                            </a>
                            <a href="#" class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="{{ asset('img/blog/blog-3.jpg') }}" alt="">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>Bảo quản sản phẩm<br /> nhựa đúng cách</h6>
                                    <span>05/11/2024</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->

<style>
    .blog__details__item img {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .blog__details__item__title {
        margin-bottom: 30px;
    }

    .blog__details__item__title h3 {
        color: #1c1c1c;
        font-weight: 700;
        line-height: 1.4;
        margin: 15px 0;
    }

    .blog__details__item__title ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .blog__details__item__title ul li {
        display: inline-block;
        margin-right: 20px;
        color: #b2b2b2;
        font-size: 14px;
    }

    .blog__details__desc {
        line-height: 1.8;
        color: #6f6f6f;
    }

    .blog__details__desc h3 {
        color: #1c1c1c;
        margin: 25px 0 15px;
    }

    .blog__details__tags {
        margin: 40px 0;
        padding-top: 20px;
        border-top: 1px solid #ebebeb;
    }

    .blog__details__tags a {
        display: inline-block;
        background: #f5f5f5;
        color: #6f6f6f;
        padding: 5px 15px;
        border-radius: 5px;
        margin-right: 10px;
        margin-bottom: 10px;
        text-decoration: none;
    }

    .blog__details__tags a:hover {
        background: #7fad39;
        color: white;
    }

    .blog__sidebar {
        position: sticky;
        top: 20px;
    }

    .blog__sidebar__search {
        position: relative;
        margin-bottom: 40px;
    }

    .blog__sidebar__search input {
        width: 100%;
        height: 50px;
        border: 1px solid #ebebeb;
        padding: 0 20px;
        border-radius: 5px;
    }

    .blog__sidebar__search button {
        position: absolute;
        right: 0;
        top: 0;
        height: 50px;
        width: 50px;
        background: #7fad39;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
    }

    .blog__sidebar__item {
        margin-bottom: 40px;
    }

    .blog__sidebar__item h4 {
        color: #1c1c1c;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .blog__sidebar__item ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .blog__sidebar__item ul li {
        margin-bottom: 10px;
    }

    .blog__sidebar__item ul li a {
        color: #6f6f6f;
        text-decoration: none;
        display: block;
        padding: 5px 0;
    }

    .blog__sidebar__item ul li a:hover {
        color: #7fad39;
    }

    .blog__sidebar__item ul li a span {
        float: right;
    }

    .blog__sidebar__recent__item {
        display: flex;
        margin-bottom: 20px;
        text-decoration: none;
    }

    .blog__sidebar__recent__item__pic {
        width: 70px;
        height: 70px;
        border-radius: 5px;
        overflow: hidden;
        margin-right: 15px;
    }

    .blog__sidebar__recent__item__pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .blog__sidebar__recent__item__text h6 {
        color: #1c1c1c;
        line-height: 1.4;
        margin-bottom: 5px;
    }

    .blog__sidebar__recent__item__text span {
        color: #b2b2b2;
        font-size: 12px;
    }
</style>
@endsection