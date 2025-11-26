@extends('layouts.app')

@section('title', 'Thông tin tài khoản')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Thông tin tài khoản</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <span>Tài khoản</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Profile Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fa fa-user-circle fa-5x text-secondary"></i>
                        </div>
                        <h5 class="card-title">{{ Auth::user()->Username }}</h5>
                        <p class="text-muted">{{ Auth::user()->Email }}</p>
                        <p class="badge badge-success">Thành viên</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Thông tin cá nhân</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Tên đăng nhập</p>
                                        <input type="text" value="{{ Auth::user()->Username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email</p>
                                        <input type="email" value="{{ Auth::user()->Email }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Vai trò</p>
                                        <input type="text" value="{{ Auth::user()->Role == 1 ? 'Quản trị viên' : 'Khách hàng' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Trạng thái</p>
                                        <input type="text" value="{{ Auth::user()->Status == 1 ? 'Đang hoạt động' : 'Bị khóa' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Ngày tham gia</p>
                                <input type="text" value="{{ date('d/m/Y H:i', strtotime(Auth::user()->CreatedAt)) }}" readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Profile Section End -->
@endsection