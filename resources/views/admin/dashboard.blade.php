@extends('layouts.admin')

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
                    <a href="{{ route('admin.variants') }}" class="small-box-footer waves-effect">
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
                    <a href="#" class="small-box-footer waves-effect">
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
                    <a href="#" class="small-box-footer waves-effect">
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
                    <a href="#" class="small-box-footer waves-effect">
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
                        <a href="#" class="btn btn-sm btn-light btn-block waves-effect">
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

<style>
    /* Background Gradient với hiệu ứng động */
    body {
        background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
        min-height: 100vh;
    }

    .content-wrapper {
        background: transparent !important;
    }

    .content-header {
        background: transparent !important;
    }

    /* Glass Morphism Effect */
    .card-glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        transition: all 0.3s ease;
    }

    .glass-header {
        background: rgba(255, 255, 255, 0.15) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 15px 15px 0 0 !important;
    }

    .glass-body {
        background: transparent !important;
    }

    .table-transparent {
        background: transparent !important;
    }

    .table-row-glass {
        background: rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .table-row-glass:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        transform: translateX(5px);
    }

    .badge-glass {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Small Box Glass Effect */
    .small-box {
        background: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        transition: all 0.3s ease;
    }

    .small-box .inner h3,
    .small-box .inner p {
        color: white !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .small-box .icon i {
        color: rgba(255, 255, 255, 0.7) !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .small-box:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 40px 0 rgba(31, 38, 135, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    /* Animations */
    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .animated {
        animation-duration: 0.8s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-40px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(40px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Wave Effect */
    .waves-effect {
        position: relative;
        overflow: hidden;
        border-radius: 0 0 15px 15px;
    }

    .waves-effect:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }

    .waves-effect:focus:after,
    .waves-effect:active:after {
        animation: ripple 1s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }

        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }

    /* Custom Scrollbar */
    .table-responsive::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Floating Particles Background */
    .particles-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s infinite ease-in-out;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Count up animation
        const counters = document.querySelectorAll('.count-up');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const updateCount = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.ceil(current);
                    requestAnimationFrame(updateCount);
                } else {
                    counter.textContent = target;
                }
            };

            // Start animation when element is in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCount();
                        observer.unobserve(entry.target);
                    }
                });
            });

            observer.observe(counter);
        });

        // Create floating particles
        createParticles();

        function createParticles() {
            const container = document.createElement('div');
            container.className = 'particles-container';
            document.body.appendChild(container);

            for (let i = 0; i < 15; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                // Random properties
                const size = Math.random() * 60 + 20;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const delay = Math.random() * 5;
                const duration = Math.random() * 3 + 3;

                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                particle.style.animationDelay = `${delay}s`;
                particle.style.animationDuration = `${duration}s`;

                container.appendChild(particle);
            }
        }
    });
</script>
@endsection