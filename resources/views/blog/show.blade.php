@extends('layouts.app')

@section('title', $blog->Title . ' - Plastic Store')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{ $blog->Title }}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('blog.index') }}">Blog</a>
                        <span>{{ Str::limit($blog->Title, 30) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog__details__content">
                    <div class="blog__details__item">
                        @if($blog->Image)
                        <div class="blog__details__pic">
                            <img src="{{ asset($blog->Image) }}" alt="{{ $blog->Title }}">
                        </div>
                        @endif

                        <div class="blog__details__text">
                            <h2>{{ $blog->Title }}</h2>
                            <div class="blog__details__meta">
                                <span><i class="fa fa-user"></i> {{ $blog->Author }}</span>
                                <span><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y H:i') }}</span>
                                <span><i class="fa fa-clock"></i> {{ $readTime }} min read</span>
                                <span><i class="fa fa-eye"></i> {{ $blog->Views ?? 0 }} views</span>
                            </div>
                            <div class="blog__details__content">
                                {!! $blog->Content !!}
                            </div>
                        </div>
                    </div>

                    <div class="blog__details__nav">
                        @if($prevBlog)
                        <div class="blog__details__nav__item prev__item">
                            <h6><a href="{{ route('blog.show', $prevBlog->BlogID) }}"><i class="fa fa-angle-left"></i> Previous</a></h6>
                            <div class="blog__details__nav__img">
                                @if($prevBlog->Image)
                                <img src="{{ asset($prevBlog->Image) }}" alt="{{ $prevBlog->Title }}" style="width: 80px; height: 60px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="blog__details__nav__text">
                                <h6>{{ Str::limit($prevBlog->Title, 40) }}</h6>
                                <span>{{ $prevBlog->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @endif

                        @if($nextBlog)
                        <div class="blog__details__nav__item next__item">
                            <h6><a href="{{ route('blog.show', $nextBlog->BlogID) }}">Next <i class="fa fa-angle-right"></i></a></h6>
                            <div class="blog__details__nav__img">
                                @if($nextBlog->Image)
                                <img src="{{ asset($nextBlog->Image) }}" alt="{{ $nextBlog->Title }}" style="width: 80px; height: 60px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="blog__details__nav__text">
                                <h6>{{ Str::limit($nextBlog->Title, 40) }}</h6>
                                <span>{{ $nextBlog->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__item">
                        <h4>Recent Posts</h4>
                        <div class="blog__sidebar__recent">
                            @foreach($recentBlogs as $recent)
                            <div class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__pic">
                                    @if($recent->Image)
                                    <img src="{{ asset($recent->Image) }}" alt="{{ $recent->Title }}" style="width: 70px; height: 70px; object-fit: cover;">
                                    @else
                                    <div class="no-image" style="width: 70px; height: 70px; background: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-image text-muted"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="blog__sidebar__recent__text">
                                    <h6><a href="{{ route('blog.show', $recent->BlogID) }}">{{ Str::limit($recent->Title, 50) }}</a></h6>
                                    <span>{{ $recent->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="blog__sidebar__item">
                        <h4>Search</h4>
                        <div class="blog__sidebar__search">
                            <form action="{{ route('blog.index') }}" method="GET">
                                <input type="text" name="search" placeholder="Search posts...">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>

                    {{-- REMOVED ERROR-PRONE CATEGORY SECTION --}}
                    {{-- <div class="blog__sidebar__item">
                        <h4>Categories</h4>
                        <ul>
                            <li><a href="{{ route('blog.index') }}">All posts</a></li>
                    @php
                    $categories = \App\Models\Blog::select('Category')->distinct()->whereNotNull('Category')->get();
                    @endphp
                    @foreach($categories as $category)
                    <li><a href="{{ route('blog.index') }}?category={{ urlencode($category->Category) }}">{{ $category->Category }}</a></li>
                    @endforeach
                    </ul>
                </div> --}}

                {{-- REPLACED WITH POPULAR TAGS --}}
                <div class="blog__sidebar__item">
                    <h4>Popular Tags</h4>
                    <div class="blog__sidebar__tags">
                        <a href="{{ route('blog.index') }}">News</a>
                        <a href="{{ route('blog.index') }}">Products</a>
                        <a href="{{ route('blog.index') }}">Promotions</a>
                        <a href="{{ route('blog.index') }}">Guides</a>
                        <a href="{{ route('blog.index') }}">Advice</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<style>
    .blog-details {
        padding: 50px 0;
    }

    .blog__details__pic {
        margin-bottom: 30px;
    }

    .blog__details__pic img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }

    .blog__details__text {
        margin-bottom: 40px;
    }

    .blog__details__text h2 {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1c1c1c;
    }

    .blog__details__meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ebebeb;
    }

    .blog__details__meta span {
        color: #6f6f6f;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .blog__details__meta i {
        margin-right: 5px;
        color: #7fad39;
    }

    .blog__details__content {
        font-size: 16px;
        line-height: 1.8;
        color: #444;
    }

    .blog__details__content p {
        margin-bottom: 20px;
    }

    .blog__details__content img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
        border-radius: 5px;
    }

    .blog__details__nav {
        display: flex;
        justify-content: space-between;
        padding: 30px 0;
        border-top: 1px solid #ebebeb;
        margin-top: 40px;
    }

    .blog__details__nav__item {
        display: flex;
        align-items: center;
        width: 48%;
    }

    .prev__item {
        text-align: left;
    }

    .next__item {
        text-align: right;
        flex-direction: row-reverse;
    }

    .blog__details__nav__img {
        margin: 0 15px;
    }

    .blog__details__nav__text h6 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .blog__details__nav__text span {
        font-size: 12px;
        color: #6f6f6f;
    }

    .blog__sidebar {
        padding-left: 20px;
    }

    .blog__sidebar__item {
        margin-bottom: 40px;
    }

    .blog__sidebar__item h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1c1c1c;
        padding-bottom: 10px;
        border-bottom: 2px solid #7fad39;
    }

    .blog__sidebar__recent__item {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #ebebeb;
    }

    .blog__sidebar__recent__pic {
        margin-right: 15px;
    }

    .blog__sidebar__recent__text h6 {
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 5px;
    }

    .blog__sidebar__recent__text h6 a {
        color: #1c1c1c;
    }

    .blog__sidebar__recent__text h6 a:hover {
        color: #7fad39;
    }

    .blog__sidebar__recent__text span {
        font-size: 12px;
        color: #6f6f6f;
    }

    .blog__sidebar__search {
        position: relative;
    }

    .blog__sidebar__search input {
        width: 100%;
        height: 45px;
        padding: 0 20px;
        border: 1px solid #ebebeb;
        border-radius: 5px;
        font-size: 14px;
    }

    .blog__sidebar__search button {
        position: absolute;
        right: 0;
        top: 0;
        height: 45px;
        width: 45px;
        background: #7fad39;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    .blog__sidebar__tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .blog__sidebar__tags a {
        display: inline-block;
        padding: 5px 15px;
        background: #f5f5f5;
        color: #6f6f6f;
        border-radius: 20px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s;
    }

    .blog__sidebar__tags a:hover {
        background: #7fad39;
        color: white;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .blog__sidebar {
            padding-left: 0;
            margin-top: 40px;
        }

        .blog__details__text h2 {
            font-size: 28px;
        }

        .blog__details__pic img {
            height: 250px;
        }

        .blog__details__nav {
            flex-direction: column;
        }

        .blog__details__nav__item {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>
@endsection