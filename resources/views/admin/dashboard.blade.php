@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endsection

@section('title', 'Admin Dashboard')

@section('admin-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-white">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-light">Dashboard</a></li>
                    <li class="breadcrumb-item active text-light">Overview</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Stats Cards with Animation -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box card-glass animated fadeInUp" data-wow-delay="0.1s">
                    <div class="inner">
                        <h3 class="count-up" data-count="{{ $stats['total_products'] }}">0</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <a href="{{ route('admin.products') }}" class="small-box-footer waves-effect">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box card-glass animated fadeInUp" data-wow-delay="0.2s">
                    <div class="inner">
                        <h3 class="count-up" data-count="{{ $stats['total_categories'] }}">0</h3>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <a href="{{ route('admin.categories') }}" class="small-box-footer waves-effect">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box card-glass animated fadeInUp" data-wow-delay="0.3s">
                    <div class="inner">
                        <h3 class="count-up" data-count="{{ $stats['total_users'] }}">0</h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.users') }}" class="small-box-footer waves-effect">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box card-glass animated fadeInUp" data-wow-delay="0.4s">
                    <div class="inner">
                        <h3 class="count-up" data-count="{{ $stats['low_stock_variants'] }}">0</h3>
                        <p>Low Stock Items</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="{{ route('admin.products.low-stock') }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Additional Stats Cards -->
            <div class="col-lg-3 col-6">
                <div class="small-box card-glass animated fadeInUp" data-wow-delay="0.5s">
                    <div class="inner">
                        <h3 class="count-up" data-count="{{ $stats['total_feedbacks'] }}">0</h3>
                        <p>Total Reviews</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <a href="{{ route('admin.reviews') }}" class="small-box-footer waves-effect">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box card-glass animated fadeInUp" data-wow-delay="0.6s">
                    <div class="inner">
                        <h3 class="count-up" data-count="{{ $stats['total_blogs'] }}">0</h3>
                        <p>Blog Posts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-blog"></i>
                    </div>
                    <a href="{{ route('admin.blog.index') }}" class="small-box-footer waves-effect">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box card-glass animated fadeInUp" data-wow-delay="0.7s">
                    <div class="inner">
                        <h3 class="count-up" data-count="{{ $stats['today_visitors'] }}">0</h3>
                        <p>Today's Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <a href="{{ route('admin.visitors') }}" class="small-box-footer waves-effect">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box card-glass animated fadeInUp" data-wow-delay="0.8s">
                    <div class="inner">
                        <h3 class="count-up" data-count="{{ $stats['total_visitors'] }}">0</h3>
                        <p>Total Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{ route('admin.visitors') }}" class="small-box-footer waves-effect">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Products, Feedbacks & Blogs -->
        <div class="row">
            <div class="col-md-4">
                <div class="card card-glass animated fadeInLeft">
                    <div class="card-header glass-header">
                        <h3 class="card-title text-white">
                            <i class="fas fa-cube mr-2"></i>Latest Products
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body glass-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-transparent">
                                <thead>
                                    <tr>
                                        <th class="text-white">Product Name</th>
                                        <th class="text-white">Category</th>
                                        <th class="text-white">Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $product)
                                    <tr class="animated fadeIn table-row-glass">
                                        <td>
                                            <div class="d-flex align-items-center text-light">
                                                <i class="fas fa-cube text-primary mr-2"></i>
                                                {{ $product->ProductName }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light badge-glass">{{ $product->category->CategoryName }}</span>
                                        </td>
                                        <td>
                                            <small class="text-light">{{ date('m/d/Y', strtotime($product->CreatedAt)) }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer glass-header">
                        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-light btn-block waves-effect">
                            View All Products <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-glass animated fadeInUp">
                    <div class="card-header glass-header">
                        <h3 class="card-title text-white">
                            <i class="fas fa-star mr-2"></i>Latest Reviews
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body glass-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-transparent">
                                <thead>
                                    <tr>
                                        <th class="text-white">Product</th>
                                        <th class="text-white">User</th>
                                        <th class="text-white">Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentFeedbacks as $feedback)
                                    <tr class="animated fadeIn table-row-glass">
                                        <td>
                                            <div class="d-flex align-items-center text-light">
                                                <i class="fas fa-shopping-bag text-success mr-2"></i>
                                                {{ $feedback->product->ProductName }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-warning">{{ $feedback->user ? $feedback->user->Username : 'Deleted User' }}</span>
                                        </td>
                                        <td>
                                            <div class="rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $feedback->Rating ? 'text-warning' : 'text-light' }}"></i>
                                                    @endfor
                                                    <span class="badge badge-warning badge-glass ml-1">{{ $feedback->Rating }}/5</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer glass-header">
                        <a href="{{ route('admin.reviews') }}" class="btn btn-sm btn-light btn-block waves-effect">
                            View All Reviews <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-glass animated fadeInRight">
                    <div class="card-header glass-header">
                        <h3 class="card-title text-white">
                            <i class="fas fa-blog mr-2"></i>Latest Blog Posts
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body glass-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-transparent">
                                <thead>
                                    <tr>
                                        <th class="text-white">Title</th>
                                        <th class="text-white">Author</th>
                                        <th class="text-white">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBlogs as $blog)
                                    <tr class="animated fadeIn table-row-glass">
                                        <td>
                                            <div class="d-flex align-items-center text-light">
                                                <i class="fas fa-file-alt text-info mr-2"></i>
                                                {{ \Illuminate\Support\Str::limit($blog->Title, 25) }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-light">{{ $blog->Author }}</span>
                                        </td>
                                        <td>
                                            <small class="text-light">{{ date('m/d/Y', strtotime($blog->created_at)) }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer glass-header">
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-light btn-block waves-effect">
                            View All Blog Posts <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endsection