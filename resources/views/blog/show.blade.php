@extends('layouts.app')

@section('title', $blog->Title . ' - Plastic Store')

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
                        <a href="{{ route('blog.index') }}">Blog</a>
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
                    <img src="{{ asset($blog->Image) }}" alt="{{ $blog->Title }}">
                    <div class="blog__details__item__title">
                        <span class="blog__category">Tin tức</span>
                        <h3>{{ $blog->Title }}</h3>
                        <ul>
                            <li><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}</li>
                            <li><i class="fa fa-user"></i> {{ $blog->Author }}</li>
                            <li><i class="fa fa-clock"></i> 5 phút đọc</li>
                        </ul>
                    </div>
                    <div class="blog__details__desc">
                        {!! $blog->Content !!}
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
                                @php
                                $prevBlog = \App\Models\Blog::where('BlogID', '<', $blog->BlogID)
                                    ->orderBy('BlogID', 'desc')
                                    ->first();
                                    @endphp
                                    @if($prevBlog)
                                    <a href="{{ route('blog.show', $prevBlog->BlogID) }}" class="blog__details__btn">
                                        <span>Bài trước</span>
                                        <h5>{{ $prevBlog->Title }}</h5>
                                    </a>
                                    @endif
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                @php
                                $nextBlog = \App\Models\Blog::where('BlogID', '>', $blog->BlogID)
                                ->orderBy('BlogID', 'asc')
                                ->first();
                                @endphp
                                @if($nextBlog)
                                <a href="{{ route('blog.show', $nextBlog->BlogID) }}" class="blog__details__btn blog__details__btn--next">
                                    <span>Bài tiếp theo</span>
                                    <h5>{{ $nextBlog->Title }}</h5>
                                </a>
                                @endif
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
                            @php
                            $recentBlogs = \App\Models\Blog::orderBy('created_at', 'desc')
                            ->limit(2)
                            ->get();
                            @endphp
                            @foreach($recentBlogs as $recentBlog)
                            <a href="{{ route('blog.show', $recentBlog->BlogID) }}" class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="{{ asset($recentBlog->Image) }}" alt="{{ $recentBlog->Title }}">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>{{ Str::limit($recentBlog->Title, 40) }}</h6>
                                    <span>{{ $recentBlog->created_at->format('d/m/Y') }}</span>
                                </div>
                            </a>
                            @endforeach
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
        max-height: 400px;
        object-fit: cover;
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
        font-size: 16px;
    }

    .blog__details__desc h1,
    .blog__details__desc h2,
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
        font-size: 14px;
    }

    .blog__details__tags a:hover {
        background: #7fad39;
        color: white;
    }

    .blog__details__btns {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #ebebeb;
    }

    .blog__details__btn {
        display: block;
        padding: 15px;
        background: #f5f5f5;
        border-radius: 5px;
        text-decoration: none;
        color: #6f6f6f;
        transition: all 0.3s ease;
    }

    .blog__details__btn:hover {
        background: #7fad39;
        color: white;
    }

    .blog__details__btn span {
        font-size: 12px;
        color: #b2b2b2;
    }

    .blog__details__btn h5 {
        margin: 5px 0 0;
        font-size: 14px;
        line-height: 1.4;
    }

    .blog__details__btn--next {
        text-align: right;
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
        font-size: 14px;
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
        cursor: pointer;
    }

    .blog__sidebar__item {
        margin-bottom: 40px;
    }

    .blog__sidebar__item h4 {
        color: #1c1c1c;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 18px;
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
        padding: 8px 0;
        transition: color 0.3s ease;
        font-size: 14px;
    }

    .blog__sidebar__item ul li a:hover {
        color: #7fad39;
    }

    .blog__sidebar__item ul li a span {
        float: right;
        color: #b2b2b2;
    }

    .blog__sidebar__recent__item {
        display: flex;
        margin-bottom: 20px;
        text-decoration: none;
        transition: transform 0.3s ease;
    }

    .blog__sidebar__recent__item:hover {
        transform: translateX(5px);
    }

    .blog__sidebar__recent__item__pic {
        width: 70px;
        height: 70px;
        border-radius: 5px;
        overflow: hidden;
        margin-right: 15px;
        flex-shrink: 0;
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
        font-size: 14px;
    }

    .blog__sidebar__recent__item__text span {
        color: #b2b2b2;
        font-size: 12px;
    }
</style>
@endsection