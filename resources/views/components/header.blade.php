<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('img/logo.png') }}" alt="Plastic Store"></a>
                </div>
            </div>
            <div class="col-lg-8">
                <nav class="header__menu">
                    <ul>
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">Trang chủ</a>
                        </li>
                        <li class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}">Sản phẩm</a>
                        </li>
                        <li class="{{ request()->routeIs('blog.index') ? 'active' : '' }}">
                            <a href="{{ route('blog.index') }}">Blog</a>
                        </li>
                        <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                            <a href="{{ route('about') }}">Giới thiệu</a>
                        </li>
                        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}">Liên hệ</a>
                        </li>
                        <li class="{{ request()->routeIs('chat.index') ? 'active' : '' }}">
                            <a href="{{ route('chat.index') }}" title="AI Assistant">
                                <i class="fa fa-robot"></i>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('login') || request()->routeIs('profile') ? 'active' : '' }}">
                            @auth
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" title="Admin">
                                <i class="fa fa-user-shield"></i>
                            </a>
                            @else
                            <a href="{{ route('profile') }}" title="Tài khoản">
                                <i class="fa fa-user"></i>
                            </a>
                            @endif
                            @else
                            <a href="{{ route('login') }}" title="Đăng nhập">
                                <i class="fa fa-user"></i>
                            </a>
                            @endauth
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2">
                <div class="header__cart">
                    <ul>
                        <li>
                            <a href="{{ route('favorites.index') }}" title="Yêu thích">
                                <i class="fa fa-heart"></i>
                                <span class="favorite-count">
                                    {{ Auth::check() ? Auth::user()->favorites()->count() : 0 }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->