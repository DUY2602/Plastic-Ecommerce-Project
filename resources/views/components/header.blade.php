<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-2 col-sm-4 col-4">
                <div class="header__logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('img/polysite-logo.jpg') }}" alt="Plastic Store" height="60px" width="120px"></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-7 d-none d-md-block">
                <nav class="header__menu">
                    <ul>
                        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}" title="Home">
                                <i class="fa fa-home"></i>
                                <span class="menu-text">Home</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}" title="Products">
                                <i class="fa fa-wine-bottle"></i>
                                <span class="menu-text">Products</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('blog.index') ? 'active' : '' }}">
                            <a href="{{ route('blog.index') }}" title="Blog">
                                <i class="fa fa-book-open"></i>
                                <span class="menu-text">Blog</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('about') ? 'active' : '' }}">
                            <a href="{{ route('about') }}" title="About Us">
                                <i class="fa fa-users"></i>
                                <span class="menu-text">About Us</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}" title="Contact">
                                <i class="fa fa-envelope"></i>
                                <span class="menu-text">Contact</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('chat.index') ? 'active' : '' }}">
                            <a href="{{ route('chat.index') }}" title="AI Assistant">
                                <i class="fa fa-robot"></i>
                                <span class="menu-text">AI Assistant</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2 col-md-3 d-none d-md-block">
                <div class="header__right">
                    <ul>
                        <!-- Login/Account/Admin -->
                        <li class="menu-item {{ request()->routeIs('login') || request()->routeIs('profile') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            @auth
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" title="Admin">
                                <i class="fa fa-user-shield"></i>
                                <span class="menu-text">Admin</span>
                            </a>
                            @else
                            <a href="{{ route('profile') }}" title="Account">
                                <i class="fa fa-user-circle"></i>
                                <span class="menu-text">Account</span>
                            </a>
                            @endif
                            @else
                            <a href="{{ route('login') }}" title="Login">
                                <i class="fa fa-sign-in-alt"></i>
                                <span class="menu-text">Login</span>
                            </a>
                            @endauth
                        </li>

                        <!-- Favorites -->
                        <li class="menu-item">
                            <a href="{{ route('favorites.index') }}" title="Favorites">
                                <i class="fa fa-heart"></i>
                                <span class="favorite-count">
                                    {{ Auth::check() ? Auth::user()->favorites()->count() : 0 }}
                                </span>
                                <span class="menu-text">Favorites</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="col-8 text-right d-block d-md-none">
                <div class="humberger__open">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay"></div>
<div class="mobile-menu-wrapper">
    <div class="mobile-menu">
        <div class="mobile-menu__header">
            <div class="mobile-menu__logo">
                <a href="{{ route('home') }}"><img src="{{ asset('img/polysite-logo.jpg') }}" alt="Plastic Store" height="50px" width="100px"></a>
            </div>
            <div class="mobile-menu__close">
                <i class="fa fa-times"></i>
            </div>
        </div>
        <nav class="mobile-menu__nav">
            <ul>
                <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" title="Home">
                        <i class="fa fa-home"></i>
                        <span class="menu-text">Home</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" title="Products">
                        <i class="fa fa-wine-bottle"></i>
                        <span class="menu-text">Products</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('blog.index') ? 'active' : '' }}">
                    <a href="{{ route('blog.index') }}" title="Blog">
                        <i class="fa fa-book-open"></i>
                        <span class="menu-text">Blog</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}" title="About Us">
                        <i class="fa fa-users"></i>
                        <span class="menu-text">About Us</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}" title="Contact">
                        <i class="fa fa-envelope"></i>
                        <span class="menu-text">Contact</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('chat.index') ? 'active' : '' }}">
                    <a href="{{ route('chat.index') }}" title="AI Assistant">
                        <i class="fa fa-robot"></i>
                        <span class="menu-text">AI Assistant</span>
                    </a>
                </li>

                <!-- Mobile Authentication -->
                <li class="menu-item {{ request()->routeIs('login') || request()->routeIs('profile') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    @auth
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" title="Admin">
                        <i class="fa fa-user-shield"></i>
                        <span class="menu-text">Admin</span>
                    </a>
                    @else
                    <a href="{{ route('profile') }}" title="Account">
                        <i class="fa fa-user-circle"></i>
                        <span class="menu-text">Account</span>
                    </a>
                    @endif
                    @else
                    <a href="{{ route('login') }}" title="Login">
                        <i class="fa fa-sign-in-alt"></i>
                        <span class="menu-text">Login</span>
                    </a>
                    @endauth
                </li>

                <!-- Mobile Favorites -->
                <li class="menu-item">
                    <a href="{{ route('favorites.index') }}" title="Favorites">
                        <i class="fa fa-heart"></i>
                        <span class="menu-text">Favorites</span>
                        <span class="mobile-favorite-count">
                            {{ Auth::check() ? Auth::user()->favorites()->count() : 0 }}
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- Header Section End -->

<style>
    /* Reset */
    body {
        margin: 0;
        padding: 0;
    }

    /* Header Styles */
    .header {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 100;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .row {
        display: flex;
        align-items: center;
        min-height: 80px;
    }

    /* Desktop Menu Styles */
    .header__menu ul,
    .header__right ul {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 0;
        list-style: none;
        transition: all 0.3s ease;
    }

    .header__right ul {
        justify-content: flex-end;
    }

    .header__menu ul li.menu-item,
    .header__right ul li.menu-item {
        position: relative;
        margin: 0 8px;
        transition: all 0.3s ease;
    }

    .header__menu ul li.menu-item a,
    .header__right ul li.menu-item a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        position: relative;
        transition: all 0.3s ease;
        color: #333;
        text-decoration: none;
        border-radius: 8px;
        white-space: nowrap;
    }

    /* Normal state - show icon only */
    .header__menu .menu-text,
    .header__right .menu-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    /* When hovering over an item */
    .header__menu ul li.menu-item:hover a,
    .header__right ul li.menu-item:hover a {
        background: rgba(127, 173, 57, 0.1);
        padding-right: 20px;
    }

    .header__menu ul li.menu-item:hover .menu-text,
    .header__right ul li.menu-item:hover .menu-text {
        opacity: 1;
        width: auto;
        margin-left: 8px;
    }

    /* Active state */
    .header__menu ul li.menu-item.active a,
    .header__right ul li.menu-item.active a {
        color: #7fad39;
        background: rgba(127, 173, 57, 0.15);
    }

    .header__menu ul li.menu-item.active a i,
    .header__right ul li.menu-item.active a i {
        color: #7fad39;
    }

    /* Hover effects */
    .header__menu ul li.menu-item a:hover,
    .header__right ul li.menu-item a:hover {
        color: #7fad39;
    }

    .header__menu ul li.menu-item a:hover i,
    .header__right ul li.menu-item a:hover i {
        color: #7fad39;
        transform: scale(1.1);
    }

    /* Favorite count */
    .favorite-count {
        background: #ff4444;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 5px;
        right: 5px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    /* Mobile Menu Styles */
    .humberger__open {
        display: inline-block;
        cursor: pointer;
        font-size: 24px;
        color: #333;
        padding: 10px;
    }

    /* Mobile Menu Overlay - FIXED */
    .mobile-menu-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .mobile-menu-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* Mobile Menu Wrapper - FIXED */
    .mobile-menu-wrapper {
        position: fixed;
        top: 0;
        right: -320px;
        width: 300px;
        height: 100%;
        z-index: 9999;
        transition: right 0.3s ease;
    }

    .mobile-menu-wrapper.active {
        right: 0;
    }

    .mobile-menu {
        width: 100%;
        height: 100%;
        background: white;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
    }

    .mobile-menu__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        background: white;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .mobile-menu__close {
        cursor: pointer;
        font-size: 22px;
        color: #333;
        padding: 5px;
    }

    .mobile-menu__nav {
        padding: 10px 0;
    }

    .mobile-menu__nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mobile-menu__nav ul li.menu-item {
        border-bottom: 1px solid #f5f5f5;
    }

    .mobile-menu__nav ul li.menu-item:last-child {
        border-bottom: none;
    }

    .mobile-menu__nav ul li.menu-item a {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .mobile-menu__nav ul li.menu-item a:hover {
        background: rgba(127, 173, 57, 0.1);
        color: #7fad39;
    }

    .mobile-menu__nav ul li.menu-item.active a {
        background: rgba(127, 173, 57, 0.15);
        color: #7fad39;
    }

    .mobile-menu__nav ul li.menu-item a i {
        width: 24px;
        font-size: 18px;
        margin-right: 15px;
        text-align: center;
    }

    .mobile-favorite-count {
        background: #ff4444;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: auto;
        font-weight: bold;
    }

    /* Responsive Grid System */
    @media (max-width: 767px) {
        .col-sm-4 {
            width: 33.33%;
        }

        .col-4 {
            width: 33.33%;
        }

        .col-8 {
            width: 66.67%;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .col-md-2 {
            width: 16.67%;
        }

        .col-md-3 {
            width: 25%;
        }

        .col-md-7 {
            width: 58.33%;
        }
    }

    @media (min-width: 992px) {
        .col-lg-2 {
            width: 16.67%;
        }

        .col-lg-8 {
            width: 66.67%;
        }

        .col-lg-2 {
            width: 16.67%;
        }
    }

    /* Hide/Show based on screen size */
    .d-none {
        display: none !important;
    }

    .d-block {
        display: block !important;
    }

    .d-md-block {
        display: none !important;
    }

    @media (min-width: 768px) {
        .d-md-block {
            display: block !important;
        }

        .d-block.d-md-none {
            display: none !important;
        }
    }

    .text-right {
        text-align: right;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const humbergerOpen = document.querySelector('.humberger__open');
        const mobileMenuClose = document.querySelector('.mobile-menu__close');
        const mobileMenuWrapper = document.querySelector('.mobile-menu-wrapper');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');

        console.log('Elements found:', {
            humbergerOpen,
            mobileMenuClose,
            mobileMenuWrapper,
            mobileMenuOverlay
        });

        // Open mobile menu
        if (humbergerOpen) {
            humbergerOpen.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Open menu clicked');
                mobileMenuWrapper.classList.add('active');
                mobileMenuOverlay.classList.add('active');
            });
        }

        // Close mobile menu
        function closeMobileMenu() {
            console.log('Closing menu');
            mobileMenuWrapper.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
        }

        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeMobileMenu();
            });
        }

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeMobileMenu();
            });
        }

        // Close menu when clicking on links
        const mobileLinks = document.querySelectorAll('.mobile-menu__nav a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                setTimeout(closeMobileMenu, 300);
            });
        });

        // Close menu with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileMenu();
            }
        });

        // Debug
        console.log('Mobile menu script loaded successfully');
    });
</script>