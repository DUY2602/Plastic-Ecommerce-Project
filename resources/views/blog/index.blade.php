@extends('layouts.app')

@section('title', 'Blog - Plastic Store')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Blog</h2>
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
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog/index.css') }}">
@endsection