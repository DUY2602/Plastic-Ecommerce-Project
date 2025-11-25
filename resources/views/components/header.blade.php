<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> hello@plastic.com</li>
                            <li>Miễn phí vận chuyển cho đơn hàng từ 500.000đ</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__auth">
                            @auth
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-user"></i> Admin</a>
                            @else
                            <a href="{{ route('profile') }}"><i class="fa fa-user"></i> {{ Auth::user()->Username }}</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <a href="#" onclick="this.closest('form').submit(); return false;">
                                    <i class="fa fa-sign-out-alt"></i> Đăng xuất
                                </a>
                            </form>
                            @else
                            <a href="{{ route('login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('img/logo.png') }}" alt="Plastic Store"></a>
                </div>
            </div>
            <div class="col-lg-7">
                <nav class="header__menu">
                    <ul>
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">Trang chủ</a>
                        </li>
                        <li class="{{ request()->routeIs('products') ? 'active' : '' }}">
                            <a href="{{ route('products') }}">Sản phẩm</a>
                        </li>
                        <li class="{{ request()->routeIs('blog') ? 'active' : '' }}">
                            <a href="{{ route('blog') }}">Blog</a>
                        </li>
                        <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                            <a href="{{ route('about') }}">Giới thiệu</a>
                        </li>
                        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}">Liên hệ</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li>
                            <a href="{{ route('favorites.index') }}">
                                <i class="fa fa-heart"></i>
                                <span class="favorite-count">
                                    {{ Auth::check() ? Auth::user()->favorites()->count() : 0 }}
                                </span>
                            </a>
                        </li>
                        <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                    </ul>
                    <div class="header__cart__price">Tổng: <span>150.000đ</span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->