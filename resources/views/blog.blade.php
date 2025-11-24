@extends('layouts.app')

@section('title', 'Blog - PolySite Bottle Manufacturing Insights')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Our Blog</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ url('/') }}">Home</a>
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
            <div class="col-lg-4 col-md-5">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Categories</h4>
                        <ul>
                            <li><a href="#">PET Technology</a></li>
                            <li><a href="#">Manufacturing</a></li>
                            <li><a href="#">Industry News</a></li>
                            <li><a href="#">Sustainability</a></li>
                            <li><a href="#">Quality Control</a></li>
                        </ul>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Recent News</h4>
                        <div class="blog__sidebar__recent">
                            <a href="#" class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="{{ asset('img/blog/sidebar/sr-1.jpg') }}" alt="">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>New PET Recycling<br /> Technology</h6>
                                    <span>MAR 05, 2024</span>
                                </div>
                            </a>
                            <a href="#" class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="{{ asset('img/blog/sidebar/sr-2.jpg') }}" alt="">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>Sustainable Packaging<br /> Trends 2024</h6>
                                    <span>FEB 28, 2024</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Search By Tags</h4>
                        <div class="blog__sidebar__item__tags">
                            <a href="#">PET</a>
                            <a href="#">PP</a>
                            <a href="#">PC</a>
                            <a href="#">Recycling</a>
                            <a href="#">Manufacturing</a>
                            <a href="#">Quality</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="{{ asset('img/blog/blog-1.jpg') }}" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> May 4,2024</li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a href="#">Advances in PET Bottle Manufacturing Technology</a></h5>
                                <p>Exploring the latest innovations in PET bottle production that enhance durability and sustainability...</p>
                                <a href="#" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <!-- Thêm more blog posts -->
                </div>
                <div class="blog__pagination">
                    <a href="#">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection