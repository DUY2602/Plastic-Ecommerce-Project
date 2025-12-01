<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('img/polysite-logo.jpg') }}" alt="Plastic Store" height="100px" width="200px"></a>
                </div>
            </div>
            <div class="col-lg-8">
                <nav class="header__menu">
                    <ul>
                        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}" title="Trang chủ">
                                <i class="fa fa-home"></i>
                                <span class="menu-text">Trang chủ</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}" title="Sản phẩm">
                                <i class="fa fa-cube"></i>
                                <span class="menu-text">Sản phẩm</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('blog.index') ? 'active' : '' }}">
                            <a href="{{ route('blog.index') }}" title="Blog">
                                <i class="fa fa-blog"></i>
                                <span class="menu-text">Blog</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('about') ? 'active' : '' }}">
                            <a href="{{ route('about') }}" title="Giới thiệu">
                                <i class="fa fa-info-circle"></i>
                                <span class="menu-text">Giới thiệu</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}" title="Liên hệ">
                                <i class="fa fa-envelope"></i>
                                <span class="menu-text">Liên hệ</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('chat.index') ? 'active' : '' }}">
                            <a href="{{ route('chat.index') }}" title="AI Assistant">
                                <i class="fa fa-robot"></i>
                                <span class="menu-text">AI Assistant</span>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('login') || request()->routeIs('profile') ? 'active' : '' }}">
                            @auth
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" title="Admin">
                                <i class="fa fa-user-shield"></i>
                                <span class="menu-text">Admin</span>
                            </a>
                            @else
                            <a href="{{ route('profile') }}" title="Tài khoản">
                                <i class="fa fa-user"></i>
                                <span class="menu-text">Tài khoản</span>
                            </a>
                            @endif
                            @else
                            <a href="{{ route('login') }}" title="Đăng nhập">
                                <i class="fa fa-user"></i>
                                <span class="menu-text">Đăng nhập</span>
                            </a>
                            @endauth
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2">
                <div class="header__cart">
                    <ul>
                        <li class="menu-item">
                            <a href="{{ route('favorites.index') }}" title="Yêu thích">
                                <i class="fa fa-heart"></i>
                                <span class="favorite-count">
                                    {{ Auth::check() ? Auth::user()->favorites()->count() : 0 }}
                                </span>
                                <span class="menu-text">Yêu thích</span>
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

<style>
    .header__menu ul {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 0;
        list-style: none;
        transition: all 0.3s ease;
    }

    .header__menu ul li.menu-item {
        position: relative;
        margin: 0 8px;
        transition: all 0.3s ease;
    }

    .header__menu ul li.menu-item a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px 12px;
        position: relative;
        transition: all 0.3s ease;
        color: #333;
        text-decoration: none;
        border-radius: 8px;
        white-space: nowrap;
    }

    /* Trạng thái bình thường - chỉ hiện icon */
    .header__menu .menu-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    /* Khi hover vào item nào đó */
    .header__menu ul li.menu-item:hover a {
        background: rgba(127, 173, 57, 0.1);
        padding-right: 20px;
    }

    .header__menu ul li.menu-item:hover .menu-text {
        opacity: 1;
        width: auto;
        margin-left: 8px;
    }

    /* Khi hover vào item, các item phía sau sẽ dạt ra */
    .header__menu ul:hover li.menu-item:hover~li.menu-item {
        transform: translateX(20px);
    }

    /* Đảm bảo tất cả items có transition */
    .header__menu ul li.menu-item {
        transition: transform 0.3s ease;
    }

    .header__menu ul li a i {
        font-size: 20px;
        min-width: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }

    /* Favorite section */
    .header__cart ul {
        display: flex;
        justify-content: flex-end;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .header__cart ul li.menu-item {
        position: relative;
        margin-left: 8px;
        transition: all 0.3s ease;
    }

    .header__cart ul li.menu-item a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        position: relative;
        transition: all 0.3s ease;
        color: #333;
        text-decoration: none;
        border-radius: 8px;
        white-space: nowrap;
    }

    .header__cart .menu-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .header__cart ul li.menu-item:hover a {
        background: rgba(127, 173, 57, 0.1);
        padding-right: 20px;
    }

    .header__cart ul li.menu-item:hover .menu-text {
        opacity: 1;
        width: auto;
        margin-left: 8px;
    }

    /* Active state */
    .header__menu ul li.menu-item.active a {
        color: #7fad39;
        background: rgba(127, 173, 57, 0.15);
    }

    .header__menu ul li.menu-item.active a i {
        color: #7fad39;
    }

    /* Hover effects */
    .header__menu ul li.menu-item a:hover {
        color: #7fad39;
    }

    .header__menu ul li.menu-item a:hover i {
        color: #7fad39;
        transform: scale(1.1);
    }

    .header__cart ul li.menu-item a:hover {
        color: #7fad39;
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
        top: 8px;
        right: 8px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    /* Khi hover vào favorite, điều chỉnh vị trí count */
    .header__cart ul li.menu-item:hover .favorite-count {
        right: calc(100% - 40px);
    }

    /* Responsive */
    @media (max-width: 991px) {

        .header__menu .menu-text,
        .header__cart .menu-text {
            display: none;
        }

        .header__menu ul li.menu-item a,
        .header__cart ul li.menu-item a {
            justify-content: center;
            padding: 12px 8px;
            gap: 0;
        }

        .header__menu ul li.menu-item a i,
        .header__cart ul li.menu-item a i {
            font-size: 18px;
        }

        .header__menu ul:hover li.menu-item:hover~li.menu-item {
            transform: none;
        }

        .favorite-count {
            top: 5px;
            right: 5px;
            width: 16px;
            height: 16px;
            font-size: 9px;
        }

        .header__cart ul li.menu-item:hover .favorite-count {
            right: 5px;
        }
    }

    /* Animation smooth */
    .header__menu,
    .header__cart {
        overflow: visible;
    }
</style>