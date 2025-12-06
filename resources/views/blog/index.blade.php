@extends('layouts.app')

@section('title', 'Blog - Plastic Store')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Blog</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog spad">
    <div class="container">
        <div class="row">
            @foreach($blogs as $blog)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="{{ asset($blog->Image) }}" alt="{{ $blog->Title }}">
                    </div>
                    <div class="blog__item__text">
                        <span class="blog__category">News</span>
                        <h5><a href="{{ route('blog.show', $blog->BlogID) }}">{{ $blog->Title }}</a></h5>
                        <p>{{ Str::limit(strip_tags($blog->Content), 100) }}</p>
                        <div class="blog__item__info">
                            <span><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}</span>
                            <span><i class="fa fa-eye"></i> {{ $blog->Views ?? 0 }}</span>
                        </div>
                        <a href="{{ route('blog.show', $blog->BlogID) }}" class="read-more">Read more <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-lg-12">
            {{-- FIXED: Removed wrapper CSS classes causing errors (product__pagination, blog__pagination) --}}
            {{-- and kept only center alignment (text-center) using Bootstrap 4 template. --}}
            <div class="blog__pagination text-center">
                {{ $blogs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</section>
<style>
    /* ... (CSS for blog__item remains unchanged) ... */
    .blog__item {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .blog__item:hover {
        transform: translateY(-5px);
    }

    .blog__item__pic {
        height: 200px;
        overflow: hidden;
        flex-shrink: 0;
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
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .blog__category {
        background: #7fad39;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
        align-self: flex-start;
        margin-bottom: 10px;
    }

    .blog__item__text h5 {
        margin: 0 0 10px;
        line-height: 1.4;
        flex-grow: 1;
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
        flex-grow: 1;
    }

    .blog__item__info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        color: #b2b2b2;
        margin-bottom: 10px;
    }

    .read-more {
        color: #7fad39;
        text-decoration: none;
        font-weight: bold;
        align-self: flex-start;
    }

    .read-more:hover {
        color: #1c1c1c;
    }

    /* PAGINATION CSS (Keep to ensure styling) */
    .blog__pagination {
        margin-top: 50px;
    }

    .blog__pagination .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

    .blog__pagination .pagination li {
        margin: 0 3px;
    }

    .blog__pagination .pagination .page-link {
        font-family: inherit;
        font-size: 14px;
        color: #6f6f6f;
        background-color: #f5f5f5;
        border: 1px solid #ebebeb;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s;
        line-height: 1.2;
        display: block;
    }

    .blog__pagination .pagination .page-item.active .page-link,
    .blog__pagination .pagination .page-link:hover {
        background-color: #7fad39;
        color: white;
        border-color: #7fad39;
    }

    /* Hide unwanted icons (just in case) */
    .blog__pagination .pagination .page-link i,
    .blog__pagination .pagination .page-link svg {
        display: none;
    }

    .blog__pagination .pagination .page-link[rel="prev"],
    .blog__pagination .pagination .page-link[rel="next"] {
        font-weight: bold;
    }
</style>
@endsection