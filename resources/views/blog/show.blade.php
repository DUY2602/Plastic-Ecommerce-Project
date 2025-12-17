@extends('layouts.app')

@section('title', $blog->Title . ' - Plastic Store')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{ $blog->Title }}</h2>
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
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog/show.css') }}">
@endsection